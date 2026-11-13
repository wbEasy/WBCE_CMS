<?php
/**
 * wbce_search - module_defs/bakery.php
 * Indexer definition for Bakery shop
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
return [
    'table'      => 'mod_bakery_items',
    'id_field'   => 'section_id',
    'item_key'   => 'item_id',
    'title'      => 'title',
    'fields'     => ['description', 'full_desc'],
    'link'       => 'link',
    'image'      => null,
    'image_path' => null,
    'mode'       => 'multi',
    'index_base' => 'all',
    'filter'     => ['active' => 1],
    'joins'      => [
        [
            'table'      => 'mod_bakery_images',
            'type'       => 'LEFT',
            'on_main'    => 'item_id',
            'on_join'    => 'item_id',
            'fields'     => [],
            'image'      => 'filename',
            'image_path' => 'bakery/thumbs/item{item_id}/',
        ],
    ],
    'suggest'    => true,
    'weights'    => [
        'page_title'  => 2,
        'keywords'    => 2,
        'item_title'  => 3,
        'description' => 1,
        'content'     => 1,
    ],
];
