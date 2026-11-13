<?php
/**
 * wbce_search - module_defs/oneforall.php
 * Indexer definition for OneForAll (OFA)
 * Callback indexer: builds correct item link from page link + item link
 * For manual configuration: use semi-config in admin tool
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
    'table'      => 'mod_oneforall_items',
    'id_field'   => 'section_id',
    'callback'   => [WbceSearchIndexer::class, 'indexOneforall'],
    'mode'       => 'multi',
    'index_base' => 'page',
    'suggest'    => true,
];
