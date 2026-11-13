<?php
/**
 * wbce_search - languages/SV.php
 * Svenska
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Avancerade sökinställningar. Index, moduler, layouter och statistik för sökningen i WBCE CMS: fulltextsökning med operatorer, förslag medan du skriver, markering av träffar på målsidan och taggmoln.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Sök';
$SEARCH['SEARCH_HEADING']                    = 'Sökning';
$SEARCH['RESULTS_FOR']                       = 'Resultat för';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Inga resultat',
    'one' => '%d resultat',
    'other' => '%d resultat',
];
$SEARCH['NO_RESULTS']                        = 'Inga resultat hittades.';
$SEARCH['ALL_WORDS']                         = 'Alla ord';
$SEARCH['ANY_WORDS']                         = 'Något av orden';
$SEARCH['EXACT_MATCH']                       = 'Exakt fras';
$SEARCH['MATCH']                             = 'Sökläge';
$SEARCH['PAGES']                             = 'Sidor';
$SEARCH['TIPS_TITLE']                        = 'Söktips:';
$SEARCH['TIP_FEWER']                         = 'Använd färre sökord';
$SEARCH['TIP_OR']                            = 'ELLER-sökning:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'annatOrd';
$SEARCH['TIP_NOT']                           = 'Uteslut:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'uteslut';
$SEARCH['TIP_PHRASE']                        = 'Exakt fras:';
$SEARCH['TIP_WILDCARD']                      = 'Jokertecken:';
$SEARCH['TIP_FUZZY']                         = 'Tillåt stavfel:';
$SEARCH['DID_YOU_MEAN']                      = 'Menade du:';
$SEARCH['SCOPE_TITLE']                       = 'Endast titel';
$SEARCH['SCOPE_CONTENT']                     = 'Endast innehåll';
$SEARCH['SEARCH_OR']                         = 'ELLER-sökning (minst ett ord)';
$SEARCH['AREAS_TITLE']                       = 'Bläddra efter ämne:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Ofta sökt:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'sökt en gång',
    'other' => 'sökt %d gånger',
];
$SEARCH['HIT_CONTENT']                       = 'Innehåll';
$SEARCH['HIT_KEYWORD']                       = 'Nyckelord';
$SEARCH['HIT_DESCRIPTION']                   = 'Beskrivning';
$SEARCH['HIT_TITLE']                         = 'Titel';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Jokertecken';
$SEARCH['LEGEND_FUZZY']                      = 'Tillåt stavfel';
$SEARCH['LEGEND_PHRASE']                     = 'Exakt fras';
$SEARCH['LEGEND_EXCLUDE']                    = 'Uteslut ord';
$SEARCH['LEGEND_OR']                         = 'Något av orden';
$SEARCH['LEGEND_COMBINATION']                = 'Kombination';
$SEARCH['LEGEND_OPERATORS']                  = 'Operatorer';
$SEARCH['OP_EXCLUDE']                        = 'uteslut';
$SEARCH['OP_WILDCARD']                       = 'joker';
$SEARCH['OP_TYPOS']                          = 'stavfel';
$SEARCH['OP_PHRASE']                         = 'fras';
$SEARCH['OP_OR']                             = 'eller';
$SEARCH['EXAMPLE_WORD']                      = 'senap';
$SEARCH['EXAMPLE_WORD2']                     = 'ekologisk';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'stark';
$SEARCH['EXAMPLE_OR']                        = 'ketchup';
$SEARCH['EXAMPLE_PHRASE']                    = 'gul senap';
$SEARCH['EXAMPLE_PHRASE2']                   = 'av majs';
$SEARCH['LABEL_LEGEND']                      = 'Förklaring';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Ordet hittades i sidans innehåll';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Ordet hittades i sidans nyckelord';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Ordet hittades i sidans beskrivning';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Ordet hittades i titeln';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Ord i innehåll och nyckelord';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Ord i innehåll och beskrivning';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Ord i nyckelord och beskrivning';
$SEARCH['LEGEND_HIT_ALL']                    = 'Ord i alla tre fälten';
$SEARCH['PAGE_PREV']                         = 'Föregående sida';
$SEARCH['PAGE_NEXT']                         = 'Nästa sida';
$SEARCH['DROPLET_DESCRIPTION']               = 'Taggmoln med de mest sökta orden. Parametrar: max=20, min_count=1, desc=Etikett, active=true (false = dold)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Översikt';
$SEARCH['MENU_MODULES']                      = 'Moduler';
$SEARCH['MENU_LAYOUT']                       = 'Layout';
$SEARCH['MENU_SETTINGS']                     = 'Inställningar';
$SEARCH['MENU_STATS']                        = 'Statistik';
$SEARCH['CRUMB_OVERVIEW']                    = 'Sökindexets status och underhåll';
$SEARCH['CRUMB_MODULES']                     = 'Vilka moduler som fyller sökindexet';
$SEARCH['CRUMB_LAYOUT']                      = 'Mall för resultatsidan';
$SEARCH['CRUMB_SETTINGS']                    = 'Sökbeteende, livesökning, taggmoln';
$SEARCH['CRUMB_STATS']                       = 'Vad besökarna söker efter';
$SEARCH['LEDE_OVERVIEW']                     = 'Aktuell status för sökindexet och sökningen på webbplatsen.';
$SEARCH['LEDE_MODULES']                      = 'Hur varje installerad modul indexeras. Moduler utan definition bidrar bara med sin sidtitel.';
$SEARCH['LEDE_LAYOUT']                       = 'Vilken layout och vilken stilmall söksidan och taggmolnet använder. Medföljande filer och filer från mallen lämnas oförändrade; du redigerar alltid din egen kopia.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Resultatsida';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Layout för sidan /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Taggmoln';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Layout för droplet [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Stilmall';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'För resultatsidan och taggmolnet';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'CSS från %1$s visas här · "Redigera" skapar %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Ingen stilmall';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'mallen har alla stilar själv';
$SEARCH['LAYOUT_ACTIVE']                     = 'aktiv';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'egen fil';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'från mallen "%s"';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'medföljande';
$SEARCH['LAYOUT_READONLY']                   = 'skrivskyddad';
$SEARCH['LAYOUT_MODIFIED']                   = 'ändrad %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'mallfilen %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'den medföljande filen %s';
$SEARCH['BTN_EDIT']                          = 'Redigera';
$SEARCH['BTN_DELETE']                        = 'Radera';
$SEARCH['BTN_BACK']                          = 'Tillbaka';
$SEARCH['BTN_SAVE_BACK']                     = 'Spara & tillbaka';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "En ny fil %1\$s skapas som kopia av %2\$s.\n\nKopian redigeras och blir den aktiva layouten; originalet lämnas oförändrat.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s finns redan. Skriva över den med innehållet i %2\$s och redigera den?\n\nDin nuvarande version av %1\$s går förlorad.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Radera %s?\n\nDetta kan inte ångras.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Aktiv layout: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s skapad';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s raderad';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Stilmall: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Viktning, utdrag, livesökning och taggmoln.';
$SEARCH['LEDE_STATS']                        = 'Sökord som registrerats för taggmolnet (topp 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Sökindex';
$SEARCH['INDEX_BUILD']                       = 'Fullständig ombyggnad';
$SEARCH['INDEX_UPDATE']                      = 'Uppdatera ändringar';
$SEARCH['INDEX_CLEAR']                       = 'Töm index';
$SEARCH['ENTRIES']                           = 'Poster';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Index byggt — inget att indexera.',
    'one' => 'Index byggt: %d post.',
    'other' => 'Index byggt: %d poster.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Inget att uppdatera.',
    'one' => '%d post uppdaterad.',
    'other' => '%d poster uppdaterade.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Index raderat.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Vill du verkligen radera hela indexet?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Sökning på webbplatsen';
$SEARCH['LABEL_LAST_INDEXED']                = 'Senast indexerad';
$SEARCH['INDEX_BUILD_DESC']                  = 'Läser <b>alla</b> sökbara sektioner igen. Tar tid på stora webbplatser.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Läser bara ändrade eller saknade sektioner. Snabbare än en fullständig ombyggnad.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Läser bara ändrade eller saknade sektioner. Inget att göra just nu.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Tömmer indexet. Sökningen hittar ingenting förrän det byggts om.';
$SEARCH['LABEL_FRESHNESS']                   = 'Aktualitet';
$SEARCH['FRESH_ALL']                         = '<b>Indexet är aktuellt</b> — alla %d sektioner stämmer med sin senaste ändring.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d av %2$d</b> sektioner har ändrats eller saknas.';
$SEARCH['FRESH_NONE']                        = 'Ännu inga sökbara sektioner.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Sökning på webbplatsen';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Inställningar › Sökning';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Offentlig';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Registrerade';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privat';
$SEARCH['SITE_SEARCH_NONE']                  = 'Av';
$SEARCH['HINT_SITE_SEARCH']                  = 'Vem som får söka — för varje sökfält på webbplatsen, oavsett vilken sökning som ligger bakom. Samma inställning som under <a href="%s">Inställningar › Sökning</a>; "Registrerade" och "Privat" betyder båda: endast inloggade besökare.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Ställ in sökningen på webbplatsen till \"%s\"?\n\nDetta ändrar webbplatsens inställning \"Sökning\" för alla besökare.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Sökning på webbplatsen: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Språk';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Ingen språkinformation';
$SEARCH['VIS_HIDDEN']                        = 'Dold';
$SEARCH['VIS_PUBLIC']                        = 'Offentlig';
$SEARCH['VIS_PRIVATE']                       = 'Privat';
$SEARCH['VIS_REGISTERED']                    = 'Registrerade';
$SEARCH['VIS_NONE']                          = 'Ingen';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Layouten är tom och sparades inte.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Kunde inte skriva search_custom.htt. Kontrollera skrivrättigheterna för mappen layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'När "AjaxSave" är ikryssat sparar Spara och Ctrl+S utan att ladda om sidan; "Spara & tillbaka" döljs då.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Minsta ordlängd';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Kortare ord ignoreras';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Titelviktning';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Träffar i titeln × faktor';
$SEARCH['SET_MAX_EXCERPT']                   = 'Max. utdragslängd';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Tecken per utdrag';
$SEARCH['SET_HIGHLIGHT']                     = 'Markering';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Markera sökorden i utdraget';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Markeringstagg';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'HTML-tagg som används för markeringen';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Resultat per sida';
$SEARCH['SET_AUTO_REINDEX']                  = 'Automatisk omindexering vid sökning';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Uppdaterar inaktuella poster i tysthet vid varje sökning';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Visa taggmoln';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'På söksidan. Droplet har en egen parameter active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Registrera sökningar';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Registrerar sökningar för taggmolnet och statistiken — att stänga av döljer inte molnet';
$SEARCH['SET_AJAX_SUGGEST']                  = 'AJAX livesökning';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Visa förslag medan du skriver';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Felsökningsläge';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Visa tekniska data under varje sökresultat (endast administratörer)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Mall för söksidan';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Frontend-mall som sidan /search/ visas i.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Webbplatsens standardmall (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Sökning';
$SEARCH['GROUP_DISPLAY']                     = 'Visning av resultat';
$SEARCH['GROUP_INDEX']                       = 'Indexunderhåll';
$SEARCH['GROUP_LIVE']                        = 'Livesökning';
$SEARCH['GROUP_TAGCLOUD']                    = 'Taggmoln';
$SEARCH['GROUP_ADMIN']                       = 'Adminverktyg';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Sidstorlek för resultatlistan';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Språkfilter';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Visa bara sidor på besökarens språk (webbplatsens standard: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Avancerad sökning';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Visa kryssrutor för sökområde och ELLER-alternativ i sökformuläret';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Max. sektioner per sökning';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Gräns för automatisk omindexering (belastningskontroll)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Källa för förslag';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Hybrid visar först titelträffar och fyller på med sidor som innehåller ordet i sin text';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Max. förslag';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Antal förslag som visas';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Bilder i förslag';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Visar objektets bild (katalog, nyheter …) bredvid förslaget, om modulen indexerar en';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Max. taggar';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Antal ord som visas i taggmolnet';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min. sökningar';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Minsta antal sökningar innan ett ord visas';
$SEARCH['SET_NAV_STYLE']                     = 'Navigering';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Flikar överst eller en ikonlist till vänster';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Titlar först, kompletterat från fulltexten (rekommenderas)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Titel + beskrivning (snabb)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Fulltextindex (grundlig)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Flikar överst';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Sidofält till vänster';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Endpoint';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Identifieras automatiskt på söksidan för fält med namnet "string", type="search" eller klassen ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Inställningar sparade.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Sökstatistik raderad.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Vill du verkligen radera all statistik?';
$SEARCH['STATS_DELETE']                      = 'Radera statistik';
$SEARCH['STATS_TERM']                        = 'Sökord';
$SEARCH['STATS_COUNT']                       = 'Antal';
$SEARCH['STATS_LAST']                        = 'Senast sökt';
$SEARCH['STATS_TERMS']                       = 'Ord';
$SEARCH['STATS_SEARCHES']                    = 'Sökningar';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Topp 100 av %d ord.',
    'other' => 'Topp 100 av %d ord.',
];
$SEARCH['STATS_EMPTY']                       = 'Inga sökord registrerade ännu.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Sökt, inget hittat';
$SEARCH['HINT_STATS_MISSES']                 = 'Hela sökningar utan resultat — en ledtråd om innehåll som dina besökare förväntar sig men inte hittar. Visas aldrig offentligt.';
$SEARCH['STATS_QUERY']                       = 'Sökning';
$SEARCH['STATS_MISSES_EMPTY']                = 'Inga sökningar utan resultat registrerade.';
$SEARCH['CARD_WORDS']                        = 'Ordindex';
$SEARCH['HINT_WORDS']                        = 'För stora webbplatser: en lista över alla ord, så att en sökning inte längre behöver läsa hela indexet. Byggs automatiskt från %s indexposter.';
$SEARCH['WORDS_INACTIVE']                    = 'Inte aktivt — webbplatsen ligger under tröskeln (%2$s indexposter, för närvarande %1$s); den vanliga sökningen är snabb nog.';
$SEARCH['WORDS_OFF']                         = 'Avstängt i inställningarna.';
$SEARCH['WORDS_BUILDING']                    = 'Byggs';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Fortsätt bygga';
$SEARCH['MSG_WORDS_READY']                   = 'Ordindex klart.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Ordindex: %d post återstår — tills dess används den vanliga sökningen.',
    'other' => 'Ordindex: %d poster återstår — tills dess används den vanliga sökningen.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'I bruk — %d ordpost.',
    'other' => 'I bruk — %d ordposter.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Ordindex';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automatiskt: byggs bara när webbplatsen når tröskeln nedan. Små webbplatser behöver det inte.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automatiskt';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Alltid på';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Av';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Ordindex från';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Antal indexerade poster (sektioner och modulobjekt) från vilket ordindexet byggs automatiskt';
$SEARCH['BTN_DELETE_TERM']                   = 'Ta bort detta ord';
$SEARCH['MSG_TERM_DELETED']                  = 'Ord borttaget.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Semikonfiguration för <b>%s</b> förifylld från search.php — kontrollera och justera.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Semikonfiguration för \'%s\' sparad.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Konfiguration och indexposter för %s raderade.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php genererad. Bygg om indexet.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Radera konfiguration och indexposter för %s?';
$SEARCH['STATUS_SEMI']                       = 'Semikonfiguration';
$SEARCH['LABEL_GUIDE']                       = 'Visa guide för denna modul';
$SEARCH['LABEL_TABLE_HINT']                  = 'Välj tabell → kolumnerna laddas automatiskt';
$SEARCH['LABEL_TABLE_SELECT']                = 'Välj tabell';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'WBCE-sidankare';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Endast sökbara sidor';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Alla sektioner (innehållspool)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Endast aktiva poster (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Tidsstyrning (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joins (valfritt, max. 3) — data från ytterligare tabeller';
$SEARCH['LABEL_GENERATE_DEF']                = 'Generera module_defs-fil';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Från search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Radera konfiguration';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Inga textkolumner';
$SEARCH['LABEL_ERROR']                       = 'Fel';
$SEARCH['LABEL_MODULE']                      = 'Modul';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Inte sökbar';
$SEARCH['LABEL_HELP']                        = 'Hjälp';
$SEARCH['BTN_CONFIGURE']                     = 'Konfigurera';
$SEARCH['BTN_CLOSE']                         = 'Stäng';
$SEARCH['DEF_GENERATED']                     = 'genererad';
$SEARCH['DEF_SHIPPED']                       = 'inbyggd';
$SEARCH['LABEL_KIND']                        = 'Typ';
$SEARCH['LABEL_INDEXING']                    = 'Indexering';
$SEARCH['LABEL_SECTIONS']                    = 'Sektioner';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtrera …';
$SEARCH['MODULES_SHOWN']                     = '%1$d av %2$d moduler visas';
$SEARCH['KIND_PAGE']                         = 'Sidmoduler';
$SEARCH['KIND_SNIPPET']                      = 'Snippets';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filter';
$SEARCH['KIND_TOOL']                         = 'Adminverktyg';
$SEARCH['BADGE_PAGE']                        = 'Sida';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filter';
$SEARCH['BADGE_TOOL']                        = 'Verktyg';
$SEARCH['GROUP_DEF']                         = 'med definition';
$SEARCH['GROUP_OPEN']                        = 'ofullständig';
$SEARCH['GROUP_TITLE']                       = 'endast sidtitel';
$SEARCH['SOURCE_MODULE']                     = 'Från modul';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Inbyggd';
$SEARCH['SOURCE_GENERATED']                  = 'Semikonfiguration';
$SEARCH['SOURCE_SEMI']                       = 'Semikonfiguration – ej genererad';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php hittad';
$SEARCH['SOURCE_TITLE']                      = 'Endast sidtitel';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Modulen har en egen sökdefinition (search_index.php) — kan inte redigeras här.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indexeras via en PHP-callback — kan inte redigeras här.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definition som följer med WBCE Search (module_defs/). En semikonfiguration har företräde.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definition genererad från semikonfigurationen.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Semikonfiguration sparad, men ingen definition genererad ännu.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Ingen definition ännu — kan förifyllas från modulens gamla search.php.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Ingen definition — indexet innehåller bara sidtiteln.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Inga sidsektioner — inget att indexera.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Sökning avstängd för denna sida';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Inbyggd definition. När du sparar skapas en semikonfiguration som har företräde.';
$SEARCH['LABEL_TABLE']                       = 'Tabell';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tabeller i denna modul';
$SEARCH['LABEL_OTHER_TABLES']                = 'Andra modultabeller';
$SEARCH['HINT_TABLE']                        = 'Endast mod_*-tabeller med en kolumn section_id kan indexeras.';
$SEARCH['LABEL_ID_FIELD']                    = 'ID-kolumn';
$SEARCH['LABEL_ITEM_KEY']                    = 'Objektnyckel';
$SEARCH['HINT_ITEM_KEY']                     = 'Unik nyckel per objekt (multiläge).';
$SEARCH['LABEL_TITLE_COL']                   = 'Titelkolumn';
$SEARCH['LABEL_TEXT_COLS']                   = 'Textkolumner';
$SEARCH['LABEL_LINK_COL']                    = 'Länkkolumn';
$SEARCH['HINT_LINK_PREFIX']                  = 'Valfritt prefix: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Bildkolumn';
$SEARCH['HINT_IMAGE_PATH']                   = 'Sökväg under /media, platshållare som {item_id} tillåtna.';
$SEARCH['LABEL_NONE']                        = 'ingen';
$SEARCH['LABEL_MODE']                        = 'Läge';
$SEARCH['MODE_SINGLE']                       = 'Enkel — en post per sektion';
$SEARCH['MODE_MULTI']                        = 'Multi — en post per objekt';
$SEARCH['LABEL_INDEX_BASE']                  = 'Indexbas';
$SEARCH['LABEL_FILTER']                      = 'Filter';
$SEARCH['LABEL_NO_JOIN']                     = 'ingen join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Välj en giltig modultabell.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'Ingen användbar tabell hittades i search.php för %s.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Inga sidor',
    'one' => '%d sida',
    'other' => '%d sidor',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Spara';
$SEARCH['MSG_SECURITY_ERROR']                = 'Säkerhetskontrollen misslyckades.';
$SEARCH['STATUS_ACTIVE']                     = 'Aktiv';
$SEARCH['STATUS_INACTIVE']                   = 'Inaktiv';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'alla','allt','att','av','blev','bli','blir','de','dem','den','denna','deras',
    'dess','det','detta','dig','din','dina','ditt','du','där','efter','ej','eller',
    'en','er','era','ert','ett','från','för','ha','hade','han','hans','har','henne',
    'hennes','hon','honom','hur','här','i','icke','ingen','inom','inte','jag','ju',
    'kan','kunde','man','med','mellan','men','mig','min','mina','mitt','mot',
    'mycket','ni','nu','när','någon','något','några','och','om','oss','på','samma',
    'sedan','sig','sin','sina','sitt','själv','skulle','som','så','sådan','till',
    'under','upp','ut','utan','vad','var','vara','varit','vi','vid','vilken','vår',
    'våra','vårt','än','är','över',
];
