<?php
/**
 * wbce_search - languages/DE.php
 * Deutsch
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Suche';
$module_description = 'Erweiterte Sucheinstellungen. Index, Module, Layouts und Statistik der Suche von WBCE CMS: Volltextsuche mit Operatoren, Live-Vorschläge, Hervorhebung der Treffer auf der Zielseite und Tag-Cloud.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Suchen';
$SEARCH['SEARCH_HEADING']                    = 'Suche';
$SEARCH['RESULTS_FOR']                       = 'Ergebnisse für';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Keine Ergebnisse',
    'one' => '%d Ergebnis',
    'other' => '%d Ergebnisse',
];
$SEARCH['NO_RESULTS']                        = 'Keine Ergebnisse gefunden.';
$SEARCH['ALL_WORDS']                         = 'Alle Wörter';
$SEARCH['ANY_WORDS']                         = 'Einzelne Wörter';
$SEARCH['EXACT_MATCH']                       = 'Genaue Wortfolge';
$SEARCH['MATCH']                             = 'Suchmodus';
$SEARCH['PAGES']                             = 'Seiten';
$SEARCH['TIPS_TITLE']                        = 'Suchtipps:';
$SEARCH['TIP_FEWER']                         = 'Weniger Begriffe verwenden';
$SEARCH['TIP_OR']                            = 'ODER-Suche:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'andererBegriff';
$SEARCH['TIP_NOT']                           = 'Ausschließen:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'ausschließen';
$SEARCH['TIP_PHRASE']                        = 'Exakte Phrase:';
$SEARCH['TIP_WILDCARD']                      = 'Platzhalter:';
$SEARCH['TIP_FUZZY']                         = 'Tippfehler zulassen:';
$SEARCH['DID_YOU_MEAN']                      = 'Meinten Sie:';
$SEARCH['SCOPE_TITLE']                       = 'Nur Titel';
$SEARCH['SCOPE_CONTENT']                     = 'Nur Inhalt';
$SEARCH['SEARCH_OR']                         = 'ODER-Suche (mind. ein Begriff)';
$SEARCH['AREAS_TITLE']                       = 'Nach Thema stöbern:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Häufig gesucht:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => '1-mal gesucht',
    'other' => '%d-mal gesucht',
];
$SEARCH['HIT_CONTENT']                       = 'Inhalt';
$SEARCH['HIT_KEYWORD']                       = 'Schlüsselwort';
$SEARCH['HIT_DESCRIPTION']                   = 'Beschreibung';
$SEARCH['HIT_TITLE']                         = 'Titel';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Platzhalter';
$SEARCH['LEGEND_FUZZY']                      = 'Tippfehler zulassen';
$SEARCH['LEGEND_PHRASE']                     = 'Exakte Phrase';
$SEARCH['LEGEND_EXCLUDE']                    = 'Begriff ausschließen';
$SEARCH['LEGEND_OR']                         = 'Einer der Begriffe';
$SEARCH['LEGEND_COMBINATION']                = 'Kombination';
$SEARCH['LEGEND_OPERATORS']                  = 'Operatoren';
$SEARCH['OP_EXCLUDE']                        = 'ausschließen';
$SEARCH['OP_WILDCARD']                       = 'Platzhalter';
$SEARCH['OP_TYPOS']                          = 'Tippfehler';
$SEARCH['OP_PHRASE']                         = 'Phrase';
$SEARCH['OP_OR']                             = 'oder';
$SEARCH['EXAMPLE_WORD']                      = 'senf';
$SEARCH['EXAMPLE_WORD2']                     = 'bio';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'scharf';
$SEARCH['EXAMPLE_OR']                        = 'ketchup';
$SEARCH['EXAMPLE_PHRASE']                    = 'gelber senf';
$SEARCH['EXAMPLE_PHRASE2']                   = 'aus mais';
$SEARCH['LABEL_LEGEND']                      = 'Legende';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Begriff im Seiteninhalt gefunden';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Begriff in den Seiten-Keywords gefunden';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Begriff in der Seitenbeschreibung gefunden';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Begriff im Titel gefunden';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Begriff in Inhalt und Keywords';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Begriff in Inhalt und Beschreibung';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Begriff in Keywords und Beschreibung';
$SEARCH['LEGEND_HIT_ALL']                    = 'Begriff in allen drei Feldern';
$SEARCH['PAGE_PREV']                         = 'Vorherige Seite';
$SEARCH['PAGE_NEXT']                         = 'Nächste Seite';
$SEARCH['DROPLET_DESCRIPTION']               = 'Tag-Cloud der häufigsten Suchbegriffe. Parameter: max=20, min_count=1, desc=Label, active=true (false = ausgeblendet)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Übersicht';
$SEARCH['MENU_MODULES']                      = 'Module';
$SEARCH['MENU_LAYOUT']                       = 'Layout';
$SEARCH['MENU_SETTINGS']                     = 'Einstellungen';
$SEARCH['MENU_STATS']                        = 'Statistik';
$SEARCH['CRUMB_OVERVIEW']                    = 'Status und Pflege des Suchindex';
$SEARCH['CRUMB_MODULES']                     = 'Welche Module den Suchindex befüllen';
$SEARCH['CRUMB_LAYOUT']                      = 'Vorlage der Suchergebnis-Seite';
$SEARCH['CRUMB_SETTINGS']                    = 'Suchverhalten, Live-Suche, Tag-Cloud';
$SEARCH['CRUMB_STATS']                       = 'Wonach Besucher suchen';
$SEARCH['LEDE_OVERVIEW']                     = 'Aktueller Zustand des Suchindex und der Frontend-Suche.';
$SEARCH['LEDE_MODULES']                      = 'Wie jedes installierte Modul indexiert wird. Module ohne Definition liefern nur ihren Seitentitel.';
$SEARCH['LEDE_LAYOUT']                       = 'Welches Layout die Suchseite und die Tag-Cloud verwenden und welches Stylesheet. Mitgelieferte Dateien und Dateien aus dem Template bleiben unverändert; bearbeitet wird immer eine eigene Kopie.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Suchergebnis-Seite';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Layout der Seite /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Tag-Cloud';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Layout des Droplets [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Stylesheet';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Für Ergebnisseite und Tag-Cloud';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'CSS aus %1$s erscheint hier · „Bearbeiten“ legt %2$s an';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Kein Stylesheet';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'das Template bringt alle Styles selbst mit';
$SEARCH['LAYOUT_ACTIVE']                     = 'aktiv';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'eigene Datei';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'aus Template „%s“';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'mitgeliefert';
$SEARCH['LAYOUT_READONLY']                   = 'nur lesen';
$SEARCH['LAYOUT_MODIFIED']                   = 'geändert %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'der Template-Datei %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'der mitgelieferten Datei %s';
$SEARCH['BTN_EDIT']                          = 'Bearbeiten';
$SEARCH['BTN_DELETE']                        = 'Löschen';
$SEARCH['BTN_BACK']                          = 'Zurück';
$SEARCH['BTN_SAVE_BACK']                     = 'Speichern & zurück';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Eine neue Datei %1\$s wird angelegt, als Kopie %2\$s.\n\nDie Kopie wird bearbeitet und als aktives Layout gewählt; das Original bleibt unverändert.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s gibt es schon. Mit dem Inhalt %2\$s überschreiben und bearbeiten?\n\nDie bisherige Fassung von %1\$s geht dabei verloren.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "%s löschen?\n\nDas lässt sich nicht rückgängig machen.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Aktives Layout: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s angelegt';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s gelöscht';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Stylesheet: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Gewichtung, Textauszüge, Live-Suche und Tag-Cloud.';
$SEARCH['LEDE_STATS']                        = 'Für die Tag-Cloud erfasste Suchbegriffe (Top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Suchindex';
$SEARCH['INDEX_BUILD']                       = 'Vollständig neu aufbauen';
$SEARCH['INDEX_UPDATE']                      = 'Geänderte aktualisieren';
$SEARCH['INDEX_CLEAR']                       = 'Index löschen';
$SEARCH['ENTRIES']                           = 'Einträge';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Index aufgebaut — nichts zu indexieren.',
    'one' => 'Index aufgebaut: %d Eintrag.',
    'other' => 'Index aufgebaut: %d Einträge.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Kein Aktualisierungsbedarf.',
    'one' => '%d Eintrag aktualisiert.',
    'other' => '%d Einträge aktualisiert.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Index gelöscht.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Index wirklich löschen?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Frontend-Suche';
$SEARCH['LABEL_LAST_INDEXED']                = 'Zuletzt indexiert';
$SEARCH['INDEX_BUILD_DESC']                  = 'Liest <b>alle</b> durchsuchbaren Abschnitte neu ein. Dauert auf großen Websites etwas länger.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Liest nur geänderte oder fehlende Abschnitte ein. Schneller als der vollständige Neuaufbau.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Liest nur geänderte oder fehlende Abschnitte ein. Gerade nichts zu tun.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Leert den Index vollständig. Die Suche findet danach nichts, bis er neu aufgebaut ist.';
$SEARCH['LABEL_FRESHNESS']                   = 'Aktualität';
$SEARCH['FRESH_ALL']                         = '<b>Index ist aktuell</b> — alle %d Abschnitte sind auf dem Stand ihrer letzten Änderung.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d von %2$d</b> Abschnitten wurden geändert oder fehlen.';
$SEARCH['FRESH_NONE']                        = 'Noch keine durchsuchbaren Abschnitte.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Suche auf der Website';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Einstellungen › Suche';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Öffentlich';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Registriert';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privat';
$SEARCH['SITE_SEARCH_NONE']                  = 'Aus';
$SEARCH['HINT_SITE_SEARCH']                  = 'Wer suchen darf — für jedes Suchfeld der Website, egal welche Suche dahinter steht. Dieselbe Einstellung wie unter <a href="%s">Einstellungen › Suche</a>; „Registriert“ und „Privat“ bedeuten beide: nur angemeldete Besucher.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Suche auf der Website auf „%s“ umstellen?\n\nDas ändert die Website-Einstellung „Suche“ für alle Besucher.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Suche auf der Website: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Sprachen';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Keine Sprachinformation';
$SEARCH['VIS_HIDDEN']                        = 'Versteckt';
$SEARCH['VIS_PUBLIC']                        = 'Öffentlich';
$SEARCH['VIS_PRIVATE']                       = 'Privat';
$SEARCH['VIS_REGISTERED']                    = 'Registriert';
$SEARCH['VIS_NONE']                          = 'Keine';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Das Layout ist leer und wurde nicht gespeichert.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'search_custom.htt konnte nicht geschrieben werden. Bitte die Schreibrechte des Ordners layouts prüfen.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Ist „AjaxSave“ angehakt, speichern „Speichern“ und Strg+S, ohne die Seite neu zu laden; „Speichern & zurück“ ist dann ausgeblendet.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Minimale Wortlänge';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Kürzere Wörter werden ignoriert';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Titelgewichtung';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Treffer im Titel × Faktor';
$SEARCH['SET_MAX_EXCERPT']                   = 'Max. Excerpt-Länge';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Zeichen pro Excerpt';
$SEARCH['SET_HIGHLIGHT']                     = 'Highlight';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Suchwörter im Excerpt hervorheben';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Highlight-Tag';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'HTML-Tag für Highlighting';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Ergebnisse pro Seite';
$SEARCH['SET_AUTO_REINDEX']                  = 'Auto-Reindex bei Suche';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Veraltete Einträge bei Suchanfrage still aktualisieren';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Tag-Cloud anzeigen';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Auf der Suchseite. Das Droplet hat einen eigenen Parameter active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Tag-Cloud aufzeichnen';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Suchbegriffe für Tag-Cloud und Statistik sammeln — ausschalten blendet die Cloud nicht aus';
$SEARCH['SET_AJAX_SUGGEST']                  = 'AJAX Live-Suche';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Vorschläge beim Tippen anzeigen';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Debug-Modus';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Technische Daten unter jedem Suchergebnis anzeigen (nur Admins)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Template der Suchseite';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Frontend-Template, in dem die Seite /search/ angezeigt wird.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Standard-Template der Website (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Suche';
$SEARCH['GROUP_DISPLAY']                     = 'Ergebnisdarstellung';
$SEARCH['GROUP_INDEX']                       = 'Index-Pflege';
$SEARCH['GROUP_LIVE']                        = 'Live-Suche';
$SEARCH['GROUP_TAGCLOUD']                    = 'Tag-Cloud';
$SEARCH['GROUP_ADMIN']                       = 'Admin-Tool';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Anzahl Treffer pro Ergebnisseite';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Sprachfilter';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Nur Seiten in der Sprache des Besuchers zeigen (Standardsprache: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Erweiterte Suche';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Suchbereich-Checkboxen und ODER-Option im Suchformular zeigen';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Max. Abschnitte pro Suche';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Obergrenze für Auto-Reindex (Lastbegrenzung)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Quelle der Vorschläge';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Hybrid zeigt zuerst Titeltreffer und füllt mit Seiten auf, die das Wort im Text enthalten';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Max. Vorschläge';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Anzahl angezeigter Vorschläge';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']          = 'Bilder in Vorschlägen';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']     = 'Zeigt das Bild eines Eintrags (Katalog, News …) neben dem Vorschlag, sofern das Modul eins indexiert';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Max. Begriffe';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Anzahl Begriffe in der Tag-Cloud';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min. Suchanfragen';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Ab wie vielen Suchen ein Begriff erscheint';
$SEARCH['SET_NAV_STYLE']                     = 'Navigation';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Tabs oben oder Icon-Leiste links';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Titel zuerst, mit Volltext aufgefüllt (empfohlen)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Titel + Beschreibung (schnell)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Volltext-Index (gründlich)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Tabs oben';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Leiste links';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Endpunkt';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Auf der Suchseite automatisch erkannt für Felder mit name="string", type="search" oder Klasse ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Einstellungen gespeichert.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Suchstatistik gelöscht.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Statistik wirklich löschen?';
$SEARCH['STATS_DELETE']                      = 'Statistik löschen';
$SEARCH['STATS_TERM']                        = 'Suchbegriff';
$SEARCH['STATS_COUNT']                       = 'Anzahl';
$SEARCH['STATS_LAST']                        = 'Zuletzt gesucht';
$SEARCH['STATS_TERMS']                       = 'Begriffe';
$SEARCH['STATS_SEARCHES']                    = 'Suchanfragen';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Die häufigsten 100 von %d Begriff.',
    'other' => 'Die häufigsten 100 von %d Begriffen.',
];
$SEARCH['STATS_EMPTY']                       = 'Noch keine Suchbegriffe erfasst.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Gesucht, nichts gefunden';
$SEARCH['HINT_STATS_MISSES']                 = 'Ganze Suchanfragen ohne Ergebnis — ein Hinweis auf Inhalte, die Besucher erwarten, aber nicht finden. Wird nie öffentlich angezeigt.';
$SEARCH['STATS_QUERY']                       = 'Suchanfrage';
$SEARCH['STATS_MISSES_EMPTY']                = 'Keine Suchen ohne Ergebnis erfasst.';
$SEARCH['CARD_WORDS']                        = 'Wort-Index';
$SEARCH['HINT_WORDS']                        = 'Für große Websites: ein Verzeichnis aller Wörter, damit eine Suche nicht mehr den ganzen Index lesen muss. Wird ab %s Index-Einträgen automatisch aufgebaut.';
$SEARCH['WORDS_INACTIVE']                    = 'Nicht aktiv — die Website liegt unter der Schwelle (%2$s Index-Einträge, derzeit %1$s); die normale Suche ist schnell genug.';
$SEARCH['WORDS_OFF']                         = 'In den Einstellungen abgeschaltet.';
$SEARCH['WORDS_BUILDING']                    = 'Im Aufbau';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Weiter aufbauen';
$SEARCH['MSG_WORDS_READY']                   = 'Wort-Index vollständig.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Wort-Index: %d Eintrag steht noch aus — bis dahin wird normal gesucht.',
    'other' => 'Wort-Index: %d Einträge stehen noch aus — bis dahin wird normal gesucht.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'In Betrieb — %d Worteintrag.',
    'other' => 'In Betrieb — %d Worteinträge.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Wort-Index';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automatisch: wird erst aufgebaut, wenn die Website die Schwelle unten erreicht. Kleine Websites brauchen ihn nicht.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automatisch';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Immer an';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Aus';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Wort-Index ab';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Anzahl indexierter Einträge (Abschnitte und Modul-Beiträge), ab der der Wort-Index automatisch aufgebaut wird';
$SEARCH['BTN_DELETE_TERM']                   = 'Begriff entfernen';
$SEARCH['MSG_TERM_DELETED']                  = 'Begriff entfernt.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Semi-Konfig für <b>%s</b> vorbelegt aus search.php — bitte prüfen und anpassen.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Semi-Konfig für \'%s\' gespeichert.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Konfiguration und Index-Einträge für %s gelöscht.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php generiert. Bitte Index neu aufbauen.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Konfiguration und Index-Einträge für %s löschen?';
$SEARCH['STATUS_SEMI']                       = 'Semi-Konfig';
$SEARCH['LABEL_GUIDE']                       = 'Anleitung für dieses Modul anzeigen';
$SEARCH['LABEL_TABLE_HINT']                  = 'Tabelle wählen → Spalten werden automatisch geladen';
$SEARCH['LABEL_TABLE_SELECT']                = 'Tabelle wählen';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'WBCE Seiten-Anker';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Nur suchbare Seiten';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Alle Abschnitte (Content-Pool)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Nur aktive Einträge (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Zeitsteuerung (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joins (optional, max. 3) — Daten aus weiteren Tabellen';
$SEARCH['LABEL_GENERATE_DEF']                = 'module_defs-Datei generieren';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Aus search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Konfiguration löschen';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Keine Text-Spalten';
$SEARCH['LABEL_ERROR']                       = 'Fehler';
$SEARCH['LABEL_MODULE']                      = 'Modul';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Nicht durchsuchbar';
$SEARCH['LABEL_HELP']                        = 'Hilfe';
$SEARCH['BTN_CONFIGURE']                     = 'Konfigurieren';
$SEARCH['BTN_CLOSE']                         = 'Schließen';
$SEARCH['DEF_GENERATED']                     = 'generiert';
$SEARCH['DEF_SHIPPED']                       = 'mitgeliefert';
$SEARCH['LABEL_KIND']                        = 'Art';
$SEARCH['LABEL_INDEXING']                    = 'Indexierung';
$SEARCH['LABEL_SECTIONS']                    = 'Sections';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtern …';
$SEARCH['MODULES_SHOWN']                     = '%1$d von %2$d Modulen angezeigt';
$SEARCH['KIND_PAGE']                         = 'Seitenmodule';
$SEARCH['KIND_SNIPPET']                      = 'Snippets';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filter';
$SEARCH['KIND_TOOL']                         = 'Admin-Tools';
$SEARCH['BADGE_PAGE']                        = 'Page';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filter';
$SEARCH['BADGE_TOOL']                        = 'Tool';
$SEARCH['GROUP_DEF']                         = 'mit Definition';
$SEARCH['GROUP_OPEN']                        = 'offen';
$SEARCH['GROUP_TITLE']                       = 'nur Seitentitel';
$SEARCH['SOURCE_MODULE']                     = 'Vom Modul';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Mitgeliefert';
$SEARCH['SOURCE_GENERATED']                  = 'Semi-Konfig';
$SEARCH['SOURCE_SEMI']                       = 'Semi-Konfig – nicht generiert';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php erkannt';
$SEARCH['SOURCE_TITLE']                      = 'Nur Seitentitel';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Das Modul liefert seine eigene Suchdefinition mit (search_index.php) — hier nicht bearbeitbar.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Wird über einen PHP-Callback indexiert — hier nicht bearbeitbar.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definition wird mit WBCE Search ausgeliefert (module_defs/). Eine Semi-Konfig hat Vorrang.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definition aus der Semi-Konfig generiert.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Semi-Konfig gespeichert, aber noch keine Definition generiert.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Noch keine Definition — kann aus der alten search.php des Moduls vorbelegt werden.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Keine Definition — im Index steht nur der Seitentitel.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Keine Seitenabschnitte — nichts zu indexieren.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Suche für diese Seite ausgeschaltet';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Mitgelieferte Definition. Speichern legt eine Semi-Konfig an, die Vorrang hat.';
$SEARCH['LABEL_TABLE']                       = 'Tabelle';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tabellen dieses Moduls';
$SEARCH['LABEL_OTHER_TABLES']                = 'Andere Modul-Tabellen';
$SEARCH['HINT_TABLE']                        = 'Nur mod_*-Tabellen mit section_id-Spalte können indexiert werden.';
$SEARCH['LABEL_ID_FIELD']                    = 'ID-Spalte';
$SEARCH['LABEL_ITEM_KEY']                    = 'Item-Schlüssel';
$SEARCH['HINT_ITEM_KEY']                     = 'Eindeutiger Schlüssel pro Eintrag (Multi-Modus).';
$SEARCH['LABEL_TITLE_COL']                   = 'Titel-Spalte';
$SEARCH['LABEL_TEXT_COLS']                   = 'Text-Spalten';
$SEARCH['LABEL_LINK_COL']                    = 'Link-Spalte';
$SEARCH['HINT_LINK_PREFIX']                  = 'Optionales Präfix: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Bild-Spalte';
$SEARCH['HINT_IMAGE_PATH']                   = 'Pfad unterhalb von /media, Platzhalter wie {item_id} erlaubt.';
$SEARCH['LABEL_NONE']                        = 'keine';
$SEARCH['LABEL_MODE']                        = 'Modus';
$SEARCH['MODE_SINGLE']                       = 'Single — ein Eintrag pro Abschnitt';
$SEARCH['MODE_MULTI']                        = 'Multi — ein Eintrag pro Item';
$SEARCH['LABEL_INDEX_BASE']                  = 'Index-Basis';
$SEARCH['LABEL_FILTER']                      = 'Filter';
$SEARCH['LABEL_NO_JOIN']                     = 'kein Join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Bitte eine gültige Modul-Tabelle wählen.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'In der search.php von %s wurde keine verwendbare Tabelle gefunden.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Keine Seiten',
    'one' => '%d Seite',
    'other' => '%d Seiten',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Speichern';
$SEARCH['MSG_SECURITY_ERROR']                = 'Sicherheitsprüfung fehlgeschlagen.';
$SEARCH['STATUS_ACTIVE']                     = 'Aktiv';
$SEARCH['STATUS_INACTIVE']                   = 'Inaktiv';

// ── Stoppwörter ────────────────────────────────────────────────────────────
// Werden nie gesucht und nie in den Wort-Index aufgenommen — kleingeschrieben.
// Gelten, sobald die Site Seiten in dieser Sprache hat (WbceSearchStopwords).
// Übersetzer: die häufigsten Füllwörter der Sprache, keine Wörterbuch-Liste.
$SEARCH['STOPWORDS'] = [
    'aber','als','am','an','auch','auf','aus','bei','bin','bis','da','das','dass',
    'dem','den','der','des','die','dies','dieser','dieses','du','durch','ein','eine',
    'einem','einen','einer','eines','er','es','für','hatte','haben','hat','hier',
    'ihm','ihn','ihr','im','in','ist','ja','jetzt','kann','kein','keine','mit',
    'nach','nicht','noch','nun','nur','ob','oder','oft','ohne','schon','sehr',
    'sein','seit','sich','sie','sind','so','sonst','über','um','und','uns','unter',
    'vom','von','vor','war','was','wenn','wer','wie','wird','wo','wurde','zu','zum',
    'zur','zwar','zwischen',
];
