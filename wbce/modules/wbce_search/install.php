<?php
/**
 * wbce_search - install.php
 * Every step can run again without harm, so upgrade.php includes this file
 * and only adds what is upgrade-only: tables (IF NOT EXISTS), settings
 * (missing keys only), droplet (code refreshed).
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

// The module is registered in {TP}addons just before this runs, but its
// initialize.php (which registers classes/ with the autoloader and the
// {TP_SEARCH} table prefix) has not run in this request — so both are done
// here. WbAuto ignores a second registration of the same folder.
WbAuto::AddDir(__DIR__ . '/classes/', true);
$database->addPrefix('{TP_SEARCH}', TABLE_PREFIX . 'mod_search_');

// One write, checked — AddonService::runScript() catches the exception and
// reports the failed step.
$ws_write = static function (string $sql, array $params = []) use ($database): void {
    $database->query($sql, $params);
    if ($database->hasError()) {
        throw new RuntimeException('wbce_search setup: ' . $database->getError());
    }
};

unset($_SESSION['ws_tracked'], $_SESSION['ws_missed']);

// ── Tables (MySQL/MariaDB + SQLite via Database::importSql()) ──────────────
foreach ($database->importSql(__DIR__ . '/install_struct.sql') as $ws_r) {
    if (!$ws_r['ok']) {
        throw new RuntimeException('wbce_search tables: ' . $ws_r['msg']);
    }
}
// importSql() drops inline KEYs for SQLite — create the ones lookups depend on.
if ($database->getDriver() === 'sqlite') {
    $ws_write("CREATE INDEX IF NOT EXISTS `{TP}wss_words_entry` ON `{TP_SEARCH}words` (`entry_id`)");
    $ws_write("CREATE INDEX IF NOT EXISTS `{TP}wss_index_section` ON `{TP_SEARCH}index` (`section_id`)");
    $ws_write("CREATE INDEX IF NOT EXISTS `{TP}wss_index_tokenized` ON `{TP_SEARCH}index` (`tokenized`)");
}

// ── Settings: JSON in {TP}settings (WbceSearchSettings) ────────────────────
// Missing keys get their defaults, stored values stay.
WbceSearchSettings::seed();

// ── Droplet [[wbce_search_tagcloud]]: register once / refresh its code ─────
// Adapts to whichever optional columns the installed Droplets version has.
if ($database->tableExists('{TP}mod_droplets') && $database->fieldExists('{TP}mod_droplets', 'code')) {
    $ws_desc = $SEARCH['DROPLET_DESCRIPTION']
        ?? 'Tag cloud of most searched terms. Parameters: max=20, min_count=1, desc=Label, active=true (false = hidden)';
    // Droplets store the code without the open tag.
    $ws_code = (string) preg_replace('/^\s*<\?php\s*/i', '', (string) file_get_contents(__DIR__ . '/droplet.php'));

    $ws_id = (int) $database->fetchValue(
        "SELECT `id` FROM `{TP}mod_droplets` WHERE `name` = ? ORDER BY `id` LIMIT 1", ['wbce_search_tagcloud']
    );
    if ($ws_id) {
        $ws_write("UPDATE `{TP}mod_droplets` SET `code` = ?, `description` = ? WHERE `id` = ?", [$ws_code, $ws_desc, $ws_id]);
        // Duplicates left behind by older install.php runs.
        $ws_write("DELETE FROM `{TP}mod_droplets` WHERE `name` = ? AND `id` <> ?", ['wbce_search_tagcloud', $ws_id]);
    } else {
        $ws_row = ['name' => 'wbce_search_tagcloud', 'description' => $ws_desc, 'code' => $ws_code];
        foreach ([
            'active' => 1, 'admin_edit' => 1, 'admin_view' => 0, 'show_wysiwyg' => 0, 'comments' => '',
            'modified_when' => time(), 'modified_by' => isset($admin) ? (int) $admin->get_user_id() : 1,
        ] as $ws_col => $ws_val) {
            if ($database->fieldExists('{TP}mod_droplets', $ws_col)) $ws_row[$ws_col] = $ws_val;
        }
        $database->insertRow('{TP}mod_droplets', $ws_row);
        if ($database->hasError()) {
            throw new RuntimeException('wbce_search droplet: ' . $database->getError());
        }
    }
}
