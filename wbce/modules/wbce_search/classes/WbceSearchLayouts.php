<?php
/**
 * wbce_search — WbceSearchLayouts
 *
 * Which layout file the search page and the tag cloud use, and which
 * stylesheet goes with them. One place for the file rules, used by the
 * layout view (WbceSearchBackend), the search page (WbceSearchPage)
 * and the tag cloud droplet.
 *
 * Per layout ('search', 'tagcloud') up to three files, in this order:
 *   custom    modules/wbce_search/layouts/<x>_custom.htt   — the admin's own copy, editable
 *   template  templates/<search template>/search/<x>.htt   — read only (belongs to the template)
 *   default   modules/wbce_search/layouts/<x>_default.htt  — shipped, read only
 * The search template is Settings → Result display → page_template, else
 * the website's default template. The admin picks one per layout (stored
 * as layout_search / layout_tagcloud); nothing picked or the picked file
 * gone → the first existing one in the order above.
 *
 * Stylesheet: fe_search.css (shipped), any .css in templates/<search
 * template>/search/, or none (the template styles everything itself).
 *
 * @module wbce_search  @license GNU General Public License
 */

defined('WB_PATH') or die('No direct access');

final class WbceSearchLayouts
{
    public const LAYOUTS = [
        'search'   => ['custom' => 'search_custom.htt',   'template' => 'search.htt',   'default' => 'search_default.htt'],
        'tagcloud' => ['custom' => 'tagcloud_custom.htt', 'template' => 'tagcloud.htt', 'default' => 'tagcloud_default.htt'],
    ];

    /** Order of the options = fallback order. */
    public const SOURCES = ['custom', 'template', 'default'];

    public const STYLESHEET_CUSTOM  = 'custom';
    public const STYLESHEET_DEFAULT = 'default';
    public const STYLESHEET_NONE    = 'none';

    /** The admin's own stylesheet copy, next to the own layout copies. */
    public const CUSTOM_CSS = 'fe_search_custom.css';

    /** What the editor can work on: a layout or the stylesheet ('css'). */
    public static function isTarget(string $target): bool
    {
        return isset(self::LAYOUTS[$target]) || $target === 'css';
    }

    /** File name of a target's own copy (<x>_custom.htt / fe_search_custom.css). */
    public static function customName(string $target): string
    {
        return $target === 'css' ? self::CUSTOM_CSS : (self::LAYOUTS[$target]['custom'] ?? '');
    }

    /** Absolute path of a target's own copy ('' for an unknown target). */
    public static function customPath(string $target): string
    {
        $name = self::customName($target);
        return $name === '' ? '' : self::MODULE_DIR . $name;
    }

    private const MODULE_DIR = WB_PATH . '/modules/wbce_search/layouts/';

    // ── Template ───────────────────────────────────────────────────────────

    /** Directory name of the search template ('' if none can be determined). */
    public static function templateName(): string
    {
        $tpl = class_exists('WbceSearchSettings') ? (string) WbceSearchSettings::get('page_template') : '';
        if ($tpl === '' && defined('DEFAULT_TEMPLATE')) {
            $tpl = (string) DEFAULT_TEMPLATE;
        }
        return preg_match('/^[A-Za-z0-9_\-]+$/', $tpl) ? $tpl : '';
    }

    /** Display name of the search template (addons.name), else its directory. */
    public static function templateTitle(): string
    {
        $tpl = self::templateName();
        return (class_exists('WbceSearchSettings') ? (WbceSearchSettings::templates()[$tpl] ?? '') : '') ?: $tpl;
    }

    private static function templateDir(): string
    {
        $tpl = self::templateName();
        return $tpl === '' ? '' : WB_PATH . '/templates/' . $tpl . '/search/';
    }

    // ── Layout files ───────────────────────────────────────────────────────

    /** Absolute path of one source of a layout ('' if unknown layout/source). */
    public static function path(string $layout, string $source): string
    {
        $file = self::LAYOUTS[$layout][$source] ?? '';
        if ($file === '') {
            return '';
        }
        if ($source === 'template') {
            $dir = self::templateDir();
            return $dir === '' ? '' : $dir . $file;
        }
        return self::MODULE_DIR . $file;
    }

    /**
     * The existing files of a layout, in display order:
     * [source => ['source', 'file', 'path', 'rel', 'mtime']].
     */
    public static function options(string $layout): array
    {
        $out = [];
        foreach (self::SOURCES as $source) {
            $path = self::path($layout, $source);
            if ($path !== '' && is_file($path)) {
                $out[$source] = [
                    'source' => $source,
                    'file'   => basename($path),
                    'path'   => $path,
                    'rel'    => substr(str_replace('\\', '/', $path), strlen(rtrim(str_replace('\\', '/', WB_PATH), '/')) + 1),
                    'mtime'  => (int) filemtime($path),
                ];
            }
        }
        return $out;
    }

    /** The source in use: the admin's pick if its file exists, else the first existing one. */
    public static function active(string $layout): string
    {
        $options = self::options($layout);
        $picked  = (string) WbceSearchSettings::get('layout_' . $layout);
        if (isset($options[$picked])) {
            return $picked;
        }
        return (string) (array_key_first($options) ?? 'default');
    }

    /** Absolute path of the layout file in use. */
    public static function file(string $layout): string
    {
        return self::path($layout, self::active($layout));
    }

    public static function setActive(string $layout, string $source): void
    {
        if (!isset(self::options($layout)[$source])) {
            throw new RuntimeException(L_('SEARCH:MSG_SECURITY_ERROR'));
        }
        WbceSearchSettings::set('layout_' . $layout, $source);
    }

    // ── The admin's own copy ──────────────────────────────────────────────

    /**
     * Copies a file to the target's own copy (overwriting it) and activates
     * the copy. $from: for a layout 'template' | 'default'; for 'css' a
     * stylesheet id ('template:<file>.css' | 'default').
     */
    public static function createCustom(string $target, string $from): void
    {
        $source = $target === 'css'
            ? (self::stylesheets()[$from]['path'] ?? '')
            : (self::options($target)[$from]['path'] ?? '');
        if (!self::isTarget($target) || $from === 'custom' || $source === '' || !is_file($source)) {
            throw new RuntimeException(L_('SEARCH:MSG_SECURITY_ERROR'));
        }
        self::writeCustom($target, (string) file_get_contents($source));
    }

    /**
     * Writes the target's own copy and makes it the active one. Shared by
     * the editor's form POST and its AJAX save (ajax_save_layout.php).
     *
     * @throws RuntimeException with a translated message
     */
    public static function writeCustom(string $target, string $content): void
    {
        $path = self::isTarget($target) ? self::customPath($target) : '';
        if ($path === '') {
            throw new RuntimeException(L_('SEARCH:MSG_SECURITY_ERROR'));
        }
        // A form POST sends the textarea with CRLF, the AJAX save with LF.
        $content = str_replace("\r\n", "\n", $content);
        if ($target !== 'css' && trim($content) === '') {
            throw new RuntimeException(L_('SEARCH:MSG_LAYOUT_EMPTY'));   // would leave the page blank
        }
        if (file_put_contents($path, $content) === false) {
            throw new RuntimeException(L_('SEARCH:MSG_LAYOUT_SAVE_FAILED'));
        }
        $target === 'css'
            ? WbceSearchSettings::set('stylesheet', self::STYLESHEET_CUSTOM)
            : WbceSearchSettings::set('layout_' . $target, 'custom');
    }

    /** Deletes the own copy; a layout falls back to the template's / default, the stylesheet to fe_search.css. */
    public static function deleteCustom(string $target): void
    {
        $path = self::isTarget($target) ? self::customPath($target) : '';
        if ($path !== '' && is_file($path) && !unlink($path)) {
            throw new RuntimeException(L_('SEARCH:MSG_LAYOUT_SAVE_FAILED'));
        }
        $target === 'css'
            ? WbceSearchSettings::set('stylesheet', self::STYLESHEET_DEFAULT)
            : WbceSearchSettings::set('layout_' . $target, '');
    }

    // ── Stylesheet ────────────────────────────────────────────────────────

    /**
     * Choices, in display order: [id => ['id', 'file', 'rel', 'path', 'source', 'mtime']].
     * id: 'custom' (fe_search_custom.css, if it exists) | 'template:<file>.css' | 'default' | 'none'.
     */
    public static function stylesheets(): array
    {
        $out    = [];
        $custom = self::customPath('css');
        if (is_file($custom)) {
            $out[self::STYLESHEET_CUSTOM] = [
                'id' => self::STYLESHEET_CUSTOM, 'file' => self::CUSTOM_CSS, 'source' => 'custom',
                'rel' => 'modules/wbce_search/layouts/' . self::CUSTOM_CSS, 'path' => $custom, 'mtime' => (int) filemtime($custom),
            ];
        }
        $dir = self::templateDir();
        if ($dir !== '' && is_dir($dir)) {
            $files = glob($dir . '*.css') ?: [];
            sort($files, SORT_NATURAL | SORT_FLAG_CASE);
            foreach ($files as $f) {
                $name = basename($f);
                $out['template:' . $name] = [
                    'id' => 'template:' . $name, 'file' => $name, 'source' => 'template',
                    'rel' => 'templates/' . self::templateName() . '/search/' . $name, 'path' => $f, 'mtime' => (int) filemtime($f),
                ];
            }
        }
        $default = WB_PATH . '/modules/wbce_search/assets/fe_search.css';
        $out[self::STYLESHEET_DEFAULT] = [
            'id' => self::STYLESHEET_DEFAULT, 'file' => 'fe_search.css', 'source' => 'default',
            'rel' => 'modules/wbce_search/assets/fe_search.css', 'path' => $default, 'mtime' => (int) @filemtime($default),
        ];
        $out[self::STYLESHEET_NONE] = [
            'id' => self::STYLESHEET_NONE, 'file' => '', 'source' => 'none', 'rel' => '', 'path' => '', 'mtime' => 0,
        ];
        return $out;
    }

    /** The stylesheet in use: the admin's pick if still available, else fe_search.css. */
    public static function activeStylesheet(): string
    {
        $picked = (string) WbceSearchSettings::get('stylesheet');
        return isset(self::stylesheets()[$picked]) ? $picked : self::STYLESHEET_DEFAULT;
    }

    public static function setStylesheet(string $id): void
    {
        if (!isset(self::stylesheets()[$id])) {
            throw new RuntimeException(L_('SEARCH:MSG_SECURITY_ERROR'));
        }
        WbceSearchSettings::set('stylesheet', $id);
    }

    /** Queues the stylesheet in use (search page, tag cloud). Nothing for "none". */
    public static function queueStylesheet(): void
    {
        if (!class_exists('I')) {
            return;
        }
        $css = self::stylesheets()[self::activeStylesheet()] ?? null;
        if ($css === null || $css['rel'] === '') {
            return;
        }
        // One id for all choices: queued by page and droplet, output once.
        I::insertCssFile(WB_URL . '/' . $css['rel'], 'head_late', [], 'wbce_search_css');
    }

    /**
     * The tag cloud in the picked 'tagcloud' layout — the one markup for the
     * droplet and the search page. $tags: WbceSearchStats::getTagCloud() rows.
     * $label: null = the language text, '' = no label. Layout data: LABEL,
     * TAGS (TERM, SIZE, URL, TITLE); the parser escapes every [KEY]. Needs
     * the module's language files loaded (Lang::loadLanguage()).
     */
    public static function renderTagCloud(array $tags, ?string $label = null): string
    {
        if ($tags === []) {
            return '';
        }
        $data = ['LABEL' => $label ?? L_('SEARCH:TAGCLOUD_LABEL'), 'TAGS' => []];
        foreach ($tags as $tag) {
            $data['TAGS'][] = [
                'TERM'  => $tag['term'],
                'SIZE'  => (int) $tag['size'],
                'URL'   => WB_URL . '/search/index.php?string=' . urlencode((string) $tag['term']) . '&match=all',
                'TITLE' => Ln_('SEARCH:TAG_SEARCHED', (int) $tag['count']),
            ];
        }
        return (new LayoutParser())->parseFile(self::file('tagcloud'), $data);
    }
}
