<?php
/**
 * wbce_search — WbceSearchSettings
 *
 * The module's settings — the only class that knows where they are stored
 * ({TP}settings, JSON: KEY_CFG for what the admin sets, KEY_STATE for what
 * the module writes itself; until 0.6.1 a table of its own).
 *
 * One declaration per setting → defaults, type casting and range clamping.
 * Before 0.4 the settings form stored raw POST values (e.g. tagcloud_max=-1
 * broke the tag cloud query with "LIMIT -1", highlight_tag=script put
 * <script> into the frontend), so every write goes through cast().
 *
 * custom_modules (semi-configs) and the layout / stylesheet picks are not
 * form settings (INTERNAL) and are written by WbceSearchModules /
 * WbceSearchLayouts.
 *
 * @license GNU General Public License
 */

declare(strict_types=1);

defined('WB_PATH') or die();

class WbceSearchSettings
{
    /**
     * type: int (min/max) | bool | enum (options) | template (installed
     * frontend template directory or '').
     * Order = order on the settings page, grouped by 'group'.
     */
    public const SCHEMA = [
        // Search behaviour
        'min_length'         => ['group' => 'search',   'type' => 'int',  'default' => 3,   'min' => 1,  'max' => 10],
        'title_weight'       => ['group' => 'search',   'type' => 'int',  'default' => 3,   'min' => 1,  'max' => 10],
        'results_per_page'   => ['group' => 'search',   'type' => 'int',  'default' => 10,  'min' => 1,  'max' => 100],
        'language_filter'    => ['group' => 'search',   'type' => 'bool', 'default' => 0],
        'advanced_search'    => ['group' => 'search',   'type' => 'bool', 'default' => 0],
        // Result display
        'max_excerpt'        => ['group' => 'display',  'type' => 'int',  'default' => 200, 'min' => 50, 'max' => 1000],
        'highlight'          => ['group' => 'display',  'type' => 'bool', 'default' => 1],
        'highlight_tag'      => ['group' => 'display',  'type' => 'enum', 'default' => 'mark', 'options' => ['mark', 'strong', 'em']],
        'debug_results'      => ['group' => 'display',  'type' => 'bool', 'default' => 0],
        // Frontend template of /search/ ('' = the website's default template).
        // Replaces the core's "search template" for the WBCE Search page.
        'page_template'      => ['group' => 'display',  'type' => 'template', 'default' => ''],
        // Index maintenance
        'auto_reindex'       => ['group' => 'index',    'type' => 'bool', 'default' => 1],
        'auto_reindex_limit' => ['group' => 'index',    'type' => 'int',  'default' => 5,   'min' => 1,  'max' => 50],
        'word_index'         => ['group' => 'index',    'type' => 'enum', 'default' => 'auto', 'options' => ['auto', 'on', 'off']],
        'word_index_threshold' => ['group' => 'index',  'type' => 'int',  'default' => 2000, 'min' => 100, 'max' => 1000000],
        // Live search
        'ajax_suggest'       => ['group' => 'live',     'type' => 'bool', 'default' => 1],
        'ajax_suggest_mode'  => ['group' => 'live',     'type' => 'enum', 'default' => 'hybrid', 'options' => ['hybrid', 'title', 'fulltext']],
        'ajax_suggest_limit' => ['group' => 'live',     'type' => 'int',  'default' => 5,   'min' => 1,  'max' => 20],
        'ajax_suggest_thumbs' => ['group' => 'live',    'type' => 'bool', 'default' => 1],
        // Tag cloud
        'tagcloud_show'      => ['group' => 'tagcloud', 'type' => 'bool', 'default' => 1],
        'tagcloud_track'     => ['group' => 'tagcloud', 'type' => 'bool', 'default' => 1],
        'tagcloud_max'       => ['group' => 'tagcloud', 'type' => 'int',  'default' => 20,  'min' => 1,  'max' => 100],
        'tagcloud_min_count' => ['group' => 'tagcloud', 'type' => 'int',  'default' => 1,   'min' => 1,  'max' => 1000],
        // Admin tool
        'nav_style'          => ['group' => 'admin',    'type' => 'enum', 'default' => 'horizontal', 'options' => ['horizontal', 'vertical']],
    ];

    // ── Storage: two JSON values in {TP}settings ──────────────────────────────
    //
    // The core loads every {TP}settings row once per request, so reading
    // these costs no query (was a module table read on every search and on
    // every frontend page). Like tinymce_wbce's 'tinymce_cfg'.

    /** What the admin sets: SCHEMA values + the keys of INTERNAL. */
    public const KEY_CFG = 'search_cfg';

    /**
     * What the module writes itself (stopword_languages, indexer). Kept apart
     * from KEY_CFG: each write stores the whole JSON, and the lazy reindex
     * runs in a visitor's request — one value must not overwrite the other.
     */
    public const KEY_STATE = 'search_state';

    /** Admin-set values outside the settings form, with their defaults. */
    public const INTERNAL = [
        'custom_modules' => [],                    // semi-configs (WbceSearchModules)
        // Layout view (WbceSearchLayouts): picked source per layout
        // ('custom' | 'template' | 'default', '' = first existing) and the
        // stylesheet ('default' | 'none' | 'template:<file>.css').
        'layout_search'   => '',
        'layout_tagcloud' => '',
        'stylesheet'      => 'default',
    ];

    /** All schema settings, cast/clamped, default where missing. */
    public static function all(): array
    {
        $raw = self::read(self::KEY_CFG);
        $out = [];
        foreach (self::SCHEMA as $name => $def) {
            $out[$name] = array_key_exists($name, $raw) ? self::cast($def, $raw[$name]) : $def['default'];
        }
        return $out;
    }

    /** One value: a SCHEMA setting (cast) or an INTERNAL one (its default if unset). */
    public static function get(string $name): mixed
    {
        if (isset(self::SCHEMA[$name])) {
            return self::all()[$name];
        }
        return self::read(self::KEY_CFG)[$name] ?? (self::INTERNAL[$name] ?? '');
    }

    /** Stores one value (SCHEMA values are cast/clamped first). */
    public static function set(string $name, mixed $value): void
    {
        $cfg = self::read(self::KEY_CFG);
        $cfg[$name] = isset(self::SCHEMA[$name]) ? self::cast(self::SCHEMA[$name], $value) : $value;
        self::write(self::KEY_CFG, $cfg);
    }

    /**
     * Validates + stores the schema keys present in $input. A checkbox that
     * is absent from a submitted form means "off", so bool keys of the
     * groups listed in $groups are written as 0 when missing.
     *
     * @return array<string,int|string> the values actually stored
     */
    public static function save(array $input, array $groups): array
    {
        $cfg    = self::read(self::KEY_CFG);
        $stored = [];
        foreach (self::SCHEMA as $name => $def) {
            if (!in_array($def['group'], $groups, true)) continue;
            if (!array_key_exists($name, $input) && $def['type'] !== 'bool') continue;
            $stored[$name] = $cfg[$name] = self::cast($def, $input[$name] ?? 0);
        }
        self::write(self::KEY_CFG, $cfg);
        return $stored;
    }

    /** A value the module wrote itself (KEY_STATE). */
    public static function state(string $name, mixed $default = ''): mixed
    {
        return self::read(self::KEY_STATE)[$name] ?? $default;
    }

    public static function setState(string $name, mixed $value): void
    {
        $state = self::read(self::KEY_STATE);
        $state[$name] = $value;
        self::write(self::KEY_STATE, $state);
    }

    /**
     * Install/upgrade: adds every missing key with its default, keeps the
     * stored ones and drops keys no longer known.
     */
    public static function seed(): void
    {
        $cfg = self::read(self::KEY_CFG);
        foreach (self::SCHEMA as $name => $def) {
            $cfg[$name] = array_key_exists($name, $cfg) ? self::cast($def, $cfg[$name]) : $def['default'];
        }
        $cfg += self::INTERNAL;
        self::write(self::KEY_CFG, array_intersect_key($cfg, self::SCHEMA + self::INTERNAL));
    }

    private static function read(string $key): array
    {
        $data = json_decode((string) Settings::get($key, '{}'), true);
        return is_array($data) ? $data : [];
    }

    private static function write(string $key, array $data): void
    {
        $error = Settings::set($key, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        if ($error) {
            throw new RuntimeException('wbce_search settings: ' . $error);
        }
    }

    private static function cast(array $def, mixed $value): int|string
    {
        return match ($def['type']) {
            'int'  => max($def['min'], min($def['max'], (int) (is_numeric($value) ? $value : $def['default']))),
            'bool' => in_array((string) $value, ['1', 'on', 'true'], true) ? 1 : 0,
            'enum' => in_array((string) $value, $def['options'], true) ? (string) $value : $def['default'],
            // An installed frontend template, else '' (= website default).
            'template' => isset(self::templates()[(string) $value]) ? (string) $value : '',
        };
    }

    /**
     * Installed frontend templates, directory => name — the same list the
     * core's settings page offers for its search template.
     *
     * @return array<string,string>
     */
    public static function templates(): array
    {
        static $list = null;
        return $list ??= array_column($GLOBALS['database']->fetchAll(
            "SELECT `directory`, `name` FROM `{TP}addons`
             WHERE `type` = 'template' AND `function` = 'template' ORDER BY `name`"
        ), 'name', 'directory');
    }
}
