<?php
/**
 * wbce_search - module_defs/wysiwyg.php
 * Indexer definition for wysiwyg / ckeditor
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
    'table'       => 'mod_wysiwyg',
    'id_field'    => 'section_id',     // = section_id, no own item_id
    'title'       => null,             // title comes from {TP}pages.page_title
    'fields'      => ['content'],
    'link'        => null,             // no own link, page URL is sufficient
    'image'       => null,
    'image_path'  => null,
    'mode'        => 'single',         // 1 entry per section
    'index_base'  => 'page',           // searchable pages only
    'filter'      => [],
    'suggest'     => true,
    'weights'     => [
        'page_title'  => 3,
        'keywords'    => 2,
        'item_title'  => 0,
        'description' => 1,
        'content'     => 1,
    ],
];
