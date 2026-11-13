<?php
/**
 * wbce_search — WbceSearchModules
 *
 * Everything the "Modules" view needs: which installed modules exist, how
 * each one is indexed (module_defs file / semi-config / legacy search.php /
 * nothing), and the semi-config read/validate/write cycle.
 *
 * Semi-config lives in the module settings (custom_modules) until
 * it is turned into a module_defs/<mod>.php file. Since 0.4 every table and
 * column name in a semi-config is validated server-side against the real
 * schema: before, any table (e.g. `users`) could be posted and its contents
 * ended up publicly searchable.
 *
 * Schema introspection goes through Database::listTables()/listColumns(),
 * so it works on MySQL/MariaDB and SQLite alike.
 *
 * @license GNU General Public License
 */

declare(strict_types=1);

defined('WB_PATH') or die();

class WbceSearchModules
{
    public const TEXT_TYPES = ['varchar', 'text', 'mediumtext', 'longtext', 'tinytext', 'char'];
    public const MAX_JOINS  = 3;

    /** Header line gen_def writes — only such files may be deleted from the UI. */
    private const GENERATED_MARK = 'Generated via Semi-Config Admin Tool';

    private string $defDir;

    /** Per-request schema caches — mainTables() inspects every mod_* table. */
    private ?array $tableCache  = null;
    private array  $columnCache = [];

    public function __construct(private Database $db)
    {
        $this->defDir = WB_PATH . '/modules/wbce_search/module_defs/';
    }

    // ── Overview list ─────────────────────────────────────────────────────

    /** One row per installed page module (+ snippets/filters/tools if $allKinds, + orphaned semi-configs). */
    public function listModules(bool $allKinds = false): array
    {
        $addons = $this->db->fetchAll(
            "SELECT `directory`, `name`, `function` FROM `{TP}addons` WHERE `type` = 'module' ORDER BY `directory`"
        );
        $types = [];
        $names = [];
        foreach ($addons as $a) {
            $names[$a['directory']] = trim((string) $a['name']) ?: $a['directory'];
            $f = (string) $a['function'];
            $types[$a['directory']] = match (true) {
                str_contains($f, 'output_filter') => 'output_filter',
                str_contains($f, 'snippet')       => 'snippet',
                str_contains($f, 'page')          => 'page',
                str_contains($f, 'tool')          => 'tool',
                default                           => null,
            };
        }
        // Only page modules have sections, i.e. something to index. Snippets,
        // tools and filters are listed only on request ($allKinds — see
        // WbceSearchBackend::SHOW_ALL_KINDS).
        $types = array_filter($types, fn ($t) => $t !== null && ($allKinds || $t === 'page'));
        unset($types['wbce_search']);

        $custom = $this->customModules();
        foreach (array_keys($custom) as $mod) {
            $types[$mod] ??= 'page';
        }

        // Pages per module: id, menu title (page title if empty), visibility,
        // searchable flag and the module's section ids on that page.
        $pages = [];
        foreach ($this->db->fetchAll(
            "SELECT s.`module`, p.`page_id`, p.`menu_title`, p.`page_title`, p.`visibility`, p.`searching`,
                    " . $this->db->groupConcat('s.`section_id`') . " AS section_ids
             FROM `{TP}sections` s
             INNER JOIN `{TP}pages` p ON s.`page_id` = p.`page_id`
             WHERE p.`visibility` != 'deleted'
             GROUP BY s.`module`, p.`page_id`, p.`menu_title`, p.`page_title`, p.`visibility`, p.`searching`
             ORDER BY p.`page_id`"
        ) as $r) {
            $ids = array_map('intval', explode(',', (string) $r['section_ids']));
            sort($ids);
            $pages[$r['module']][] = [
                'page_id'    => (int) $r['page_id'],
                'title'      => trim((string) $r['menu_title']) !== '' ? $r['menu_title'] : $r['page_title'],
                'visibility' => (string) $r['visibility'],
                'searching'  => (bool) $r['searching'],
                'sections'   => $ids,
            ];
        }

        $indexed = array_column($this->db->fetchAll(
            "SELECT `module`, COUNT(*) AS c FROM `{TP_SEARCH}index` WHERE `searching` = 1 GROUP BY `module`"
        ), 'c', 'module');

        $rows = [];
        foreach ($types as $mod => $type) {
            $defKind = $this->defKind($mod);
            $source  = $this->source($defKind, isset($custom[$mod]), $this->hasSearchPhp($mod), $type);
            $rows[] = [
                'module'      => $mod,
                'name'        => $names[$mod] ?? $mod,
                'type'        => $type,
                'source'      => $source,
                'source_rank' => array_search($source, self::SOURCES, true),
                'source_group'=> self::SOURCE_GROUP[$source],
                'editable'    => !in_array($source, ['module', 'callback', 'none'], true),
                'pages'       => $pages[$mod] ?? [],
                'page_count'  => count($pages[$mod] ?? []),
                'indexed'     => (int) ($indexed[$mod] ?? 0),
            ];
        }
        usort($rows, fn ($a, $b) => strnatcasecmp($a['name'], $b['name']) ?: strcmp($a['module'], $b['module']));
        return $rows;
    }

    /**
     * Where a module's search definition comes from — one value, in display
     * order. ('none': not a page module and no definition — nothing to index.)
     */
    public const SOURCES = ['module', 'callback', 'shipped', 'generated', 'semi', 'search_php', 'title', 'none'];

    /** Filter groups of the module list: has a definition / needs work / page title only. */
    private const SOURCE_GROUP = [
        'module' => 'def', 'callback' => 'def', 'shipped' => 'def', 'generated' => 'def',
        'semi' => 'open', 'search_php' => 'open',
        'title' => 'title', 'none' => 'title',
    ];

    private function source(?string $defKind, bool $isSemi, bool $hasSearchPhp, string $type): string
    {
        return match (true) {
            $defKind !== null => $defKind,          // module | callback | shipped | generated
            $isSemi           => 'semi',            // saved, but no definition generated
            $hasSearchPhp     => 'search_php',      // can be preset from the legacy search.php
            $type === 'page'  => 'title',
            default           => 'none',
        };
    }

    /**
     * 'module' (the module ships modules/<mod>/search_index.php itself) |
     * 'callback' | 'generated' | 'shipped' | null (no definition).
     */
    public function defKind(string $mod): ?string
    {
        if (is_file(WB_PATH . '/modules/' . $mod . '/search_index.php')) {
            return 'module';
        }
        $file = $this->defDir . $mod . '.php';
        if (!is_file($file)) return null;
        $def = (static fn () => require $file)();
        if (!is_array($def)) return null;
        if (!empty($def['callback'])) return 'callback';
        return str_contains((string) file_get_contents($file, false, null, 0, 400), self::GENERATED_MARK)
            ? 'generated' : 'shipped';
    }

    public function hasSearchPhp(string $mod): bool
    {
        return is_file(WB_PATH . '/modules/' . $mod . '/search.php');
    }

    public function hasGuide(string $mod): bool
    {
        return is_file($this->defDir . 'guides/' . $mod . '.md');
    }

    // ── Schema introspection ──────────────────────────────────────────────

    /** Short names (no TABLE_PREFIX) of mod_* tables that have a section_id column. */
    public function mainTables(): array
    {
        return array_values(array_filter(
            $this->joinTables(),
            fn ($t) => isset($this->columns($t)['section_id'])
        ));
    }

    /** Short names of all mod_* tables (join candidates). */
    public function joinTables(): array
    {
        if ($this->tableCache === null) {
            $len = strlen(TABLE_PREFIX);
            $this->tableCache = array_map(fn ($t) => substr($t, $len), $this->db->listTables('{TP}mod_'));
        }
        return $this->tableCache;
    }

    /** ['col' => 'basetype', …] in table order; [] for an unknown table. */
    public function columns(string $shortTable): array
    {
        if (!preg_match('/^mod_[A-Za-z0-9_]+$/', $shortTable)) return [];
        return $this->columnCache[$shortTable] ??= $this->db->listColumns('{TP}' . $shortTable);
    }

    public function textColumns(string $shortTable): array
    {
        return array_keys(array_filter(
            $this->columns($shortTable),
            fn ($t) => in_array(strtolower($t), self::TEXT_TYPES, true)
        ));
    }

    // ── Semi-config ───────────────────────────────────────────────────────

    public function customModules(): array
    {
        $data = WbceSearchSettings::get('custom_modules');
        return is_array($data) ? $data : [];
    }

    /**
     * Current config for the editor: DB semi-config first, else the
     * module_defs file translated into the same shape, else a blank one
     * pre-selecting the module's own first table.
     */
    public function semiData(string $mod): array
    {
        $custom = $this->customModules();
        if (isset($custom[$mod])) {
            return $this->normalize($custom[$mod]) + ['source' => 'semi'];
        }
        $file = $this->defDir . $mod . '.php';
        if (is_file($file)) {
            $def = (static fn () => require $file)();
            if (is_array($def) && empty($def['callback'])) {
                $def['filter_active'] = !empty($def['filter']['active']);
                $def['filter_time']   = !empty($def['filter']['published_when']);
                return $this->normalize($def) + ['source' => 'def'];
            }
        }
        $own = array_values(array_filter($this->mainTables(), fn ($t) => str_starts_with($t, 'mod_' . $mod)));
        return $this->normalize(['table' => $own[0] ?? '']) + ['source' => 'new'];
    }

    /**
     * Validates POSTed editor values against the real schema and stores
     * them. Unknown tables/columns are dropped, never stored.
     *
     * @throws InvalidArgumentException with a user-facing reason
     */
    public function saveSemi(string $mod, array $post): array
    {
        $mod   = $this->cleanName($mod);
        $table = (string) ($post['table'] ?? '');
        if ($mod === '' || !in_array($table, $this->mainTables(), true)) {
            throw new InvalidArgumentException('table');
        }
        $cols = array_keys($this->columns($table));
        $pick = fn ($v) => in_array((string) $v, $cols, true) ? (string) $v : null;

        $idField = $pick($post['id_field'] ?? '') ?? 'section_id';
        $fields  = array_values(array_intersect((array) ($post['fields'] ?? []), $this->textColumns($table)));

        $joins = [];
        $joinTables = $this->joinTables();
        foreach (array_slice((array) ($post['joins'] ?? []), 0, self::MAX_JOINS) as $j) {
            $jt = (string) ($j['table'] ?? '');
            if (!in_array($jt, $joinTables, true)) continue;
            $jcols = array_keys($this->columns($jt));
            $jpick = fn ($v) => in_array((string) $v, $jcols, true) ? (string) $v : null;
            $onMain = $pick($j['on_main'] ?? '');
            $onJoin = $jpick($j['on_join'] ?? '');
            if (!$onMain || !$onJoin) continue;
            $joins[] = array_filter([
                'table'      => $jt,
                'type'       => ($j['type'] ?? '') === 'INNER' ? 'INNER' : 'LEFT',
                'on_main'    => $onMain,
                'on_join'    => $onJoin,
                'fields'     => array_values(array_intersect((array) ($j['fields'] ?? []), $this->textColumns($jt))),
                'image'      => $jpick($j['image'] ?? ''),
                'image_path' => $this->cleanPath((string) ($j['image_path'] ?? '')),
                'link'       => $jpick($j['link'] ?? ''),
            ], fn ($v) => $v !== null && $v !== '' && $v !== []);
        }

        $config = [
            'table'         => $table,
            'id_field'      => $idField,
            'item_key'      => $pick($post['item_key'] ?? ''),
            'title'         => $pick($post['title'] ?? ''),
            'fields'        => $fields,
            'link'          => $pick($post['link'] ?? ''),
            'link_prefix'   => $this->cleanPath((string) ($post['link_prefix'] ?? '')) ?: null,
            'image'         => $pick($post['image'] ?? ''),
            'image_path'    => $this->cleanPath((string) ($post['image_path'] ?? '')),
            'mode'          => ($post['mode'] ?? '') === 'multi' ? 'multi' : 'single',
            'index_base'    => ($post['index_base'] ?? '') === 'all' ? 'all' : 'page',
            // Fixed columns: only possible when the table has them.
            'filter_active' => !empty($post['filter_active']) && in_array('active', $cols, true),
            'filter_time'   => !empty($post['filter_time'])
                               && !array_diff(['published_when', 'published_until'], $cols),
            'joins'         => $joins,
        ];

        $custom = $this->customModules();
        $custom[$mod] = $config;
        $this->storeCustom($custom);
        return $config;
    }

    /** Turns the semi-config into module_defs/<mod>.php and drops the DB copy. */
    public function generateDef(string $mod): void
    {
        $mod    = $this->cleanName($mod);
        $custom = $this->customModules();
        if (!isset($custom[$mod])) {
            throw new InvalidArgumentException('no semi-config');
        }
        $d = $this->normalize($custom[$mod]);
        $filter = [];
        if ($d['filter_active']) $filter['active'] = 1;
        if ($d['filter_time']) {
            $filter['published_when']  = '<= NOW';
            $filter['published_until'] = '>= NOW';
        }
        $php = "<?php\n/**\n * wbce_search - module_defs/$mod.php\n * " . self::GENERATED_MARK . "\n */\nreturn "
             . var_export([
                 'table'       => $d['table'],
                 'id_field'    => $d['id_field'],
                 'item_key'    => $d['item_key'] ?: null,
                 'title'       => $d['title'] ?: null,
                 'fields'      => $d['fields'],
                 'link'        => $d['link'] ?: null,
                 'link_prefix' => $d['link_prefix'] ?: null,
                 'image'       => $d['image'] ?: null,
                 'image_path'  => $d['image_path'],
                 'mode'        => $d['mode'],
                 'index_base'  => $d['index_base'],
                 'filter'      => $filter,
                 'joins'       => $d['joins'],
             ], true) . ";\n";

        $file = $this->defDir . $mod . '.php';
        if (file_put_contents($file, $php) === false) {
            throw new RuntimeException('write');
        }
        if (function_exists('opcache_invalidate')) opcache_invalidate($file, true);

        unset($custom[$mod]);
        $this->storeCustom($custom);
    }

    /**
     * Removes the semi-config, a *generated* def file and the module's index
     * entries. Shipped defs (wysiwyg, bakery, …) are never deleted — before
     * 0.4 this action removed them for good.
     */
    public function deleteConfig(string $mod): void
    {
        $mod    = $this->cleanName($mod);
        $custom = $this->customModules();
        unset($custom[$mod]);
        $this->storeCustom($custom);

        if ($this->defKind($mod) === 'generated') {
            $file = $this->defDir . $mod . '.php';
            unlink($file);
            if (function_exists('opcache_invalidate')) opcache_invalidate($file, true);
        }
        $this->db->query("DELETE FROM `{TP_SEARCH}index` WHERE `module` = ?", [$mod]);
        if ($this->db->hasError()) throw new RuntimeException($this->db->getError());
    }

    /** Presets a semi-config from the table name found in a legacy search.php. */
    public function importFromSearchPhp(string $mod): string
    {
        $mod = $this->cleanName($mod);
        $src = $this->hasSearchPhp($mod) ? (string) file_get_contents(WB_PATH . '/modules/' . $mod . '/search.php') : '';
        $q   = preg_quote($mod, '/');
        $table = match (true) {
            (bool) preg_match('/["\'](mod_' . $q . '(?:_\w+)?)["\']/i', $src, $m) => $m[1],
            (bool) preg_match('/["\']mod_["\']\s*\.\s*\$\w+\s*\.\s*["\'](\w+)["\']/i', $src, $m) => 'mod_' . $mod . '_' . $m[1],
            (bool) preg_match('/["\']mod_["\']\s*\.\s*basename\(__DIR__\)/i', $src) => 'mod_' . $mod,
            default => '',
        };
        if ($table === '' || !in_array($table, $this->mainTables(), true)) {
            throw new InvalidArgumentException('table');
        }
        $cols = array_keys($this->columns($table));
        $custom = $this->customModules();
        $custom[$mod] = $this->normalize([
            'table'    => $table,
            'item_key' => in_array('item_id', $cols, true) ? 'item_id' : null,
            'mode'     => in_array('item_id', $cols, true) ? 'multi' : 'single',
        ]);
        $this->storeCustom($custom);
        return $table;
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    private function normalize(array $d): array
    {
        $fields = $d['fields'] ?? [];
        return [
            'table'         => (string) ($d['table'] ?? ''),
            'id_field'      => (string) ($d['id_field'] ?? 'section_id'),
            'item_key'      => (string) ($d['item_key'] ?? ''),
            'title'         => (string) ($d['title'] ?? ''),
            'fields'        => is_array($fields) ? array_values($fields) : array_filter(array_map('trim', explode(',', (string) $fields))),
            'link'          => (string) ($d['link'] ?? ''),
            'link_prefix'   => (string) ($d['link_prefix'] ?? ''),
            'image'         => (string) ($d['image'] ?? ''),
            'image_path'    => (string) ($d['image_path'] ?? ''),
            'mode'          => ($d['mode'] ?? 'single') === 'multi' ? 'multi' : 'single',
            'index_base'    => ($d['index_base'] ?? 'page') === 'all' ? 'all' : 'page',
            'filter_active' => !empty($d['filter_active']),
            'filter_time'   => !empty($d['filter_time']),
            'joins'         => array_values(array_slice((array) ($d['joins'] ?? []), 0, self::MAX_JOINS)),
        ];
    }

    private function storeCustom(array $custom): void
    {
        WbceSearchSettings::set('custom_modules', $custom);
    }

    private function cleanName(string $v): string
    {
        return preg_replace('/[^A-Za-z0-9_]/', '', $v);
    }

    /** Path templates: plain path chars + {placeholders}, no "..". */
    private function cleanPath(string $v): string
    {
        $v = preg_replace('#[^A-Za-z0-9_./{}\-]#', '', trim($v));
        return str_replace('..', '', $v);
    }
}
