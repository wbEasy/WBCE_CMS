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

$module_directory   = 'jsadmin';
$module_name        = 'Javascript Admin';
$module_function    = 'tool';
$module_version     = '2.0.2';
$module_platform    = '1.7.0';
$module_author      = 'Stepan Riha, Swen Uth, BerndJM, Christian M. Stefan';
$module_license     = 'BSD License';
$module_description = 'Settings for the PageTaree and section management behaviour.';
$module_icon        = 'fa fa-sitemap';
$module_level       = 'core';

/**
 * Version history
 *
 * 2.0.2 - security fixes, based on Rik van Loenhout's review (2026-10-09)
 *         [-] move_to.php removed: positions written via GET without a token,
 *             position unbounded; unused since 2.0.0 (upgrade.php deletes
 *             a leftover copy)
 *         [!] tool.php: form action no longer echoes REQUEST_URI
 *         [!] drag & drop requests carry an IDKEY; the core endpoints check
 *             it together with the rights on each page
 *
 * 2.0.1 - multi-driver SQL corrections (MySQL/SQLite) as preparation for
 *         experimental SQLite readiness
 *
 * 2.0.0 - complete rework.
 *         [c] from YahooUI to jQuery Sortable
 *          This version saves approximately 1 MB of the WBCE package.
 * 
 * 
 * 1.4.4 - fixes for MySQL-Strict (Bernd)
 *
 * 1.4.3
 *        - Add module_level core status
 *        - Update module_platform
 *
 * 1.4.2
 *        - Add Admintool Icon
 *
 * 1.4.1
 *        - Making use of Insert class
 *
 **/
