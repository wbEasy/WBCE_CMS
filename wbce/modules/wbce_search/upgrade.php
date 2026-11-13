<?php
/**
 * wbce_search - upgrade.php
 * Removes leftovers of older versions, runs install.php (tables, settings,
 * droplet — all repeatable, it also carries the pre-0.6.1 settings table
 * over), then the upgrade-only steps (columns, conversions).
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
defined('WB_PATH') or die("No direct access");

// ── 0.6.0 / 0.6.1: files that no longer belong to the module ───────────────
// A module upgrade copies new files over the old ones but never deletes, so
// leftovers are removed here — each only if it is recognisably ours.
//   search.php — the 0.3 hook into the legacy core search; dead since the
//                module serves /search/ itself.
//   .htaccess  — opened ajax.php to the web; nothing in core blocks module
//                PHP files, and ajax.php is admin-only now.
//   lib/indexer.php — the ws_* indexer functions; WbceSearchIndexer since 0.6.1.
//   WbceSearch*.php — the classes live in classes/ since 0.6.1; the old
//                copies in the module root would be dead duplicates.
//   lib/stopwords.php — the stop words come from the language files
//                ($SEARCH['STOPWORDS']) since 0.6.1.
//   frontend.css / frontend.js / jump.js — assets/fe_search.css,
//                assets/fe_search.js, assets/fe_search_jump.js since 0.6.1.
//   ajax.php   — served the semi-config help as text; since 0.6.1 the help
//                opens in the MarkdownWbce reader.
//   lib/setup.php — install/upgrade helpers; install.php holds them since 0.6.1.
//   search_admin_tool.php — the /search/ dispatcher, search_page.php since
//                0.6.1 (search/index.php includes the new name).
$ws_leftovers = [
    'search.php'        => 'function wbce_search_search',
    '.htaccess'         => '<Files "ajax.php">',
    'lib/indexer.php'   => 'function ws_rebuild_index',
    'lib/stopwords.php' => 'Stop words DE + EN',
    'frontend.css'      => 'wbce_search - frontend.css',
    'frontend.js'       => 'wbce_search - frontend.js',
    'jump.js'           => 'wbce_search - jump.js',
    'ajax.php'          => 'wbce_search - ajax.php',
    'lib/setup.php'     => 'function ws_setup_tables',
    'search_admin_tool.php' => 'wbce_search - search_admin_tool.php',
];
foreach (['WbceSearch', 'WbceSearchBackend', 'WbceSearchFuzzy', 'WbceSearchIcons', 'WbceSearchIndexer',
          'WbceSearchModules', 'WbceSearchPage', 'WbceSearchSettings', 'WbceSearchWords'] as $ws_class) {
    $ws_leftovers[$ws_class . '.php'] = 'class ' . $ws_class;
}
foreach ($ws_leftovers as $ws_file => $ws_mark) {
    $ws_path = __DIR__ . '/' . $ws_file;
    if (is_file($ws_path) && str_contains((string) file_get_contents($ws_path), $ws_mark)) {
        unlink($ws_path);
    }
}

// ── Tables, settings, droplet: the install steps (all repeatable) ──────────
require __DIR__ . '/install.php';

// ── Columns added over the 0.1.x line ──────────────────────────────────────
$ws_columns = [
    'detail_url'  => "VARCHAR(512) NOT NULL DEFAULT ''",
    'thumb_url'   => "VARCHAR(512) NOT NULL DEFAULT ''",
    'item_id'     => "INT UNSIGNED NOT NULL DEFAULT 0",
    'item_title'  => "TEXT",
    'description' => "TEXT",
    'keywords'    => "VARCHAR(512) NOT NULL DEFAULT ''",
    'visibility'  => "VARCHAR(32) NOT NULL DEFAULT 'public'",
    'searching'   => "TINYINT(1) NOT NULL DEFAULT 1",
    'indexed_at'  => "INT UNSIGNED NOT NULL DEFAULT 0",
    'tokenized'   => "TINYINT(1) NOT NULL DEFAULT 0",   // 0.5.0 word index
];
foreach ($ws_columns as $col => $type) {
    if (!$database->fieldExists('{TP_SEARCH}index', $col)) {
        $database->addField('{TP_SEARCH}index', $col, $type);
        if ($database->hasError()) {
            throw new RuntimeException('wbce_search column ' . $col . ': ' . $database->getError());
        }
    }
}

// 0.5.0: searches without hits are counted separately (stats page "no hits").
if (!$database->fieldExists('{TP_SEARCH}stats', 'misses')) {
    $database->addField('{TP_SEARCH}stats', 'misses', "INT UNSIGNED NOT NULL DEFAULT 0");
    if ($database->hasError()) {
        throw new RuntimeException('wbce_search column misses: ' . $database->getError());
    }
}
if ($database->getDriver() === 'mysql') {
    // KEY for the word-index backlog count (fresh installs get it from
    // install_struct.sql; addIndex() drops and re-creates, so this is idempotent).
    $database->addIndex('{TP_SEARCH}index', 'tokenized', 'tokenized');
}

// ── WBCE Search is the only search: the old frontend switch is gone ──────
// (Settings 'use_search_tool', and before 0.4 a sentinel file.)
Settings::delete('use_search_tool');
$ws_sentinel = WB_PATH . '/modules/wbce_search/wbce_search.active';
if (is_file($ws_sentinel)) {
    @unlink($ws_sentinel);
}

// 0.5.1: detail_url/thumb_url hold {SYSVAR:WB_URL} instead of the absolute
// site URL, so the index survives a move. Convert the existing rows.
(new WbceSearchIndexer($database))->tokenizeUrls();

// 0.4.0: rows of sections that are gone / no longer searchable are pruned
// by the indexer now; a full rebuild after upgrading brings the index and
// the new "processed, nothing to index" marker rows up to date.

unset($_SESSION['ws_tracked'], $_SESSION['ws_missed']);
