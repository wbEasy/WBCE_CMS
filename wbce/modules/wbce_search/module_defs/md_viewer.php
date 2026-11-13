<?php
/**
 * wbce_search - module_defs/md_viewer.php
 * Indexer definition for MD Viewer — reads MD files directly
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

// No standard array — MD Viewer uses its own indexer callback
return [
    'table'      => 'mod_md_viewer',
    'id_field'   => 'section_id',
    'item_key'   => null,
    'title'      => null,
    'fields'     => [],
    'link'       => null,
    'image'      => null,
    'image_path' => null,
    'mode'       => 'single',
    'index_base' => 'page',
    'filter'     => [],
    'joins'      => [],
    'suggest'    => true,
    'callback'   => [WbceSearchIndexer::class, 'indexMdViewer'],
    'weights'    => [
        'page_title'  => 3,
        'keywords'    => 2,
        'item_title'  => 0,
        'description' => 1,
        'content'     => 1,
    ],
];
