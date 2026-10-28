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
 * @license         https://www.gnu.org/licenses/gpl.html
 * @platform        WBCE
 *
 */

$module_directory   = 'news_img';
$module_name        = 'News with Images';
$module_function    = 'page';
$module_version     = '5.0.36';
$module_platform    = '1.4';
$module_author      = 'Ryan Djurovich, Rob Smith, Silvia Reins, Martin Hecht, Florian Meerwinck, Bianka Martinovic, Slugger';
$module_license     = 'GNU General Public License';
$module_description = 'This page module is designed for making a news page with images and lightbox effect.';

/**
 * CHANGE LOG
 * 
 * v5.0.36 - 2026/10/28
 *         - Fernando via Rik van Loenhout (report), Christian M. Stefan
 *         * fetchNewsItems / mod_nwi_get_news_items() returned news of every
 *           page, also private/registered ones the visitor may not see;
 *           only news of visible pages now
 *
 * v5.0.35 - 2026/10/25
 *         - Rik van Loenhout (review), Christian M. Stefan
 *         * "delete group" did nothing since 5.0.33: the link carried no
 *           section_id, so modules/admin.php set it to 0 and the ownership
 *           check (group must belong to the section) refused every deletion
 *
 * v5.0.34 - 2026/10/24
 *         - Rik van Loenhout (review), Christian M. Stefan
 *         * every IDKEY carries a purpose ('post', 'group', 'image', 'tag',
 *           'section') and every consumer requires it, so a key issued for
 *           one kind of object is no longer accepted as another
 *         * gallery images (delete, reorder) must belong to the post
 *         * uploader: 'post' key plus admin right on the post's page (it
 *           checked only the module right); no server path in the answer
 *         * drag & drop: all rows must belong to one section the user may
 *           administrate, checked before anything is written
 *         * move_up/move_down: the object must belong to the section
 *
 * v5.0.33 - 2026/10/23
 *         - Rik van Loenhout (review), Christian M. Stefan
 *         * SQL injection via manage_posts[] in the mass actions (activate,
 *           clear dates, delete, tags): post/tag ids are cast to int
 *         * a page editor could change, delete, copy or move posts, groups
 *           and tags of other pages by sending their ids with his own
 *           page_id: every endpoint now checks the object belongs to the
 *           section modules/admin.php has verified; copy/move/group targets
 *           on another page need admin rights there; global tags are
 *           admin-only
 *         * unserialize() of the group target without allowed_classes
 *         * "settings only for admins" is enforced on save, not just in the form
 *         * uploader: image extensions only, checked before the file is moved
 *         * deleting several posts at once removed the image folder of an
 *           unrelated post ("<1st id><2nd id>") instead of the 2nd post's
 *
 * v5.0.32 - 2026/08/10
 *         - Christian M. Stefan
 *         * multi-driver SQL corrections (MySQL/SQLite) as preparation for
 *           experimental SQLite readiness: all eight table DDL blocks
 *           (including the FOREIGN KEY / UNIQUE KEY constraints on
 *           mod_news_img_posts_img) moved to install_struct.sql, routed
 *           through Database::importSql() instead of raw query(sprintf(...))
 *           so they get normalized for the active driver
 *
 * v5.0.31 - 2026/03/23
 *         - slugger
 *         ! PHP 8.5 fixes
 *
 * v5.0.30 - 2025/12/30
 *         - webbird, florian
 *         ! bugfix for deprecated issue caused by tag sanitzing
 *
 * v5.0.29 - 2025/12/01
 *         - mrbaseman
 *         ! tag sanitizing 
 *
 * v5.0.28 - 2024/09/26
 *         - mrbaseman
 *         * add sorting order: expiration date ascending
 *         ! bug fix for v5.0.27 concerning access files 
 *         ! complete the language files
 *
 * v5.0.27 - 2024/09/25
 *         - mrbaseman
 *         * add mass actions to clear publication and expiration date
 *
 * v5.0.26 - 2024/05/26
 *         - florian
 *         * add TAGLIST feature
 *
 * v5.0.25 - 2024/01/31
 *         - florian
 *         ! fix issue with droplet fetchNewsItems (aka getnewsitems, which caused unwanted overwriting of droplet from NIA with the same name)
 *
 * v5.0.24 - 2023/11/20
 *         - mrbaseman
 *         ! fix post_id in access file for next/prev pages
 
 * v5.0.23 - 2023/11/20
 *         - florian
 *         ! fix sorting issue due to group assignment (undo changes from 5.0.13)
 *
 * v5.0.22 - 2023/06/17
 *         - florian
 *         ! fixing issues with missing accessfiles due to post activation handling
 *
 * v5.0.21 - 2023/04/18
 *         - florian
 *         ! several bugfixes (see Github commits) 
 *
 * v5.0.20 - 2023/04/09
 *		   - florian
 *         ! fix update issue with new setting show_settings_only_admins
 *         * better handling of post activation (remove / rebuild access file)
 *
 * v5.0.19 - 2023/02/01
 *		   - florian
 *         ! missing changes on upgrade.php in single install package. no changes in WBCE core repo.
 * 
 * v5.0.18 - 2023/01/27
 *         - florian
 *         ! fix issue with non-replacement of {SYSVAR:MEDIA_REL}
 *
 * v5.0.17 - 2022-11-14
 *         - florian         
 *         * add option to show settings only admins

 * v5.0.16 - 2022-08-15
 *         - florian         
 *         ! PHP 8.1 fixes    
 *
 * v5.0.15 - 2022-03-05
 *         - webbird
 *           ! fixed upgrade changes wrong version number
 *
 * v5.0.14 - 2022-02-08
 *         - florian
 *           * Add [AOPEN] [ACLOSE] placeholders + webp compatibility
 *
 * v5.0.13 - 2021-12-25
 *         - gchriz
 *           * Add missing option 4 and make "order news by group" working
 *
 * v5.0.12 - 2021-12-10
 *         - Florian
 *           * fix rss.php (require section_id for sql query instead of page_id since page_id is no longer stored in news_img_post table)
 *
 * v5.0.11 - 2021-10-09
 *         - Florian
 *           * added HREF placeholder
 *
 * v5.0.10 - 2021-10-02
 *         - Florian
 *           ! fixed deleted tags are still in database
 *           * added Sort tags ascending
 *
 * v5.0.9  - 2021-09-19
 *         - Florian
 *           ! remove image database changes for unfinished image handling from upgrade.php
 *           ! Post images can be either deleted or replaced now (w/o deleting the old image file)
 *           ! Remove unnecessary sorting option PostID
 *           * improved view management: views/default/config.private.php -> views/default/config.php -> add.php
 *
 * v5.0.8  - 2021-07-11
 *         - Florian
 *           * better prev/next navigation when group is selected
 *
 * v5.0.7  - 2020-09-20
 *         - Various
 *           ! fixed languages files
 *           ! fixed import script
 *           ! fixed post_id
 *
 * v5.0.6  - 2020-07-20
 *         - Florian
 *           ! Remove unnecessary link to frotorama.css from frontend.css
 *
 * v5.0.5  - 2020-07-18
 *         - Florian
 *           ! fix wrong likn to fotorama.css (reported by klawin)
 *
 * v5.0.4  - 2020-06-18
 *         - Colinax
 *           ! fix error in install.php
 **/
