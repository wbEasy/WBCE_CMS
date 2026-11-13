<?php
/**
 * wbce_search - languages/EN.php
 * English
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Advanced Search Settings. Index, modules, layouts and statistics of the WBCE CMS search: full-text search with operators, live suggestions, hit highlighting on the target page and a tag cloud.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Search';
$SEARCH['SEARCH_HEADING']                    = 'Search';
$SEARCH['RESULTS_FOR']                       = 'Results for';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'No results',
    'one' => '%d result',
    'other' => '%d results',
];
$SEARCH['NO_RESULTS']                        = 'No results found.';
$SEARCH['ALL_WORDS']                         = 'All words';
$SEARCH['ANY_WORDS']                         = 'Any word';
$SEARCH['EXACT_MATCH']                       = 'Exact phrase';
$SEARCH['MATCH']                             = 'Search mode';
$SEARCH['PAGES']                             = 'Pages';
$SEARCH['TIPS_TITLE']                        = 'Search tips:';
$SEARCH['TIP_FEWER']                         = 'Use fewer terms';
$SEARCH['TIP_OR']                            = 'OR search:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'otherTerm';
$SEARCH['TIP_NOT']                           = 'Exclude:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'exclude';
$SEARCH['TIP_PHRASE']                        = 'Exact phrase:';
$SEARCH['TIP_WILDCARD']                      = 'Wildcard:';
$SEARCH['TIP_FUZZY']                         = 'Tolerate typos:';
$SEARCH['DID_YOU_MEAN']                      = 'Did you mean:';
$SEARCH['SCOPE_TITLE']                       = 'Title only';
$SEARCH['SCOPE_CONTENT']                     = 'Content only';
$SEARCH['SEARCH_OR']                         = 'OR search (at least one term)';
$SEARCH['AREAS_TITLE']                       = 'Browse by topic:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Frequently searched:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'searched once',
    'other' => 'searched %d times',
];
$SEARCH['HIT_CONTENT']                       = 'Content';
$SEARCH['HIT_KEYWORD']                       = 'Keyword';
$SEARCH['HIT_DESCRIPTION']                   = 'Description';
$SEARCH['HIT_TITLE']                         = 'Title';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Wildcard';
$SEARCH['LEGEND_FUZZY']                      = 'Tolerate typos';
$SEARCH['LEGEND_PHRASE']                     = 'Exact phrase';
$SEARCH['LEGEND_EXCLUDE']                    = 'Exclude term';
$SEARCH['LEGEND_OR']                         = 'Either term';
$SEARCH['LEGEND_COMBINATION']                = 'Combination';
$SEARCH['LEGEND_OPERATORS']                  = 'Operators';
$SEARCH['OP_EXCLUDE']                        = 'exclude';
$SEARCH['OP_WILDCARD']                       = 'wildcard';
$SEARCH['OP_TYPOS']                          = 'typos';
$SEARCH['OP_PHRASE']                         = 'phrase';
$SEARCH['OP_OR']                             = 'or';
$SEARCH['EXAMPLE_WORD']                      = 'mustard';
$SEARCH['EXAMPLE_WORD2']                     = 'organic';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'hot';
$SEARCH['EXAMPLE_OR']                        = 'ketchup';
$SEARCH['EXAMPLE_PHRASE']                    = 'yellow mustard';
$SEARCH['EXAMPLE_PHRASE2']                   = 'from corn';
$SEARCH['LABEL_LEGEND']                      = 'Legend';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Term found in the page content';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Term found in the page keywords';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Term found in the page description';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Term found in the title';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Term in content and keywords';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Term in content and description';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Term in keywords and description';
$SEARCH['LEGEND_HIT_ALL']                    = 'Term in all three fields';
$SEARCH['PAGE_PREV']                         = 'Previous page';
$SEARCH['PAGE_NEXT']                         = 'Next page';
$SEARCH['DROPLET_DESCRIPTION']               = 'Tag cloud of most searched terms. Parameters: max=20, min_count=1, desc=Label, active=true (false = hidden)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Overview';
$SEARCH['MENU_MODULES']                      = 'Modules';
$SEARCH['MENU_LAYOUT']                       = 'Layout';
$SEARCH['MENU_SETTINGS']                     = 'Settings';
$SEARCH['MENU_STATS']                        = 'Statistics';
$SEARCH['CRUMB_OVERVIEW']                    = 'Search index status and maintenance';
$SEARCH['CRUMB_MODULES']                     = 'Which modules feed the search index';
$SEARCH['CRUMB_LAYOUT']                      = 'Template of the search results page';
$SEARCH['CRUMB_SETTINGS']                    = 'Search behaviour, live search, tag cloud';
$SEARCH['CRUMB_STATS']                       = 'What visitors search for';
$SEARCH['LEDE_OVERVIEW']                     = 'Current state of the search index and the frontend search.';
$SEARCH['LEDE_MODULES']                      = 'How each installed module is indexed. Modules without a definition only contribute their page title.';
$SEARCH['LEDE_LAYOUT']                       = 'Which layout the search page and the tag cloud use, and which stylesheet. Shipped files and files from the template stay unchanged; you always edit your own copy.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Search results page';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Layout of the page /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Tag cloud';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Layout of the droplet [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Stylesheet';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'For the results page and the tag cloud';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'CSS from %1$s shows up here · "Edit" creates %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'No stylesheet';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'the template brings all styles itself';
$SEARCH['LAYOUT_ACTIVE']                     = 'active';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'own file';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'from template "%s"';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'shipped';
$SEARCH['LAYOUT_READONLY']                   = 'read only';
$SEARCH['LAYOUT_MODIFIED']                   = 'changed %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'the template file %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'the shipped file %s';
$SEARCH['BTN_EDIT']                          = 'Edit';
$SEARCH['BTN_DELETE']                        = 'Delete';
$SEARCH['BTN_BACK']                          = 'Back';
$SEARCH['BTN_SAVE_BACK']                     = 'Save & back';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "A new file %1\$s will be created as a copy of %2\$s.\n\nThe copy is edited and becomes the active layout; the original stays unchanged.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s exists already. Overwrite it with the content of %2\$s and edit it?\n\nYour current version of %1\$s will be lost.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Delete %s?\n\nThis cannot be undone.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Active layout: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s created';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s deleted';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Stylesheet: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Scoring, excerpts, live search and the tag cloud.';
$SEARCH['LEDE_STATS']                        = 'Search terms recorded for the tag cloud (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Search Index';
$SEARCH['INDEX_BUILD']                       = 'Full rebuild';
$SEARCH['INDEX_UPDATE']                      = 'Update changed';
$SEARCH['INDEX_CLEAR']                       = 'Clear index';
$SEARCH['ENTRIES']                           = 'Entries';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Index built — nothing to index.',
    'one' => 'Index built: %d entry.',
    'other' => 'Index built: %d entries.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Nothing to update.',
    'one' => '%d entry updated.',
    'other' => '%d entries updated.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Index deleted.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Really delete the entire index?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Frontend search';
$SEARCH['LABEL_LAST_INDEXED']                = 'Last indexed';
$SEARCH['INDEX_BUILD_DESC']                  = 'Reads <b>all</b> searchable sections again. Takes a while on large websites.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Reads only changed or missing sections. Faster than a full rebuild.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Reads only changed or missing sections. Nothing to do right now.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Empties the index. The search finds nothing until it is rebuilt.';
$SEARCH['LABEL_FRESHNESS']                   = 'Up to date';
$SEARCH['FRESH_ALL']                         = '<b>The index is up to date</b> — all %d sections match their last change.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d of %2$d</b> sections were changed or are missing.';
$SEARCH['FRESH_NONE']                        = 'No searchable sections yet.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Search on the website';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Settings › Search';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Public';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Registered';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Private';
$SEARCH['SITE_SEARCH_NONE']                  = 'Off';
$SEARCH['HINT_SITE_SEARCH']                  = 'Who may search — for every search box on the website, whichever search is behind it. The same setting as under <a href="%s">Settings › Search</a>; "Registered" and "Private" both mean: logged-in visitors only.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Set the search on the website to \"%s\"?\n\nThis changes the website setting \"Search\" for all visitors.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Search on the website: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Languages';
$SEARCH['LABEL_NO_LANG_INFO']                = 'No language information';
$SEARCH['VIS_HIDDEN']                        = 'Hidden';
$SEARCH['VIS_PUBLIC']                        = 'Public';
$SEARCH['VIS_PRIVATE']                       = 'Private';
$SEARCH['VIS_REGISTERED']                    = 'Registered';
$SEARCH['VIS_NONE']                          = 'None';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'The layout is empty and was not saved.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Could not write search_custom.htt. Please check the write permissions of the layouts folder.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'With "AjaxSave" ticked, Save and Ctrl+S save without reloading the page; "Save & back" is hidden then.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Minimum word length';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Shorter words are ignored';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Title weight';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Hits in title × factor';
$SEARCH['SET_MAX_EXCERPT']                   = 'Max. excerpt length';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Characters per excerpt';
$SEARCH['SET_HIGHLIGHT']                     = 'Highlight';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Highlight search terms in excerpt';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Highlight tag';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'HTML tag used for highlighting';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Results per page';
$SEARCH['SET_AUTO_REINDEX']                  = 'Auto-reindex on search';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Silently update stale entries on each search request';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Show tag cloud';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'On the search page. The droplet has its own parameter active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Track tag cloud searches';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Record searches for the tag cloud and the statistics — switching this off does not hide the cloud';
$SEARCH['SET_AJAX_SUGGEST']                  = 'AJAX live search';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Show suggestions while typing';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Debug mode';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Show technical data below each search result (admins only)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Search page template';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Frontend template the /search/ page is shown in.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Website default template (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Search';
$SEARCH['GROUP_DISPLAY']                     = 'Results display';
$SEARCH['GROUP_INDEX']                       = 'Index maintenance';
$SEARCH['GROUP_LIVE']                        = 'Live search';
$SEARCH['GROUP_TAGCLOUD']                    = 'Tag cloud';
$SEARCH['GROUP_ADMIN']                       = 'Admin tool';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Pagination size of the results page';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Language filter';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Only show pages in the visitor\'s language (site default: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Advanced search';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Show scope checkboxes and OR option in the search form';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Max. sections per search';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Limit for auto-reindex (load control)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Suggestion source';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Hybrid lists title matches first and tops up with pages that contain the word in their text';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Max. suggestions';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Number of suggestions shown';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']          = 'Images in suggestions';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']     = 'Shows the item\'s picture (catalogue, news …) next to the suggestion, where the module indexes one';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Max. tags';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Number of terms shown in the tag cloud';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min. searches';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Minimum number of searches before a term appears';
$SEARCH['SET_NAV_STYLE']                     = 'Navigation';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Tabs on top or an icon sidebar on the left';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Titles first, topped up from the full text (recommended)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Title + description (fast)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Full-text index (thorough)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Tabs on top';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Sidebar on the left';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Endpoint';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Detected automatically on the search page for fields named "string", type="search" or class ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Settings saved.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Search statistics deleted.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Really delete all statistics?';
$SEARCH['STATS_DELETE']                      = 'Delete statistics';
$SEARCH['STATS_TERM']                        = 'Search term';
$SEARCH['STATS_COUNT']                       = 'Count';
$SEARCH['STATS_LAST']                        = 'Last searched';
$SEARCH['STATS_TERMS']                       = 'Terms';
$SEARCH['STATS_SEARCHES']                    = 'Searches';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 of %d term.',
    'other' => 'Top 100 of %d terms.',
];
$SEARCH['STATS_EMPTY']                       = 'No search terms recorded yet.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Searched, nothing found';
$SEARCH['HINT_STATS_MISSES']                 = 'Whole queries that returned no result — a hint at content your visitors expect but do not find. Never shown publicly.';
$SEARCH['STATS_QUERY']                       = 'Query';
$SEARCH['STATS_MISSES_EMPTY']                = 'No searches without results recorded.';
$SEARCH['CARD_WORDS']                        = 'Word index';
$SEARCH['HINT_WORDS']                        = 'For large websites: a list of all words, so a search no longer has to read the whole index. Built automatically from %s index entries on.';
$SEARCH['WORDS_INACTIVE']                    = 'Not active — the website is below the threshold (%2$s index entries, currently %1$s); the normal search is fast enough.';
$SEARCH['WORDS_OFF']                         = 'Switched off in the settings.';
$SEARCH['WORDS_BUILDING']                    = 'Being built';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Continue building';
$SEARCH['MSG_WORDS_READY']                   = 'Word index complete.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Word index: %d entry still pending — the normal search is used until then.',
    'other' => 'Word index: %d entries still pending — the normal search is used until then.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'In use — %d word entry.',
    'other' => 'In use — %d word entries.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Word index';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automatic: built only when the site reaches the threshold below. Small sites do not need it.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automatic';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Always on';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Off';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Word index from';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Number of indexed entries (sections and module items) from which the word index is built automatically';
$SEARCH['BTN_DELETE_TERM']                   = 'Remove this term';
$SEARCH['MSG_TERM_DELETED']                  = 'Term removed.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Semi-config for <b>%s</b> preset from search.php — please review and adjust.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Semi-config for \'%s\' saved.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Configuration and index entries for %s deleted.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php generated. Please rebuild the index.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Delete configuration and index entries for %s?';
$SEARCH['STATUS_SEMI']                       = 'Semi-config';
$SEARCH['LABEL_GUIDE']                       = 'Show guide for this module';
$SEARCH['LABEL_TABLE_HINT']                  = 'Select table → columns load automatically';
$SEARCH['LABEL_TABLE_SELECT']                = 'Select table';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'WBCE page anchor';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Searchable pages only';
$SEARCH['LABEL_ALL_SECTIONS']                = 'All sections (content pool)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Active entries only (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Time control (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joins (optional, max. 3) — data from additional tables';
$SEARCH['LABEL_GENERATE_DEF']                = 'Generate module_defs file';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'From search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Delete configuration';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'No text columns';
$SEARCH['LABEL_ERROR']                       = 'Error';
$SEARCH['LABEL_MODULE']                      = 'Module';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Not searchable';
$SEARCH['LABEL_HELP']                        = 'Help';
$SEARCH['BTN_CONFIGURE']                     = 'Configure';
$SEARCH['BTN_CLOSE']                         = 'Close';
$SEARCH['DEF_GENERATED']                     = 'generated';
$SEARCH['DEF_SHIPPED']                       = 'built-in';
$SEARCH['LABEL_KIND']                        = 'Type';
$SEARCH['LABEL_INDEXING']                    = 'Indexing';
$SEARCH['LABEL_SECTIONS']                    = 'Sections';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filter …';
$SEARCH['MODULES_SHOWN']                     = '%1$d of %2$d modules shown';
$SEARCH['KIND_PAGE']                         = 'Page modules';
$SEARCH['KIND_SNIPPET']                      = 'Snippets';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filters';
$SEARCH['KIND_TOOL']                         = 'Admin tools';
$SEARCH['BADGE_PAGE']                        = 'Page';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filter';
$SEARCH['BADGE_TOOL']                        = 'Tool';
$SEARCH['GROUP_DEF']                         = 'with definition';
$SEARCH['GROUP_OPEN']                        = 'incomplete';
$SEARCH['GROUP_TITLE']                       = 'page title only';
$SEARCH['SOURCE_MODULE']                     = 'From module';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Built-in';
$SEARCH['SOURCE_GENERATED']                  = 'Semi-config';
$SEARCH['SOURCE_SEMI']                       = 'Semi-config – not generated';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php found';
$SEARCH['SOURCE_TITLE']                      = 'Page title only';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'The module ships its own search definition (search_index.php) — not editable here.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indexed by a PHP callback — not editable here.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definition shipped with WBCE Search (module_defs/). A semi-config takes precedence over it.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definition generated from the semi-config.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Semi-config saved, but no definition generated yet.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'No definition yet — can be preset from the module\'s legacy search.php.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'No definition — the index only holds the page title.';
$SEARCH['HINT_SOURCE_NONE']                  = 'No page sections — nothing to index.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Search switched off for this page';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Built-in definition. Saving creates a semi-config that takes precedence over it.';
$SEARCH['LABEL_TABLE']                       = 'Table';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tables of this module';
$SEARCH['LABEL_OTHER_TABLES']                = 'Other module tables';
$SEARCH['HINT_TABLE']                        = 'Only mod_* tables with a section_id column can be indexed.';
$SEARCH['LABEL_ID_FIELD']                    = 'ID column';
$SEARCH['LABEL_ITEM_KEY']                    = 'Item key';
$SEARCH['HINT_ITEM_KEY']                     = 'Unique key per item (multi mode).';
$SEARCH['LABEL_TITLE_COL']                   = 'Title column';
$SEARCH['LABEL_TEXT_COLS']                   = 'Text columns';
$SEARCH['LABEL_LINK_COL']                    = 'Link column';
$SEARCH['HINT_LINK_PREFIX']                  = 'Optional prefix: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Image column';
$SEARCH['HINT_IMAGE_PATH']                   = 'Path below /media, placeholders like {item_id} allowed.';
$SEARCH['LABEL_NONE']                        = 'none';
$SEARCH['LABEL_MODE']                        = 'Mode';
$SEARCH['MODE_SINGLE']                       = 'Single — one entry per section';
$SEARCH['MODE_MULTI']                        = 'Multi — one entry per item';
$SEARCH['LABEL_INDEX_BASE']                  = 'Index base';
$SEARCH['LABEL_FILTER']                      = 'Filter';
$SEARCH['LABEL_NO_JOIN']                     = 'no join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Please choose a valid module table.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'No usable table found in search.php of %s.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'No pages',
    'one' => '%d page',
    'other' => '%d pages',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Save';
$SEARCH['MSG_SECURITY_ERROR']                = 'Security check failed.';
$SEARCH['STATUS_ACTIVE']                     = 'Active';
$SEARCH['STATUS_INACTIVE']                   = 'Inactive';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'a','about','above','after','again','all','also','am','an','and','any','are',
    'as','at','be','been','before','being','between','both','but','by','can','did',
    'do','does','doing','down','during','each','few','for','from','get','got','had',
    'has','have','having','he','her','here','him','his','how','if','in','into','is',
    'it','its','just','me','more','most','my','no','not','now','of','off','on','or',
    'our','out','own','same','she','so','some','than','that','the','their','them',
    'then','there','these','they','this','those','through','to','too','under','up',
    'us','was','we','were','what','when','where','which','while','who','will','with',
    'you','your',
];
