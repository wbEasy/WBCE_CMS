<?php
/**
 * wbce_search - languages/NL.php
 * Nederlands
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Geavanceerde zoekinstellingen. Index, modules, lay-outs en statistieken van de zoekfunctie van WBCE CMS: zoeken in volledige tekst met operatoren, live suggesties, markering van treffers op de doelpagina en tagwolk.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Zoeken';
$SEARCH['SEARCH_HEADING']                    = 'Zoeken';
$SEARCH['RESULTS_FOR']                       = 'Resultaten voor';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Geen resultaten',
    'one' => '%d resultaat',
    'other' => '%d resultaten',
];
$SEARCH['NO_RESULTS']                        = 'Geen resultaten gevonden.';
$SEARCH['ALL_WORDS']                         = 'Alle woorden';
$SEARCH['ANY_WORDS']                         = 'Een van de woorden';
$SEARCH['EXACT_MATCH']                       = 'Exacte zin';
$SEARCH['MATCH']                             = 'Zoekmodus';
$SEARCH['PAGES']                             = 'Pagina\'s';
$SEARCH['TIPS_TITLE']                        = 'Zoektips:';
$SEARCH['TIP_FEWER']                         = 'Gebruik minder zoektermen';
$SEARCH['TIP_OR']                            = 'OF-zoeken:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'andereTerm';
$SEARCH['TIP_NOT']                           = 'Uitsluiten:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'uitsluiten';
$SEARCH['TIP_PHRASE']                        = 'Exacte zin:';
$SEARCH['TIP_WILDCARD']                      = 'Jokerteken:';
$SEARCH['TIP_FUZZY']                         = 'Tikfouten toestaan:';
$SEARCH['DID_YOU_MEAN']                      = 'Bedoelde u:';
$SEARCH['SCOPE_TITLE']                       = 'Alleen titel';
$SEARCH['SCOPE_CONTENT']                     = 'Alleen inhoud';
$SEARCH['SEARCH_OR']                         = 'OF-zoeken (minstens één term)';
$SEARCH['AREAS_TITLE']                       = 'Bladeren per onderwerp:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Vaak gezocht:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'één keer gezocht',
    'other' => '%d keer gezocht',
];
$SEARCH['HIT_CONTENT']                       = 'Inhoud';
$SEARCH['HIT_KEYWORD']                       = 'Trefwoord';
$SEARCH['HIT_DESCRIPTION']                   = 'Beschrijving';
$SEARCH['HIT_TITLE']                         = 'Titel';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Jokerteken';
$SEARCH['LEGEND_FUZZY']                      = 'Tikfouten toestaan';
$SEARCH['LEGEND_PHRASE']                     = 'Exacte zin';
$SEARCH['LEGEND_EXCLUDE']                    = 'Term uitsluiten';
$SEARCH['LEGEND_OR']                         = 'Een van beide termen';
$SEARCH['LEGEND_COMBINATION']                = 'Combinatie';
$SEARCH['LEGEND_OPERATORS']                  = 'Operatoren';
$SEARCH['OP_EXCLUDE']                        = 'uitsluiten';
$SEARCH['OP_WILDCARD']                       = 'joker';
$SEARCH['OP_TYPOS']                          = 'tikfouten';
$SEARCH['OP_PHRASE']                         = 'zin';
$SEARCH['OP_OR']                             = 'of';
$SEARCH['EXAMPLE_WORD']                      = 'mosterd';
$SEARCH['EXAMPLE_WORD2']                     = 'biologisch';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'pittig';
$SEARCH['EXAMPLE_OR']                        = 'ketchup';
$SEARCH['EXAMPLE_PHRASE']                    = 'gele mosterd';
$SEARCH['EXAMPLE_PHRASE2']                   = 'van maïs';
$SEARCH['LABEL_LEGEND']                      = 'Legenda';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Term gevonden in de pagina-inhoud';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Term gevonden in de trefwoorden van de pagina';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Term gevonden in de paginabeschrijving';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Term gevonden in de titel';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Term in inhoud en trefwoorden';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Term in inhoud en beschrijving';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Term in trefwoorden en beschrijving';
$SEARCH['LEGEND_HIT_ALL']                    = 'Term in alle drie de velden';
$SEARCH['PAGE_PREV']                         = 'Vorige pagina';
$SEARCH['PAGE_NEXT']                         = 'Volgende pagina';
$SEARCH['DROPLET_DESCRIPTION']               = 'Tagwolk van de meest gezochte termen. Parameters: max=20, min_count=1, desc=Label, active=true (false = verborgen)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Overzicht';
$SEARCH['MENU_MODULES']                      = 'Modules';
$SEARCH['MENU_LAYOUT']                       = 'Layout';
$SEARCH['MENU_SETTINGS']                     = 'Instellingen';
$SEARCH['MENU_STATS']                        = 'Statistieken';
$SEARCH['CRUMB_OVERVIEW']                    = 'Status en onderhoud van de zoekindex';
$SEARCH['CRUMB_MODULES']                     = 'Welke modules de zoekindex vullen';
$SEARCH['CRUMB_LAYOUT']                      = 'Sjabloon van de resultatenpagina';
$SEARCH['CRUMB_SETTINGS']                    = 'Zoekgedrag, live zoeken, tagwolk';
$SEARCH['CRUMB_STATS']                       = 'Waar bezoekers naar zoeken';
$SEARCH['LEDE_OVERVIEW']                     = 'Huidige status van de zoekindex en de zoekfunctie op de website.';
$SEARCH['LEDE_MODULES']                      = 'Hoe elke geïnstalleerde module wordt geïndexeerd. Modules zonder definitie leveren alleen hun paginatitel.';
$SEARCH['LEDE_LAYOUT']                       = 'Welke layout de zoekpagina en de tagwolk gebruiken, en welk stylesheet. Meegeleverde bestanden en bestanden uit het template blijven ongewijzigd; u bewerkt altijd uw eigen kopie.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Resultatenpagina';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Layout van de pagina /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Tagwolk';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Layout van de droplet [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Stylesheet';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Voor de resultatenpagina en de tagwolk';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'CSS uit %1$s verschijnt hier · "Bewerken" maakt %2$s aan';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Geen stylesheet';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'het template levert alle stijlen zelf';
$SEARCH['LAYOUT_ACTIVE']                     = 'actief';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'eigen bestand';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'uit template "%s"';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'meegeleverd';
$SEARCH['LAYOUT_READONLY']                   = 'alleen-lezen';
$SEARCH['LAYOUT_MODIFIED']                   = 'gewijzigd %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'het templatebestand %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'het meegeleverde bestand %s';
$SEARCH['BTN_EDIT']                          = 'Bewerken';
$SEARCH['BTN_DELETE']                        = 'Verwijderen';
$SEARCH['BTN_BACK']                          = 'Terug';
$SEARCH['BTN_SAVE_BACK']                     = 'Opslaan & terug';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Er wordt een nieuw bestand %1\$s aangemaakt als kopie van %2\$s.\n\nDe kopie wordt bewerkt en wordt de actieve layout; het origineel blijft ongewijzigd.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s bestaat al. Overschrijven met de inhoud van %2\$s en bewerken?\n\nUw huidige versie van %1\$s gaat verloren.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "%s verwijderen?\n\nDit kan niet ongedaan worden gemaakt.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Actieve layout: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s aangemaakt';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s verwijderd';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Stylesheet: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Weging, uittreksels, live zoeken en de tagwolk.';
$SEARCH['LEDE_STATS']                        = 'Zoektermen die voor de tagwolk zijn vastgelegd (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Zoekindex';
$SEARCH['INDEX_BUILD']                       = 'Volledig opnieuw opbouwen';
$SEARCH['INDEX_UPDATE']                      = 'Wijzigingen bijwerken';
$SEARCH['INDEX_CLEAR']                       = 'Index legen';
$SEARCH['ENTRIES']                           = 'Items';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Index opgebouwd — niets te indexeren.',
    'one' => 'Index opgebouwd: %d item.',
    'other' => 'Index opgebouwd: %d items.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Niets bij te werken.',
    'one' => '%d item bijgewerkt.',
    'other' => '%d items bijgewerkt.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Index verwijderd.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'De hele index echt verwijderen?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Zoeken op de website';
$SEARCH['LABEL_LAST_INDEXED']                = 'Laatst geïndexeerd';
$SEARCH['INDEX_BUILD_DESC']                  = 'Leest <b>alle</b> doorzoekbare secties opnieuw. Duurt even bij grote websites.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Leest alleen gewijzigde of ontbrekende secties. Sneller dan volledig opnieuw opbouwen.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Leest alleen gewijzigde of ontbrekende secties. Op dit moment niets te doen.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Leegt de index. Zoeken vindt niets meer tot de index opnieuw is opgebouwd.';
$SEARCH['LABEL_FRESHNESS']                   = 'Actualiteit';
$SEARCH['FRESH_ALL']                         = '<b>De index is actueel</b> — alle %d secties komen overeen met hun laatste wijziging.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d van %2$d</b> secties zijn gewijzigd of ontbreken.';
$SEARCH['FRESH_NONE']                        = 'Nog geen doorzoekbare secties.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Zoeken op de website';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Instellingen › Zoeken';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Openbaar';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Geregistreerd';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privé';
$SEARCH['SITE_SEARCH_NONE']                  = 'Uit';
$SEARCH['HINT_SITE_SEARCH']                  = 'Wie mag zoeken — voor elk zoekveld op de website, welke zoekfunctie er ook achter zit. Dezelfde instelling als onder <a href="%s">Instellingen › Zoeken</a>; "Geregistreerd" en "Privé" betekenen allebei: alleen ingelogde bezoekers.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Zoeken op de website op \"%s\" zetten?\n\nDit wijzigt de website-instelling \"Zoeken\" voor alle bezoekers.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Zoeken op de website: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Talen';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Geen taalinformatie';
$SEARCH['VIS_HIDDEN']                        = 'Verborgen';
$SEARCH['VIS_PUBLIC']                        = 'Openbaar';
$SEARCH['VIS_PRIVATE']                       = 'Privé';
$SEARCH['VIS_REGISTERED']                    = 'Geregistreerd';
$SEARCH['VIS_NONE']                          = 'Geen';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'De layout is leeg en is niet opgeslagen.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'search_custom.htt kon niet worden geschreven. Controleer de schrijfrechten van de map layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Met "AjaxSave" aangevinkt slaan Opslaan en Ctrl+S op zonder de pagina te herladen; "Opslaan & terug" is dan verborgen.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Minimale woordlengte';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Kortere woorden worden genegeerd';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Titelweging';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Treffers in de titel × factor';
$SEARCH['SET_MAX_EXCERPT']                   = 'Max. lengte uittreksel';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Tekens per uittreksel';
$SEARCH['SET_HIGHLIGHT']                     = 'Markeren';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Zoektermen in het uittreksel markeren';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Markeringstag';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'HTML-tag voor de markering';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Resultaten per pagina';
$SEARCH['SET_AUTO_REINDEX']                  = 'Automatisch herindexeren bij zoeken';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Verouderde items bij elke zoekopdracht stil bijwerken';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Tagwolk tonen';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Op de zoekpagina. De droplet heeft een eigen parameter active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Zoekopdrachten vastleggen';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Zoekopdrachten vastleggen voor de tagwolk en de statistieken — uitschakelen verbergt de wolk niet';
$SEARCH['SET_AJAX_SUGGEST']                  = 'AJAX live zoeken';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Suggesties tonen tijdens het typen';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Debugmodus';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Technische gegevens onder elk zoekresultaat tonen (alleen beheerders)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Template van de zoekpagina';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Frontend-template waarin de pagina /search/ wordt getoond.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Standaardtemplate van de website (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Zoeken';
$SEARCH['GROUP_DISPLAY']                     = 'Weergave resultaten';
$SEARCH['GROUP_INDEX']                       = 'Indexonderhoud';
$SEARCH['GROUP_LIVE']                        = 'Live zoeken';
$SEARCH['GROUP_TAGCLOUD']                    = 'Tagwolk';
$SEARCH['GROUP_ADMIN']                       = 'Beheertool';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Paginagrootte van de resultatenpagina';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Taalfilter';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Alleen pagina\'s in de taal van de bezoeker tonen (standaard van de website: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Uitgebreid zoeken';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Selectievakjes voor het zoekbereik en de OF-optie in het zoekformulier tonen';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Max. secties per zoekopdracht';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Limiet voor automatisch herindexeren (belastingsbeheer)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Bron van suggesties';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Hybride toont eerst titeltreffers en vult aan met pagina\'s die het woord in hun tekst bevatten';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Max. suggesties';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Aantal getoonde suggesties';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Afbeeldingen in suggesties';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Toont de afbeelding van het item (catalogus, nieuws …) naast de suggestie, als de module er een indexeert';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Max. tags';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Aantal termen in de tagwolk';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min. zoekopdrachten';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Minimaal aantal zoekopdrachten voordat een term verschijnt';
$SEARCH['SET_NAV_STYLE']                     = 'Navigatie';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Tabs bovenaan of een pictogrambalk links';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Eerst titels, aangevuld uit de volledige tekst (aanbevolen)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Titel + beschrijving (snel)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Volledige-tekstindex (grondig)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Tabs bovenaan';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Zijbalk links';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Endpoint';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Op de zoekpagina automatisch herkend voor velden met de naam "string", type="search" of klasse ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Instellingen opgeslagen.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Zoekstatistieken verwijderd.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Alle statistieken echt verwijderen?';
$SEARCH['STATS_DELETE']                      = 'Statistieken verwijderen';
$SEARCH['STATS_TERM']                        = 'Zoekterm';
$SEARCH['STATS_COUNT']                       = 'Aantal';
$SEARCH['STATS_LAST']                        = 'Laatst gezocht';
$SEARCH['STATS_TERMS']                       = 'Termen';
$SEARCH['STATS_SEARCHES']                    = 'Zoekopdrachten';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 van %d term.',
    'other' => 'Top 100 van %d termen.',
];
$SEARCH['STATS_EMPTY']                       = 'Nog geen zoektermen vastgelegd.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Gezocht, niets gevonden';
$SEARCH['HINT_STATS_MISSES']                 = 'Volledige zoekopdrachten zonder resultaat — een aanwijzing voor inhoud die uw bezoekers verwachten maar niet vinden. Nooit openbaar getoond.';
$SEARCH['STATS_QUERY']                       = 'Zoekopdracht';
$SEARCH['STATS_MISSES_EMPTY']                = 'Geen zoekopdrachten zonder resultaat vastgelegd.';
$SEARCH['CARD_WORDS']                        = 'Woordindex';
$SEARCH['HINT_WORDS']                        = 'Voor grote websites: een lijst van alle woorden, zodat een zoekopdracht niet meer de hele index hoeft te lezen. Wordt automatisch opgebouwd vanaf %s indexitems.';
$SEARCH['WORDS_INACTIVE']                    = 'Niet actief — de website ligt onder de drempel (%2$s indexitems, nu %1$s); het normale zoeken is snel genoeg.';
$SEARCH['WORDS_OFF']                         = 'Uitgeschakeld in de instellingen.';
$SEARCH['WORDS_BUILDING']                    = 'Wordt opgebouwd';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Verder opbouwen';
$SEARCH['MSG_WORDS_READY']                   = 'Woordindex compleet.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Woordindex: nog %d item open — tot dan wordt het normale zoeken gebruikt.',
    'other' => 'Woordindex: nog %d items open — tot dan wordt het normale zoeken gebruikt.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'In gebruik — %d woorditem.',
    'other' => 'In gebruik — %d woorditems.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Woordindex';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automatisch: alleen opgebouwd als de website de drempel hieronder bereikt. Kleine websites hebben hem niet nodig.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automatisch';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Altijd aan';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Uit';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Woordindex vanaf';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Aantal geïndexeerde items (secties en module-items) vanaf waar de woordindex automatisch wordt opgebouwd';
$SEARCH['BTN_DELETE_TERM']                   = 'Deze term verwijderen';
$SEARCH['MSG_TERM_DELETED']                  = 'Term verwijderd.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Semi-configuratie voor <b>%s</b> vooraf ingevuld uit search.php — controleer en pas aan.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Semi-configuratie voor \'%s\' opgeslagen.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Configuratie en indexitems voor %s verwijderd.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php gegenereerd. Bouw de index opnieuw op.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Configuratie en indexitems voor %s verwijderen?';
$SEARCH['STATUS_SEMI']                       = 'Semi-configuratie';
$SEARCH['LABEL_GUIDE']                       = 'Handleiding voor deze module tonen';
$SEARCH['LABEL_TABLE_HINT']                  = 'Tabel kiezen → kolommen worden automatisch geladen';
$SEARCH['LABEL_TABLE_SELECT']                = 'Tabel kiezen';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'WBCE-paginaanker';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Alleen doorzoekbare pagina\'s';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Alle secties (contentpool)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Alleen actieve items (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Tijdsturing (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joins (optioneel, max. 3) — gegevens uit extra tabellen';
$SEARCH['LABEL_GENERATE_DEF']                = 'module_defs-bestand genereren';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Uit search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Configuratie verwijderen';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Geen tekstkolommen';
$SEARCH['LABEL_ERROR']                       = 'Fout';
$SEARCH['LABEL_MODULE']                      = 'Module';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Niet doorzoekbaar';
$SEARCH['LABEL_HELP']                        = 'Help';
$SEARCH['BTN_CONFIGURE']                     = 'Configureren';
$SEARCH['BTN_CLOSE']                         = 'Sluiten';
$SEARCH['DEF_GENERATED']                     = 'gegenereerd';
$SEARCH['DEF_SHIPPED']                       = 'ingebouwd';
$SEARCH['LABEL_KIND']                        = 'Type';
$SEARCH['LABEL_INDEXING']                    = 'Indexering';
$SEARCH['LABEL_SECTIONS']                    = 'Secties';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filteren …';
$SEARCH['MODULES_SHOWN']                     = '%1$d van %2$d modules getoond';
$SEARCH['KIND_PAGE']                         = 'Paginamodules';
$SEARCH['KIND_SNIPPET']                      = 'Snippets';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filters';
$SEARCH['KIND_TOOL']                         = 'Beheertools';
$SEARCH['BADGE_PAGE']                        = 'Pagina';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filter';
$SEARCH['BADGE_TOOL']                        = 'Tool';
$SEARCH['GROUP_DEF']                         = 'met definitie';
$SEARCH['GROUP_OPEN']                        = 'onvolledig';
$SEARCH['GROUP_TITLE']                       = 'alleen paginatitel';
$SEARCH['SOURCE_MODULE']                     = 'Uit module';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Ingebouwd';
$SEARCH['SOURCE_GENERATED']                  = 'Semi-configuratie';
$SEARCH['SOURCE_SEMI']                       = 'Semi-configuratie – niet gegenereerd';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php gevonden';
$SEARCH['SOURCE_TITLE']                      = 'Alleen paginatitel';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'De module levert een eigen zoekdefinitie (search_index.php) — hier niet bewerkbaar.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Geïndexeerd via een PHP-callback — hier niet bewerkbaar.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definitie meegeleverd met WBCE Search (module_defs/). Een semi-configuratie gaat voor.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definitie gegenereerd uit de semi-configuratie.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Semi-configuratie opgeslagen, maar nog geen definitie gegenereerd.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Nog geen definitie — kan vooraf worden ingevuld uit de oude search.php van de module.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Geen definitie — de index bevat alleen de paginatitel.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Geen paginasecties — niets te indexeren.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Zoeken uitgeschakeld voor deze pagina';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Ingebouwde definitie. Opslaan maakt een semi-configuratie die voorgaat.';
$SEARCH['LABEL_TABLE']                       = 'Tabel';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tabellen van deze module';
$SEARCH['LABEL_OTHER_TABLES']                = 'Andere moduletabellen';
$SEARCH['HINT_TABLE']                        = 'Alleen mod_*-tabellen met een kolom section_id kunnen worden geïndexeerd.';
$SEARCH['LABEL_ID_FIELD']                    = 'ID-kolom';
$SEARCH['LABEL_ITEM_KEY']                    = 'Itemsleutel';
$SEARCH['HINT_ITEM_KEY']                     = 'Unieke sleutel per item (multimodus).';
$SEARCH['LABEL_TITLE_COL']                   = 'Titelkolom';
$SEARCH['LABEL_TEXT_COLS']                   = 'Tekstkolommen';
$SEARCH['LABEL_LINK_COL']                    = 'Linkkolom';
$SEARCH['HINT_LINK_PREFIX']                  = 'Optioneel voorvoegsel: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Afbeeldingskolom';
$SEARCH['HINT_IMAGE_PATH']                   = 'Pad onder /media, plaatshouders zoals {item_id} toegestaan.';
$SEARCH['LABEL_NONE']                        = 'geen';
$SEARCH['LABEL_MODE']                        = 'Modus';
$SEARCH['MODE_SINGLE']                       = 'Enkel — één item per sectie';
$SEARCH['MODE_MULTI']                        = 'Multi — één item per element';
$SEARCH['LABEL_INDEX_BASE']                  = 'Indexbasis';
$SEARCH['LABEL_FILTER']                      = 'Filter';
$SEARCH['LABEL_NO_JOIN']                     = 'geen join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Kies een geldige moduletabel.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'Geen bruikbare tabel gevonden in search.php van %s.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Geen pagina\'s',
    'one' => '%d pagina',
    'other' => '%d pagina\'s',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Opslaan';
$SEARCH['MSG_SECURITY_ERROR']                = 'Beveiligingscontrole mislukt.';
$SEARCH['STATUS_ACTIVE']                     = 'Actief';
$SEARCH['STATUS_INACTIVE']                   = 'Inactief';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'aan','al','alle','als','ben','bij','dan','dat','de','der','deze','die','dit',
    'doch','doen','door','dus','een','eens','en','er','ge','geen','had','heb',
    'hebben','heeft','hem','het','hier','hij','hoe','hun','ik','in','is','ja','je',
    'kan','kon','maar','me','meer','men','met','mij','mijn','moet','na','naar',
    'niet','niets','nog','nu','of','om','omdat','ons','ook','op','over','reeds',
    'te','tegen','toch','toen','tot','u','uit','uw','van','veel','voor','want',
    'waren','was','wat','we','wel','werd','wie','wij','wil','worden','zal','ze',
    'zei','zelf','zich','zij','zijn','zo','zonder','zou',
];
