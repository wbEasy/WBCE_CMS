<?php
/**
 * wbce_search — WbceSearchBackend
 *
 * Controller for the AdminTool (admin/admintools/tool.php?tool=wbce_search).
 * Layout and request flow follow modules/WbceAnalytics (WbceAnalyticsBackend):
 * one persistent _shell.twig with a #wss-view swap target, nav links that
 * hx-get the next view into it, and a persisted `nav_style` setting that
 * picks _nav.twig (tabs on top) or _nav_vertical.twig (icon sidebar).
 *
 * Request types:
 *   GET  ?action=<view>                 full page (shell + view)
 *   GET  ?action=<view>  + HX-Request   bare view fragment (nav swap)
 *   GET  ?action=modules&partial=…      editor fragments (semi panel, columns)
 *   POST ?action=<view>  op=<operation> run the operation, then answer with
 *        the re-rendered view fragment + toast (HTMX) or redirect (no JS).
 * Every POST is FTAN-checked; info.php puts the runner into no_page mode
 * for HTMX requests, so fragments are not wrapped in admin chrome.
 *
 * @license GNU General Public License
 */

declare(strict_types=1);

defined('WB_PATH') or die();

class WbceSearchBackend
{
    /** Views reachable via ?action=… — order = nav order. */
    public const VIEWS = ['overview', 'settings', 'modules', 'layout', 'stats'];   // = nav order

    /** Views loaded as a full page instead of an HTMX swap (they queue assets via I::). */
    private const FULL_LOAD_VIEWS = ['layout'];


    private bool $isHtmx;
    private string $navPartial = '_nav.twig';
    private string $toolUrl;
    private Alerts $alerts;
    private WbceSearchModules $modules;

    public function __construct(
        private Database $db,
        private Admin $admin,
        private \Twig\Environment $twig
    ) {
        $this->isHtmx  = Alerts::isHtmx();
        $this->toolUrl = ADMIN_URL . '/admintools/tool.php?tool=wbce_search';
        $this->alerts  = new Alerts();
        $this->modules = new WbceSearchModules($db);
    }

    public function run(): void
    {
        $view = (string) ($_GET['action'] ?? 'overview');
        if (!in_array($view, self::VIEWS, true)) {
            $view = 'overview';
        }
        if (WbceSearchSettings::get('nav_style') === 'vertical') {
            $this->navPartial = '_nav_vertical.twig';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePost($view);
            return;
        }
        if ($view === 'modules' && isset($_GET['partial'])) {
            $this->modulesPartial((string) $_GET['partial']);
            return;
        }
        $this->showView($view);
    }

    // ── Views ─────────────────────────────────────────────────────────────

    private function showView(string $view, array $extra = []): void
    {
        match ($view) {
            'modules'  => $this->viewModules($extra),
            'layout'   => $this->viewLayout(),
            'settings' => $this->viewSettings(),
            'stats'    => $this->viewStats(),
            default    => $this->viewOverview(),
        };
    }

    private function viewOverview(): void
    {
        $sections = (int) $this->db->fetchValue(
            "SELECT COUNT(*) FROM `{TP}sections` s
             INNER JOIN `{TP}pages` p ON s.page_id = p.page_id
             WHERE p.visibility NOT IN ('none','deleted') AND p.searching = '1'"
        );
        $stale = (int) $this->db->fetchValue(
            "SELECT COUNT(DISTINCT s.section_id) FROM `{TP}sections` s
             INNER JOIN `{TP}pages` p ON s.page_id = p.page_id
             LEFT JOIN `{TP_SEARCH}index` i ON i.section_id = s.section_id
             WHERE p.visibility NOT IN ('none','deleted') AND p.searching = '1'
               AND (i.section_id IS NULL OR p.modified_when > i.indexed_at)"
        );
        $last = (int) $this->db->fetchValue("SELECT MAX(`indexed_at`) FROM `{TP_SEARCH}index`");

        $byVis = array_column($this->db->fetchAll(
            "SELECT `visibility`, COUNT(*) AS c FROM `{TP}pages`
             WHERE `visibility` != 'deleted' GROUP BY `visibility`"
        ), 'c', 'visibility');

        $this->render('overview', [
            // Only a backlog is worth a line in the overview; the word
            // index's state otherwise shows in Settings.
            'words_backlog'   => WbceSearchWords::isActive($this->db) ? WbceSearchWords::backlog($this->db) : 0,
            'sections'        => $sections,
            'stale'           => $stale,
            'stale_pct'       => $sections ? min(100, (int) round($stale / $sections * 100)) : 0,
            'last_index'      => $last ? $this->localDate($last) : '—',
            // The core's "Search" setting — read through Settings, not the
            // SEARCH constant, so a change made in this request shows at once.
            'search_mode'     => $this->siteSearchMode(),
            'settings_url'    => ADMIN_URL . '/settings/index.php',
            'pages_by_vis'    => $byVis,
            'pages_total'     => array_sum($byVis),
            // Each with its flag (languages/<CODE>.svg, as in the page tree);
            // empty when the core ships none for that code.
            'languages'       => array_map(
                static function (array $l): array {
                    $code = strtoupper((string) preg_replace('/[^A-Za-z]/', '', (string) $l['language']));
                    $l['flag'] = $code !== '' && is_file(WB_PATH . '/languages/' . $code . '.svg')
                        ? WB_URL . '/languages/' . $code . '.svg' : '';
                    return $l;
                },
                $this->db->fetchAll(
                    "SELECT `language`, COUNT(*) AS c FROM `{TP}pages`
                     WHERE `visibility` != 'deleted' AND `language` != ''
                     GROUP BY `language` ORDER BY c DESC"
                )
            ),
        ]);
    }

    private function viewModules(array $extra = []): void
    {
        $open = (string) ($extra['open'] ?? ($_GET['open'] ?? ''));
        $rows = $this->modules->listModules(self::SHOW_ALL_KINDS);
        $vars = $this->modulesTableVars() + [
            'rows'        => $rows,
            'type_counts' => array_count_values(array_column($rows, 'type')),
            'open'        => $open,
            // Page / section links in the page list (same anchor rule as
            // admin/pages/modify.php: SEC_ANCHOR, or 'sec_anchor_' if empty).
            'admin_url'   => ADMIN_URL,
            'sec_anchor'  => defined('SEC_ANCHOR') && SEC_ANCHOR ? SEC_ANCHOR : 'sec_anchor_',
            'icons_url'   => WB_URL . '/include/wbeSelect/icons/',
            // Semi-config help in the MarkdownWbce reader (core module):
            // help_semi_konfig_<LANG>.md, else help_semi_konfig.md (EN).
            'help_url' => class_exists('MdReaderLink')
                ? MdReaderLink::file('/modules/wbce_search/help_semi_konfig.md')->title('WBCE Search — Semi-Config')->url()
                : '',
        ];
        if ($open !== '') {
            $vars['semi'] = $this->semiVars($open);
        }
        $this->render('modules', $vars);
    }

    /**
     * Layout tab: per layout (search page, tag cloud) the files to pick from,
     * plus the stylesheet. ?edit=<layout> opens the editor on that layout's
     * own copy (<x>_custom.htt) — only that file is ever edited.
     */
    private function viewLayout(): void
    {
        $edit = (string) ($_GET['edit'] ?? '');
        if (WbceSearchLayouts::isTarget($edit) && is_file(WbceSearchLayouts::customPath($edit))) {
            $path = WbceSearchLayouts::customPath($edit);
            // CodeEditor queues its assets via I:: — that only works on a full
            // page load, which is why 'layout' is in FULL_LOAD_VIEWS.
            CodeEditor::init('wss_layout_content', $edit === 'css' ? 'css' : 'htt', [
                'height'    => 560,
                'toolbar'   => true,
                'ajax_save' => true,
                'ajax_url'  => WB_URL . '/modules/wbce_search/ajax_save_layout.php',
                'ajax_data' => ['idKey' => $this->admin->getIDKEY(true), 'layout' => $edit],
            ]);
            $this->render('layout', [
                'mode'           => 'edit',
                'layout'         => $edit,
                'file'           => [
                    'file' => basename($path),
                    'rel'  => 'modules/wbce_search/layouts/' . basename($path),
                ],
                'layout_content' => (string) file_get_contents($path),
            ]);
            return;
        }

        $layouts = [];
        foreach (array_keys(WbceSearchLayouts::LAYOUTS) as $layout) {
            $options = WbceSearchLayouts::options($layout);
            foreach ($options as &$o) {
                $o['modified'] = $this->localDate($o['mtime']);
            }
            unset($o);
            $layouts[$layout] = [
                'options'     => $options,
                'active'      => WbceSearchLayouts::active($layout),
                'custom_file' => WbceSearchLayouts::LAYOUTS[$layout]['custom'],
            ];
        }
        $stylesheets = WbceSearchLayouts::stylesheets();
        foreach ($stylesheets as &$s) {
            $s['modified'] = $s['mtime'] ? $this->localDate($s['mtime']) : '';
        }
        unset($s);
        $this->render('layout', [
            'mode'           => 'list',
            'layouts'        => $layouts,
            'stylesheets'    => $stylesheets,
            'css_custom'     => WbceSearchLayouts::CUSTOM_CSS,
            'stylesheet'     => WbceSearchLayouts::activeStylesheet(),
            'template_title' => WbceSearchLayouts::templateTitle(),
            'template_name'  => WbceSearchLayouts::templateName(),
        ]);
    }

    private function viewSettings(): void
    {
        $groups = [];
        foreach (WbceSearchSettings::SCHEMA as $name => $def) {
            $groups[$def['group']][$name] = $def;
        }
        $this->render('settings', [
            'values'          => WbceSearchSettings::all(),
            'groups'          => $groups,
            'site_language'   => defined('DEFAULT_LANGUAGE') ? DEFAULT_LANGUAGE : LANGUAGE,
            'ajax_endpoint'   => WB_URL . '/search/index.php?ws_ajax=1&q=…',
            'frontend_templates' => WbceSearchSettings::templates(),
            'default_template'   => defined('DEFAULT_TEMPLATE') ? DEFAULT_TEMPLATE : '',
        ] + $this->wordsState());
    }

    /** Word index state for the settings view (see WbceSearchWords). */
    private function wordsState(): array
    {
        $on = WbceSearchWords::isActive($this->db);
        return [
            'words_mode'      => (string) WbceSearchSettings::get('word_index'),
            'words_active'    => $on,
            'words_threshold' => (int) WbceSearchSettings::get('word_index_threshold'),
            'words_backlog'   => $on ? WbceSearchWords::backlog($this->db) : 0,
            'words_rows'      => $on ? (int) $this->db->fetchValue("SELECT COUNT(*) FROM `{TP_SEARCH}words`") : 0,
            'index_count'     => (int) $this->db->fetchValue("SELECT COUNT(*) FROM `{TP_SEARCH}index` WHERE `searching` = 1"),
        ];
    }

    private function viewStats(): void
    {
        // count = searches with hits (tag cloud), misses = searches without
        // (trackMiss() stores the whole query). Two lists, same table.
        $rows = $this->db->fetchAll(
            "SELECT `term`, `count`, `last_search` FROM `{TP_SEARCH}stats`
             WHERE `count` > 0 ORDER BY `count` DESC, `last_search` DESC LIMIT 100"
        );
        $misses = $this->db->fetchAll(
            "SELECT `term`, `misses`, `last_search` FROM `{TP_SEARCH}stats`
             WHERE `misses` > 0 ORDER BY `misses` DESC, `last_search` DESC LIMIT 100"
        );
        foreach ([&$rows, &$misses] as &$list) {
            foreach ($list as &$r) {
                $r['last'] = $r['last_search'] ? $this->localDate((int) $r['last_search']) : '—';
            }
            unset($r);
        }
        unset($list);
        $this->render('stats', [
            'rows'     => $rows,
            'misses'   => $misses,
            'total'    => (int) $this->db->fetchValue("SELECT COUNT(*) FROM `{TP_SEARCH}stats` WHERE `count` > 0"),
            'misses_total' => (int) $this->db->fetchValue("SELECT COUNT(*) FROM `{TP_SEARCH}stats` WHERE `misses` > 0"),
            'searches' => (int) $this->db->fetchValue("SELECT COALESCE(SUM(`count`),0) FROM `{TP_SEARCH}stats`"),
            'tracking' => (bool) WbceSearchSettings::get('tagcloud_track'),
        ]);
    }

    // ── Modules: editor fragments ─────────────────────────────────────────

    /**
     * Modules view: list snippets, output filters and admin tools too (with
     * a "Type" column and type checkboxes)? Off: only page modules have
     * sections, so the others never have anything to index or configure.
     * Kept switchable in case that changes.
     */
    private const SHOW_ALL_KINDS = false;

    /** Shared by the table and the editor row (its colspan). */
    private function modulesTableVars(): array
    {
        return ['show_kinds' => self::SHOW_ALL_KINDS, 'cols' => self::SHOW_ALL_KINDS ? 6 : 5];
    }

    private function modulesPartial(string $partial): void
    {
        $mod  = preg_replace('/[^A-Za-z0-9_]/', '', (string) ($_GET['mod'] ?? ''));
        $slot = max(0, min(WbceSearchModules::MAX_JOINS - 1, (int) ($_GET['slot'] ?? 0)));
        [$template, $vars] = match ($partial) {
            // Semi-config editor for one module (lazy — before 0.4 all 45
            // editors were pre-rendered into one 6 MB page): a whole <tr>,
            // swapped in right after the module's row (hx-swap="afterend").
            'semi' => ['partials/semi_row.twig', ['semi' => $this->semiVars($mod), 'mod' => $mod]],
            // Main-table column block, re-rendered by PHP when the table
            // select changes — same code path as the first render, so the
            // text-column checkboxes can't go stale any more.
            'semi_cols' => ['partials/semi_columns.twig',
                ['semi' => $this->semiVars($mod, $this->requestedMainTable()), 'mod' => $mod]],
            'join_cols' => ['partials/semi_join.twig',
                $this->joinVars($mod, $slot, ['table' => (string) ($_GET['semi']['joins'][$slot]['table'] ?? '')])],
            default => [null, []],
        };
        if ($template === null) {
            http_response_code(404);
            return;
        }
        $html = $this->twig->load($template)->render($this->baseVars('modules') + $this->modulesTableVars() + $vars);

        // Fragments go out bare. The AdminTools runner wraps a no_page answer
        // in <div class="adminModuleWrapper">; around the editor's <tr> that
        // div would break the table, since the browser can't place a <tr>
        // inside a <div>.
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        echo $html;
        exit;
    }

    /** Main table currently chosen in the editor (form field semi[table]), '' if none. */
    private function requestedMainTable(): string
    {
        return is_array($_GET['semi'] ?? null) ? (string) ($_GET['semi']['table'] ?? '') : '';
    }

    /** Editor variables; $table overrides the saved table (live table switch). */
    private function semiVars(string $mod, ?string $table = null): array
    {
        $data = $this->modules->semiData($mod);
        if ($table !== null && $table !== $data['table']) {
            $data = array_merge($data, ['table' => $table, 'fields' => [], 'id_field' => 'section_id',
                'item_key' => '', 'title' => '', 'link' => '', 'image' => '']);
        }
        $mainTables = $this->modules->mainTables();
        if (!in_array($data['table'], $mainTables, true)) {
            $data['table'] = '';
        }
        $joins = [];
        for ($i = 0; $i < WbceSearchModules::MAX_JOINS; $i++) {
            $joins[] = $this->joinVars($mod, $i, $data['joins'][$i] ?? []);
        }
        return [
            'mod'          => $mod,
            'data'         => $data,
            'columns'      => $data['table'] ? $this->modules->columns($data['table']) : [],
            'text_columns' => $data['table'] ? $this->modules->textColumns($data['table']) : [],
            'main_tables'  => $mainTables,
            'own_prefix'   => 'mod_' . $mod,
            'joins'        => $joins,
            'def_kind'     => $this->modules->defKind($mod),
            'is_semi'      => isset($this->modules->customModules()[$mod]),
            'has_search'   => $this->modules->hasSearchPhp($mod),
            'has_guide'    => $this->modules->hasGuide($mod),
        ];
    }

    private function joinVars(string $mod, int $slot, array $join): array
    {
        $table = (string) ($join['table'] ?? '');
        $all   = $this->modules->joinTables();
        if (!in_array($table, $all, true)) $table = '';
        return [
            'mod'          => $mod,
            'slot'         => $slot,
            'join'         => $join + ['type' => 'LEFT', 'on_main' => '', 'on_join' => '', 'fields' => [],
                                       'image' => '', 'image_path' => '', 'link' => ''],
            'jtable'       => $table,
            'join_tables'  => $all,
            'own_prefix'   => 'mod_' . $mod,
            'jcolumns'     => $table ? array_keys($this->modules->columns($table)) : [],
            'jtext'        => $table ? $this->modules->textColumns($table) : [],
            'main_columns' => array_keys($this->modules->columns(
                $this->requestedMainTable() ?: $this->modules->semiData($mod)['table']
            )),
        ];
    }

    // ── POST operations ───────────────────────────────────────────────────

    private function handlePost(string $view): void
    {
        if (!$this->admin->checkFTAN()) {
            $this->respond($view, L_('SEARCH:MSG_SECURITY_ERROR'), 'error');
            return;
        }
        $op  = (string) ($_POST['op'] ?? '');
        $mod = preg_replace('/[^A-Za-z0-9_]/', '', (string) ($_POST['mod'] ?? ''));

        try {
            [$msg, $type, $extra] = match ($op) {
                'rebuild'         => $this->opRebuild(false),
                'smart_rebuild'   => $this->opRebuild(true),
                'clear_index'     => $this->opClearIndex(),
                'build_words'     => $this->opBuildWords(),
                'set_site_search' => $this->opSetSiteSearch(),
                'save_settings'   => $this->opSaveSettings(),
                'clear_stats'     => $this->opSql("DELETE FROM `{TP_SEARCH}stats`", 'MSG_STATS_DELETED'),
                'delete_term'     => $this->opDeleteTerm(),
                'save_semi'       => $this->opSaveSemi($mod),
                // Saves the posted editor state first, so unsaved edits are not lost.
                'gen_def'         => $this->opModule($mod, function () use ($mod) {
                    $this->modules->saveSemi($mod, (array) ($_POST['semi'] ?? []));
                    $this->modules->generateDef($mod);
                }, 'MSG_DEF_GENERATED'),
                'delete_semi'     => $this->opModule($mod, fn () => $this->modules->deleteConfig($mod), 'MSG_SEMI_DELETED', false),
                'import_search'   => $this->opImport($mod),
                'layout_pick'     => $this->opLayoutPick(),
                'layout_create'   => $this->opLayoutCreate(),
                'layout_save'     => $this->opLayoutSave(),
                'layout_delete'   => $this->opLayoutDelete(),
                'stylesheet_pick' => $this->opStylesheetPick(),
                default          => [L_('SEARCH:MSG_SECURITY_ERROR'), 'error', []],
            };
        } catch (\Throwable $e) {
            trigger_error('[wbce_search] op ' . $op . ': ' . $e->getMessage(), E_USER_WARNING);
            [$msg, $type, $extra] = [L_('SEARCH:LABEL_ERROR') . ': ' . $e->getMessage(), 'error', ['open' => $mod]];
        }
        $this->respond($view, $msg, $type, $extra);
    }

    private function opRebuild(bool $smart): array
    {
        $indexer = new WbceSearchIndexer($this->db);
        $count   = $smart ? $indexer->smartRebuild() : $indexer->rebuild();
        if ($this->db->hasError()) {
            throw new RuntimeException($this->db->getError());
        }
        // Plural forms incl. the n = 0 wording ("Nothing to update.") live in the language file.
        $msg = Ln_($smart ? 'SEARCH:MSG_INDEX_UPDATED' : 'SEARCH:MSG_INDEX_BUILT', $count);
        $msg .= $this->buildWords();
        $this->refreshVocabulary();
        return [$msg, 'success', []];
    }

    /**
     * Typo vocabulary (WbceSearchFuzzy) after the index changed: drop it, and
     * on large sites rebuild it here — visitor requests never do the full
     * word-table scan there. Small sites rebuild it on demand.
     */
    private function refreshVocabulary(): void
    {
        WbceSearchFuzzy::invalidate();
        if (WbceSearchWords::usable($this->db)) {
            WbceSearchFuzzy::build($this->db);
        }
    }

    /**
     * Word index (large sites): tokenise what is pending within a time budget
     * that leaves room inside a typical 30 s max_execution_time. Whatever is
     * left is reported; "Continue" (op build_words) or visitor searches work
     * it off, and the search keeps using the row scan until it is complete.
     * Returns a sentence to append to the toast ('' when inactive).
     */
    private function buildWords(): string
    {
        WbceSearchWords::reset();   // entry count may just have changed
        if (!WbceSearchWords::isActive($this->db)) {
            return '';
        }
        WbceSearchWords::pruneOrphans($this->db);
        $done = WbceSearchWords::backfill($this->db, PHP_INT_MAX, 20.0);
        if ($done > 0 && $this->db->getDriver() === 'mysql') {
            // Fresh statistics: right after a bulk load InnoDB still estimates
            // ~1 row per word and picks bad plans (measured: a two-term query
            // 2.7 s before, 0.26 s after ANALYZE on 5 000 entries).
            $this->db->fetchAll("ANALYZE TABLE `{TP_SEARCH}words`, `{TP_SEARCH}index`");
        }
        $left = WbceSearchWords::backlog($this->db);
        return ' ' . ($left > 0 ? Ln_('SEARCH:MSG_WORDS_PENDING', $left) : L_('SEARCH:MSG_WORDS_READY'));
    }

    private function opBuildWords(): array
    {
        $msg = trim($this->buildWords());
        $this->refreshVocabulary();
        return [$msg !== '' ? $msg : L_('SEARCH:WORDS_INACTIVE'), 'success', []];
    }

    private function opClearIndex(): array
    {
        $this->db->query("DELETE FROM `{TP_SEARCH}index`");
        if (WbceSearchWords::available($this->db)) {
            WbceSearchWords::clear($this->db);
        }
        WbceSearchFuzzy::invalidate();
        if ($this->db->hasError()) throw new RuntimeException($this->db->getError());
        return [L_('SEARCH:MSG_INDEX_DELETED'), 'success', []];
    }

    /** DELETE instead of TRUNCATE: works inside transactions and on SQLite. */
    private function opSql(string $sql, string $msgKey): array
    {
        $this->db->query($sql);
        if ($this->db->hasError()) throw new RuntimeException($this->db->getError());
        return [L_('SEARCH:' . $msgKey), 'success', []];
    }

    /** Values of the core setting "search" (Settings → Search). */
    private const SITE_SEARCH_MODES = ['public', 'registered', 'private', 'none'];

    private function siteSearchMode(): string
    {
        $mode = (string) Settings::get('search', 'public');
        return in_array($mode, self::SITE_SEARCH_MODES, true) ? $mode : 'public';
    }

    /**
     * Writes the CORE setting "search" (who may search the website) — on
     * purpose with no more than the tool permission: this tool is where the
     * search is run. Exactly this one key, one of its four values; FTAN is
     * checked by handlePost().
     */
    private function opSetSiteSearch(): array
    {
        $mode = (string) ($_POST['search'] ?? '');
        if (!in_array($mode, self::SITE_SEARCH_MODES, true)) {
            return [L_('SEARCH:MSG_SECURITY_ERROR'), 'error', []];
        }
        $err = Settings::set('search', $mode);
        if ($err) {
            throw new RuntimeException((string) $err);
        }
        return [sprintf(L_('SEARCH:MSG_SITE_SEARCH_SAVED'), L_('SEARCH:SITE_SEARCH_' . strtoupper($mode))), 'success', []];
    }

    private function opSaveSettings(): array
    {
        $before = WbceSearchSettings::get('nav_style');
        WbceSearchSettings::save($_POST, array_unique(array_column(WbceSearchSettings::SCHEMA, 'group')));
        if (WbceSearchSettings::get('nav_style') !== $before) {
            // The shell itself changes — reload the whole page.
            $this->alerts->sessionToast(L_('SEARCH:MSG_SETTINGS_SAVED'), 'success');
            header('HX-Trigger: ' . json_encode(['reloadPage' => true]));
            exit;
        }
        return [L_('SEARCH:MSG_SETTINGS_SAVED'), 'success', []];
    }

    private function opDeleteTerm(): array
    {
        $this->db->query("DELETE FROM `{TP_SEARCH}stats` WHERE `term` = ?", [(string) ($_POST['term'] ?? '')]);
        if ($this->db->hasError()) throw new RuntimeException($this->db->getError());
        return [L_('SEARCH:MSG_TERM_DELETED'), 'success', []];
    }

    private function opSaveSemi(string $mod): array
    {
        try {
            $this->modules->saveSemi($mod, (array) ($_POST['semi'] ?? []));
        } catch (InvalidArgumentException) {
            return [L_('SEARCH:MSG_SEMI_INVALID_TABLE'), 'error', ['open' => $mod]];
        }
        return [sprintf(L_('SEARCH:MSG_SEMI_SAVED'), $mod), 'success', ['open' => $mod]];
    }

    private function opModule(string $mod, callable $fn, string $msgKey, bool $keepOpen = true): array
    {
        $fn();
        return [sprintf(L_('SEARCH:' . $msgKey), $mod), 'success', $keepOpen ? ['open' => $mod] : []];
    }

    private function opImport(string $mod): array
    {
        try {
            $this->modules->importFromSearchPhp($mod);
        } catch (InvalidArgumentException) {
            return [sprintf(L_('SEARCH:MSG_IMPORT_FAILED'), $mod), 'error', []];
        }
        return [sprintf(strip_tags(L_('SEARCH:MSG_SEMI_PRESET')), $mod), 'success', ['open' => $mod]];
    }

    /** Save button with AjaxSave off: plain form POST, then redirect back (PRG). */
    // ── Layout tab ────────────────────────────────────────────────────────

    /** The posted editor target, validated ('search' | 'tagcloud' | 'css'). */
    private function postedLayout(): string
    {
        $layout = (string) ($_POST['layout'] ?? '');
        if (!WbceSearchLayouts::isTarget($layout)) {
            throw new RuntimeException(L_('SEARCH:MSG_SECURITY_ERROR'));
        }
        return $layout;
    }

    private function opLayoutPick(): array
    {
        $layout = $this->postedLayout();
        if ($layout === 'css') {
            throw new RuntimeException(L_('SEARCH:MSG_SECURITY_ERROR'));   // stylesheet: op stylesheet_pick
        }
        $source = (string) ($_POST['source'] ?? '');
        WbceSearchLayouts::setActive($layout, $source);
        $file = WbceSearchLayouts::LAYOUTS[$layout][$source];
        return [sprintf(L_('SEARCH:MSG_LAYOUT_ACTIVE'), $file), 'success', []];
    }

    /** "Edit" on the template's or the default file: copy it to <x>_custom.htt, then open the editor. */
    private function opLayoutCreate(): array
    {
        $layout = $this->postedLayout();
        WbceSearchLayouts::createCustom($layout, (string) ($_POST['from'] ?? ''));
        return [sprintf(L_('SEARCH:MSG_LAYOUT_CREATED'), WbceSearchLayouts::customName($layout)), 'success', ['edit' => $layout]];
    }

    /** Editor form POST (AjaxSave off). "Save & back" returns to the list. */
    private function opLayoutSave(): array
    {
        $layout = $this->postedLayout();
        WbceSearchLayouts::writeCustom($layout, (string) ($_POST['layout_content'] ?? ''));
        return [L_('{MESSAGE:CHANGES_SAVE_SUCCESS}'), 'success', empty($_POST['back']) ? ['edit' => $layout] : []];
    }

    private function opLayoutDelete(): array
    {
        $layout = $this->postedLayout();
        WbceSearchLayouts::deleteCustom($layout);
        return [sprintf(L_('SEARCH:MSG_LAYOUT_DELETED'), WbceSearchLayouts::customName($layout)), 'success', []];
    }

    private function opStylesheetPick(): array
    {
        $id = (string) ($_POST['stylesheet'] ?? '');
        WbceSearchLayouts::setStylesheet($id);
        $label = WbceSearchLayouts::stylesheets()[$id]['file'] ?: L_('SEARCH:LAYOUT_CSS_NONE');
        return [sprintf(L_('SEARCH:MSG_STYLESHEET_ACTIVE'), $label), 'success', []];
    }

    /**
     * HTMX: toast + re-rendered view fragment. No JS / full-load views:
     * session toast + redirect back (PRG), runner buffer discarded first.
     */
    private function respond(string $view, string $msg, string $type, array $extra = []): void
    {
        if ($this->isHtmx && !in_array($view, self::FULL_LOAD_VIEWS, true)) {
            $this->alerts->toast($msg, $type);
            $this->showView($view, $extra);
            return;
        }
        $this->alerts->sessionToast($msg, $type);
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        $url = $this->toolUrl . '&action=' . $view
            . (!empty($extra['open']) ? '&open=' . urlencode($extra['open']) : '')
            . (!empty($extra['edit']) ? '&edit=' . urlencode($extra['edit']) : '');
        header('Location: ' . $url);
        exit;
    }

    // ── Rendering ─────────────────────────────────────────────────────────

    private function baseVars(string $view): array
    {
        return [
            'active'          => $view,
            'views'           => self::VIEWS,
            'full_load_views' => self::FULL_LOAD_VIEWS,
            'nav_partial'     => $this->navPartial,
        ];
    }

    /** Bare fragment for HTMX, shell-wrapped for a normal page load. */
    private function render(string $view, array $vars): void
    {
        $vars += $this->baseVars($view);
        $contentPath = 'content/' . $view . '.twig';
        if ($this->isHtmx) {
            $this->twig->load($contentPath)->display($vars);
            return;
        }
        $this->twig->load('_shell.twig')->display($vars + ['content_template' => $contentPath]);
    }

    /** Raw UTC epoch → the admin's date and time format, in their zone. */
    private function localDate(int $ts): string
    {
        return DateTimeFormat::dateTime($ts);
    }
}
