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

/**
 * Droplets — backup download
 *
 * The backup directory (DROPLETS_BACKUP_DIR) lies below var/, which the core
 * closes for direct web access (var/.htaccess), since a backup zip holds the
 * code of all droplets. Backups are downloaded through this script instead,
 * which applies the same permission check as the tool and only serves files
 * that are actually listed in the backup directory.
 *
 * The file name travels as an IDKEY (the name itself stays in the session),
 * read with peek ($ajax = true) instead of being redeemed: the download
 * leaves the admin on the backups page, and redeeming would invalidate
 * every other link there (restore, delete). Fine for a read-only action;
 * the destructive links on that page still use one-time keys.
 *
 * GET: file — IDKEY of the backup zip's name, see templates/backups.twig
 */

require_once '../../config.php';

$admin = new Admin('admintools', 'admintools', false);
require_once __DIR__ . '/functions.inc.php';

if (!$admin->get_permission('admintools') || !$admin->hasToolPermission('droplets')) {
    http_response_code(403);
    exit('Access denied');
}

$sFile = droplets_backup_path($admin->checkIDKEY('file', false, 'GET', true));
if ($sFile === null) {
    http_response_code(404);
    exit('Not found');
}

while (ob_get_level() > 0) {
    ob_end_clean();
}
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . basename($sFile) . '"');
header('Content-Length: ' . filesize($sFile));
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, no-store');
readfile($sFile);
exit;
