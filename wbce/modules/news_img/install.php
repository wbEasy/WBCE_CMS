<?php
/**
 *
 * @category        modules
 * @package         news_img
 * @author          WBCE Community
 * @copyright       2004-2009, Ryan Djurovich
 * @copyright       2009-2010, Website Baker Org. e.V.
 * @copyright       2019-, WBCE Community
 * @link            https://www.wbce.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WBCE
 *
 */

if(defined('WB_URL'))
{
    // DDL lives in install_struct.sql and goes through importSql() rather
    // than raw query() — it normalises MySQL-only syntax (AUTO_INCREMENT,
    // inline UNIQUE/KEY/INDEX, ENGINE=, UNSIGNED, ...) for SQLite the same
    // way the core installer's SQL files are handled. Default
    // preserveExisting=true is fine here — these statements are all
    // CREATE TABLE IF NOT EXISTS with no DROP TABLE to skip.
    foreach ($database->importSql(__DIR__ . '/install_struct.sql') as $r) {
        if (!$r['ok']) {
            echo "<h2>DB error creating " . h($r['statement']) . ": " . h($r['msg']) . "</h2>";
        }
    }

        // Make news post img files dir
    require_once(WB_PATH.'/framework/functions.php');
    if(make_dir(WB_PATH.MEDIA_DIRECTORY.'/.news_img')) {
        // Add a index.php file to prevent directory spoofing
        $content = ''.
"<?php

/**
 *
 * @category        modules
 * @package         news_img
 * @author          WBCE Community
 * @copyright       2004-2009, Ryan Djurovich
 * @copyright       2009-2010, Website Baker Org. e.V.
 * @copyright       2019-, WBCE Community
 * @link            https://www.wbce.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WBCE
 *
 */

header('Location: ../');
?>";
        $handle = fopen(WB_PATH.MEDIA_DIRECTORY.'/.news_img/index.php', 'w');
        fwrite($handle, $content);
        fclose($handle);
        change_mode(WB_PATH.MEDIA_DIRECTORY.'/.news_img/index.php', 'file');
    }
        
        // Make news post img thumb files dir
    require_once(WB_PATH.'/framework/functions.php');
    if(make_dir(WB_PATH.MEDIA_DIRECTORY.'/.news_img/thumb')) {
        // Add a index.php file to prevent directory spoofing
        $content = ''.
"<?php

/**
 *
 * @category        modules
 * @package         news_img
 * @author          WBCE Community
 * @copyright       2004-2009, Ryan Djurovich
 * @copyright       2009-2010, Website Baker Org. e.V.
 * @copyright       2019-, WBCE Community
 * @link            https://www.wbce.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WBCE
 *
 */

header('Location: ../');
?>";
        $handle = fopen(WB_PATH.MEDIA_DIRECTORY.'/.news_img/thumb/index.php', 'w');
        fwrite($handle, $content);
        fclose($handle);
        change_mode(WB_PATH.MEDIA_DIRECTORY.'/.news_img/thumb/index.php', 'file');
    }

    // install the droplet(s)
    if(!defined('CAT_PATH')) {
        try {
            // workaround for problem with global $module_directory overwritten
            // by functions.inc.php here
            $orig_module_dir = $module_directory;
             include WB_PATH.'/modules/droplets/functions.inc.php';
            make_dir(WB_PATH.'/temp/unzip');
            wbce_unpack_and_import(WB_PATH.'/modules/news_img/droplets/droplet_fetchNewsItems.zip', WB_PATH . '/temp/unzip/');
            rm_full_dir(WB_PATH.'/temp/unzip');
            $module_directory = $orig_module_dir;
        } catch ( \Exception $e ) {}
    } else {
        CAT_Helper_Droplet::installDroplet(WB_PATH.'/modules/news_img/droplets/droplet_fetchNewsItems.zip');
    }
    
};
