<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright Ryan Djurovich (2004-2009)
 * @copyright WebsiteBaker Org. e.V. (2009-2015)
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

// Prevent  this  file  from  being  accessed  directly
defined('WB_PATH') or die('No direct access allowed');

// Compatibility mode for older versions.
// (The News module still needs it for example.)
if (isset($wb)) {
    $admin = $wb; // note: this is not a real object of class Admin.
}
if (isset($wb->default_link)) {
    $default_link = $wb->default_link;
}
if (isset($wb->page_trail)) {
    $page_trail = $wb->page_trail;
}
if (isset($wb->page_description)) {
    $page_description = $wb->page_description;
}
if (isset($wb->page_keywords)) {
    $page_keywords = $wb->page_keywords;
}
if (isset($wb->link)) {
    $page_link = $wb->link;
}


// Load Snippet Type modules into the frontend
$snippets = $database->fetchAll("SELECT `directory` FROM `{TP}addons` WHERE `function` LIKE '%snippet%'");
foreach ($snippets as $rec) {
    $file = WB_PATH . '/modules/' . $rec['directory'] . '/include.php';
    if (file_exists($file)) {
        include $file;
    }
}


if (!function_exists('get_page_link')) {
    /**
     * @brief  get `link` entry from database `{TP}pages` table using page_id
     *
     * @param int $id
     * @return string
     * @global object $database
     */
    function get_page_link($page_id)
    {
        return $GLOBALS['database']->fetchValue(
            'SELECT `link` FROM `{TP}pages` WHERE `page_id` = ?',
            [(int)$page_id]
        );
    }
}

//function to highlight search results
if (!function_exists('search_highlight')) {
    /**
     *
     * @staticvar  bool    $string_ul_umlaut
     * @staticvar  bool    $string_ul_regex
     * @param string $foo
     * @param array $arr_string
     * @return     string
     */
    function search_highlight($foo = '', $arr_string = array())
    {
        require_once WB_PATH . '/framework/functions.php';
        static $string_ul_umlaut = false;
        static $string_ul_regex = false;
        if ($string_ul_umlaut === false || $string_ul_regex === false) {
            require WB_PATH . '/search/search_convert.php';
        }
        $foo = entities_to_umlauts($foo, 'UTF-8');
        array_walk($arr_string, function (&$v, $k) {
            $v = preg_quote($v, '~'); // '~' is the pattern delimiter below
        });
        $search_string = implode("|", array_filter($arr_string, fn($v) => $v !== ''));
        // No term: the pattern "()" would match everywhere and wrap every
        // character position in an empty <span class="highlight">.
        if ($search_string === '') {
            return $foo;
        }
        $string = str_replace($string_ul_umlaut, $string_ul_regex, $search_string);
        // the highlighting
        // match $string, but not inside <style>...</style>, <script>...</script>, <!--...--> or HTML-Tags
        // Also droplet tags are now excluded from highlighting.
        // split $string into pieces - "cut away" styles, scripts, comments, HTML-tags and eMail-addresses
        // we have to cut <pre> and <code> as well.
        // An HTML tag is "<", then unquoted characters or whole quoted attribute
        // values, then ">" — so <input ... value="<b>value</b>" > stays one tag.
        // Atomic/possessive on purpose: the former <(?:[^<]|<.*>)*> nested two
        // repetitions, and on rich markup (inline SVG, <picture>, long card
        // lists) PCRE gave up with "backtrack limit exhausted" — preg_split()
        // returned false and the page was shown without any highlight.
        // <svg> is cut away whole: a <span> inside an SVG <text> is no SVG
        // element, and the browser would stop drawing the highlighted word.
        $matches = preg_split("~(\[\[.*\]\]|<style.*</style>|<script.*</script>|<svg.*</svg>|<pre.*</pre>|<code.*</code>|<!--.*-->|<(?>[^<>\"']++|\"[^\"]*+\"|'[^']*+')*+>|\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,8}\b)~iUs", $foo, -1, (PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY));
        if (is_array($matches) && $matches != array()) {
            $foo = "";
            foreach ($matches as $match) {
                if ($match[0] != "<" && !preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,8}$/i', $match) && !preg_match('~\[\[.*\]\]~', $match)) {
                    $match = str_replace(array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;', '&nbsp;'), array('<', '>', '&', '"', '\'', "\xC2\xA0"), $match);
                    $match = preg_replace('~(' . $string . ')~ui', '_span class=_highlight__$1_/span_', $match);
                    // Re-escape the decoded text. Without this, text shown escaped on
                    // the page (&lt;img onerror=…&gt; in a post or comment) became live
                    // HTML for anyone opening the page with ?searchresult=1&sstring=…
                    // (XSS). double_encode=false keeps entities the decode above did
                    // not touch (&copy;, &#8212; …) as they were.
                    $match = htmlspecialchars($match, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', false);
                    $match = str_replace(array('_span class=_highlight__', '_/span_'), array('<span class="highlight">', '</span>'), $match);
                }
                $foo .= $match;
            }
        }
        if (DEFAULT_CHARSET != 'utf-8') {
            $foo = umlauts_to_entities($foo, 'UTF-8');
        }
        return $foo;
    }
}


if (!function_exists('get_block_id')) {
    /**
     * @brief  Function to extract Block ID from Blockname
     *         If fed whith an integer or numeric string it simply returns this as an integer.
     *         If fed whith a string it tries to find this string in the $block[] array of the current template.
     *         It returns the id if found otherwise it returns 1 (default template block)
     *
     * @param unspec $uMenu may be string or integer
     * @return int
     */
    function get_block_id($uBlock)
    {
        return TemplateBlocks::getBlockId($uBlock);
    }
}

if (!function_exists('get_menu_id')) {
    /**
     * @brief  Function to extract Menu ID from Menuname
     *         If fed whith an integer or numeric string it simply returns this as an integer.
     *         If fed whith a string it tries to find this string in the $menu[] array of the current template.
     *         It returns the id if found otherwise it returns 0 (default menu id)
     *
     * @param unspec $uMenu may be string or integer
     * @return integer
     */
    function get_menu_id($uMenu)
    {
        if (is_int($uMenu) or preg_match("/^[0-9]+$/is", $uMenu)) {
            return (int)$uMenu;
        } else {
            require(WB_PATH . "/templates/" . TEMPLATE . "/info.php");
            if ($key = array_search($uMenu, $menu)) {
                return (int)$key;
            } else {
                return 0;
            }
        }
    }
}


if (!function_exists('get_section_array')) {
    /**
     * @brief  Get Array with all the details of a section by using the section_id.
     *
     * @param integer $iSectionID
     * @return array
     */
    function get_section_array($iSectionID)
    {
        $aSection = array();
        if (isset($iSectionID) && $iSectionID > 0) {
            global $database;
            $sSql = 'SELECT * FROM `{TP}sections` WHERE `section_id` = ?';
            if ($rSections = $database->query($sSql, [(int)$iSectionID])) {
                $aSection = $rSections->fetchRow(MYSQLI_ASSOC);
            }
        }
        return $aSection;
    }
}

/**
 * Registers CSS and JS modfiles for a given module (frontend).
 *
 * @param string $moduleDir
 * @return void
 */
function register_module_modfiles(string $moduleDir): void
{
    if (empty($moduleDir)) {
        return;
    }

    $toInsert = $GLOBALS['wb']->retrieveModfilesFromDir($moduleDir, 'frontend');

    foreach ($toInsert as $assetType => $files) {
        $assetType = strtolower($assetType);

        foreach ($files as $file) {
            // $file[0] contains the actual file URL (backward compatible format)
            $fileUrl = $file[0] ?? $file;   // Sicherheit: falls mal ein String kommt

            match ($assetType) {
                'css'      => I::insertCssFile($fileUrl, 'HEAD MODFILES'),
                'js_head'  => I::insertJsFile($fileUrl, 'HEAD MODFILES'),
                'js_body'  => I::insertJsFile($fileUrl, 'BODY MODFILES'),
                default    => null,
            };
        }
    }
}

/**
 * May the current frontend visitor see this section?
 *
 * Sections of the page being viewed were checked by Frontend/TemplateBlocks
 * already. A section of another page (SectionPicker, ShowRandomWysiwyg,
 * default block content) needs the same checks: page visibility and viewing
 * groups/users, and the section's publication period. Outside the frontend
 * (backend, CLI) there is no visitor to check, so it is always true.
 *
 * @param array $section row from {TP}sections
 * @return bool
 */
function section_is_viewable(array $section): bool
{
    global $wb, $database;

    if (!($wb instanceof frontend)) {
        return true;
    }

    // the page being viewed passed these checks in Frontend already
    $pageId = (int)($section['page_id'] ?? 0);
    if ($pageId !== (int)($wb->page_id ?? 0) || empty($wb->page) || !empty($wb->page_access_denied)) {
        $page = $database->fetchRow(
            'SELECT `visibility`, `viewing_groups`, `viewing_users` FROM `{TP}pages` WHERE `page_id` = ?',
            [$pageId]
        );
        if (empty($page) || !$wb->page_is_visible($page)) {
            return false;
        }
    }

    $now   = time();
    $start = (int)($section['publ_start'] ?? 0);
    $end   = (int)($section['publ_end'] ?? 0);
    return ($start === 0 || $now >= $start) && ($end === 0 || $now <= $end);
}

/**
 * Renders the content of a specific section by including its module's view.php.
 *
 * Handles output buffering, OPF filters, section anchor and automatic modfile registration.
 *
 * @param int    $sectionId      Section ID to render
 * @param bool   $useSecAnchor   Whether to add the section anchor (if SEC_ANCHOR is defined)
 * @param string $anchorId       Custom anchor ID (overrides automatic anchor)
 * @return string                Rendered section content
 */
function get_section_content(int $sectionId, bool $useSecAnchor = false, string $anchorId = ''): string
{
    $section = get_section_array($sectionId);
    if (empty($section) || empty($section['module'])) {
        return '';
    }

    if (!section_is_viewable($section)) {
        return '';
    }

    $moduleViewFile = WB_PATH . '/modules/' . $section['module'] . '/view.php';

    if (!is_readable($moduleViewFile)) {
        return '';
    }

    // Setup environment for legacy module view.php
    ob_start();

    $page_id    = $pageId    = (int)$section['page_id'];
    $section_id = $sectionId;

    global $database, $wb, $globals, $TEXT, $MENU, $HEADING, $MESSAGE;
    $admin = $wb;

    if (isset($globals) && is_array($globals)) {
        foreach ($globals as $globalName) {
            global $$globalName;
        }
    }

    require $moduleViewFile;
    $content = ob_get_clean();

    // Apply OPF section filter
    if (function_exists('opf_apply_filters')) {
        $content = opf_controller('section', $content, $section['module'], $pageId, $sectionId);
    }

    // Add section anchor
    if ($useSecAnchor || $anchorId !== '') {
        $secAnchorLayout = '<a class="section_anchor" id="%s"></a>';

        if ($anchorId !== '') {
            $sectionAnchor = sprintf($secAnchorLayout, $anchorId);
        } elseif (defined('SEC_ANCHOR') && SEC_ANCHOR !== '') {
            $sectionAnchor = sprintf($secAnchorLayout, SEC_ANCHOR . $section['section_id']);
        } else {
            $sectionAnchor = '';
        }

        if ($sectionAnchor !== '') {
            $content = $sectionAnchor . $content;
        }
    }

    // Register module modfiles (CSS/JS)
    register_module_modfiles($section['module']);

    // FEE (FrontEnd Edit) hook — the optional `fee` module wraps the section so a
    // logged-in editor gets an inline edit affordance (see modules/fee/). It is a
    // pure pass-through when fee is absent or the viewer may not edit this page, so
    // visitors always receive unwrapped, clean HTML. Mirrors the opf_* hook style.
    if (function_exists('fee_wrap_section')) {
        $content = fee_wrap_section($content, $sectionId, $section['module'], (int) $section['page_id']);
    }

    return $content;
}

/**
 * Fetches all sections of a template layout block and returns them as an array.
 *
 * @param int|string $block  Block ID (numeric) or block name
 * @return array|null        Sections array, or null on permission/visibility failure.
 *                           Returns null (not []) so template checks like
 *                           if (!block_contents()) work correctly.
 */
function block_contents($block = 1): ?array
{
    return TemplateBlocks::dbContent($block);
}

if (!function_exists('page_content')) {
    /**
     * @brief   print or return (e.g. into a variable for later use)
     *          all the sections of one block into the template
     *          It now alllows to enter block names as well as block numbers.
     *          The second parameter lets the function return the result instead of printing it immediately.
     *
     * @param unspec $uBlock Block ID or Block name
     * @param bool $bPrint echo the contents
     *                      or set to 0 if you want to fetch the contents into a variable
     * @return string
     * @global  object $wb       |   The global variables are
     * @global  object $database |   optional and will be used
     * @global  array $globals   |   only in case PAGE_CONTENT
     * @global  array $TEXT      |   (this are the special pages
     * @global  array $MESSAGE   |   like search, account etc.)
     * @global  array $HEADING   |   is defined.
     * @global  array $MENU      |
     *
     */
    function page_content($uBlock = 1, $bPrint = 1)
    {
        return TemplateBlocks::pageContent($uBlock, $bPrint);
    }
}

if (!function_exists('block_section_count')) {
    /**
     * @brief   Cheap existence check for a template layout block — a single
     *          COUNT(*) query, no section rendering.
     *
     *          block_contents()/page_content() are the only existing way to
     *          find out whether a block has anything in it, and both pay the
     *          full render cost (every assigned section's view.php runs,
     *          including module DB queries) just to answer that yes/no
     *          question. This lets a template decide layout structure (e.g.
     *          whether to open a two-column wrapper at all) without paying
     *          that cost purely to check.
     *
     *          Mirrors block_contents()'s own publication-window gating, so
     *          a section outside its publ_start/publ_end range doesn't count
     *          as "present" here either — same rule, cheap query instead of
     *          a full render.
     *
     *          Does NOT guarantee a rendered section will yield non-empty
     *          output (a module's view.php can still legitimately return '')
     *          — for that, page_content($block, 0) remains the source of
     *          truth. This answers "is anything assigned to this block",
     *          not "will this block render visible content".
     *
     * @param unspec $uBlock Block ID or Block name
     * @param int|null $pageId Defaults to the current page ($wb->page_id)
     * @return int
     */
    function block_section_count($uBlock = 1, ?int $pageId = null): int
    {
        return TemplateBlocks::dbSectionCount($uBlock, $pageId);
    }
}

if (!function_exists('block_has_sections')) {
    /**
     * @brief   Convenience wrapper around block_section_count() — "does this
     *          block have anything assigned" as a boolean, for template
     *          `if` conditions.
     *
     * @param unspec $uBlock Block ID or Block name
     * @param int|null $pageId Defaults to the current page ($wb->page_id)
     * @return bool
     */
    function block_has_sections($uBlock = 1, ?int $pageId = null): bool
    {
        return TemplateBlocks::dbHasSections($uBlock, $pageId);
    }
}

if (!function_exists('register_block_content')) {
    /**
     * @brief   Lets a Page/Section-type module — or a SECTION/SPECIAL-level
     *          OutputFilter, which runs synchronously during
     *          get_section_content() — contribute additional HTML to a
     *          block without an explicit {TP}sections row.
     *
     *          Blocks are addressed by number only — let the user pick it
     *          from TemplateBlocks::getBlocks($page_id) and store that. A
     *          number the current template does not declare is swallowed.
     *
     *          SYNC-ONLY: a slot reader (block_has_content()/
     *          render_block_content()) only sees pushes that have already
     *          happened. A template that reads a slot before the block that
     *          writes it calls prerender_blocks() at the top of its index.php.
     *
     *          PAGE-level OutputFilters (Droplets among them) are OUT OF
     *          SCOPE — they run once, after the whole template has already
     *          executed, so a push from that stage would never be seen by
     *          any reader. Do not call this from an OPF_TYPE_PAGE* filter.
     *
     * @param int        $block    Block number, as in the template's info.php.
     * @param string     $html     Rendered HTML to contribute.
     * @param int        $priority 0-9, lower renders first among non-override
     *                             pushes (default 5).
     * @param bool       $override When true, this push replaces the ENTIRE
     *                             block output once it exists — lowest
     *                             implementation priority, no known real
     *                             use case yet.
     * @return void
     */
    function register_block_content(int $block, string $html, int $priority = 5, bool $override = false): void
    {
        TemplateBlocks::push($block, $html, $priority, $override);
    }
}

if (!function_exists('block_has_content')) {
    /**
     * @brief   Merged existence check: true if the block has DB sections OR
     *          any register_block_content()'ed content. Unlike
     *          block_has_sections() (strictly DB-only, unchanged), this is
     *          the check to use for a template that wants to read a slot.
     *
     *          False for a block the current template does not declare.
     *          Only reliable for pushes that have already happened — see
     *          prerender_blocks().
     *
     * @param int      $block  Block number, as in the template's info.php
     * @param int|null $pageId Defaults to the current page ($wb->page_id)
     * @return bool
     */
    function block_has_content(int $block, ?int $pageId = null): bool
    {
        return TemplateBlocks::hasContent($block, $pageId);
    }
}

if (!function_exists('render_block_content')) {
    /**
     * @brief   Merged output for a block: DB content (existing position
     *          order, via page_content()) followed by
     *          register_block_content()'ed content ordered by priority.
     *          If any override push exists for this key, it alone is
     *          output. See register_block_content() for the ordering/
     *          override rules.
     *
     *          A block the current template does not declare outputs
     *          nothing — unlike page_content(), which falls back to block 1.
     *
     * @param int  $block  Block number, as in the template's info.php
     * @param bool $print  echo the contents, or false to fetch into a variable
     * @return string
     */
    function render_block_content(int $block, bool $print = true): string
    {
        return TemplateBlocks::render($block, $print);
    }
}

if (!function_exists('prerender_blocks')) {
    /**
     * @brief   Renders every block of the current template once, before the
     *          template outputs anything, so every register_block_content()
     *          has happened by the time a block is read. Call it at the top
     *          of the template's index.php. page_content()/block_contents()
     *          then come from the cache, no section runs twice.
     *
     *          Block 99 ("nicht zeigen" by convention) is never rendered.
     *
     * @return void
     */
    function prerender_blocks(): void
    {
        TemplateBlocks::prerender();
    }
}

// Function for page title
if (!function_exists('page_title')) {
    function page_title($spacer = ' - ', $template = '[WEBSITE_TITLE][SPACER][PAGE_TITLE]')
    {
        $vars = array('[WEBSITE_TITLE]', '[PAGE_TITLE]', '[MENU_TITLE]', '[SPACER]');
        $values = array(WEBSITE_TITLE, PAGE_TITLE, MENU_TITLE, $spacer);
        echo str_replace($vars, $values, $template);
    }
}

// Function for page description
if (!function_exists('page_description')) {
    function page_description()
    {
        global $wb;
        if ($wb->page_description != '') {
            echo $wb->page_description;
        } else {
            echo WEBSITE_DESCRIPTION;
        }
    }
}

// Function for page keywords
if (!function_exists('page_keywords')) {
    function page_keywords()
    {
        global $wb;
        if ($wb->page_keywords != '') {
            echo $wb->page_keywords;
        } else {
            echo WEBSITE_KEYWORDS;
        }
    }
}

// Function for page header
if (!function_exists('page_header')) {
    function page_header($date_format = 'Y')
    {
        echo WEBSITE_HEADER;
    }
}

// Function for page footer
if (!function_exists('page_footer')) {
    function page_footer($date_format = 'Y')
    {
        global $starttime;
        $vars = array('[YEAR]', '[PROCESS_TIME]');
        $processtime = array_sum(explode(" ", microtime())) - $starttime;
        $values = array(date($date_format), $processtime);
        echo str_replace($vars, $values, WEBSITE_FOOTER);
    }
}


// Function to add optional module Javascript or CSS stylesheets into the <head> section of the frontend
if (!function_exists('register_frontend_modfiles')) {
    function register_frontend_modfiles($sModfileType = "css")
    {
        if ($sModfileType != 'jquery') {
            echo '<!--(PH) ' . strtoupper($sModfileType) . ' HEAD MODFILES -->' . PHP_EOL;
        }
        return $GLOBALS['wb']->registerModfiles($sModfileType, "frontend");
    }
}

// Function to add optional module Javascript into the <body> section of the frontend
if (!function_exists('register_frontend_modfiles_body')) {
    function register_frontend_modfiles_body($sModfileType = "js")
    {
        return;
    }
}