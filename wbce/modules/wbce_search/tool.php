<?php
/**
 * wbce_search — tool.php
 *
 * Entry point for admin/admintools/tool.php?tool=wbce_search. The AdminTools
 * runner has already built $admin, checked the tool permission and loaded
 * languages/{LANGUAGE}.php before requiring this file. assets/backend.css
 * and assets/backend.js are auto-loaded by the core for this tool.
 *
 * Thin on purpose: assets + Twig setup, then WbceSearchBackend::run().
 * Same structure as modules/WbceAnalytics/tool.php.
 *
 * @license GNU General Public License
 */

defined('WB_PATH') or die('Direct access not allowed.');

// Classes (classes/) come from the autoloader — registered in initialize.php.

Alerts::ensureToastAssets();
I::insertJsFile(INCLUDE_URL . '/htmx/htmx.min.js', 'body_late');

// Same faces as WbceAnalytics, fetched + cached server-side by FontCache —
// no admin browser talks to fonts.googleapis.com directly.
I::insertWebFont(
    'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700'
    . '&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500;600&display=swap'
);

// getTwig() has autoescape OFF — every data value in the templates needs |e.
$oTwig = getTwig(__DIR__ . '/twig/');
WbceSearchIcons::register($oTwig);

try {
    (new WbceSearchBackend($database, $admin, $oTwig))->run();
} catch (\Throwable $e) {
    trigger_error('[wbce_search tool.php] ' . $e->getMessage()
        . ' in ' . basename($e->getFile()) . ':' . $e->getLine(), E_USER_WARNING);
    echo '<div class="alert alert-danger" style="margin:20px"><strong>wbce_search error:</strong><br>'
       . htmlspecialchars($e->getMessage()) . '</div>';
}

