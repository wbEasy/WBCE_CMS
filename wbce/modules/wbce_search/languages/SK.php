<?php
/**
 * wbce_search - languages/SK.php
 * Slovenčina
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Pokročilé nastavenia vyhľadávania. Index, moduly, šablóny a štatistiky vyhľadávania WBCE CMS: fulltextové vyhľadávanie s operátormi, živé návrhy, zvýraznenie výsledkov na cieľovej stránke a oblak značiek.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Hľadať';
$SEARCH['SEARCH_HEADING']                    = 'Vyhľadávanie';
$SEARCH['RESULTS_FOR']                       = 'Výsledky pre';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Žiadne výsledky',
    'one' => '%d výsledok',
    'few' => '%d výsledky',
    'many' => '%d výsledkov',
    'other' => '%d výsledkov',
];
$SEARCH['NO_RESULTS']                        = 'Nenašli sa žiadne výsledky.';
$SEARCH['ALL_WORDS']                         = 'Všetky slová';
$SEARCH['ANY_WORDS']                         = 'Ktorékoľvek slovo';
$SEARCH['EXACT_MATCH']                       = 'Presná fráza';
$SEARCH['MATCH']                             = 'Režim vyhľadávania';
$SEARCH['PAGES']                             = 'Stránky';
$SEARCH['TIPS_TITLE']                        = 'Tipy na vyhľadávanie:';
$SEARCH['TIP_FEWER']                         = 'Použite menej výrazov';
$SEARCH['TIP_OR']                            = 'Hľadanie ALEBO:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'inýVýraz';
$SEARCH['TIP_NOT']                           = 'Vylúčiť:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'vylúčiť';
$SEARCH['TIP_PHRASE']                        = 'Presná fráza:';
$SEARCH['TIP_WILDCARD']                      = 'Zástupný znak:';
$SEARCH['TIP_FUZZY']                         = 'Tolerovať preklepy:';
$SEARCH['DID_YOU_MEAN']                      = 'Mali ste na mysli:';
$SEARCH['SCOPE_TITLE']                       = 'Iba nadpis';
$SEARCH['SCOPE_CONTENT']                     = 'Iba obsah';
$SEARCH['SEARCH_OR']                         = 'Hľadanie ALEBO (aspoň jeden výraz)';
$SEARCH['AREAS_TITLE']                       = 'Prehľadávať podľa témy:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Často hľadané:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'hľadané raz',
    'few' => 'hľadané %d-krát',
    'many' => 'hľadané %d-krát',
    'other' => 'hľadané %d-krát',
];
$SEARCH['HIT_CONTENT']                       = 'Obsah';
$SEARCH['HIT_KEYWORD']                       = 'Kľúčové slovo';
$SEARCH['HIT_DESCRIPTION']                   = 'Popis';
$SEARCH['HIT_TITLE']                         = 'Nadpis';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Zástupný znak';
$SEARCH['LEGEND_FUZZY']                      = 'Tolerovať preklepy';
$SEARCH['LEGEND_PHRASE']                     = 'Presná fráza';
$SEARCH['LEGEND_EXCLUDE']                    = 'Vylúčiť výraz';
$SEARCH['LEGEND_OR']                         = 'Jeden z výrazov';
$SEARCH['LEGEND_COMBINATION']                = 'Kombinácia';
$SEARCH['LEGEND_OPERATORS']                  = 'Operátory';
$SEARCH['OP_EXCLUDE']                        = 'vylúčiť';
$SEARCH['OP_WILDCARD']                       = 'zástupný znak';
$SEARCH['OP_TYPOS']                          = 'preklepy';
$SEARCH['OP_PHRASE']                         = 'fráza';
$SEARCH['OP_OR']                             = 'alebo';
$SEARCH['EXAMPLE_WORD']                      = 'horčica';
$SEARCH['EXAMPLE_WORD2']                     = 'bio';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'pálivá';
$SEARCH['EXAMPLE_OR']                        = 'kečup';
$SEARCH['EXAMPLE_PHRASE']                    = 'žltá horčica';
$SEARCH['EXAMPLE_PHRASE2']                   = 'z kukurice';
$SEARCH['LABEL_LEGEND']                      = 'Legenda';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Výraz nájdený v obsahu stránky';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Výraz nájdený v kľúčových slovách stránky';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Výraz nájdený v popise stránky';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Výraz nájdený v nadpise';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Výraz v obsahu a kľúčových slovách';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Výraz v obsahu a popise';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Výraz v kľúčových slovách a popise';
$SEARCH['LEGEND_HIT_ALL']                    = 'Výraz vo všetkých troch poliach';
$SEARCH['PAGE_PREV']                         = 'Predchádzajúca stránka';
$SEARCH['PAGE_NEXT']                         = 'Nasledujúca stránka';
$SEARCH['DROPLET_DESCRIPTION']               = 'Oblak najhľadanejších výrazov. Parametre: max=20, min_count=1, desc=Popisok, active=true (false = skryté)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Prehľad';
$SEARCH['MENU_MODULES']                      = 'Moduly';
$SEARCH['MENU_LAYOUT']                       = 'Rozloženie';
$SEARCH['MENU_SETTINGS']                     = 'Nastavenia';
$SEARCH['MENU_STATS']                        = 'Štatistiky';
$SEARCH['CRUMB_OVERVIEW']                    = 'Stav a údržba vyhľadávacieho indexu';
$SEARCH['CRUMB_MODULES']                     = 'Ktoré moduly plnia vyhľadávací index';
$SEARCH['CRUMB_LAYOUT']                      = 'Šablóna stránky s výsledkami';
$SEARCH['CRUMB_SETTINGS']                    = 'Správanie vyhľadávania, živé vyhľadávanie, oblak štítkov';
$SEARCH['CRUMB_STATS']                       = 'Čo návštevníci hľadajú';
$SEARCH['LEDE_OVERVIEW']                     = 'Aktuálny stav vyhľadávacieho indexu a vyhľadávania na webe.';
$SEARCH['LEDE_MODULES']                      = 'Ako sa indexuje každý nainštalovaný modul. Moduly bez definície prispievajú iba nadpisom svojej stránky.';
$SEARCH['LEDE_LAYOUT']                       = 'Aké rozloženie a aký štýl používa stránka vyhľadávania a oblak štítkov. Dodávané súbory a súbory zo šablóny zostávajú nezmenené; vždy upravujete vlastnú kópiu.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Stránka s výsledkami';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Rozloženie stránky /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Oblak štítkov';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Rozloženie dropletu [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Štýl';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Pre stránku s výsledkami a oblak štítkov';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'CSS z %1$s sa zobrazí tu · „Upraviť“ vytvorí %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Bez štýlu';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'šablóna si prináša všetky štýly sama';
$SEARCH['LAYOUT_ACTIVE']                     = 'aktívne';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'vlastný súbor';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'zo šablóny „%s“';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'dodávaný';
$SEARCH['LAYOUT_READONLY']                   = 'iba na čítanie';
$SEARCH['LAYOUT_MODIFIED']                   = 'zmenené %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'súbor šablóny %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'dodávaný súbor %s';
$SEARCH['BTN_EDIT']                          = 'Upraviť';
$SEARCH['BTN_DELETE']                        = 'Zmazať';
$SEARCH['BTN_BACK']                          = 'Späť';
$SEARCH['BTN_SAVE_BACK']                     = 'Uložiť a späť';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Vytvorí sa nový súbor %1\$s ako kópia %2\$s.\n\nKópia sa upraví a stane sa aktívnym rozložením; originál zostane nezmenený.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s už existuje. Prepísať ho obsahom %2\$s a upraviť?\n\nVaša aktuálna verzia %1\$s sa stratí.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Zmazať %s?\n\nTúto akciu nemožno vrátiť.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Aktívne rozloženie: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s vytvorený';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s zmazaný';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Štýl: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Hodnotenie, úryvky, živé vyhľadávanie a oblak štítkov.';
$SEARCH['LEDE_STATS']                        = 'Hľadané výrazy zaznamenané pre oblak štítkov (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Vyhľadávací index';
$SEARCH['INDEX_BUILD']                       = 'Úplné prebudovanie';
$SEARCH['INDEX_UPDATE']                      = 'Aktualizovať zmeny';
$SEARCH['INDEX_CLEAR']                       = 'Vyprázdniť index';
$SEARCH['ENTRIES']                           = 'Záznamy';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Index vytvorený — nie je čo indexovať.',
    'one' => 'Index vytvorený: %d záznam.',
    'few' => 'Index vytvorený: %d záznamy.',
    'many' => 'Index vytvorený: %d záznamov.',
    'other' => 'Index vytvorený: %d záznamov.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Nie je čo aktualizovať.',
    'one' => 'Aktualizovaný %d záznam.',
    'few' => 'Aktualizované %d záznamy.',
    'many' => 'Aktualizovaných %d záznamov.',
    'other' => 'Aktualizovaných %d záznamov.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Index zmazaný.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Naozaj zmazať celý index?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Vyhľadávanie na webe';
$SEARCH['LABEL_LAST_INDEXED']                = 'Naposledy indexované';
$SEARCH['INDEX_BUILD_DESC']                  = 'Znovu načíta <b>všetky</b> prehľadávateľné sekcie. Na veľkých weboch to chvíľu trvá.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Načíta iba zmenené alebo chýbajúce sekcie. Rýchlejšie ako úplné prebudovanie.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Načíta iba zmenené alebo chýbajúce sekcie. Momentálne nie je čo robiť.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Vyprázdni index. Vyhľadávanie nič nenájde, kým sa znovu nevytvorí.';
$SEARCH['LABEL_FRESHNESS']                   = 'Aktuálnosť';
$SEARCH['FRESH_ALL']                         = '<b>Index je aktuálny</b> — všetkých %d sekcií zodpovedá svojej poslednej zmene.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d z %2$d</b> sekcií bolo zmenených alebo chýba.';
$SEARCH['FRESH_NONE']                        = 'Zatiaľ žiadne prehľadávateľné sekcie.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Vyhľadávanie na webe';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Nastavenia › Vyhľadávanie';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Verejné';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Registrovaní';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Súkromné';
$SEARCH['SITE_SEARCH_NONE']                  = 'Vypnuté';
$SEARCH['HINT_SITE_SEARCH']                  = 'Kto smie vyhľadávať — pre každé vyhľadávacie pole na webe, nech je za ním akékoľvek vyhľadávanie. Rovnaké nastavenie ako v <a href="%s">Nastavenia › Vyhľadávanie</a>; „Registrovaní“ aj „Súkromné“ znamenajú: iba prihlásení návštevníci.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Nastaviť vyhľadávanie na webe na „%s“?\n\nTým sa zmení nastavenie webu „Vyhľadávanie“ pre všetkých návštevníkov.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Vyhľadávanie na webe: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Jazyky';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Žiadne informácie o jazyku';
$SEARCH['VIS_HIDDEN']                        = 'Skryté';
$SEARCH['VIS_PUBLIC']                        = 'Verejné';
$SEARCH['VIS_PRIVATE']                       = 'Súkromné';
$SEARCH['VIS_REGISTERED']                    = 'Registrovaní';
$SEARCH['VIS_NONE']                          = 'Žiadne';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Rozloženie je prázdne a nebolo uložené.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Súbor search_custom.htt sa nepodarilo zapísať. Skontrolujte oprávnenia na zápis do priečinka layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Pri zaškrtnutom „AjaxSave“ ukladá Uložiť a Ctrl+S bez opätovného načítania stránky; „Uložiť a späť“ je potom skryté.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Minimálna dĺžka slova';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Kratšie slová sa ignorujú';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Váha nadpisu';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Zhody v nadpise × koeficient';
$SEARCH['SET_MAX_EXCERPT']                   = 'Max. dĺžka úryvku';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Znakov na úryvok';
$SEARCH['SET_HIGHLIGHT']                     = 'Zvýraznenie';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Zvýrazniť hľadané výrazy v úryvku';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Značka zvýraznenia';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'HTML značka použitá na zvýraznenie';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Výsledkov na stránku';
$SEARCH['SET_AUTO_REINDEX']                  = 'Automatická reindexácia pri hľadaní';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Pri každom hľadaní potichu aktualizuje zastarané záznamy';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Zobraziť oblak štítkov';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Na stránke vyhľadávania. Droplet má vlastný parameter active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Zaznamenávať hľadania';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Zaznamenáva hľadania pre oblak štítkov a štatistiky — vypnutie oblak neskryje';
$SEARCH['SET_AJAX_SUGGEST']                  = 'Živé vyhľadávanie AJAX';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Zobrazovať návrhy počas písania';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Režim ladenia';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Zobraziť technické údaje pod každým výsledkom (iba administrátori)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Šablóna stránky vyhľadávania';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Šablóna webu, v ktorej sa zobrazuje stránka /search/.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Predvolená šablóna webu (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Vyhľadávanie';
$SEARCH['GROUP_DISPLAY']                     = 'Zobrazenie výsledkov';
$SEARCH['GROUP_INDEX']                       = 'Údržba indexu';
$SEARCH['GROUP_LIVE']                        = 'Živé vyhľadávanie';
$SEARCH['GROUP_TAGCLOUD']                    = 'Oblak štítkov';
$SEARCH['GROUP_ADMIN']                       = 'Nástroj správy';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Veľkosť stránky zoznamu výsledkov';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Jazykový filter';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Zobraziť iba stránky v jazyku návštevníka (predvolený jazyk webu: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Rozšírené vyhľadávanie';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Zobraziť vo formulári začiarkavacie polia rozsahu a voľbu ALEBO';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Max. sekcií na hľadanie';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Limit automatickej reindexácie (riadenie záťaže)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Zdroj návrhov';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Hybridný režim najprv vypíše zhody v nadpisoch a doplní stránkami, ktoré slovo obsahujú v texte';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Max. návrhov';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Počet zobrazených návrhov';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Obrázky v návrhoch';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Zobrazí obrázok položky (katalóg, novinky …) vedľa návrhu, ak ho modul indexuje';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Max. štítkov';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Počet výrazov v oblaku štítkov';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min. hľadaní';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Minimálny počet hľadaní, kým sa výraz zobrazí';
$SEARCH['SET_NAV_STYLE']                     = 'Navigácia';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Záložky hore alebo lišta ikon vľavo';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Najprv nadpisy, doplnené z plného textu (odporúčané)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Nadpis + popis (rýchle)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Fulltextový index (dôkladné)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Záložky hore';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Bočný panel vľavo';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Koncový bod';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Na stránke vyhľadávania sa rozpozná automaticky pri poliach s názvom „string“, type="search" alebo triedou ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Nastavenia uložené.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Štatistiky vyhľadávania zmazané.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Naozaj zmazať všetky štatistiky?';
$SEARCH['STATS_DELETE']                      = 'Zmazať štatistiky';
$SEARCH['STATS_TERM']                        = 'Hľadaný výraz';
$SEARCH['STATS_COUNT']                       = 'Počet';
$SEARCH['STATS_LAST']                        = 'Naposledy hľadané';
$SEARCH['STATS_TERMS']                       = 'Výrazy';
$SEARCH['STATS_SEARCHES']                    = 'Hľadania';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 z %d výrazu.',
    'few' => 'Top 100 z %d výrazov.',
    'many' => 'Top 100 z %d výrazov.',
    'other' => 'Top 100 z %d výrazov.',
];
$SEARCH['STATS_EMPTY']                       = 'Zatiaľ neboli zaznamenané žiadne hľadané výrazy.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Hľadané, nič nenájdené';
$SEARCH['HINT_STATS_MISSES']                 = 'Celé hľadania bez výsledku — vodítko k obsahu, ktorý návštevníci očakávajú, ale nenachádzajú. Nikdy sa nezobrazuje verejne.';
$SEARCH['STATS_QUERY']                       = 'Dopyt';
$SEARCH['STATS_MISSES_EMPTY']                = 'Nezaznamenané žiadne hľadania bez výsledku.';
$SEARCH['CARD_WORDS']                        = 'Index slov';
$SEARCH['HINT_WORDS']                        = 'Pre veľké weby: zoznam všetkých slov, aby vyhľadávanie nemuselo čítať celý index. Vytvára sa automaticky od %s záznamov indexu.';
$SEARCH['WORDS_INACTIVE']                    = 'Neaktívny — web je pod prahom (%2$s záznamov indexu, teraz %1$s); bežné vyhľadávanie je dosť rýchle.';
$SEARCH['WORDS_OFF']                         = 'Vypnuté v nastaveniach.';
$SEARCH['WORDS_BUILDING']                    = 'Vytvára sa';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Pokračovať vo vytváraní';
$SEARCH['MSG_WORDS_READY']                   = 'Index slov je hotový.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Index slov: zostáva %d záznam — dovtedy sa používa bežné vyhľadávanie.',
    'few' => 'Index slov: zostávajú %d záznamy — dovtedy sa používa bežné vyhľadávanie.',
    'many' => 'Index slov: zostáva %d záznamov — dovtedy sa používa bežné vyhľadávanie.',
    'other' => 'Index slov: zostáva %d záznamov — dovtedy sa používa bežné vyhľadávanie.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'Používa sa — %d záznam slov.',
    'few' => 'Používa sa — %d záznamy slov.',
    'many' => 'Používa sa — %d záznamov slov.',
    'other' => 'Používa sa — %d záznamov slov.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Index slov';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automaticky: vytvorí sa iba vtedy, keď web dosiahne prah uvedený nižšie. Malé weby ho nepotrebujú.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automaticky';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Vždy zapnuté';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Vypnuté';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Index slov od';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Počet indexovaných záznamov (sekcie a položky modulov), od ktorého sa index slov vytvára automaticky';
$SEARCH['BTN_DELETE_TERM']                   = 'Odstrániť tento výraz';
$SEARCH['MSG_TERM_DELETED']                  = 'Výraz odstránený.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Polokonfigurácia pre <b>%s</b> predvyplnená zo search.php — skontrolujte a upravte.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Polokonfigurácia pre \'%s\' uložená.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Konfigurácia a záznamy indexu pre %s zmazané.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php vytvorený. Prebudujte prosím index.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Zmazať konfiguráciu a záznamy indexu pre %s?';
$SEARCH['STATUS_SEMI']                       = 'Polokonfigurácia';
$SEARCH['LABEL_GUIDE']                       = 'Zobraziť návod k tomuto modulu';
$SEARCH['LABEL_TABLE_HINT']                  = 'Vyberte tabuľku → stĺpce sa načítajú automaticky';
$SEARCH['LABEL_TABLE_SELECT']                = 'Vyberte tabuľku';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'Kotva stránky WBCE';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Iba prehľadávateľné stránky';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Všetky sekcie (zásobník obsahu)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Iba aktívne záznamy (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Časové riadenie (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joiny (voliteľné, max. 3) — údaje z ďalších tabuliek';
$SEARCH['LABEL_GENERATE_DEF']                = 'Vytvoriť súbor module_defs';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Zo search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Zmazať konfiguráciu';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Žiadne textové stĺpce';
$SEARCH['LABEL_ERROR']                       = 'Chyba';
$SEARCH['LABEL_MODULE']                      = 'Modul';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Neprehľadávateľné';
$SEARCH['LABEL_HELP']                        = 'Pomocník';
$SEARCH['BTN_CONFIGURE']                     = 'Konfigurovať';
$SEARCH['BTN_CLOSE']                         = 'Zavrieť';
$SEARCH['DEF_GENERATED']                     = 'vytvorené';
$SEARCH['DEF_SHIPPED']                       = 'vstavané';
$SEARCH['LABEL_KIND']                        = 'Typ';
$SEARCH['LABEL_INDEXING']                    = 'Indexovanie';
$SEARCH['LABEL_SECTIONS']                    = 'Sekcie';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtrovať …';
$SEARCH['MODULES_SHOWN']                     = 'Zobrazených %1$d z %2$d modulov';
$SEARCH['KIND_PAGE']                         = 'Moduly stránok';
$SEARCH['KIND_SNIPPET']                      = 'Snippety';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtre';
$SEARCH['KIND_TOOL']                         = 'Nástroje správy';
$SEARCH['BADGE_PAGE']                        = 'Stránka';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filter';
$SEARCH['BADGE_TOOL']                        = 'Nástroj';
$SEARCH['GROUP_DEF']                         = 's definíciou';
$SEARCH['GROUP_OPEN']                        = 'neúplné';
$SEARCH['GROUP_TITLE']                       = 'iba nadpis stránky';
$SEARCH['SOURCE_MODULE']                     = 'Z modulu';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Vstavané';
$SEARCH['SOURCE_GENERATED']                  = 'Polokonfigurácia';
$SEARCH['SOURCE_SEMI']                       = 'Polokonfigurácia – nevytvorené';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'Nájdený search.php';
$SEARCH['SOURCE_TITLE']                      = 'Iba nadpis stránky';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Modul prináša vlastnú definíciu vyhľadávania (search_index.php) — tu sa nedá upraviť.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indexované pomocou PHP callbacku — tu sa nedá upraviť.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definícia dodávaná s WBCE Search (module_defs/). Polokonfigurácia má prednosť.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definícia vytvorená z polokonfigurácie.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Polokonfigurácia uložená, ale definícia ešte nebola vytvorená.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Zatiaľ bez definície — dá sa predvyplniť zo starého search.php modulu.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Bez definície — index obsahuje iba nadpis stránky.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Žiadne sekcie stránok — nie je čo indexovať.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Vyhľadávanie je pre túto stránku vypnuté';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Vstavaná definícia. Uložením vznikne polokonfigurácia, ktorá má prednosť.';
$SEARCH['LABEL_TABLE']                       = 'Tabuľka';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tabuľky tohto modulu';
$SEARCH['LABEL_OTHER_TABLES']                = 'Ďalšie tabuľky modulov';
$SEARCH['HINT_TABLE']                        = 'Indexovať sa dajú iba tabuľky mod_* so stĺpcom section_id.';
$SEARCH['LABEL_ID_FIELD']                    = 'Stĺpec ID';
$SEARCH['LABEL_ITEM_KEY']                    = 'Kľúč položky';
$SEARCH['HINT_ITEM_KEY']                     = 'Jedinečný kľúč pre každú položku (režim viac).';
$SEARCH['LABEL_TITLE_COL']                   = 'Stĺpec nadpisu';
$SEARCH['LABEL_TEXT_COLS']                   = 'Textové stĺpce';
$SEARCH['LABEL_LINK_COL']                    = 'Stĺpec odkazu';
$SEARCH['HINT_LINK_PREFIX']                  = 'Voliteľná predpona: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Stĺpec obrázka';
$SEARCH['HINT_IMAGE_PATH']                   = 'Cesta pod /media, zástupné symboly ako {item_id} sú povolené.';
$SEARCH['LABEL_NONE']                        = 'žiadny';
$SEARCH['LABEL_MODE']                        = 'Režim';
$SEARCH['MODE_SINGLE']                       = 'Jeden — jeden záznam na sekciu';
$SEARCH['MODE_MULTI']                        = 'Viac — jeden záznam na položku';
$SEARCH['LABEL_INDEX_BASE']                  = 'Základ indexu';
$SEARCH['LABEL_FILTER']                      = 'Filter';
$SEARCH['LABEL_NO_JOIN']                     = 'bez joinu';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Vyberte prosím platnú tabuľku modulu.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'V search.php modulu %s sa nenašla použiteľná tabuľka.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Žiadne stránky',
    'one' => '%d stránka',
    'few' => '%d stránky',
    'many' => '%d stránok',
    'other' => '%d stránok',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Uložiť';
$SEARCH['MSG_SECURITY_ERROR']                = 'Bezpečnostná kontrola zlyhala.';
$SEARCH['STATUS_ACTIVE']                     = 'Aktívny';
$SEARCH['STATUS_INACTIVE']                   = 'Neaktívny';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'a','aby','aj','ak','ako','ale','alebo','ani','áno','až','bez','bol','bola',
    'boli','bolo','byť','by','čo','či','do','ho','i','ja','je','jeho','jej','ich',
    'jemu','k','kde','kedy','keď','kto','ktorá','ktoré','ktorí','ktorý','ku','lebo',
    'len','ma','mi','medzi','mňa','mne','my','na','nad','nám','nás','nie','niečo',
    'nič','o','od','on','ona','oni','ono','po','pod','podľa','pre','prečo','preto',
    'pretože','pred','pri','s','sa','si','sme','so','som','ste','sú','ta','tak',
    'takže','tam','te','teda','ten','to','toho','tom','tu','túto','ty','tie',
    'tieto','u','už','v','vám','vás','vo','však','všetko','vy','z','za','zo','že',
];
