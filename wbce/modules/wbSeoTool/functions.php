<?php
/**
 * WBCE CMS AdminTool: wbSeoTool
 *
 * functions.php
 * Data layer for the SEO tree view — built on the shared PageTree class.
 *
 * @package     wbSeoTool
 * @author      Christian M. Stefan (https://www.wbEasy.de/)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

// prevent this file from being accessed directly
if (!defined('WB_PATH')) exit("Cannot access this file directly " . __FILE__);

if (!function_exists('wbSeoToolRewriteColumnAllowed')) {

    /**
     * May this {TP}pages column be used as the "rewrite URL" column?
     *
     * The column becomes a free text field for every editor in the tree, so
     * it must be a column of its own (e.g. `slug`), never one of the core
     * structure or permission columns — otherwise the tree would let anyone
     * with pages_modify rewrite admin_groups, visibility, link, …
     *
     * @param  string $column
     * @return bool
     */
    function wbSeoToolRewriteColumnAllowed(string $column): bool
    {
        static $coreColumns = [
            'page_id', 'parent', 'root_parent', 'level', 'link', 'target',
            'page_trail', 'template', 'visibility', 'visibility_backup',
            'position', 'menu', 'language', 'searching', 'admin_groups',
            'admin_users', 'viewing_groups', 'viewing_users', 'modified_when',
            'modified_by', 'page_code',
        ];

        return preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $column) === 1
            && !in_array(strtolower($column), $coreColumns, true);
    }
}

if (!function_exists('seoPageTree')) {

    /**
     * Build the SEO admin tree: PageTree::load() (page_title, description,
     * keywords, and all permission flags already included) plus, if enabled,
     * the configurable "rewrite URL" column merged in on top.
     *
     * @param  object        $admin
     * @param  Database|null $db
     * @return array  Nested tree, ready for Twig
     */
    function seoPageTree(object $admin, ?Database $db = null): array
    {
        $db ??= $GLOBALS['database'];

        $tree = PageTree::load($admin, $db);

        if (defined('REWRITE_URL') && REWRITE_URL !== '' && $db->fieldExists('{TP}pages', REWRITE_URL)) {
            $column = REWRITE_URL;
            $rows   = $db->fetchAll("SELECT `page_id`, `{$column}` AS rewrite_url FROM `{TP}pages`");

            $map = [];
            foreach ($rows as $row) {
                $map[(int) $row['page_id']] = $row['rewrite_url'] ?? '';
            }

            mergeRewriteUrlColumn($tree, $map, $column);
        }

        return $tree;
    }
}

if (!function_exists('mergeRewriteUrlColumn')) {

    /**
     * Recursively inject the rewrite-url column value into every tree node.
     *
     * @param  array  $nodes   Tree nodes, passed by reference
     * @param  array  $map     page_id => value
     * @param  string $column  Target key name (matches the DB column name)
     */
    function mergeRewriteUrlColumn(array &$nodes, array $map, string $column): void
    {
        foreach ($nodes as &$page) {
            $page[$column] = $map[$page['page_id']] ?? '';
            if (!empty($page['children'])) {
                mergeRewriteUrlColumn($page['children'], $map, $column);
            }
        }
        unset($page);
    }
}
