<?php
/**
 * Standalone LayoutParser
 * ────────────────────────────────────────────────────────────────────────────
 * 
 * A lightweight template parser for HTML layout strings stored in the
 * database or loaded from simple text based files (.htt).
 * 
 * Makes use of class Lang and LangPlural for easy translations.
 * 
 * @file       framework/LayoutParser.php
 * @package    Framework
 * @version    2.1.0 (adapted for use with WBCE CMS)
 * @author     Christian M. Stefan  (https://www.wbEasy.de)
 * @copyright  2025-2026 Christian M. Stefan
 * @copyright  2026 WBCE CMS Project
 * @license    GNU/GPL v2 https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Zero dependencies. PHP 8.1+.
 *
 * ── Placeholders ────────────────────────────────────────────────────────────
 *  [KEY]
 *  [PREFIX.FIELD]                 dot notation — field inside a loop item
 *  [SETTINGS.DEBUG]               dot notation — nested top-level array access
 *  [KEY|filter]                   apply a predefined filter (a few are included)
 *  [KEY|filter1|filter2:"param"]  chain several filters, use parameters if provided
 *  [KEY|filter:VARIABLE.KEY]      unquoted variable reference as param (NEW)
 *                                 (allows for filter names coming from dynamic data)
 *
 *  Array filters receive the raw value (a list stays a list):
 *    [ITEMS|length]               number of entries (string: number of characters)
 *    [ITEMS|first]  [ITEMS|last]  first / last entry (string: first / last character)
 *    [TAGS|join]  [TAGS|join:" · "]  scalar entries joined, default ", "
 *    [KEY|plural:COUNT]           Lang plural array → "5 Posts"
 *  All other filters get the value as text (an array becomes "").
 *    [ITEM.TEXT|excerpt:120]      strip tags, cut; "…" only when actually cut
 *    [ITEM.CREATED|date:"d.m.Y"]  date string or Unix timestamp (int or 9+ digits);
 *                                 empty / 0 → "", unparseable → printed as is
 *
 *  Fallback for an empty value (missing, "", null, false, empty list —
 *  "0" and 0 are values and stay):
 *    [AUTHOR|default:"Anonymous"]   [TITLE|default:PAGE.TITLE]
 *    [TAGS|default:"–"|join]        chainable, a list passes through
 *
 *  Missing keys print "" — setDebugUndefined(true) prints [UNDEFINED:KEY]
 *  instead (only for keys that do not exist; not with |default). For
 *  development only.
 *
 * ── Dot notation ────────────────────────────────────────────────────────────
 *  Dots in key names provide three things:
 *
 *  1. Loop field access:
 *     {foreach ARTICLES as ARTICLE}
 *       [ARTICLE.TITLE]              field from the current iteration
 *       [ARTICLE._INDEX]             meta: 1-based position
 *       [ARTICLE._COUNT]             meta: total items
 *       [ARTICLE._FIRST]             meta: "1" on first iteration, "" otherwise
 *       [ARTICLE._LAST]              meta: "1" on last  iteration, "" otherwise
 *     {/foreach}
 *
 *  2. Nested array access in top-level data:
 *     $data = ['SETTINGS' => ['THEME' => 'dark']]
 *     [SETTINGS.THEME]  → "dark"
 *
 *     Resolution: fast flat-key lookup first (handles loop vars in O(1)),
 *     then dot-walk for nested arrays. Returns "" for missing keys.
 * 
 *  3. 
 *     (i18n) Lang and LangPlural integration:
 *     All language files that include their language Arrays (e.g. $TEXT, $MY_MOD)
 *     and are available in the global scope are accessible via dot notation in
 *     layouts like this:
 * 
 *     [TEXT.SAVE]                            → 'Speichern'  DE
 *     [MENU.PAGES]                           → 'Pages'      EN 
 *    
 *     // and plurals (if $MOD_FOO language array contains such key-value pairs):  
 *     [MOD_FOO.POST_COUNT|plural:5]        → '5 Posts'
 *     [MOD_FOO.POST_COUNT|plural:TOTAL]      → uses $data['TOTAL'] as count
 *     [MOD_FOO.POST_COUNT|plural:ART._COUNT] → uses loop meta-variable
 * 
 *     For this to work there is no need to pass those languages over to the 
 *     layout manually using pages. All that's needed is that the $MOD_FOO array
 *     is accessible in the global scope.
 * 
 * ── Conditionals ────────────────────────────────────────────────────────────
 *  {if KEY} … {/if}
 *  {if KEY} … {else} … {/if}
 *  {if KEY} … {elseif KEY2} … {else} … {/if}
 *  {ifnot CONDITION} … {/ifnot}   any condition below, negated
 *  Dotted keys work in all conditional forms: {if ARTICLE.ACTIVE}
 *  A bare key is true when its value is non-empty (a non-empty list too).
 *
 *  Tests:
 *    {if KEY is empty}      {if KEY is not empty}
 *    {if KEY is defined}    {if KEY is not defined}
 *    "empty" = missing, "", null, false or an empty list. Unlike a bare
 *    {if KEY}, "0" / 0 is NOT empty. "defined" = the key exists at all,
 *    even when it holds "" or null.
 *
 *  Numeric operators (unquoted RHS):
 *    ==  !=  >  <  >=  <=
 *    {if PRODUCT.PRICE > 100}   {if ITEM.STOCK <= 0}
 *
 *  Variable on the right-hand side (unquoted key):
 *    {if ITEM.ID == CURRENT_ID}   {if S.PRICE > R.LIMIT}
 *    == / != compare as numbers when both sides are numeric, else as
 *    strings; > < >= <= compare as numbers.
 *
 *  String equality (double-quoted RHS):
 *    ==  !=
 *    {if ARTICLE.STATUS == "published"}
 *
 *  String content operators (double-quoted RHS) — positive and negative:
 *    contains      / not-contains
 *    icontains     / not-icontains
 *    in            / not-in
 *    starts-with   / not-starts-with
 *    istarts-with  / not-istarts-with
 *    ends-with     / not-ends-with
 *    iends-with    / not-iends-with
 *
 *    {if ARTICLE.TAGS contains "Fotografie"}
 *    {if USER.ROLE not-in "admin,editor"}
 *    {if PAGE.SLUG not-starts-with "archive/"}
 *
 *  Combining (also in {elseif}): and / or (or && / ||), not, parentheses.
 *  Precedence not > and > or; the keywords are lowercase words of their
 *  own, text in double quotes is never split. Malformed → false.
 *    {if R.THUMB and R.ITEM_TITLE}
 *    {if FORMAT == "png" or FORMAT == "gif"}
 *    {if not R.HIDDEN and (USER_LOGGED_IN or IS_ADMIN)}
 *
 * ── Layout files and assets ─────────────────────────────────────────────────
 *  $parser->parseFile($file, $data)   layout from an .htt file inside the
 *                                     installation (droplets may not read files)
 *
 *  {insertCssFile "{MODULES}/foo/foo.css"}
 *  {insertCssFile "foo.css" position="head_late" id="foo" media="print"}
 *  {insertJsFile  "{TEMPLATE}/js/foo.js" position="body_late" defer}
 *  Hands the file to the AssetQueue (same names as the Twig functions); the
 *  directive itself prints nothing. AssetQueue tokens ({WB_URL}, {MODULES},
 *  {TEMPLATE}, …) are expanded there; a plain relative path is relative to
 *  the layout file (parseFile() only). Only .css / .js, no external URLs,
 *  no "..". In a branch of {if} that is not taken nothing is loaded.
 *  No bundles: those are set up at boot time (initialize_fe.php), as in Twig.
 *
 * ── Loops ────────────────────────────────────────────────────────────────────
 *  {foreach LIST as ITEM} … {/foreach}
 *  {foreach MAP as KEY => VALUE} … {/foreach}
 *
 *  Auto-injected per iteration (leading underscore = meta-variable):
 *    [ITEM._INDEX]   1-based position
 *    [ITEM._COUNT]   total items
 *    [ITEM._FIRST]   "1" on first iteration, "" otherwise
 *    [ITEM._LAST]    "1" on last  iteration, "" otherwise
 *
 *  Loops nest to any depth. The list may be dotted — a list inside the
 *  current item, or a nested top-level array:
 *    {foreach RESULTS as R}
 *      <h3>[R.TITLE]</h3>
 *      {foreach R.SECTIONS as S}
 *        <a href="[S.LINK]">[S.TITLE]</a> ([S._INDEX]/[S._COUNT], hit [R._INDEX])
 *      {/foreach}
 *    {/foreach}
 *    {foreach SETTINGS.ITEMS as I} … {/foreach}
 *  Outer loop variables stay visible inside an inner loop; each loop has
 *  its own meta-variables. Whitespace right after the opening tag and
 *  right before {/foreach} is trimmed. An unclosed {foreach} is left in
 *  the output as text.
 *
 *  Empty list:
 *    {foreach RESULTS as R} … {else} <p>No results.</p> {/foreach}
 *  Only an {else} on the loop's own level counts — one inside a nested
 *  {if} or {foreach} belongs to that.
 *
 *  Part of the list (in any order; N a number or a key):
 *    {foreach NEWS as N limit 5}  {foreach NEWS as N offset 5 limit 5}
 *    {foreach NEWS as N limit SETTINGS.PER_PAGE}
 *  limit 0 or an empty/missing key = all ("0 = unlimited", as settings
 *  use it). _INDEX/_COUNT/_FIRST/_LAST refer to the part shown; map keys
 *  are kept. Nothing left → the {else} branch.
 *
 *  Loop budget: 100 000 iterations per parse() in total (all loops,
 *  partials included), adjustable with setMaxLoopIterations(). When it
 *  runs out the loop stops, prints <!-- loop limit reached --> and warns
 *  once. It only catches runaway nesting of big lists into themselves.
 *
 * ── Defaults ────────────────────────────────────────────────────────────────
 *  {default KEY "fallback"}  /  {default KEY 'fallback'}  /  {default KEY word}
 *  Dotted keys work too: {default ARTICLE.AUTHOR "Anonymous"}
 *
 * ── Partials & Includes ──────────────────────────────────────────────────────
 *  Simple (inherits current scope):
 *    {partial NAME}
 *    {include "path/file.htt"} 
 *
 *  With extra data — additive (merged on top of inherited scope):
 *    {partial NAME with KEY="literal" KEY=DOTTED.VAR}
 *    {include "path/file.htt" with KEY="literal" KEY=DOTTED.VAR}
 *  KEY=DOTTED.VAR passes the value as it is — a list can be looped over
 *  inside the partial: {partial ROW with ITEMS=R.SECTIONS}
 *
 *  Used inside a loop body, a partial sees the loop variables.
 *  Nesting deeper than 10 (e.g. a partial including itself) stops with a
 *  warning and <!-- partial 'NAME': nesting limit reached -->.
 *
 * ── Comments ─────────────────────────────────────────────────────────────────
 *  {# template comment #}       always stripped
 *  <!-- html comment -->       stripped only when setStripHtmlComments(true)
 *
 * ── Object support ───────────────────────────────────────────────────────────
 *  parse() and loop items 
 *  accept arrays, stdClass, or any object with toArray()
 *
 * ── Dump: Lookup keys, arrays and filters ────────────────────────────────────
 *    a convenient way to see what's available in a given Layout
 * 
 *  [_CONTEXT|dump]   all template variables (lang namespaces excluded)
 *  [_FILTERS|dump]   alphabetical list of registered filter names
 *  [_LANG|dump]      lang namespaces only: TEXT, MENU, MESSAGE, HINT, HEADING, OVERVIEW
 *  [KEY|dump]        print_r of any single variable (dotted keys work)
 *
 * ── Processing order (do not reorder) ────────────────────────────────────────
 *  comments → loops → partials/includes → conditionals → defaults → placeholders
 *
 *  Loops run before partials so a partial inside a loop body is rendered
 *  per iteration with that iteration's variables.
 *
 *  Data is never template: what a loop, a partial/include or a {default}
 *  has already printed is held aside (_protect()) while the later passes
 *  run, so a value like "[SECRET]" or "{if X}…{/if}" is output literally.
 *
 */

// Prevent  this  file  from  being  accessed  directly
defined('WB_PATH') or die('No direct access allowed');

class LayoutParser
{
    // ── Properties ───────────────────────────────────────────────────────────

    /** @var array<string, callable> */
    private array $filters = [];

    /** @var array<string, string> */
    private array $partials = [];

    private string $partialsPath = '';
    private bool $stripHtmlComments = false;

    /**
     * Runtime globals registered via addGlobal() / addGlobals().
     * @var array<string, mixed>
     */
    private array $globals = [];

    /**
     * Active variable scope at the current point in the parse pipeline.
     * @var array|null
     */
    protected ?array $currentScope = null;

    /**
     * Finished output (a loop, a partial/include, a {default} value) waiting
     * to be put back. It stays out of the text as a marker while the later
     * passes run, so DATA is never read as template — see _protect().
     * @var array<int, string>
     */
    private array $stash = [];

    /** Random per outermost parse(): data cannot forge a marker. */
    private string $stashNonce = '';

    /** parse() is re-entered for partials/includes; the stash lives for the outermost call. */
    private int $parseDepth = 0;

    /** Partials/includes nested deeper than this are cut off (self-inclusion). */
    private const MAX_PARTIAL_DEPTH = 10;
    private int $partialDepth = 0;

    /**
     * Loop iterations allowed per outermost parse(). Generous on purpose —
     * no single list is cut in practice; what it stops is nesting the same
     * big list into itself ({foreach L}{foreach L}{foreach L}: n³).
     */
    private int $maxLoopIterations = 100000;
    private int $loopIterations    = 0;

    /** setDebugUndefined(true): a missing key prints [UNDEFINED:KEY] instead of "". */
    private bool $debugUndefined = false;

    /** Folder of the layout file being parsed (parseFile()), '' for a string. */
    private string $layoutDir = '';

    // ── Constructor ───────────────────────────────────────────────────────────

    public function __construct(string $partialsPath = '')
    {
        $this->partialsPath = rtrim($partialsPath, '/\\');

        $this->filters = [

            // Case
            'upper'    => fn($v)               => strtoupper((string) $v),
            'lower'    => fn($v)               => strtolower((string) $v),
            'ucfirst'  => fn($v)               => ucfirst(strtolower((string) $v)),
            'ucwords'  => fn($v)               => ucwords(strtolower((string) $v)),

            // Whitespace / length
            'trim'     => fn($v)               => trim((string) $v),
            'truncate' => fn($v, $len = '80')  => mb_strlen((string) $v) > (int) $len
                              ? mb_substr((string) $v, 0, (int) $len) . '…'
                              : (string) $v,

            // Text formatting
            'nl2br'    => fn($v)               => nl2br(htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8')),
            // "…" only when something was cut off (was appended to every value).
            'excerpt'  => function ($v, $len = '120'): string {
                $text = strip_tags((string) $v);
                return mb_strlen($text) > (int) $len ? mb_substr($text, 0, (int) $len) . '…' : $text;
            },
            'striphtml'=> fn($v)               => strip_tags((string) $v),

            // Numbers & dates
            'int'      => fn($v)               => (string)(int) $v,
            'float'    => fn($v, $dec = '2')   => number_format((float) $v, (int) $dec),
            'date'     => fn($v, $fmt = 'd.m.Y')  => self::_formatDate($v, (string) $fmt),
            'time'     => fn($v, $fmt = 'H:i')    => self::_formatDate($v, (string) $fmt),

            // Arrays (also: a string's length / first / last character).
            // These receive the raw value — see ARRAY_FILTERS.
            'length'   => fn($v)               => (string) (is_array($v) ? count($v) : mb_strlen((string) $v)),
            'first'    => fn($v)               => is_array($v)
                              ? ($v === [] ? '' : reset($v))
                              : mb_substr((string) $v, 0, 1),
            'last'     => fn($v)               => is_array($v)
                              ? ($v === [] ? '' : end($v))
                              : mb_substr((string) $v, -1),
            'join'     => fn($v, $sep = ', ')  => is_array($v)
                              ? implode((string) $sep, array_filter($v, fn($x) => is_scalar($x)))
                              : (string) $v,

            // Fallback for an empty value (see _isEmpty(): "0" is a value).
            // [AUTHOR|default:"Anonymous"]  [TITLE|default:PAGE.TITLE]
            // Gets the raw value (ARRAY_FILTERS), so a list passes through
            // to a following |join or |length.
            'default'  => function (mixed $v, ?string $fallback = null, bool $isVarRef = false): mixed {
                if (!self::_isEmpty($v) || $fallback === null) {
                    return $v;
                }
                return $isVarRef
                    ? ($this->_resolveDotKey($fallback, $this->currentScope ?? [], true) ?? '')
                    : $fallback;
            },

            // HTML safety
            'escape'   => fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'),
            'raw'      => fn($v) => (string) $v,

            // ── plural (NEW) ──────────────────────────────────────────────────
            // Resolves a plural array from the Lang registry to the correct
            // form for a given count.
            //
            // $value    : the plural array from getRegistry(), e.g.
            //             ['one' => '%d Seite', 'other' => '%d Seiten']
            //             A plain string value is also accepted and sprintf'd.
            // $param    : the count — either a quoted literal ("5") or an
            //             unquoted variable key (TOTAL, ARTICLE._COUNT).
            //             Variable keys are resolved from $this->currentScope.
            // $isVarRef : true when $param was specified without quotes —
            //             signals that $param should be treated as a scope key.
            //
            // Usage in templates:
            //   [TEXT.PAGE_COUNT|plural:"1"]            → '1 Seite'
            //   [TEXT.PAGE_COUNT|plural:"5"]            → '5 Seiten'
            //   [TEXT.PAGE_COUNT|plural:TOTAL]          → resolves $data['TOTAL']
            //   [TEXT.PAGE_COUNT|plural:ARTICLE._COUNT] → resolves loop meta-var
            'plural' => function(mixed $val, ?string $param = null, bool $isVarRef = false): string {
                // Resolve the count
                $count = 0;
                if ($param !== null) {
                    if ($isVarRef && $this->currentScope !== null) {
                        $count = (int)($this->_resolveDotKey($param, $this->currentScope) ?? 0);
                    } else {
                        $count = (int)$param;
                    }
                }

                // Plain string value — just sprintf the count in
                if (!is_array($val)) {
                    return sprintf((string)$val, $count);
                }

                // parse() uppercases every data key — the Lang registry's
                // plural arrays too ('one' → 'ONE'), so the categories below
                // were never found and the first form won every time.
                $val = array_change_key_case($val, CASE_LOWER);

                // Optional explicit 'zero' key — takes priority over CLDR rules
                if ($count === 0 && isset($val['zero'])) {
                    return sprintf((string)$val['zero'], $count);
                }

                // Pick the correct CLDR plural category
                // Requires Lang and LangPlural to be loaded
                $category = class_exists('LangPlural')
                    ? LangPlural::category(
                          class_exists('Lang') ? Lang::getLocale() : 'EN',
                          $count
                      )
                    : ($count === 1 ? 'one' : 'other');

                $form = $val[$category] ?? $val['other'] ?? $val['one'] ?? reset($val);
                return sprintf((string)$form, $count);
            },

            // Debug
            'dump' => fn(mixed $value, ?string $param = null): string
                => $this->_printDebug($value, $param),
        ];
    }

    // ── Public API — Configuration ────────────────────────────────────────────

    public function addFilter(string $name, callable $fn): static
    {
        $this->filters[strtolower($name)] = $fn;
        return $this;
    }

    public function addPartial(string $name, string $html): static
    {
        $this->partials[strtoupper($name)] = $html;
        return $this;
    }

    public function setPartialsPath(string $path): static
    {
        $this->partialsPath = rtrim($path, '/\\');
        return $this;
    }

    /** Loop iterations allowed per parse() call (default 100 000). */
    public function setMaxLoopIterations(int $max): static
    {
        $this->maxLoopIterations = max(1, $max);
        return $this;
    }

    /**
     * Development aid: a placeholder whose key does not exist at all prints
     * [UNDEFINED:KEY] instead of nothing (typos, a missing translation, a
     * field the loop item lacks). An existing but empty value still prints
     * "", and so does [KEY|default:…]. Off by default — never in production.
     */
    public function setDebugUndefined(bool $on = true): static
    {
        $this->debugUndefined = $on;
        return $this;
    }

    public function setStripHtmlComments(bool $value): static
    {
        $this->stripHtmlComments = $value;
        return $this;
    }

    public function addGlobal(string $key, mixed $value): static
    {
        $this->globals[strtoupper($key)] = $value;
        return $this;
    }

    public function addGlobals(array $globals): static
    {
        foreach ($globals as $key => $value) {
            $this->globals[strtoupper($key)] = $value;
        }
        return $this;
    }

    protected function _defaultGlobals(): array
    {
        $defaults = [
            'TEMPLATE_URL'  => (defined('TEMPLATE') && defined('WB_URL'))
                                    ? WB_URL . '/templates/' . TEMPLATE
                                    : '',
            'WB_URL'        => defined('WB_URL')   ? WB_URL   : '',
            'ADMIN_URL'     => defined('ADMIN_URL') ? ADMIN_URL : '',
        ];

        // Automatically merge the full Lang registry if Lang is loaded.
        // This makes [TEXT.SAVE], [MENU.PAGES], [MOD_NEWS.TITLE] etc. available
        // in every template without any manual addGlobals() call.
        // Lang data has lower priority than $data passed to parse() —
        // a key in $data always overrides a translation of the same name.
        if (class_exists('Lang', false)) {
            $defaults = array_merge(Lang::getRegistry(), $defaults);
        }

        return $defaults;
    }

    // ── Public API — Parse ────────────────────────────────────────────────────

    /**
     * parse() with the layout read from an .htt file — the way for code that
     * may not read files itself (droplets: CodeVet blocks file_get_contents).
     * Only .htt files inside the installation are read (see readLayoutFile());
     * anything else renders "" (with setDebugUndefined(): an HTML comment).
     */
    public function parseFile(string $file, array|object $data): string
    {
        $layout = self::readLayoutFile($file);
        if ($layout === null) {
            return $this->debugUndefined
                ? '<!-- layout file not found or not allowed: ' . htmlspecialchars(basename($file), ENT_QUOTES, 'UTF-8') . ' -->'
                : '';
        }
        // Relative {insertCssFile}/{insertJsFile} paths resolve against this folder.
        $previousDir     = $this->layoutDir;
        $this->layoutDir = dirname((string) realpath($file));
        try {
            return $this->parse($layout, $data);
        } finally {
            $this->layoutDir = $previousDir;
        }
    }

    /**
     * Contents of a layout file, or null unless it is an existing .htt file
     * inside WB_PATH. The checks run on the resolved path, so "../" and a
     * symlink to config.php or a file outside the installation are refused
     * — a droplet must not be able to print arbitrary files through this.
     */
    public static function readLayoutFile(string $file): ?string
    {
        $root = defined('WB_PATH') ? realpath(WB_PATH) : false;
        $real = realpath($file);
        if ($root === false || $real === false || !is_file($real)) {
            return null;
        }
        $real = str_replace('\\', '/', $real);
        $root = rtrim(str_replace('\\', '/', $root), '/') . '/';
        $same = DIRECTORY_SEPARATOR === '\\'
            ? stripos($real, $root) === 0        // Windows: paths are case-insensitive
            : str_starts_with($real, $root);
        if (!$same || strtolower(pathinfo($real, PATHINFO_EXTENSION)) !== 'htt') {
            return null;
        }
        $layout = file_get_contents($real);
        return $layout === false ? null : $layout;
    }

    public function parse(string $layout, array|object $data): string
    {
        $merged = array_merge(
            $this->_uppercaseKeys($this->_defaultGlobals()),
            $this->_uppercaseKeys($this->globals),
            $this->_uppercaseKeys($this->_normalize($data))
        );

        if ($this->parseDepth++ === 0) {
            $this->stash          = [];
            $this->stashNonce     = bin2hex(random_bytes(6));
            $this->loopIterations = 0;
        }
        try {
            return $this->_restore($this->_render($layout, $merged));
        } finally {
            if (--$this->parseDepth === 0) {
                $this->stash = [];
            }
        }
    }

    /**
     * Takes finished output out of the text: the later passes of the
     * enclosing render (conditionals, defaults, placeholders) run over the
     * whole text, and used to evaluate "[KEY]" or "{if …}" inside a VALUE a
     * loop or partial had already printed — data read as template. The
     * marker holds no [ ] { } and is put back by _restore() at the end.
     */
    private function _protect(string $output): string
    {
        $this->stash[] = $output;
        return "\x1A" . $this->stashNonce . ':' . (count($this->stash) - 1) . "\x1A";
    }

    /** Puts protected output back, including markers nested inside it. */
    private function _restore(string $html): string
    {
        if ($this->stash === [] || !str_contains($html, "\x1A")) {
            return $html;
        }
        return preg_replace_callback(
            '~\x1A' . $this->stashNonce . ':(\d+)\x1A~',
            fn(array $m): string => $this->_restore($this->stash[(int) $m[1]] ?? ''),
            $html
        ) ?? $html;
    }

    /**
     * The pipeline on an already merged scope. A loop iteration renders its
     * body through here, not through parse(): its scope is a copy of the
     * parent's merged scope, so merging the globals and the whole Lang
     * registry again (and uppercasing every key) per iteration only cost
     * time — with nested loops that is one full merge per inner item.
     */
    private function _render(string $layout, array $scope): string
    {
        $previousScope      = $this->currentScope;
        $this->currentScope = $scope;

        $html = $layout;
        $html = $this->_stripComments($html);
        // Loops BEFORE partials: a {partial … with N=I.NAME} inside a loop
        // body must be rendered per iteration, with I set. Partials first
        // resolved it once, against the outer scope, before the loop ran.
        $html = $this->_resolveLoops($html, $this->currentScope);
        $html = $this->_resolvePartials($html, $this->currentScope);
        $html = $this->_resolveConditionals($html, $this->currentScope);
        // After the conditionals: an {insertCssFile} in a branch that is not
        // taken loads nothing.
        $html = $this->_resolveAssets($html);
        $html = $this->_resolveDefaults($html, $this->currentScope);
        $html = $this->_resolvePlaceholders($html, $this->currentScope);

        $this->currentScope = $previousScope;

        return $html;
    }

    // ── Private — Assets ──────────────────────────────────────────────────────

    /**
     * {insertCssFile "…" position="…" id="…" media="…"}
     * {insertJsFile  "…" position="…" id="…" defer async type="module"}
     *
     * Same names as the Twig functions (tsf_insert.php). The directive is
     * removed from the output and the file handed to the AssetQueue
     * (I::insertCssFile / I::insertJsFile), which expands its {TOKENS}
     * ({MODULES}, {TEMPLATE}, {WB_URL}, …), checks the file exists, dedupes
     * and adds the cache buster. This method only:
     *   - turns a RELATIVE path into a URL against the layout file's folder
     *     (parseFile() only — parse() of a string has no folder);
     *   - refuses what an editable layout / droplet must not load: another
     *     extension than .css / .js, external URLs (http(s)://, //) and "..".
     * A refused or unresolvable entry loads nothing (setDebugUndefined():
     * an HTML comment says why).
     */
    private function _resolveAssets(string $html): string
    {
        if (!str_contains($html, '{insert')) {
            return $html;
        }
        return preg_replace_callback(
            '~\{(insertCssFile|insertJsFile)\s+"([^"]*)"((?:\s+[a-z]+(?:="[^"]*")?)*)\s*\}~',
            function (array $m): string {
                $isCss = $m[1] === 'insertCssFile';
                $why   = $this->_queueAsset($m[2], $m[3], $isCss);
                return ($why !== '' && $this->debugUndefined)
                    ? '<!-- ' . $m[1] . ' "' . htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8') . '": ' . $why . ' -->'
                    : '';
            },
            $html
        ) ?? $html;
    }

    /** Queues one asset; returns '' on success, else the reason. */
    private function _queueAsset(string $src, string $attrString, bool $isCss): string
    {
        $src = trim($src);
        $ext = $isCss ? 'css' : 'js';
        $bare = (string) strtok($src, '?#');

        if ($src === '' || preg_match('~^(?:[a-z][a-z0-9+.\-]*:|//)~i', $src)) {
            return 'external or empty URL not allowed';
        }
        if (strtolower(pathinfo($bare, PATHINFO_EXTENSION)) !== $ext) {
            return 'only .' . $ext . ' files';
        }
        if (str_contains($bare, '..')) {
            return '".." not allowed';
        }

        if (!str_starts_with($src, '{')) {
            // Relative to the layout file — only known for parseFile().
            $root = defined('WB_PATH') ? realpath(WB_PATH) : false;
            if ($this->layoutDir === '' || $root === false || !defined('WB_URL')) {
                return 'relative path needs parseFile()';
            }
            $dir  = str_replace('\\', '/', $this->layoutDir);
            $root = rtrim(str_replace('\\', '/', $root), '/');
            if (stripos($dir . '/', $root . '/') !== 0) {
                return 'layout outside the installation';
            }
            $src = rtrim(WB_URL, '/') . substr($dir, strlen($root)) . '/' . ltrim($src, '/');
        }

        preg_match_all('~([a-z]+)(?:="([^"]*)")?~', $attrString, $am, PREG_SET_ORDER);
        $opt = [];
        foreach ($am as $a) {
            $opt[$a[1]] = $a[2] ?? true;
        }
        $position = (string) ($opt['position'] ?? ($isCss ? 'head_late' : 'body_late'));
        $id       = (string) ($opt['id'] ?? '');
        $attrs    = [];
        if ($isCss) {
            if (isset($opt['media'])) $attrs['media'] = (string) $opt['media'];
        } else {
            foreach (['defer', 'async'] as $flag) {
                if (isset($opt[$flag])) $attrs[$flag] = true;
            }
            if (($opt['type'] ?? '') === 'module') $attrs['type'] = 'module';
        }

        if (!class_exists('I')) {
            return 'no AssetQueue';
        }
        $isCss
            ? I::insertCssFile($src, $position, $attrs, $id)
            : I::insertJsFile($src, $position, $attrs, $id);
        return '';
    }

    // ── Private — Key resolution ──────────────────────────────────────────────

    private function _resolveDotKey(string $key, array $data, bool $raw = false): mixed
    {
        if (array_key_exists($key, $data)) {
            $value = $data[$key];
            if ($raw) { return $value; }
            return (is_scalar($value) || $value === null) ? $value : null;
        }

        if (str_contains($key, '.')) {
            $parts   = explode('.', $key);
            $current = $data;

            foreach ($parts as $part) {
                if (is_array($current) && array_key_exists($part, $current)) {
                    $current = $current[$part];
                } else {
                    return null;
                }
            }

            if ($raw) { return $current; }
            return (is_scalar($current) || $current === null) ? $current : null;
        }

        return null;
    }

    /**
     * Whether a key exists at all — the same lookup as _resolveDotKey(),
     * which cannot tell a missing key from one that holds null.
     */
    private function _keyExists(string $key, array $data): bool
    {
        if (array_key_exists($key, $data)) {
            return true;
        }
        if (!str_contains($key, '.')) {
            return false;
        }
        $current = $data;
        foreach (explode('.', $key) as $part) {
            if (!is_array($current) || !array_key_exists($part, $current)) {
                return false;
            }
            $current = $current[$part];
        }
        return true;
    }

    /**
     * "Empty" for `is empty` and |default: null, "", false, an empty list.
     * Unlike a bare {if KEY}, "0" and 0 are NOT empty — a price of 0 or a
     * count of 0 is a value, not a missing one.
     */
    private static function _isEmpty(mixed $value): bool
    {
        return $value === null || $value === '' || $value === false || $value === [];
    }

    // ── Private — Normalization ───────────────────────────────────────────────

    private function _normalize(mixed $value): array
    {
        if (is_array($value)) return $value;
        if (is_object($value)) {
            return method_exists($value, 'toArray') ? $value->toArray() : (array) $value;
        }
        return [];
    }

    private function _uppercaseKeys(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $upperKey          = is_string($key) ? strtoupper($key) : $key;
            $result[$upperKey] = is_array($value) ? $this->_uppercaseKeys($value) : $value;
        }
        return $result;
    }

    // ── Private — Parse `with` attribute ─────────────────────────────────────

    private function _parseWith(string $withStr, array $scope): array
    {
        $withStr = trim($withStr);
        if ($withStr === '') return $scope;

        $extra = [];
        preg_match_all(
            '~([A-Z_][A-Z0-9_]*)=(?:"([^"]*)"|([ A-Z_][A-Z0-9_.]*))~',
            $withStr, $matches, PREG_SET_ORDER
        );

        foreach ($matches as $m) {
            if (isset($m[3]) && trim($m[3]) !== '') {
                // A key: its raw value, so a list reaches the partial as a
                // list (was cast to string — every array arrived as "").
                $extra[$m[1]] = $this->_resolveDotKey(trim($m[3]), $scope, true) ?? '';
            } else {
                // A quoted literal, "" included ($m[3] is absent then — the
                // former $m[2] !== '' test fell through to it: a warning).
                $extra[$m[1]] = $m[2];
            }
        }

        return array_merge($scope, $extra);
    }

    // ── Private pipeline — Step 0: Comments ──────────────────────────────────

    private function _stripComments(string $html): string
    {
        $html = preg_replace('~\{#.*?#\}~s', '', $html);
        if ($this->stripHtmlComments) {
            $html = preg_replace('~<!--.*?-->~s', '', $html);
        }
        return $html;
    }

    // ── Private pipeline — Step 1: Partials & Includes ───────────────────────

    private function _resolvePartials(string $html, array $data): string
    {
        $html = preg_replace_callback(
            '~\{partial\s+([A-Z_]+)(?:\s+with\s+(.*?))?\s*\}~s',
            function ($m) use ($data) {
                $name  = strtoupper($m[1]);
                $scope = $this->_parseWith($m[2] ?? '', $data);
                if (!isset($this->partials[$name])) {
                    return "<!-- partial '{$name}' not registered -->";
                }
                return $this->_renderPartial("partial '{$name}'", $this->partials[$name], $scope);
            },
            $html
        ) ?? $html;

        if ($this->partialsPath !== '') {
            $html = preg_replace_callback(
                '~\{include\s+"([^"]+)"(?:\s+with\s+(.*?))?\s*\}~s',
                function ($m) use ($data) {
                    $fullPath = wbceSafeRelativePath($this->partialsPath, $m[1]);
                    $scope    = $this->_parseWith($m[2] ?? '', $data);
                    if ($fullPath === null || !is_file($fullPath)) {
                        return "<!-- include '" . h($m[1]) . "' not found -->";
                    }
                    return $this->_renderPartial("include '" . h($m[1]) . "'", (string) file_get_contents($fullPath), $scope);
                },
                $html
            ) ?? $html;
        }

        return $html;
    }

    /**
     * A partial or include that (directly or via others) includes itself
     * recursed until PHP died — a white page from one line in an editable
     * layout. Past MAX_PARTIAL_DEPTH it is cut off with a comment and a log
     * entry instead.
     */
    private function _renderPartial(string $label, string $layout, array $scope): string
    {
        if ($this->partialDepth >= self::MAX_PARTIAL_DEPTH) {
            trigger_error("LayoutParser: {$label} — nesting limit (" . self::MAX_PARTIAL_DEPTH . ') reached, recursion?', E_USER_WARNING);
            return "<!-- {$label}: nesting limit reached -->";
        }
        $this->partialDepth++;
        try {
            return $this->_protect($this->parse($layout, $scope));
        } finally {
            $this->partialDepth--;
        }
    }

    // ── Private pipeline — Step 2: Loops ─────────────────────────────────────

    /**
     * Opening tag: {foreach LIST as ITEM} / {foreach LIST as KEY => VALUE}.
     * LIST may be dotted — R.SECTIONS (a list inside the current loop item)
     * or SETTINGS.ITEMS (a nested top-level array).
     * Optional, in any order: limit N / offset N (N a number or a key).
     */
    private const LOOP_OPEN = '~\{foreach\s+([A-Z_][A-Z0-9_.]*)\s+as\s+(?:([A-Z_][A-Z0-9_]*)\s*=>\s*)?([A-Z_][A-Z0-9_]*)((?:\s+(?:limit|offset)\s+(?:\d+|[A-Z_][A-Z0-9_.]*))*)\s*\}~';

    private const LOOP_CLOSE = '{/foreach}';

    /**
     * Resolves the outermost loops; inner loops are resolved when each
     * iteration's body goes through parse() again — that is what makes
     * nesting work. The body is found by counting depth: a non-greedy
     * regex (what this used to be) ends the OUTER loop at the first
     * {/foreach}, which belongs to the inner one.
     */
    private function _resolveLoops(string $html, array $data): string
    {
        $out = '';
        $pos = 0;

        while (preg_match(self::LOOP_OPEN, $html, $open, PREG_OFFSET_CAPTURE, $pos)) {
            $tagStart  = $open[0][1];
            $bodyStart = $tagStart + strlen($open[0][0]);
            $bodyEnd   = $this->_findLoopEnd($html, $bodyStart);

            if ($bodyEnd === null) {
                // Unclosed: leave this tag as it is (as before) and keep
                // looking — loops after it may still be complete.
                $out .= substr($html, $pos, $bodyStart - $pos);
                $pos  = $bodyStart;
                continue;
            }

            // Whitespace around the block is trimmed, as the former
            // "}\s*(.*?)\s*{/foreach}" pattern did.
            $body = preg_replace('~\A\s+|\s+\z~', '', substr($html, $bodyStart, $bodyEnd - $bodyStart)) ?? '';

            $out .= substr($html, $pos, $tagStart - $pos)
                  . $this->_protect($this->_renderLoop($open[1][0], (string) ($open[2][0] ?? ''), $open[3][0], $body, $data, (string) ($open[4][0] ?? '')));
            $pos  = $bodyEnd + strlen(self::LOOP_CLOSE);
        }

        return $out . substr($html, $pos);
    }

    /** Offset of the {/foreach} that closes a loop whose body starts at $from, or null. */
    private function _findLoopEnd(string $html, int $from): ?int
    {
        $tags = '~' . substr(self::LOOP_OPEN, 1, -1) . '|' . preg_quote(self::LOOP_CLOSE, '~') . '~';
        if (!preg_match_all($tags, $html, $m, PREG_OFFSET_CAPTURE, $from)) {
            return null;
        }

        $depth = 1;
        foreach ($m[0] as [$tag, $offset]) {
            $depth += ($tag === self::LOOP_CLOSE) ? -1 : 1;
            if ($depth === 0) {
                return $offset;
            }
        }
        return null;
    }

    private function _renderLoop(string $listName, string $keyAlias, string $prefix, string $blockTpl, array $data, string $range = ''): string
    {
        $keyAlias = $keyAlias !== '' ? strtoupper($keyAlias) : null;
        $prefix   = strtoupper($prefix);

        // {foreach …} body {else} shown when the list is empty {/foreach}
        [$blockTpl, $emptyTpl] = $this->_splitLoopElse($blockTpl);

        // Flat key first (loop fields are stored flat, e.g. "R.SECTIONS"),
        // then a dot-walk through nested top-level data.
        $items = $this->_resolveDotKey($listName, $data, true) ?? [];
        if (is_iterable($items) && $range !== '') {
            $items = $this->_sliceLoop($items, $range, $data);
        }
        if (!is_iterable($items) || empty($items)) {
            return $emptyTpl !== '' ? $this->_render($emptyTpl, $data) : '';
        }

        $total  = count($items);
        $output = '';
        $index  = 0;

        foreach ($items as $mapKey => $item) {
            if (++$this->loopIterations > $this->maxLoopIterations) {
                if ($this->loopIterations === $this->maxLoopIterations + 1) {
                    trigger_error('LayoutParser: loop limit (' . $this->maxLoopIterations . ' iterations) reached — the same list nested into itself?', E_USER_WARNING);
                }
                $output .= '<!-- loop limit reached -->';
                break;
            }
            if (is_scalar($item) || $item === null) {
                $item = ['' => $item, 'VALUE' => $item];
            } else {
                // Uppercased here because _render() does not re-run parse()'s
                // _uppercaseKeys() — matters for object items (toArray()).
                $item = $this->_uppercaseKeys($this->_normalize($item));
            }

            $scopeData = $data;
            if ($keyAlias !== null) {
                $scopeData[$keyAlias] = (string) $mapKey;
            }

            $scopeData[$prefix . '._INDEX'] = $index + 1;
            $scopeData[$prefix . '._COUNT'] = $total;
            $scopeData[$prefix . '._FIRST'] = ($index === 0)          ? '1' : '';
            $scopeData[$prefix . '._LAST']  = ($index === $total - 1) ? '1' : '';

            foreach ($item as $k => $v) {
                $k        = strtoupper((string) $k);
                $fieldKey = ($k === '') ? $prefix : $prefix . '.' . $k;
                $scopeData[$fieldKey] = $v;
            }

            $output .= $this->_render($blockTpl, $scopeData);
            $index++;
        }

        return $output;
    }

    /**
     * {foreach LIST as I offset 2 limit 5}: the part of the list that is
     * looped over. N is a number or a key (a module setting, say). A limit
     * of 0 or an empty/missing one means "all" — the usual "0 = unlimited"
     * of a setting; a negative offset counts as 0. Keys are kept, so
     * KEY => VALUE still sees the real keys; _INDEX/_COUNT refer to the part.
     */
    private function _sliceLoop(iterable $items, string $range, array $data): array
    {
        $items = is_array($items) ? $items : iterator_to_array($items);

        preg_match_all('~(limit|offset)\s+(\d+|[A-Z_][A-Z0-9_.]*)~', $range, $m, PREG_SET_ORDER);
        $limit  = 0;
        $offset = 0;
        foreach ($m as [, $what, $n]) {
            $n = ctype_digit($n) ? (int) $n : (int) ($this->_resolveDotKey($n, $data) ?? 0);
            if ($what === 'limit') { $limit = $n; } else { $offset = max(0, $n); }
        }

        return array_slice($items, $offset, $limit > 0 ? $limit : null, true);
    }

    /**
     * Splits a loop body at ITS {else} — not one belonging to a nested
     * {if}…{else}…{/if} or to a nested loop's own {else}. Both parts are
     * trimmed like the body. No {else} of its own → [body, ''].
     *
     * @return array{0: string, 1: string}
     */
    private function _splitLoopElse(string $body): array
    {
        if (!str_contains($body, '{else}')) {
            return [$body, ''];
        }

        $tags = '~' . substr(self::LOOP_OPEN, 1, -1) . '|\{/foreach\}|\{if\s[^}]*\}|\{/if\}|\{else\}~';
        if (!preg_match_all($tags, $body, $m, PREG_OFFSET_CAPTURE)) {
            return [$body, ''];
        }

        $loopDepth = 0;
        $ifDepth   = 0;
        foreach ($m[0] as [$tag, $offset]) {
            if ($tag === '{/foreach}')            { $loopDepth--; continue; }
            if ($tag === '{/if}')                 { $ifDepth--;   continue; }
            if (str_starts_with($tag, '{foreach')) { $loopDepth++; continue; }
            if (str_starts_with($tag, '{if'))      { $ifDepth++;   continue; }
            if ($loopDepth === 0 && $ifDepth === 0) { // {else} of this loop
                $trim = static fn(string $s): string => preg_replace('~\A\s+|\s+\z~', '', $s) ?? '';
                return [$trim(substr($body, 0, $offset)), $trim(substr($body, $offset + strlen('{else}')))];
            }
        }
        return [$body, ''];
    }

    // ── Private pipeline — Step 3: Conditionals ──────────────────────────────

    private function _resolveConditionals(string $html, array $data): string
    {
        $inner    = '(?:(?!\{(?:if|ifnot)[\s_])[\s\S])*?';
        $previous = null;

        while ($previous !== $html) {
            $previous = $html;

            $html = preg_replace_callback(
                '~\{if\s+([^\}]+)\}
                  (' . $inner . ')
                  ((?:\{elseif\s+[^\}]+\}' . $inner . ')*)
                  (?:\{else\}(' . $inner . '))?
                  \{/if\}~x',
                function ($m) use ($data, $inner) {
                    $thenBlock   = $m[2];
                    $elseifChain = $m[3];
                    $elseBlock   = $m[4] ?? '';

                    if ($this->_evaluateCondition(trim($m[1]), $data)) return $thenBlock;

                    if ($elseifChain !== '') {
                        preg_match_all(
                            '~\{elseif\s+([^\}]+)\}([\s\S]*?)(?=\{elseif\s|\z)~',
                            $elseifChain, $branches, PREG_SET_ORDER
                        );
                        foreach ($branches as $branch) {
                            if ($this->_evaluateCondition(trim($branch[1]), $data)) {
                                return $branch[2];
                            }
                        }
                    }

                    return $elseBlock;
                },
                $html
            ) ?? $html;

            $html = preg_replace_callback(
                // The same conditions as {if} (only a single key before).
                '~\{ifnot\s+([^\}]+)\}(' . $inner . ')\{/ifnot\}~x',
                function ($m) use ($data) {
                    return $this->_evaluateCondition(trim($m[1]), $data) ? '' : $m[2];
                },
                $html
            ) ?? $html;
        }

        return $html;
    }

    /**
     * A full {if}/{elseif} condition: single conditions (see _evaluateAtom())
     * combined with and / or / && / ||, not, and parentheses. Precedence:
     * not > and > or. Keywords are lowercase and must stand alone (keys are
     * uppercase, so BRAND is a key, and "not-contains" an operator); text in
     * double quotes is never split. A malformed condition is false — as an
     * unknown one always was.
     */
    private function _evaluateCondition(string $condStr, array $data): bool
    {
        $tokens = $this->_conditionTokens($condStr);

        // One plain condition — exactly the former behaviour, no parser.
        if (count($tokens) === 1 && $tokens[0][0] === 'atom') {
            return $this->_evaluateAtom($tokens[0][1], $data);
        }

        $pos    = 0;
        $ok     = true;
        $result = $this->_conditionOr($tokens, $pos, $data, $ok);

        return $ok && $pos === count($tokens) && $result;
    }

    /**
     * Splits a condition into ['atom', text] / ['and'|'or'|'not'|'('|')', ''].
     *
     * @return list<array{0: string, 1: string}>
     */
    private function _conditionTokens(string $cond): array
    {
        $tokens  = [];
        $buf     = '';
        $inQuote = false;
        $len     = strlen($cond);

        $flush = static function () use (&$buf, &$tokens): void {
            $text = trim($buf);
            if ($text !== '') $tokens[] = ['atom', $text];
            $buf = '';
        };

        for ($i = 0; $i < $len; $i++) {
            $c = $cond[$i];
            if ($c === '"') { $inQuote = !$inQuote; $buf .= $c; continue; }
            if ($inQuote)   { $buf .= $c; continue; }

            if ($c === '(' || $c === ')') {
                $flush();
                $tokens[] = [$c, ''];
                continue;
            }
            if (($c === '&' || $c === '|') && ($cond[$i + 1] ?? '') === $c) {
                $flush();
                $tokens[] = [$c === '&' ? 'and' : 'or', ''];
                $i++;
                continue;
            }
            // and / or / not as a word of its own: start or after a blank or
            // "(", followed by a blank, "(" or the end.
            // "KEY is not empty": that "not" belongs to the condition.
            $atWordStart = $i === 0 || ctype_space($cond[$i - 1]) || $cond[$i - 1] === '(';
            if ($atWordStart && preg_match('~\G(and|or|not)(?=[\s(]|$)~', $cond, $m, 0, $i)
                && !($m[1] === 'not' && preg_match('~(?:^|\s)is\s+$~', $buf))) {
                $flush();
                $tokens[] = [$m[1], ''];
                $i += strlen($m[1]) - 1;
                continue;
            }
            $buf .= $c;
        }
        $flush();

        return $tokens;
    }

    private function _conditionOr(array $tokens, int &$pos, array $data, bool &$ok): bool
    {
        $value = $this->_conditionAnd($tokens, $pos, $data, $ok);
        while ($ok && ($tokens[$pos][0] ?? '') === 'or') {
            $pos++;
            $right = $this->_conditionAnd($tokens, $pos, $data, $ok);
            $value = $value || $right;
        }
        return $value;
    }

    private function _conditionAnd(array $tokens, int &$pos, array $data, bool &$ok): bool
    {
        $value = $this->_conditionNot($tokens, $pos, $data, $ok);
        while ($ok && ($tokens[$pos][0] ?? '') === 'and') {
            $pos++;
            $right = $this->_conditionNot($tokens, $pos, $data, $ok);
            $value = $value && $right;
        }
        return $value;
    }

    private function _conditionNot(array $tokens, int &$pos, array $data, bool &$ok): bool
    {
        $token = $tokens[$pos] ?? null;
        if ($token === null) { $ok = false; return false; }

        switch ($token[0]) {
            case 'not':
                $pos++;
                return !$this->_conditionNot($tokens, $pos, $data, $ok);
            case '(':
                $pos++;
                $value = $this->_conditionOr($tokens, $pos, $data, $ok);
                if (($tokens[$pos][0] ?? '') !== ')') { $ok = false; return false; }
                $pos++;
                return $value;
            case 'atom':
                $pos++;
                return $this->_evaluateAtom($token[1], $data);
            default: // a dangling and / or / )
                $ok = false;
                return false;
        }
    }

    /** One condition: KEY, KEY op "text" / number, KEY contains|in|… "text". */
    private function _evaluateAtom(string $condStr, array $data): bool
    {
        $keyPat = '[A-Z_][A-Z0-9_.]*';

        // KEY is [not] empty / KEY is [not] defined
        if (preg_match('~^(' . $keyPat . ')\s+is\s+(not\s+)?(empty|defined)$~', $condStr, $m)) {
            $result = $m[3] === 'defined'
                ? $this->_keyExists($m[1], $data)
                : self::_isEmpty($this->_resolveDotKey($m[1], $data, true));
            return $m[2] !== '' ? !$result : $result;
        }

        if (preg_match(
            '~^(' . $keyPat . ')\s+
              (not-icontains|not-contains|not-in|
               not-istarts-with|not-starts-with|
               not-iends-with|not-ends-with|
               icontains|contains|in|
               istarts-with|starts-with|
               iends-with|ends-with)
              \s+"([^"]*)"$~x',
            $condStr, $m
        )) {
            $actual = (string)($this->_resolveDotKey($m[1], $data) ?? '');
            $op     = $m[2];
            $rhs    = $m[3];
            $negate = str_starts_with($op, 'not-');
            $baseOp = $negate ? substr($op, 4) : $op;

            $match = match($baseOp) {
                'contains'    => str_contains($actual, $rhs),
                'icontains'   => str_contains(strtolower($actual), strtolower($rhs)),
                'in'          => in_array($actual, array_map('trim', explode(',', $rhs)), strict: true),
                'starts-with' => str_starts_with($actual, $rhs),
                'istarts-with'=> str_starts_with(strtolower($actual), strtolower($rhs)),
                'ends-with'   => str_ends_with($actual, $rhs),
                'iends-with'  => str_ends_with(strtolower($actual), strtolower($rhs)),
            };

            return $negate ? !$match : $match;
        }

        if (preg_match(
            '~^(' . $keyPat . ')\s*(==|!=|>=|<=|>|<)\s*(?:"([^"]*)"|([-]?\d+\.?\d*)|(' . $keyPat . '))$~',
            $condStr, $m
        )) {
            $actual   = (string)($this->_resolveDotKey($m[1], $data) ?? '');
            $op       = $m[2];

            if (($m[5] ?? '') !== '') {
                // Right-hand side is another key: {if PAGE.ID == CURRENT_ID}.
                // Two numbers compare as numbers ("5" == "5.0"), anything
                // else as text; < > as numbers like every ordering here.
                $rhs = (string)($this->_resolveDotKey($m[5], $data) ?? '');
                if ($op === '==' || $op === '!=') {
                    $equal = (is_numeric($actual) && is_numeric($rhs))
                        ? (float) $actual === (float) $rhs
                        : $actual === $rhs;
                    return $op === '==' ? $equal : !$equal;
                }
            } else {
                // PCRE leaves a trailing group that did not take part out of
                // $m: for a quoted literal there is no $m[4] at all (was a
                // warning on every {if KEY == "…"}).
                $isQuoted = (($m[4] ?? '') === '');
                $rhs      = $isQuoted ? $m[3] : $m[4];

                if ($isQuoted && ($op === '==' || $op === '!=')) {
                    return ($op === '==') ? ($actual === $rhs) : ($actual !== $rhs);
                }
            }

            $left  = (float) $actual;
            $right = (float) $rhs;

            return match($op) {
                '==' => $left === $right,
                '!=' => $left !== $right,
                '>'  => $left >   $right,
                '<'  => $left <   $right,
                '>=' => $left >=  $right,
                '<=' => $left <=  $right,
            };
        }

        if (preg_match('~^(' . $keyPat . ')$~', $condStr, $m)) {
            // Raw: a non-empty list is true (non-scalars used to read as null).
            return !empty($this->_resolveDotKey($m[1], $data, true));
        }

        return false;
    }

    // ── Private pipeline — Step 4: Inline defaults ───────────────────────────

    private function _resolveDefaults(string $html, array $data): string
    {
        return preg_replace_callback(
            '~\{default\s+([A-Z_][A-Z0-9_.]*)\s+(?:"([^"]*)"|\'([^\']*)\'|([^\s\}]+))\s*\}~',
            function ($m) use ($data) {
                $fallback = $m[2] !== '' ? $m[2] : ($m[3] !== '' ? $m[3] : $m[4]);
                $value    = $this->_resolveDotKey($m[1], $data);
                // The value is data → escaped like [KEY] (was printed raw)
                // and protected; the fallback is template text and stays as
                // written, evaluable as before.
                return !empty($value)
                    ? $this->_protect(htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'))
                    : $fallback;
            },
            $html
        ) ?? $html;
    }

    // ── Private pipeline — Step 5: Placeholders & filters ────────────────────

    private function _resolvePlaceholders(string $html, array $data): string
    {
        return preg_replace_callback(
            // Filter names: [a-z][a-z0-9_]* — was [a-z]+, so "nl2br" (and any
            // custom filter with a digit or "_") never matched.
            '~\[([A-Z_][A-Z0-9_.]*)((?:\|[a-z][a-z0-9_]*(?::(?:"[^"]*"|\d+|[A-Z_][A-Z0-9_.]*))?)+)?\]~',
            function ($m) use ($data) {
                $key         = $m[1];
                $filterStr   = $m[2] ?? '';
                $filterChain = $this->_parseFilterChain($filterStr);

                if ($key === '_CONTEXT' || $key === '_FILTERS' || $key === '_LANG') {

                    // Namespaces that belong to _LANG, not _CONTEXT
                    $langKeys = ['TEXT', 'MESSAGE', 'HINT', 'MENU', 'HEADING', 'OVERVIEW'];

                    $rawValue = match ($key) {
                        '_CONTEXT' => array_filter(
                            $this->currentScope ?? [],
                            fn($k) => !in_array($k, $langKeys, true),
                            ARRAY_FILTER_USE_KEY
                        ),
                        '_LANG'    => array_intersect_key(
                            $this->currentScope ?? [],
                            array_flip($langKeys)
                        ),
                        '_FILTERS' => (function () {
                            $n = array_keys($this->filters); sort($n); return $n;
                        })(),
                    };

                    $dumpParam = null;
                    foreach ($filterChain as [$name, $param]) {
                        if ($name === 'dump') { $dumpParam = $param; break; }
                    }

                    return $this->_printDebug($rawValue, $dumpParam, $key);
                }

                $hasDump   = false;
                $dumpParam = null;
                foreach ($filterChain as [$fname, $fparam]) {
                    if ($fname === 'dump') { $hasDump = true; $dumpParam = $fparam; break; }
                }

                if ($hasDump) {
                    $rawValue = $this->_resolveDotKey($key, $data, raw: true);
                    return $this->_printDebug($rawValue ?? '', $dumpParam, $key);
                }

                // Raw value: the array filters (plural, length, join …) need
                // the list itself; _applyFilters() turns anything that is not
                // text into "" for the others and at the end — so [LIST]
                // without a filter still prints nothing, as before.
                if ($this->debugUndefined && !$this->_keyExists($key, $data)
                    && !in_array('default', array_column($filterChain, 0), true)) {
                    return '[UNDEFINED:' . $key . ']';
                }
                $value = $this->_resolveDotKey($key, $data, raw: true);
                return $this->_applyFilters($value, $filterChain, $key, $data);
            },
            $html
        ) ?? $html;
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    /**
     * Parse a filter chain string into an array of [name, param, isVarRef] tuples.
     *
     * Recognises two param forms:
     *   |filter:"quoted literal"  → param = 'quoted literal',  isVarRef = false
     *   |filter:VARIABLE.KEY      → param = 'VARIABLE.KEY',    isVarRef = true
     *   |filter                   → param = null,              isVarRef = false
     *
     * isVarRef = true signals that the param is a scope key to be resolved
     * at filter-application time, not a literal value. Used by the |plural
     * filter to resolve dynamic counts like ARTICLE._COUNT.
     *
     * @return array<array{0: string, 1: string|null, 2: bool}>
     */
    private function _parseFilterChain(string $filterStr): array
    {
        if ($filterStr === '') return [];

        $chain = [];

        // CHANGE 1: Extended regex — captures both quoted literals and unquoted var refs
        // Group 1: filter name
        // Group 2: quoted literal param (inside "…")
        // Group 3: unquoted variable reference (UPPER_SNAKE or dotted UPPER.SNAKE)
        preg_match_all(
            '~\|([a-z][a-z0-9_]*)(?::(?:"([^"]*)"|(\d+|[A-Z_][A-Z0-9_.]*)))?~',
            $filterStr, $matches, PREG_SET_ORDER
        );

        foreach ($matches as $match) {
            $quoted   = isset($match[2]) && $match[2] !== '' ? $match[2] : null;
            $unquoted = isset($match[3]) && $match[3] !== '' ? $match[3] : null;
            $param    = $quoted ?? $unquoted;
            // An unquoted NUMBER is a literal (|plural:5, |truncate:80), not a
            // key — it used to be looked up as key "5" and counted as 0.
            $isVarRef = ($unquoted !== null && !ctype_digit($unquoted));

            $chain[] = [$match[1], $param, $isVarRef];
        }

        return $chain;
    }

    /**
     * Apply a filter chain to a string value.
     *
     * CHANGE 2: Accepts $scope parameter for resolving variable-ref params.
     * CHANGE 3: Passes isVarRef flag as third argument to filter callables.
     *
     * Filter callable signature:
     *   fn(mixed $value, ?string $param = null, bool $isVarRef = false): string
     *
     * Most built-in filters ignore $isVarRef — only |plural uses it.
     *
     * @param array<array{0: string, 1: string|null, 2: bool}> $filterChain
     */
    /** Filters that receive the raw value (a list), not its text. */
    private const ARRAY_FILTERS = ['plural', 'length', 'first', 'last', 'join', 'default'];

    /**
     * $value is the raw value (was string-typed: |plural, whose value is the
     * plural ARRAY, died with a TypeError on every use). Array filters get it
     * as it is; every other filter gets text — a list or object reads as "",
     * as a placeholder always did — and so does the final output.
     */
    private function _applyFilters(mixed $value, array $filterChain, string $heading = '', array $scope = []): string
    {
        $skipEscape = false;
        $text = static fn(mixed $v): string => (is_scalar($v) || $v === null) ? (string) $v : '';

        foreach ($filterChain as [$name, $param, $isVarRef]) {
            if ($name === 'raw') {
                $skipEscape = true;
                continue;
            }

            if ($name === 'escape') {
                $value      = htmlspecialchars($text($value), ENT_QUOTES, 'UTF-8');
                $skipEscape = true;
                continue;
            }

            // nl2br escapes itself (its <br />s must survive) — the final
            // auto-escape would turn them into "&lt;br /&gt;". Built in on
            // purpose: an addFilter('nl2br', …) override that did not escape
            // would otherwise print raw HTML with the auto-escape skipped.
            if ($name === 'nl2br') {
                $value      = nl2br(htmlspecialchars($text($value), ENT_QUOTES, 'UTF-8'));
                $skipEscape = true;
                continue;
            }

            if ($name === 'dump') {
                $value      = $this->_printDebug($value, $param, $heading);
                $skipEscape = true;
                continue;
            }

            if (isset($this->filters[$name])) {
                $fn  = $this->filters[$name];
                $arg = in_array($name, self::ARRAY_FILTERS, true) ? $value : $text($value);
                // isVarRef as third argument: |plural resolves an unquoted
                // param as a scope key; other filters ignore it.
                $value = $param !== null ? $fn($arg, $param, $isVarRef) : $fn($arg);
            }
        }

        $value = $text($value);
        if (!$skipEscape) {
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }

        return $value;
    }

    /**
     * |date / |time. A number is a Unix timestamp — strtotime("1700000000")
     * fails, and date($fmt, false) printed 01.01.1970. Anything else goes
     * through strtotime(); what it cannot read is shown as it is. Empty and
     * "0" stay empty, as before. (Locale-aware output belongs to the planned
     * DateTimeFormat layer, not here.)
     */
    private static function _formatDate(mixed $value, string $format): string
    {
        if ($value === null || $value === '' || $value === '0' || $value === 0 || $value === false) {
            return '';
        }
        // A digit string only from 9 digits on (every timestamp since 1973):
        // "20261109" is YYYYMMDD, which strtotime() reads correctly.
        if (is_int($value) || (is_string($value) && ctype_digit($value) && strlen($value) >= 9)) {
            return date($format, (int) $value);
        }
        $ts = strtotime((string) $value);
        return $ts === false ? (string) $value : date($format, $ts);
    }

    private function _printDebug(mixed $value, ?string $param = null, string $heading = ''): string
    {
        $isDetail = ($param === 'detail');
        $label    = $heading !== '' ? '[' . $heading . ']' : 'Debug';

        ob_start();

        if (function_exists('dump')) {
            dump($value, $label, $isDetail);
        } else {
            echo '<details style="margin:1em 0;border:1px solid #dee2e6;border-radius:4px;'
               . 'font-family:monospace;font-size:13px;background:#f8f9fa;">';
            echo '<summary style="cursor:pointer;padding:.5rem 1rem;font-weight:600;'
               . 'color:#1247d8;list-style:none;">Debug: '
               . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</summary>';
            echo '<pre style="margin:0;padding:1rem;max-height:600px;overflow:auto;'
               . 'white-space:pre-wrap;color:#c01727;background:#fffeed;'
               . 'border-top:1px solid #dee2e6;">';
            $isDetail ? var_dump($value) : print_r($value);
            echo '</pre></details>';
        }

        return ob_get_clean();
    }
}