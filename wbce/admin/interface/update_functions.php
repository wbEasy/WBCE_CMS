<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * Update advisories: notes about installed addons that WBCE no longer ships
 * or that are installed in a version with a known problem. Shown at the end
 * of install/update.php and to administrators on the backend start page.
 *
 * One entry per addon in wbceAdvisoryList(); the texts live in this file as
 * well (wbceAdvisoryText()), so the update and the backend use the same
 * wording without touching the core language files.
 *
 * Loaded by framework/functions.php.
 *
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

defined('WB_PATH') or die('No direct access allowed');

/**
 * The addons WBCE has something to say about.
 *
 *   fixed    first version without the known problem; older ones get a warning
 *   current  version to recommend
 *   url      where to get it
 *   marker   what a template/droplet/filter contains when it runs the addon's
 *            code on every page (searched to find where it is wired in)
 *   activity optional: fn(): ?int — timestamp of the last recorded activity
 *
 * @return array<string, array>  keyed by module directory
 */
function wbceAdvisoryList(): array
{
    return [
        'wbstats' => [
            'fixed'    => '0.2.5.11',   // SQL injection in class.count.php (getUTM()) closed
            'current'  => '0.2.5.12',
            'url'      => 'https://addons.wbce.org/pages/addons.php?do=item&item=85',
            'marker'   => 'wbstats/count.php',
            'activity' => function (): ?int {
                global $database;
                if (!$database->tableExists('{TP}mod_wbstats_day')) {
                    return null;
                }
                $day = (string) $database->fetchValue("SELECT MAX(`day`) FROM `{TP}mod_wbstats_day`");
                $ts  = preg_match('/^\d{8}$/', $day) ? strtotime($day) : false;
                return $ts === false ? null : $ts;
            },
        ],
    ];
}

/**
 * Advisories for the addons installed here.
 *
 * Levels:
 *   critical  version with a known problem, and its code runs on the site
 *             (wired in somewhere, or activity within the last 30 days)
 *   warn      version with a known problem, not wired in anywhere we can see
 *   info      problem fixed, but no longer shipped with WBCE (only with
 *             $withInfo — worth a line after an update, not a lasting warning)
 *
 * @param  bool $withInfo  include 'info' advisories
 * @return array[]  each: addon, name, installed, level, references[], last_activity
 */
function wbceAdvisories(bool $withInfo = false): array
{
    global $database;
    $result = [];

    foreach (wbceAdvisoryList() as $dir => $def) {
        $row = $database->fetchRow(
            "SELECT `name`, `version` FROM `{TP}addons` WHERE `directory` = ? AND `type` IN ('module', 'module_off')",
            [$dir]
        );
        if ($row === null) {
            continue;
        }
        $installed = (string) $row['version'];
        $outdated  = version_compare($installed, $def['fixed'], '<');
        if (!$outdated && !$withInfo) {
            continue;
        }

        $references   = [];
        $lastActivity = null;
        if ($outdated) {
            $references   = wbceAdvisoryReferences($def['marker']);
            $lastActivity = isset($def['activity']) ? ($def['activity'])() : null;
        }
        $running = $references !== [] || ($lastActivity !== null && $lastActivity > time() - 30 * 86400);

        $result[] = [
            'addon'         => $dir,
            'name'          => (string) $row['name'],
            'installed'     => $installed,
            'level'         => !$outdated ? 'info' : ($running ? 'critical' : 'warn'),
            'references'    => $references,
            'last_activity' => $lastActivity,
        ];
    }

    return $result;
}

/**
 * Where $marker is wired in: template files, droplets, Code2 sections and
 * output filters. 'guarded' tells whether a file_exists() check precedes it
 * (a heuristic — without one, removing the addon breaks the page).
 *
 * @return array[]  each: where (string), guarded (bool)
 */
function wbceAdvisoryReferences(string $marker): array
{
    global $database;
    $found   = [];
    // file_exists() within 300 characters before or after the marker: both
    // "if (file_exists('…/count.php'))" and "$f = '…/count.php'; if (file_exists($f))"
    $guarded = function (string $code) use ($marker): bool {
        $pos = stripos($code, $marker);
        return $pos !== false
            && stripos(substr($code, max(0, $pos - 300), 600 + strlen($marker)), 'file_exists') !== false;
    };

    $templates = WB_PATH . '/templates';
    if (is_dir($templates)) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($templates, FilesystemIterator::SKIP_DOTS)
        );
        foreach ($files as $file) {
            if (!preg_match('/\.(php|htt|twig|inc|html?)$/i', $file->getFilename())) {
                continue;
            }
            $code = (string) @file_get_contents($file->getPathname());
            if (stripos($code, $marker) !== false) {
                $found[] = [
                    'where'   => str_replace('\\', '/', substr($file->getPathname(), strlen(WB_PATH))),
                    'guarded' => $guarded($code),
                ];
            }
        }
    }

    // code stored in the database: [table, label column, code column, label prefix]
    foreach ([
        ['{TP}mod_droplets',               'name',       'code',    'Droplet '],
        ['{TP}mod_code2',                  'section_id', 'content', 'Code2, section '],
        ['{TP}mod_outputfilter_dashboard', 'name',       'func',    'Output filter '],
    ] as [$table, $label, $column, $prefix]) {
        if (!$database->tableExists($table)) {
            continue;
        }
        foreach ($database->fetchAll(
            "SELECT `{$label}` AS `label`, `{$column}` AS `code` FROM `{$table}` WHERE `{$column}` LIKE ?",
            ['%' . $marker . '%']
        ) as $rec) {
            $found[] = ['where' => $prefix . $rec['label'], 'guarded' => $guarded((string) $rec['code'])];
        }
    }

    return $found;
}

/**
 * The advisory as HTML (escaped), in the given language.
 *
 * @param array  $advisory  one entry of wbceAdvisories()
 * @param string $lang      'DE', 'EN', 'NL' …; empty = LANGUAGE, else EN
 */
function wbceAdvisoryHtml(array $advisory, string $lang = ''): string
{
    $def = wbceAdvisoryList()[$advisory['addon']];
    $e   = fn(string $s): string => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    $t   = fn(string $key, array $vars = []): string => $e(strtr(wbceAdvisoryText($advisory['addon'], $key, $lang), $vars));
    $v   = ['{name}' => $advisory['name'], '{installed}' => $advisory['installed'], '{current}' => $def['current']];

    $html = '<strong>' . $t('title_' . $advisory['level'], $v) . '</strong><br>' . $t('dropped', $v);
    if ($advisory['level'] === 'info') {
        return $html . ' <a href="' . $e($def['url']) . '" target="_blank" rel="noopener">' . $t('aor') . '</a>';
    }

    if ($advisory['last_activity'] !== null) {
        $html .= '<br>' . $t('last_activity', ['{date}' => date('Y-m-d', $advisory['last_activity'])]);
    }
    if ($advisory['references'] !== []) {
        $html .= '<br>' . $t('references') . '<ul>';
        foreach ($advisory['references'] as $ref) {
            $html .= '<li><code>' . $e($ref['where']) . '</code>' . ($ref['guarded'] ? '' : ' — ' . $t('unguarded')) . '</li>';
        }
        $html .= '</ul>';
    }

    $html .= ($advisory['references'] === [] ? '<br>' : '') . $t('options') . '<ul>'
           . '<li><a href="' . $e($def['url']) . '" target="_blank" rel="noopener">' . $t('option_update', $v) . '</a></li>'
           . '<li><a href="https://addons.wbce.org/" target="_blank" rel="noopener">' . $t('option_switch') . '</a></li>'
           . '<li>' . $t(in_array(false, array_column($advisory['references'], 'guarded'), true) ? 'option_remove_refs' : 'option_remove') . '</li>'
           . '</ul>';

    return $html;
}

/**
 * Text of an advisory in the given language (falls back to EN).
 */
function wbceAdvisoryText(string $addon, string $key, string $lang = ''): string
{
    static $texts = [
        'wbstats' => [
            'EN' => [
                'title_critical'     => '{name} {installed} has a known security hole, and its visitor counter is running on this site.',
                'title_warn'         => '{name} {installed} is outdated and has a known security hole.',
                'title_info'         => '{name} {installed} is no longer shipped with WBCE.',
                'dropped'            => 'WBCE no longer ships wbstats: the installed module stays, but it is no longer updated with WBCE.',
                'aor'                => 'Future versions: Add-on Repository',
                'last_activity'      => 'Last visit counted: {date}',
                'references'         => 'The counter is included here:',
                'unguarded'          => 'without a file_exists() check',
                'options'            => 'What you can do:',
                'option_update'      => 'Update to wbstats {current} (Add-on Repository)',
                'option_switch'      => 'Switch to another statistics module (Add-on Repository)',
                'option_remove'      => 'Remove wbstats (Add-ons → Modules).',
                'option_remove_refs' => 'Remove wbstats (Add-ons → Modules) — first take the includes listed above out of the template, or the pages without a file_exists() check stop working.',
            ],
            'DE' => [
                'title_critical'     => '{name} {installed} hat eine bekannte Sicherheitslücke, und der Besucherzähler läuft auf dieser Website.',
                'title_warn'         => '{name} {installed} ist veraltet und hat eine bekannte Sicherheitslücke.',
                'title_info'         => '{name} {installed} wird nicht mehr mit WBCE ausgeliefert.',
                'dropped'            => 'WBCE liefert wbstats nicht mehr mit: Das installierte Modul bleibt erhalten, wird mit WBCE aber nicht mehr aktualisiert.',
                'aor'                => 'Neue Versionen: Add-on-Repository',
                'last_activity'      => 'Zuletzt gezählter Besuch: {date}',
                'references'         => 'Der Zähler wird hier eingebunden:',
                'unguarded'          => 'ohne file_exists()-Prüfung',
                'options'            => 'Was Sie tun können:',
                'option_update'      => 'Auf wbstats {current} aktualisieren (Add-on-Repository)',
                'option_switch'      => 'Auf ein anderes Statistik-Modul umsteigen (Add-on-Repository)',
                'option_remove'      => 'wbstats entfernen (Erweiterungen → Module).',
                'option_remove_refs' => 'wbstats entfernen (Erweiterungen → Module) — vorher die oben genannten Einbindungen aus dem Template nehmen, sonst funktionieren die Seiten ohne file_exists()-Prüfung nicht mehr.',
            ],
            'NL' => [
                'title_critical'     => '{name} {installed} heeft een bekend beveiligingslek, en de bezoekersteller draait op deze website.',
                'title_warn'         => '{name} {installed} is verouderd en heeft een bekend beveiligingslek.',
                'title_info'         => '{name} {installed} wordt niet meer met WBCE meegeleverd.',
                'dropped'            => 'WBCE levert wbstats niet meer mee: de geïnstalleerde module blijft staan, maar wordt niet meer met WBCE bijgewerkt.',
                'aor'                => 'Nieuwe versies: Add-on Repository',
                'last_activity'      => 'Laatst getelde bezoek: {date}',
                'references'         => 'De teller wordt hier ingevoegd:',
                'unguarded'          => 'zonder file_exists()-controle',
                'options'            => 'Wat u kunt doen:',
                'option_update'      => 'Bijwerken naar wbstats {current} (Add-on Repository)',
                'option_switch'      => 'Overstappen op een andere statistiekmodule (Add-on Repository)',
                'option_remove'      => 'wbstats verwijderen (Extra’s → Modules).',
                'option_remove_refs' => 'wbstats verwijderen (Extra’s → Modules) — haal eerst de hierboven genoemde invoegingen uit de template, anders werken de pagina\'s zonder file_exists()-controle niet meer.',
            ],
        ],
    ];

    $lang = strtoupper($lang !== '' ? $lang : (defined('LANGUAGE') ? LANGUAGE : 'EN'));
    return $texts[$addon][$lang][$key] ?? $texts[$addon]['EN'][$key] ?? $key;
}
