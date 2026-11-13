<?php
/**
 * wbce_search - WbceSearchIndexer.php
 * Fills {TP_SEARCH}index from the page sections: full rebuild,
 * smart rebuild (changed sections), lazy reindex (a few per search).
 *
 * Per section the content comes from, in this order: the module's own
 * search_index.php, an admin semi-config, module_defs/<module>.php — each
 * either a table definition (indexByDef()) or a callback — else page
 * metadata only. How a module writes its search_index.php:
 * SEARCH_INDEX_HOWTO.md.
 *
 * Callback API (unchanged since 0.3; modules' own search_index.php use it):
 *   fn(Database $database, array $def, array $section,
 *      int $pid, int $sid, string $module,
 *      string $page_title, string $description, string $keywords,
 *      string $visibility, int $searching, int $now): int   (rows written)
 *
 * 'callback' is any PHP callable: a closure, [Class::class, 'method'] or a
 * function name.
 *
 * @module    wbce_search
 * @author    Peter Kitzinger (Slugger)
 * @author    Christian M. Stefan (https://www.wbEasy.de)
 * @copyright WBCE Project (2026-)
 * @license   GNU General Public License
 * @platform  WBCE 1.7.0+
 *
 * Developed with AI assistance (Claude).
 */

declare(strict_types=1);

defined('WB_PATH') or die('No direct access');

final class WbceSearchIndexer
{
    /** Name of the file a module ships to describe its own search indexing. */
    public const MODULE_SEARCH_FILE = 'search_index.php';

    private const INDEX = '{TP_SEARCH}index';

    /** Columns of the section rows every run works on (sections + pages). */
    private const SECTION_COLUMNS =
        's.section_id, s.page_id, s.module,
         p.page_title, p.menu_title, p.description, p.keywords,
         p.link, p.visibility, p.searching, p.language,
         p.viewing_groups, p.viewing_users, p.modified_when';

    /** Pages whose sections are indexed at all. */
    private const SEARCHABLE =
        "p.visibility NOT IN ('none','deleted')
         AND p.searching = '1'
         AND (s.block IS NULL OR s.block != 99)";

    /** @var array<string, array|null> module definitions, per request */
    private static array $defCache = [];

    public function __construct(private Database $db)
    {
    }

    // ── Runs ────────────────────────────────────────────────────────────────

    /**
     * Full rebuild — deletes and rebuilds from scratch, in ONE transaction:
     * a run that dies halfway no longer leaves a half-empty index behind, and
     * on SQLite the thousands of inserts are one commit instead of one each.
     * A failing section is skipped inside indexSections(); only a failure
     * of the rebuild itself rolls back (the old index stays) and throws.
     *
     * @return int entries written
     */
    public function rebuild(): int
    {
        return $this->db->transaction(function (Database $db): int {
            // DELETE, not TRUNCATE: portable (SQLite) and transaction-safe.
            $db->query("DELETE FROM `" . self::INDEX . "`");
            if (WbceSearchWords::available($db)) {
                WbceSearchWords::clear($db);
            }
            return $this->indexSections($this->indexableSections());
        });
    }

    /** Smart rebuild — only changed or missing sections. */
    public function smartRebuild(): int
    {
        $this->prune();
        return $this->indexSections($this->staleSections(null));
    }

    /**
     * Lazy reindex — at most $limit stale sections; runs inside a visitor's
     * search request. The word index (large sites only) then tokenises what
     * was just re-indexed plus a small slice of any backlog — bounded too.
     */
    public function lazyReindex(int $limit = 5): int
    {
        $this->prune();
        $count = $this->indexSections($this->staleSections($limit));

        if (WbceSearchWords::isActive($this->db)) {
            WbceSearchWords::backfill($this->db, $count + 25, 1.0);
        }
        return $count;
    }

    /**
     * Drops index rows whose section is gone or whose page is no longer
     * searchable (trash, visibility "none", searching = 0). Smart/lazy reindex
     * only ever look at searchable pages, so without this such rows survived
     * until the next full rebuild. (The search itself also checks the live page
     * state — this keeps the table and the admin counters honest.)
     */
    public function prune(): void
    {
        $this->db->query(
            "DELETE FROM `" . self::INDEX . "`
             WHERE `section_id` NOT IN (
                 SELECT s.section_id FROM `{TP}sections` s
                 INNER JOIN `{TP}pages` p ON s.page_id = p.page_id
                 WHERE p.visibility NOT IN ('none','deleted') AND p.searching = '1'
             )"
        );
    }

    /**
     * Index a list of section rows (columns: SECTION_COLUMNS).
     *
     * @return int entries written
     */
    public function indexSections(?array $rows): int
    {
        if (empty($rows)) {
            return 0;
        }

        $now   = time();
        $count = 0;

        // Before anything is tokenised: the stop words follow the site's
        // page languages, which may just have changed with these sections.
        $this->syncStopwordLanguages();

        // Semi-configs from the admin tool (custom_modules), per module.
        $custom = WbceSearchSettings::get('custom_modules');
        $custom = is_array($custom) ? $custom : [];

        $wordsActive = WbceSearchWords::isActive($this->db);

        foreach ($rows as $section) {
            $written = $this->indexSection($section, $custom, $wordsActive, $now);
            $count  += $written;

            // Nothing indexable in this section (no items, all filtered,
            // external MD file …): store a marker so the section counts as
            // processed. Without it the section stayed "stale" forever — the
            // stale badge never cleared, Update reported "nothing to update",
            // and the lazy reindex re-processed it on every single search.
            if ($written === 0) {
                $this->insertMarker((int) $section['page_id'], (int) $section['section_id'], (string) ($section['module'] ?? ''), $now);
            }
        }

        // A module's own callback (search_index.php) writes its rows itself and
        // may still store absolute URLs — bring them into the stored form too.
        $this->tokenizeUrls(array_map(fn(array $r): int => (int) $r['section_id'], $rows));

        return $count;
    }

    /**
     * Replace the absolute site URL in detail_url/thumb_url by
     * WbceSearch::URL_TOKEN. $sectionIds limits it to those sections (indexer
     * run); null converts the whole table (upgrade from < 0.5.1).
     * REPLACE() and LIKE … ESCAPE exist on MySQL and SQLite alike; '!' is the
     * escape character because a backslash is read differently by the two.
     */
    public function tokenizeUrls(?array $sectionIds = null): void
    {
        if ($sectionIds === []) {
            return;
        }

        $like        = str_replace(['!', '%', '_'], ['!!', '!%', '!_'], WB_URL) . '%';
        $scope       = '';
        $scopeParams = [];
        if ($sectionIds !== null) {
            $scope       = ' AND `section_id` IN (' . implode(',', array_fill(0, count($sectionIds), '?')) . ')';
            $scopeParams = array_values($sectionIds);
        }
        foreach (['detail_url', 'thumb_url'] as $col) {
            $this->db->query(
                "UPDATE `" . self::INDEX . "`
                    SET `$col` = REPLACE(`$col`, ?, ?)
                  WHERE `$col` LIKE ? ESCAPE '!'" . $scope,
                array_merge([WB_URL, WbceSearch::URL_TOKEN, $like], $scopeParams)
            );
        }
    }

    // ── Module definitions ──────────────────────────────────────────────────

    /**
     * The index definition of a module, cached per request (the indexer asks
     * once per section). Order: modules/MODULE/search_index.php (the module's
     * own, see SEARCH_INDEX_HOWTO.md) → module_defs/MODULE.php → alias check →
     * null. A semi-config from the admin tool comes between the module's own
     * file and module_defs/; that is decided in indexSection().
     */
    public static function moduleDef(string $module): ?array
    {
        if (!array_key_exists($module, self::$defCache)) {
            self::$defCache[$module] = self::findModuleDef($module);
        }
        return self::$defCache[$module];
    }

    /** Does the module ship its own modules/<module>/search_index.php? */
    public static function hasOwnDef(string $module): bool
    {
        $module = (string) preg_replace('/[^A-Za-z0-9_\-]/', '', $module);
        return $module !== '' && is_file(WB_PATH . '/modules/' . $module . '/' . self::MODULE_SEARCH_FILE);
    }

    /** Uncached lookup — see moduleDef(). */
    public static function findModuleDef(string $module): ?array
    {
        $module = (string) preg_replace('/[^A-Za-z0-9_\-]/', '', $module);
        if ($module === '') {
            return null;
        }

        // The module's own definition — lets e.g. VES ship its indexer itself,
        // so wbce_search never needs to know the module's data format.
        $own = WB_PATH . '/modules/' . $module . '/' . self::MODULE_SEARCH_FILE;
        if (is_file($own)) {
            $def = self::requireDef($own, false);
            if (is_array($def)) {
                return $def;
            }
        }

        $defDir = WB_PATH . '/modules/wbce_search/module_defs/';

        // Direct file
        $file = $defDir . $module . '.php';
        if (file_exists($file)) {
            $def = self::requireDef($file, true);
            return is_array($def) ? $def : null;
        }

        // Alias check: search all defs for 'aliases'
        foreach (glob($defDir . '*.php') ?: [] as $f) {
            if (basename($f) === 'index.php' || str_contains(basename($f), 'NOTINUSED')) {
                continue;
            }
            $d = self::requireDef($f, true);
            if (is_array($d) && isset($d['aliases']) && in_array($module, $d['aliases'], true)) {
                return $d;
            }
        }

        return null;
    }

    /**
     * A definition file's return value, required in an empty scope. Files of
     * module_defs/ skip the opcache: they are edited in place (guides).
     */
    private static function requireDef(string $file, bool $fresh): mixed
    {
        if ($fresh && function_exists('opcache_invalidate')) {
            opcache_invalidate($file, true);
        }
        return (static function (string $__file) { return require $__file; })($file);
    }

    // ── One section ─────────────────────────────────────────────────────────

    /**
     * Re-index one section: its old rows go, new ones come from its
     * definition. One broken section (a module's table gone, a callback that
     * throws, a failed delete) skips itself instead of ending the whole run —
     * and inside rebuild()'s transaction, where Database rethrows every SQL
     * error, instead of rolling the rebuild back.
     *
     * @return int entries written
     */
    private function indexSection(array $section, array $custom, bool $wordsActive, int $now): int
    {
        $sid    = (int) $section['section_id'];
        $pid    = (int) $section['page_id'];
        $module = (string) ($section['module'] ?? '');

        // Page metadata
        $pageTitle   = !empty($section['page_title']) ? (string) $section['page_title'] : (string) ($section['menu_title'] ?? '');
        $description = strip_tags(html_entity_decode((string) ($section['description'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $keywords    = strip_tags(html_entity_decode((string) ($section['keywords'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $visibility  = (string) ($section['visibility'] ?? 'public');
        $searching   = (int) ($section['searching'] ?? 1);

        try {
            // Delete existing entries for this section (and their word-index
            // rows — the re-inserted entries get new ids and tokenized = 0).
            if ($wordsActive) {
                WbceSearchWords::deleteSection($this->db, $sid);
            }
            $this->db->query("DELETE FROM `" . self::INDEX . "` WHERE `section_id` = ?", [$sid]);
            if ($this->db->hasError()) {
                throw new RuntimeException($this->db->getError());
            }

            // Precedence: the module's own search_index.php > admin semi-config >
            // module_defs/. The module knows its data rules (drafts, groups,
            // rights) and the admin tool offers no semi-config for it; a
            // semi-config still beats a module_defs file (before 0.4 it did not,
            // although the admin tool said so).
            $useCustom = !empty($custom[$module]) && !self::hasOwnDef($module);
            $def  = $useCustom ? $custom[$module] : self::moduleDef($module);
            $args = [$this->db, $def, $section, $pid, $sid, $module, $pageTitle, $description, $keywords, $visibility, $searching, $now];

            if (!empty($def['callback'])) {
                // Callback indexer (MD Viewer, VES, CatalogueHub …). One that
                // cannot be called is an error in the definition: the section
                // gets nothing (a marker) and a log line — falling back to the
                // table definition would index it differently than intended,
                // and a typo in the callback name would go unnoticed.
                if (!is_callable($def['callback'])) {
                    throw new RuntimeException('callback is not callable: ' . self::describeCallback($def['callback']));
                }
                return (int) call_user_func_array($def['callback'], $args);
            }
            if (!empty($def['table']) || $useCustom) {
                // Definition-based indexer (module_defs, search_index.php,
                // semi-config — a semi-config without a table writes nothing)
                return $this->indexByDef(...array_slice($args, 1));
            }

            // Generic fallback: page metadata only
            // (keywords + description are indexed as their own fields)
            $content = trim($this->genericContent($module, $sid, $custom));
            if ($content === '' && $pageTitle === '') {
                return 0;
            }
            $this->db->insertRow(self::INDEX, [
                'page_id'     => $pid,
                'section_id'  => $sid,
                'item_id'     => 0,
                'module'      => $module,
                'title'       => $pageTitle,
                'item_title'  => '',
                'description' => $description,
                'keywords'    => $keywords,
                'content'     => $content,
                'detail_url'  => '',
                'thumb_url'   => '',
                'visibility'  => $visibility,
                'searching'   => $searching,
                'indexed_at'  => $now,
            ]);
            return $this->db->hasError() ? 0 : 1;
        } catch (\Throwable $e) {
            trigger_error('[wbce_search] indexing section ' . $sid . ' (' . $module . ') failed: ' . $e->getMessage(), E_USER_WARNING);
            $this->db->setError('');
            return 0;
        }
    }

    /**
     * Index via a table definition — single or multi mode, up to 3 joins.
     * Public: a module callback may hand part of its work to it.
     *
     * @return int entries written
     */
    public function indexByDef(
        array $def, array $section,
        int $pid, int $sid, string $module,
        string $page_title, string $description, string $keywords,
        string $visibility, int $searching, int $now
    ): int {
        $count       = 0;
        $main_alias  = 'm';
        // Identifier, not a value — it cannot be bound, so it is reduced to
        // [A-Za-z0-9_] like the join tables below; {TP} as everywhere else.
        $main_name   = (string) preg_replace('/[^a-zA-Z0-9_]/', '', (string) ($def['table'] ?? ''));
        if ($main_name === '') {
            return 0;
        }
        $main_table  = '{TP}' . $main_name;
        $id_field    = $def['id_field']    ?? 'section_id';
        $item_key    = $def['item_key']    ?? null;
        $title_field = $def['title']       ?? null;
        $fields      = $def['fields']      ?? [];
        $link_field  = $def['link']        ?? null;
        $link_prefix = $def['link_prefix'] ?? '';
        $img_field   = $def['image']       ?? null;
        $img_path    = $def['image_path']  ?? '';
        $mode        = $def['mode']        ?? 'single';
        $index_base  = $def['index_base']  ?? 'page';
        $filter      = $def['filter']      ?? [];
        // Semi-config stores filter_active/filter_time instead of a filter array.
        // Only for columns the table has: the table may have changed since the
        // config was saved, and a table without `active` has no inactive rows.
        if (empty($filter)) {
            if (!empty($def['filter_active']) && $this->db->fieldExists($main_table, 'active')) {
                $filter['active'] = 1;
            }
            if (!empty($def['filter_time']) && $this->db->fieldExists($main_table, 'published_when')
                && $this->db->fieldExists($main_table, 'published_until')) {
                $filter['published_when'] = '<= NOW'; $filter['published_until'] = '>= NOW';
            }
        }
        $joins = array_slice($def['joins'] ?? [], 0, 3); // max. 3 joins

        // ── SELECT ──────────────────────────────────────────────────────────
        // item_key must exist in the table before it goes into the SELECT
        if ($item_key && !$this->db->fieldExists($main_table, $item_key)) {
            $item_key = null;
        }
        $core_fields = array_unique(array_filter(array_merge(
            [$id_field],
            $item_key    ? [$item_key]    : [],
            $title_field ? [$title_field] : [],
            $fields,
            $link_field  ? [$link_field]  : [],
            !$img_field || $img_field === 'joins' ? [] : [$img_field],
        )));
        $select_parts = array_map(fn($f) => "`$main_alias`.`$f`", $core_fields);

        // Join fields with aliases j1, j2, j3
        $join_sql = '';
        foreach ($joins as $i => $join) {
            $ja    = 'j' . ($i + 1);
            $jname = self::ident($join['table'] ?? '');
            $jtype = strtoupper($join['type'] ?? 'LEFT') === 'INNER' ? 'INNER' : 'LEFT';
            $jown  = self::ident($join['on_main'] ?? '');
            $jfgn  = self::ident($join['on_join'] ?? '');
            if ($jname === '' || !$jown || !$jfgn) continue;

            $join_sql .= " $jtype JOIN `{TP}$jname` AS `$ja` ON `$main_alias`.`$jown` = `$ja`.`$jfgn`";

            // Fields from the join table — concatenated for 1:n relations
            // (Database::groupConcat(): GROUP_CONCAT on MySQL, group_concat on SQLite)
            foreach ($join['fields'] ?? [] as $jf) {
                $jf = self::ident($jf);
                if ($jf) $select_parts[] = $this->db->groupConcat("`$ja`.`$jf`", ' ') . " AS `{$ja}_{$jf}`";
            }
            if (!empty($join['image'])) {
                $jimg = self::ident($join['image']);
                $select_parts[] = "MIN(`$ja`.`$jimg`) AS `{$ja}_{$jimg}`";
            }
            if (!empty($join['link'])) {
                $jlnk = self::ident($join['link']);
                $select_parts[] = "MIN(`$ja`.`$jlnk`) AS `{$ja}_{$jlnk}`";
            }
        }

        // ── WHERE + filter ──────────────────────────────────────────────────
        $where  = [];
        $params = [];

        // Pool mode only skips the section_id filter for multi mode;
        // single mode always filters by section_id regardless of index_base.
        if ($index_base === 'page' || $mode === 'single') {
            $where[]  = "`$main_alias`.`$id_field` = ?";
            $params[] = $sid;
        }

        $t = time();
        foreach ($filter as $col => $val) {
            $col = self::ident($col);
            if ($val === '<= NOW') {
                $where[]  = "(`$main_alias`.`$col` = 0 OR `$main_alias`.`$col` <= ?)";
                $params[] = $t;
            } elseif ($val === '>= NOW') {
                $where[]  = "(`$main_alias`.`$col` = 0 OR `$main_alias`.`$col` >= ?)";
                $params[] = $t;
            } else {
                $where[]  = "`$main_alias`.`$col` = ?";
                $params[] = $val;
            }
        }

        $sql = 'SELECT ' . implode(', ', $select_parts) . " FROM `$main_table` AS `$main_alias`" . $join_sql;
        if (!empty($where)) $sql .= ' WHERE ' . implode(' AND ', $where);
        // GROUP BY for joins: no duplicate rows for 1:n relations
        if (!empty($def['joins'])) {
            $sql .= " GROUP BY `$main_alias`.`" . ($item_key ?? $id_field) . '`';
        }

        $items = $this->db->fetchAll($sql, $params);
        if (empty($items)) {
            return 0;
        }

        // ── Index items ─────────────────────────────────────────────────────
        foreach ($items as $item) {
            // Content: main table fields, then join fields
            $content = '';
            foreach ($fields as $f) {
                if (!empty($item[$f])) $content .= ' ' . $item[$f];
            }
            foreach ($joins as $i => $join) {
                foreach ($join['fields'] ?? [] as $jf) {
                    $key = 'j' . ($i + 1) . '_' . self::ident($jf);
                    if (!empty($item[$key])) $content .= ' ' . $item[$key];
                }
            }
            $content = self::plainText($content);

            $item_title = $title_field ? trim((string) ($item[$title_field] ?? '')) : '';

            // detail_url: main table or the first join with a link
            $detail_url    = '';
            $resolved_link = '';
            if ($link_field && $link_field !== 'joins' && !empty($item[$link_field])) {
                $resolved_link = (string) $item[$link_field];
            } else {
                foreach ($joins as $i => $join) {
                    if (empty($join['link'])) continue;
                    $key = 'j' . ($i + 1) . '_' . self::ident($join['link']);
                    if (!empty($item[$key])) { $resolved_link = (string) $item[$key]; break; }
                }
            }
            if ($resolved_link) {
                if (str_starts_with($resolved_link, 'http')) {
                    $detail_url = $resolved_link;
                } elseif ($link_prefix) {
                    // Prefix template: {page_link}, {item_id}, {section_id}, {page_id}
                    $prefix = str_replace(
                        ['{page_link}', '{item_id}', '{section_id}', '{page_id}'],
                        [$section['link'] ?? '', $item[$item_key ?? 'item_id'] ?? 0, $sid, $pid],
                        $link_prefix
                    );
                    $detail_url = WB_URL . PAGES_DIRECTORY . '/' . rtrim($prefix, '/') . '/' . ltrim($resolved_link, '/') . PAGE_EXTENSION;
                } else {
                    $detail_url = WB_URL . PAGES_DIRECTORY . '/' . ltrim($resolved_link, '/') . PAGE_EXTENSION;
                }
            }

            // thumb_url: main table or the first join with an image
            $thumb_url = '';
            if ($img_field && $img_field !== 'joins' && !empty($item[$img_field])) {
                $thumb_url = WB_URL . MEDIA_DIRECTORY . '/' . ltrim(self::resolvePathTemplate((string) $img_path, $item), '/') . $item[$img_field];
            } else {
                foreach ($joins as $i => $join) {
                    if (empty($join['image'])) continue;
                    $key = 'j' . ($i + 1) . '_' . self::ident($join['image']);
                    if (!empty($item[$key])) {
                        $thumb_url = WB_URL . MEDIA_DIRECTORY . '/'
                            . ltrim(self::resolvePathTemplate((string) ($join['image_path'] ?? ''), $item), '/') . $item[$key];
                        break;
                    }
                }
            }

            // item_id only when item_key is defined, else 0 (single mode)
            $item_id = ($item_key !== null) ? (int) ($item[$item_key] ?? 0) : 0;

            // keywords + description are indexed as their own fields
            if (empty($content) && empty($page_title) && empty($item_title)) continue;

            $this->db->insertRow(self::INDEX, [
                'page_id'     => $pid,
                'section_id'  => $sid,
                'item_id'     => $item_id,
                'module'      => $module,
                'title'       => $page_title,
                'item_title'  => $item_title,
                'description' => $description,
                'keywords'    => $keywords,
                'content'     => $content,
                'detail_url'  => WbceSearch::urlToToken($detail_url),
                'thumb_url'   => WbceSearch::urlToToken($thumb_url),
                'visibility'  => $visibility,
                'searching'   => $searching,
                'indexed_at'  => $now,
            ]);
            if (!$this->db->hasError()) $count++;

            if ($mode === 'single') break;
        }
        return $count;
    }

    /** {field} placeholders in an image path ("bakery/thumbs/item{item_id}/") from the item row. */
    public static function resolvePathTemplate(string $tpl, array $item): string
    {
        return (string) preg_replace_callback(
            '/\{([a-zA-Z0-9_]+)\}/',
            fn(array $m): string => (string) ($item[$m[1]] ?? $m[0]),
            $tpl
        );
    }

    // ── Built-in callbacks (module_defs/md_viewer.php, oneforall.php) ───────

    /** MD Viewer: the section's Markdown file (internal sources only) as plain text. */
    public static function indexMdViewer(
        Database $database, array $def, array $section,
        int $pid, int $sid, string $module,
        string $page_title, string $description, string $keywords,
        string $visibility, int $searching, int $now
    ): int {
        $row = $database->fetchRow(
            "SELECT `md_source`, `md_source_type` FROM `{TP}mod_md_viewer` WHERE `section_id` = ?",
            [$sid]
        );
        if (!$row || $row['md_source_type'] !== 'internal' || empty($row['md_source'])) {
            return 0;
        }

        // Only files inside the media folder
        $file_path = realpath(WB_PATH . MEDIA_DIRECTORY . $row['md_source']);
        $base_path = realpath(WB_PATH . MEDIA_DIRECTORY);
        if (!$file_path || !$base_path || !str_starts_with($file_path, $base_path) || !is_file($file_path)) {
            return 0;
        }

        $md_text = (string) file_get_contents($file_path);
        if ($md_text === '') return 0;

        // Markdown syntax out — in this order (code blocks before inline code,
        // images before links). A failing pattern (backtrack limit on a huge
        // file) leaves the text as it is instead of emptying it.
        foreach ([
            '/```[\s\S]*?```/'               => ' ',
            '/`[^`]+`/'                      => ' ',
            '/!\[.*?\]\(.*?\)/'              => ' ',
            '/\[([^\]]+)\]\([^\)]+\)/'       => '$1',
            '/^#{1,6}\s+/m'                  => ' ',
            '/[*_]{1,3}([^*_]+)[*_]{1,3}/'   => '$1',
            '/\[\[.+?\]\]/s'                 => '',
        ] as $pattern => $replacement) {
            $md_text = preg_replace($pattern, $replacement, $md_text) ?? $md_text;
        }
        $content = trim((string) preg_replace('/\s+/', ' ', trim($md_text)));

        if (empty($content) && empty($page_title)) return 0;

        $database->insertRow('{TP_SEARCH}index', [
            'page_id'     => $pid,
            'section_id'  => $sid,
            'item_id'     => 0,
            'module'      => $module,
            'title'       => $page_title,
            'item_title'  => '',
            'description' => $description,
            'keywords'    => $keywords,
            'content'     => $content,
            'detail_url'  => '',
            'thumb_url'   => '',
            'visibility'  => $visibility,
            'searching'   => $searching,
            'indexed_at'  => $now,
        ]);
        return $database->hasError() ? 0 : 1;
    }

    /** OneForAll: one entry per active item — title, description, text fields, first image. */
    public static function indexOneforall(
        Database $database, array $def, array $section,
        int $pid, int $sid, string $module,
        string $page_title, string $description, string $keywords,
        string $visibility, int $searching, int $now
    ): int {
        $mod_name = 'oneforall';

        $items = $database->fetchAll(
            "SELECT i.item_id, i.title, i.link AS item_link, i.description AS item_desc
             FROM `{TP}mod_{$mod_name}_items` i
             WHERE i.section_id = ? AND i.active = 1
             ORDER BY i.position ASC",
            [$sid]
        );
        if (empty($items)) return 0;

        $page_link = $database->fetchValue(
            "SELECT `link` FROM `{TP}pages` WHERE `page_id` = ? LIMIT 1",
            [$pid]
        );

        $count = 0;
        foreach ($items as $item) {
            $item_id    = (int) $item['item_id'];
            $item_title = trim((string) ($item['title'] ?? ''));
            $item_desc  = strip_tags((string) ($item['item_desc'] ?? ''));

            // Text fields from item_fields (type: text, textarea, wysiwyg)
            $field_values = $database->fetchAll(
                "SELECT f.value FROM `{TP}mod_{$mod_name}_item_fields` f
                 INNER JOIN `{TP}mod_{$mod_name}_fields` fd USING(field_id)
                 WHERE f.item_id = ? AND fd.type IN ('text','textarea','wysiwyg')",
                [$item_id]
            );
            $extra_text = implode(' ', array_column($field_values, 'value'));

            // keywords + description are indexed as their own fields
            $content = trim($item_title . ' ' . $item_desc . ' ' . $extra_text);
            $content = strip_tags(html_entity_decode($content, ENT_QUOTES, 'UTF-8'));

            // First active image as thumbnail
            $thumb_file = $database->fetchValue(
                "SELECT `filename` FROM `{TP}mod_{$mod_name}_images`
                 WHERE `item_id` = ? AND `active` = '1' ORDER BY `position` ASC LIMIT 1",
                [$item_id]
            );
            $thumb_url = '';
            if ($thumb_file) {
                // OFA stores thumbs as JPG even when the original is a PNG
                $thumb_jpg = str_replace('.png', '.jpg', (string) $thumb_file);
                $thumb_dir = '/oneforall/thumbs/item' . $item_id . '/';
                if (is_file(WB_PATH . MEDIA_DIRECTORY . $thumb_dir . $thumb_jpg)) {
                    $thumb_url = WB_URL . MEDIA_DIRECTORY . $thumb_dir . $thumb_jpg;
                } elseif (is_file(WB_PATH . MEDIA_DIRECTORY . $thumb_dir . $thumb_file)) {
                    $thumb_url = WB_URL . MEDIA_DIRECTORY . $thumb_dir . $thumb_file;
                }
            }

            // Detail URL: page link + item link
            $detail_url = '';
            $item_link  = trim((string) ($item['item_link'] ?? ''));
            if ($page_link && $item_link) {
                $detail_url = WB_URL . PAGES_DIRECTORY . $page_link . $item_link . PAGE_EXTENSION;
            }

            $database->insertRow('{TP_SEARCH}index', [
                'page_id'     => $pid,
                'section_id'  => $sid,
                'item_id'     => $item_id,
                'module'      => $module,
                'title'       => $page_title,
                'item_title'  => $item_title,
                'description' => $description,
                'keywords'    => $keywords,
                'content'     => $content,
                'detail_url'  => WbceSearch::urlToToken($detail_url),
                'thumb_url'   => WbceSearch::urlToToken($thumb_url),
                'visibility'  => $visibility,
                'searching'   => $searching,
                'indexed_at'  => $now,
            ]);
            if (!$database->hasError()) $count++;
        }
        return $count;
    }

    // ── Helpers ─────────────────────────────────────────────────────────────

    /** Every section of a searchable page, in page order. */
    public function indexableSections(): array
    {
        return $this->db->fetchAll(
            "SELECT " . self::SECTION_COLUMNS . "
             FROM `{TP}sections` s
             INNER JOIN `{TP}pages` p ON s.page_id = p.page_id
             WHERE " . self::SEARCHABLE . "
             ORDER BY s.page_id, s.position ASC"
        );
    }

    /**
     * Sections without index rows or whose page changed since they were
     * indexed, newest first; $limit null = all.
     */
    private function staleSections(?int $limit): array
    {
        return $this->db->fetchAll(
            "SELECT " . self::SECTION_COLUMNS . "
             FROM `{TP}sections` s
             INNER JOIN `{TP}pages` p ON s.page_id = p.page_id
             LEFT JOIN `" . self::INDEX . "` i ON i.section_id = s.section_id
             WHERE " . self::SEARCHABLE . "
               AND (i.section_id IS NULL OR p.modified_when > i.indexed_at)
             GROUP BY s.section_id
             ORDER BY p.modified_when DESC"
            . ($limit !== null ? ' LIMIT ' . $limit : '')
        );
    }

    /** Text of an unknown module via its custom_modules config (table + fields). */
    private function genericContent(string $module, int $sid, array $custom): string
    {
        $text = '';

        if (!empty($custom[$module])) {
            $def        = $custom[$module];
            $table      = self::ident($def['table'] ?? '');
            $fields_raw = $def['fields'] ?? '';
            $cols = array_filter(array_map(
                fn($c) => self::ident(trim((string) $c)),
                is_array($fields_raw) ? $fields_raw : explode(',', (string) $fields_raw)
            ));
            if ($table && !empty($cols)) {
                $rows = $this->db->fetchAll(
                    'SELECT `' . implode('`, `', $cols) . "` FROM `{TP}$table` WHERE `section_id` = ?",
                    [$sid]
                );
                foreach ($rows as $r) {
                    foreach ($r as $val) {
                        if (is_string($val) && strlen($val) > 2) $text .= ' ' . $val;
                    }
                }
            }
        }

        return strip_tags(html_entity_decode(trim($text), ENT_QUOTES, 'UTF-8'));
    }

    /**
     * Stores the languages of the searchable pages as the site's stop-word
     * languages (WbceSearchStopwords). When the set changes — the first page
     * in a new language, the last one of a language gone, or the first run
     * after an upgrade — the word index no longer matches the stop words the
     * search drops: all entries are re-tokenised. Until that backlog is done
     * the search reads the text itself (WbceSearchWords::usable() is false),
     * so results stay correct in the meantime.
     */
    private function syncStopwordLanguages(): void
    {
        $now    = implode(',', WbceSearchStopwords::siteLanguages($this->db));
        // Never stored ('') differs from any site with pages and stores the set.
        if ((string) WbceSearchSettings::state(WbceSearchStopwords::CFG_KEY) === $now) {
            return;
        }

        WbceSearchSettings::setState(WbceSearchStopwords::CFG_KEY, $now);
        WbceSearchStopwords::reset();
        if (WbceSearchWords::available($this->db)) {
            WbceSearchWords::clear($this->db);
        }
    }

    /** Placeholder row: never searchable (searching = 0), only marks the section as indexed. */
    private function insertMarker(int $pid, int $sid, string $module, int $now): void
    {
        $this->db->query(
            "DELETE FROM `" . self::INDEX . "` WHERE `section_id` = ? AND `searching` = 0",
            [$sid]
        );
        $this->db->insertRow(self::INDEX, [
            'page_id'     => $pid,
            'section_id'  => $sid,
            'item_id'     => 0,
            'module'      => $module,
            'title'       => '',
            'item_title'  => '',
            'description' => '',
            'keywords'    => '',
            'content'     => '',
            'detail_url'  => '',
            'thumb_url'   => '',
            'visibility'  => 'none',
            'searching'   => 0,
            'indexed_at'  => $now,
        ]);
    }

    /**
     * HTML of module fields → searchable text: block ends become spaces (words
     * of adjacent paragraphs must not merge), tags and entities out, droplets
     * [[…]] and {PLACEHOLDERS} out, whitespace collapsed.
     * Public for the callbacks of modules' search_index.php
     * (SEARCH_INDEX_HOWTO.md).
     */
    public static function plainText(string $html): string
    {
        $text = preg_replace('/<\/(p|div|h[1-6]|li|td|th|br|blockquote|pre)>/i', ' ', $html);
        $text = preg_replace('/<(br|hr)(\s[^>]*)?\/?>/i', ' ', (string) $text);
        $text = strip_tags(html_entity_decode(trim((string) $text), ENT_QUOTES, 'UTF-8'));
        $text = preg_replace('/\[\[.*?\]\]|\{[A-Z_]+\}/', ' ', $text);
        // /u: \s then also matches U+00A0 (decoded &nbsp;), which used to
        // survive as runs of non-breaking spaces in the stored text.
        return trim((string) preg_replace('/\s+/u', ' ', (string) $text));
    }

    /** A callback for the log: "name", "Class::method" or "closure". */
    private static function describeCallback(mixed $cb): string
    {
        return match (true) {
            is_string($cb)                    => $cb,
            is_array($cb) && count($cb) === 2 => (is_object($cb[0]) ? get_class($cb[0]) : (string) $cb[0]) . '::' . (string) $cb[1],
            $cb instanceof \Closure           => 'closure',
            default                           => get_debug_type($cb),
        };
    }

    /** SQL identifier from a definition: [A-Za-z0-9_] only (cannot be bound). */
    private static function ident(mixed $name): string
    {
        return (string) preg_replace('/[^a-zA-Z0-9_]/', '', (string) $name);
    }
}
