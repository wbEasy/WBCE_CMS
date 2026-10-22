<?php
/**
 * WBCE CMS AdminTool: wbSeoTool
 *
 * ajax/save.php
 * HTMX endpoint: saves a single inline-edited SEO field for one page.
 *
 * Security model:
 *  - This file is reached directly (own config.php), not through
 *    admin/admintools/tool.php, so it checks the tool right itself.
 *  - The page_id is never taken from the request body. It comes from
 *    redeeming the `idkey` that PageTree::load() issued with the purpose
 *    'page' — only for pages the user may modify. A key issued for anything
 *    else (a section, user or group ID of the same number) is refused.
 *  - The key alone is still no authorization: the page permission is
 *    checked again here, against the current state of the page.
 *  - checkIDKEY(..., $ajax = true) does not invalidate sibling keys, so
 *    every other editable cell on the page stays usable.
 *
 * @package     wbSeoTool
 * @author      Christian M. Stefan (https://www.wbEasy.de/)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

declare(strict_types=1);

require '../../../config.php';

/** @var Database $database */

$admin = new Admin('Pages', 'pages_modify', false);
require_once dirname(__DIR__) . '/functions.php';

// same rule as the tool itself (admintools/tool.php + tool.php)
if (!$admin->get_permission('admintools') || !$admin->get_permission('pages')
    || !$admin->hasToolPermission('wbSeoTool')) {
    http_response_code(403);
    exit('insufficient privileges');
}

$pageId = (int) $admin->checkIDKEY('idkey', 0, 'POST', true, 'page');
if ($pageId <= 0) {
    http_response_code(403);
    exit('invalid or expired token');
}

// Re-check the page permission the way PageTree::walkPermissions() does;
// a page that no longer exists is refused as well.
$page = $database->fetchRow(
    "SELECT `visibility`, `admin_groups`, `admin_users` FROM `{TP}pages` WHERE `page_id` = ?",
    [$pageId]
);
$bTrashInline = defined('PAGE_TRASH') && PAGE_TRASH === 'inline';
if (!$page
    || !$admin->get_page_permission($page, 'admin')
    || ($page['visibility'] === 'deleted' && !$bTrashInline)) {
    http_response_code(403);
    exit('insufficient privileges');
}

$field = (string) ($_POST['field'] ?? '');

$allowedFields = ['page_title', 'description', 'keywords'];

$aSettings = json_decode((string) Settings::get('seo_cfg', '{}'), true) ?: [];

if (!empty($aSettings['menuTitleConfig']['use'])) {
    $allowedFields[] = 'menu_title';
}

if (!empty($aSettings['rewriteUrl']['use']) && !empty($aSettings['rewriteUrl']['dbString'])) {
    $candidate = (string) $aSettings['rewriteUrl']['dbString'];
    if (wbSeoToolRewriteColumnAllowed($candidate) && $database->fieldExists('{TP}pages', $candidate)) {
        $allowedFields[] = $candidate;
    }
}

if (!in_array($field, $allowedFields, true)) {
    http_response_code(400);
    exit('unknown field');
}

$value = trim(str_replace("\r", '', (string) ($_POST['value'] ?? '')));

$database->query(
    "UPDATE `{TP}pages` SET `{$field}` = ? WHERE `page_id` = ?",
    [$value, $pageId]
);

if ($database->hasError()) {
    http_response_code(500);
    exit('save failed');
}

echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
