<?php
/**
 * framework/TemplateBlocks.php — class TemplateBlocks
 *
 * @package    WBCE\Frontend
 * @copyright  2026 WBCE CMS
 * @since      WBCE 1.7.0
 * @license    GNU/GPL v2 https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Consolidates the layout-block rendering logic that used to be scattered
 * across standalone functions in framework/frontend.functions.php
 * (get_block_id, block_contents, block_section_count, block_has_sections,
 * page_content) into one class, following the same "one class, thin
 * backward-compatible procedural shims" pattern already used for
 * framework/Assets/AssetQueue.php (aliased as I::).
 *
 * ── Phase 1/2 (this file + the shims in frontend.functions.php) ──────────
 * Pure code relocation. Every method below is a byte-for-byte behavioural
 * copy of the function it replaces — no new logic, no new hook, no changed
 * fallback. The goal is a verifiable no-op refactor before any new feature
 * (the push/merge API) is added on top in Phase 3.
 *
 * ── Phase 3 — Sync-only push/merge API ────────────────────────────────────
 * register_block_content() lets a Page/Section-type module (or a
 * SECTION/SPECIAL-level OutputFilter, which runs synchronously during
 * get_section_content()) contribute additional HTML to a block without an
 * explicit {TP}sections row.
 *
 * Blocks are addressed by NUMBER only. The names in a template's info.php
 * are labels for the editor ('Sidebar', 'Rechte Spalte', 'sidebar-right'
 * all mean block 2 in different templates), not identifiers — a module
 * that hard-codes one only works with one template. A module lets the user
 * pick the number from getBlocks($page_id) instead and stores that.
 * A number the current template does not declare is swallowed: push()
 * stores nothing, hasContent() is false, render() outputs nothing.
 *
 * This is deliberately SYNC-ONLY: a slot reader (hasContent()/render())
 * only sees pushes that have already happened — there is no deferred/marker
 * resolution stage. A template that reads a slot before the block that
 * writes it calls prerender_blocks() first, at the top of its index.php:
 *
 *   prerender_blocks();                  // every block renders HERE, once
 *   ?><aside>
 *   <?php if (block_has_content(2)) render_block_content(2); ?>
 *   </aside>
 *   <main><?php page_content(1); ?></main>
 *
 * After that, page_content()/block_contents() are served from the cache
 * prerender() filled, so no section runs twice. A template that never
 * calls prerender_blocks() renders exactly as before.
 *
 * PAGE-level OutputFilters (Droplets among them — registered at
 * OPF_TYPE_PAGE, which only runs once on the fully assembled page buffer
 * AFTER the whole template has already executed) are explicitly OUT OF
 * SCOPE. A push from that stage would land in the registry after every
 * possible reader has already run — a write with no consumer. Droplet/
 * PAGE-level integration would need a deferred marker-resolution mechanism
 * (a genuinely separate feature), not this class.
 *
 * block_has_sections() / block_contents() / page_content() remain strictly
 * DB-only (unchanged from before this refactor) so existing templates that
 * never opted into the push API see zero behavioural difference. The merged
 * (DB + push) view is only reachable through the new block_has_content() /
 * render_block_content() names.
 */

// Prevent this file from being accessed directly
defined('WB_PATH') or die('No direct access allowed');

final class TemplateBlocks
{
    // ── Singleton (push-registry state only; DB-facing methods are stateless) ─

    private static ?self $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /** @var array<int, list<array{html: string, priority: int, override: bool, seq: int}>> */
    private array $pushed = [];

    /** Monotonic counter — deterministic tie-break independent of sort stability. */
    private static int $seq = 0;

    /** @var array<string, array<int, string>> getBlocks() result per template dir */
    private static array $blocksCache = [];

    /** @var array<int, array|null> dbContent() results, filled only by prerender() */
    private static array $dbCache = [];

    private static bool $prerendered = false;

    // ── DB-facing methods — byte-for-byte copies of the old procedural bodies ─

    /**
     * @brief  Extract Block ID from Blockname (byte-for-byte copy of the old
     *         get_block_id()). Unknown names silently fall back to block 1 —
     *         this is EXISTING behaviour, unchanged, kept for the DB-facing
     *         path. The push-registry path (push()/hasContent()/render()) does
     *         NOT use this resolver — see blockExists().
     *
     * @param unspec $uBlock may be string or integer
     * @return int
     */
    public static function getBlockId($uBlock): int
    {
        if (is_int($uBlock) or preg_match("/^[0-9]+$/is", $uBlock)) {
            return (int)$uBlock;
        } else {
            require(WB_PATH . "/templates/" . TEMPLATE . "/info.php");
            if ($key = array_search($uBlock, $block)) {
                return (int)$key;
            } else {
                return 1;
            }
        }
    }

    /**
     * @brief   Fetches all sections of a template layout block and returns
     *          them as an array. Byte-for-byte copy of the old block_contents(),
     *          plus one addition: after prerender() the result comes from its
     *          cache, so the sections don't run a second time.
     *
     * @param int|string $block  Block ID (numeric) or block name
     * @return array|null        Sections array, or null on permission/visibility failure.
     */
    public static function dbContent($block = 1): ?array
    {
        global $database, $wb, $TEXT, $HEADING, $MENU;
        $admin = $wb;

        $blockId = is_numeric($block) ? (int)$block : self::getBlockId($block);

        if (array_key_exists($blockId, self::$dbCache)) {
            return self::$dbCache[$blockId];
        }

        $blockSections = [];

        // Early exits for permission / visibility issues
        if ($wb->page_access_denied ?? false) {
            echo L_("MESSAGE['FRONTEND_SORRY_NO_VIEWING_PERMISSIONS']||No viewing permissions");
            return null;
        }
        if ($wb->page_no_active_sections ?? false) {
            echo L_("MESSAGE['FRONTEND_SORRY_NO_ACTIVE_SECTIONS']||No active sections");
            return null;
        }

        // Special case: full page content via PAGE_CONTENT constant
        if (defined('PAGE_CONTENT')) {
            ob_start();
            require PAGE_CONTENT;
            $blockSections[]['content'] = ob_get_clean();
            return $blockSections;
        }

        // Return null if current page is not visible
        if (($wb instanceof frontend) && !$wb->page_is_visible($wb->page ?? [])) {
            return null;
        }

        // Get sections for this block
        $sql = 'SELECT `section_id` FROM `{TP}sections`
                WHERE `page_id` = ? AND `block` = ?
                ORDER BY `position`';

        $pageId = $page_id = $wb->page_id ?? 0;

        $sectionsResult = $database->query($sql, [$pageId, $blockId]);

        if (!$sectionsResult || $sectionsResult->numRows() === 0) {
            // Try default block content
            if (($wb->default_block_content) === intval(0)) {
                return null;
            }

            $pageId = is_numeric($wb->default_block_content ?? null)
                ? (int)$wb->default_block_content
                : ($wb->default_page_id ?? 0);

            $sectionsResult = $database->query($sql, [$pageId, $blockId]);

            if (!$sectionsResult || $sectionsResult->numRows() === 0) {
                return null;
            }
        }

        // Process each section
        while ($row = $sectionsResult->fetchRow(MYSQLI_ASSOC)) {
            $sectionId = (int)$row['section_id'];
            $section   = get_section_array($sectionId);

            if (empty($section)) continue;

            // Skip section if outside publication period
            $currentTime = time();
            if (!(
                ($currentTime <= ($section['publ_end']   ?? 0) || ($section['publ_end']   ?? 0) == 0) &&
                ($currentTime >= ($section['publ_start'] ?? 0) || ($section['publ_start'] ?? 0) == 0)
            )) {
                continue;
            }

            // Render section content via get_section_content()
            $content = get_section_content($sectionId);

            if ($content === '') continue;

            // Search result highlighting — mutually exclusive with OPF 'special' filter
            if (isset($_GET['searchresult']) && is_numeric($_GET['searchresult'])
                && !isset($_GET['nohighlight']) && !empty($_GET['sstring'])) {

                $searchString = filter_input(INPUT_GET, 'sstring', FILTER_SANITIZE_ENCODED);
                $searchString = str_replace('%', '', $searchString);
                $searchTerms  = explode(' ', $searchString);

                if ($_GET['searchresult'] == 2) {
                    $searchTerms[0] = str_replace('_', ' ', $searchTerms[0] ?? '');
                }

                $blockSections[]['content'] = search_highlight($content, $searchTerms);
                continue;
            }

            // Apply OPF 'special' filter — only outside search-highlight path
            if (function_exists('opf_apply_filters')) {
                $content = opf_controller('special', $content);
            }

            // Build section anchor
            $sectionAnchor = '';
            if (defined('SEC_ANCHOR') && SEC_ANCHOR !== '') {
                $sectionAnchor = '<a class="section_anchor" id="' . SEC_ANCHOR . $section['section_id'] . '"></a>';
            }

            $blockSections[$sectionId] = [
                'position'     => $section['position']    ?? 0,
                'section_id'   => $section['section_id']  ?? $sectionId,
                'module'       => $section['module']      ?? '',
                'section_name' => $section['namesection'] ?? '',
                'evenodd'      => (($section['position']  ?? 0) % 2 === 1) ? 'even' : 'odd',
                'content'      => $sectionAnchor !== ''
                    ? PHP_EOL . $sectionAnchor . PHP_EOL . $content
                    : $content,
            ];
        }

        return $blockSections;
    }

    /**
     * @brief   Cheap existence check for a template layout block — a single
     *          COUNT(*) query, no section rendering. Byte-for-byte copy of
     *          the old block_section_count().
     *
     * @param unspec   $uBlock Block ID or Block name
     * @param int|null $pageId Defaults to the current page ($wb->page_id)
     * @return int
     */
    public static function dbSectionCount($uBlock = 1, ?int $pageId = null): int
    {
        global $database, $wb;

        $blockId = self::getBlockId($uBlock);
        $pageId ??= $wb->page_id ?? 0;
        $now = time();

        $sql = 'SELECT COUNT(*) FROM `{TP}sections`
                WHERE `page_id` = ? AND `block` = ?
                AND (`publ_start` = 0 OR `publ_start` <= ?)
                AND (`publ_end` = 0 OR `publ_end` >= ?)';

        return (int) $database->fetchValue($sql, [$pageId, $blockId, $now, $now]);
    }

    /**
     * @brief   Convenience wrapper around dbSectionCount() — "does this block
     *          have anything assigned" as a boolean. Byte-for-byte copy of
     *          the old block_has_sections(). Strictly DB-only — does NOT
     *          consider push()ed content. See hasContent() for the merged check.
     *
     * @param unspec   $uBlock Block ID or Block name
     * @param int|null $pageId Defaults to the current page ($wb->page_id)
     * @return bool
     */
    public static function dbHasSections($uBlock = 1, ?int $pageId = null): bool
    {
        return self::dbSectionCount($uBlock, $pageId) > 0;
    }

    /**
     * @brief   Print or return all the sections of one block into the
     *          template. Byte-for-byte copy of the old page_content().
     *          Strictly DB-only — does NOT include push()ed content.
     *          See render() for the merged (DB + push) output.
     *
     * @param unspec $uBlock Block ID or Block name
     * @param bool   $bPrint echo the contents, or 0 to fetch into a variable
     * @return string|void
     */
    public static function pageContent($uBlock = 1, $bPrint = 1)
    {
        $iBlockID = self::getBlockId($uBlock);
        $sRetVal = '';
        if (!defined('PAGE_CONTENT')) {
            $aSections = self::dbContent($iBlockID);
            if (!empty($aSections)) {
                foreach ($aSections as $section) {
                    $sRetVal .= $section['content'];
                }
            }
        } else {
            // PAGE_CONTENT is defined
            // it will go into the block with ID = 1
            if ($iBlockID == 1) {
                ob_start();
                global $wb, $database, $globals, $TEXT, $MESSAGE, $HEADING, $MENU;
                $admin = $wb;
                if (isset($globals) and is_array($globals)) {
                    foreach ($globals as $sGlobalName) {
                        global $$sGlobalName;
                    }
                }
                require PAGE_CONTENT;
                $sRetVal .= ob_get_clean();
            }
        }
        // FEE (FrontEnd Edit) hook
        if (function_exists('fee_wrap_block')) {
            $sRetVal = fee_wrap_block($sRetVal, $iBlockID);
        }

        // echo or return
        if ($bPrint == 1) {
            echo $sRetVal;
        } else {
            return $sRetVal;
        }
    }

    // ── Phase 3 — Push-registry / merge API (sync-only, see class docblock) ──

    /**
     * @brief   The layout blocks a template declares in its info.php, as
     *          [blockId => label], e.g. [1 => 'Hauptinhalt', 2 => 'Sidebar'].
     *          Same fallback as admin/pages/sections.php: a template without
     *          $block[1] still gets block 1 ("Main").
     *
     *          With $pageId: the blocks of that page's own template, for a
     *          module's select box in the backend (pages can use different
     *          templates). Without: the template rendering right now
     *          (TEMPLATE, which also honours the template switcher).
     *
     * @param int|null $pageId
     * @return array<int, string>
     */
    public static function getBlocks(?int $pageId = null): array
    {
        $template = $pageId === null ? self::currentTemplate() : self::pageTemplate($pageId);

        if (!isset(self::$blocksCache[$template])) {
            self::$blocksCache[$template] = self::templateBlocks($template);
        }
        return self::$blocksCache[$template];
    }

    /** True if the template rendering right now declares this block number. */
    public static function blockExists(int $blockId): bool
    {
        return isset(self::getBlocks()[$blockId]);
    }

    private static function currentTemplate(): string
    {
        return defined('TEMPLATE') ? TEMPLATE : DEFAULT_TEMPLATE;
    }

    /**
     * The template directory a page uses — same rule as Frontend.php:
     * pages.template if set and its index.php exists, else DEFAULT_TEMPLATE.
     */
    private static function pageTemplate(int $pageId): string
    {
        global $database;

        $template = $pageId > 0
            ? (string) $database->fetchValue('SELECT `template` FROM `{TP}pages` WHERE `page_id` = ?', [$pageId])
            : '';

        if ($template !== '' && is_file(WB_PATH . '/templates/' . $template . '/index.php')) {
            return $template;
        }
        return DEFAULT_TEMPLATE;
    }

    /** @return array<int, string> */
    private static function templateBlocks(string $template): array
    {
        // Own scope: info.php also sets a dozen $template_* variables.
        $file  = WB_PATH . '/templates/' . basename($template) . '/info.php';
        $block = is_file($file)
            ? (static function (string $file): array {
                require $file;
                return isset($block) && is_array($block) ? $block : [];
            })($file)
            : [];

        if (($block[1] ?? '') === '') {
            $block[1] = $GLOBALS['TEXT']['MAIN'] ?? 'Main';
        }
        ksort($block);

        $blocks = [];
        foreach ($block as $id => $label) {
            $blocks[(int)$id] = (string)$label;
        }
        return $blocks;
    }

    /**
     * @brief   Renders every block of the current template once, up front, so
     *          that every push() has happened before the template outputs
     *          anything. Called by the template itself, at the top of its
     *          index.php, via prerender_blocks(). A second call does nothing.
     *
     *          Block 99 is never rendered: by convention it holds sections
     *          that are not shown ("nicht zeigen"), and running their
     *          view.php here would be new behaviour (a form module in it
     *          would suddenly process POST data).
     *          Pages with PAGE_CONTENT (account, search), no viewing
     *          permission or no active sections are left alone, so the
     *          template's own page_content() calls behave exactly as before
     *          (including the messages dbContent() echoes for those cases).
     */
    public static function prerender(): void
    {
        global $wb;

        if (self::$prerendered || defined('PAGE_CONTENT')
            || ($wb->page_access_denied ?? false) || ($wb->page_no_active_sections ?? false)) {
            return;
        }
        self::$prerendered = true;

        foreach (array_keys(self::getBlocks()) as $blockId) {
            if ($blockId !== 99) {
                self::$dbCache[$blockId] = self::dbContent($blockId);
            }
        }
    }

    /**
     * A module (or a SECTION/SPECIAL-level OutputFilter — NOT a PAGE-level
     * one; see class docblock) calls this while it renders to contribute
     * additional HTML to a block. A block number the current template does
     * not declare is swallowed: nothing is stored.
     *
     * @param int        $block    Block number, as in the template's info.php.
     * @param string     $html     Rendered HTML to contribute.
     * @param int        $priority 0-9. Among non-override pushes, lower
     *                             renders first (default 5). Ignored between
     *                             override pushes except as the primary
     *                             tie-break (highest wins).
     * @param bool       $override When true, this push replaces the ENTIRE
     *                             block output (DB content and all
     *                             non-override pushes are discarded) once
     *                             any override push exists for this key.
     *                             Lowest implementation priority — no known
     *                             real use case yet.
     */
    public static function push(int $block, string $html, int $priority = 5, bool $override = false): void
    {
        if (!self::blockExists($block)) {
            return;
        }
        self::getInstance()->pushed[$block][] = [
            'html'     => $html,
            'priority' => $priority,
            'override' => $override,
            'seq'      => self::$seq++,
        ];
    }

    /**
     * Merged existence check: true if the block has DB sections OR any
     * push()ed content; false for a block the current template does not
     * declare. Only reliable for pushes that have already happened — see
     * prerender().
     */
    public static function hasContent(int $block, ?int $pageId = null): bool
    {
        if (!self::blockExists($block)) {
            return false;
        }
        return !empty(self::getInstance()->pushed[$block])
            || self::dbHasSections($block, $pageId);
    }

    /**
     * Merged output: DB content (existing position order, via pageContent())
     * followed by push()ed content ordered by priority (ascending; ties
     * broken by registration order). If any override push exists for this
     * key, it alone is output — DB content and non-override pushes are
     * discarded (see push()'s $override doc).
     *
     * Tie-break among multiple override pushes: highest priority wins;
     * equal priority → most recently registered wins.
     *
     * A block the current template does not declare outputs nothing —
     * unlike page_content(), which falls back to block 1.
     */
    public static function render(int $block, bool $print = true): string
    {
        if (!self::blockExists($block)) {
            return '';
        }
        $items = self::getInstance()->pushed[$block] ?? [];

        $overrides = array_values(array_filter($items, static fn(array $i): bool => $i['override']));

        if (!empty($overrides)) {
            usort($overrides, static function (array $a, array $b): int {
                return ($b['priority'] <=> $a['priority']) ?: ($b['seq'] <=> $a['seq']);
            });
            $html = $overrides[0]['html'];
        } else {
            $dbHtml = (string) self::pageContent($block, 0);

            $pushes = array_values(array_filter($items, static fn(array $i): bool => !$i['override']));
            usort($pushes, static function (array $a, array $b): int {
                return ($a['priority'] <=> $b['priority']) ?: ($a['seq'] <=> $b['seq']);
            });

            $html = $dbHtml . implode('', array_column($pushes, 'html'));
        }

        if ($print) {
            echo $html;
            return '';
        }
        return $html;
    }

    /**
     * For tests / CLI batch jobs that render multiple "pages" in one process.
     */
    public static function reset(): void
    {
        self::getInstance()->pushed = [];
        self::$blocksCache = [];
        self::$dbCache     = [];
        self::$prerendered = false;
    }
}
