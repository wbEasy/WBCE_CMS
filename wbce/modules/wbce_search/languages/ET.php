<?php
/**
 * wbce_search - languages/ET.php
 * Eesti
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Täpsemad otsingu seaded. WBCE CMS-i otsingu indeks, moodulid, paigutused ja statistika: täistekstotsing operaatoritega, reaalajas soovitused, vastete esiletõstmine sihtlehel ja märksõnapilv.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Otsi';
$SEARCH['SEARCH_HEADING']                    = 'Otsing';
$SEARCH['RESULTS_FOR']                       = 'Tulemused päringule';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Tulemusi pole',
    'one' => '%d tulemus',
    'other' => '%d tulemust',
];
$SEARCH['NO_RESULTS']                        = 'Tulemusi ei leitud.';
$SEARCH['ALL_WORDS']                         = 'Kõik sõnad';
$SEARCH['ANY_WORDS']                         = 'Mõni sõna';
$SEARCH['EXACT_MATCH']                       = 'Täpne fraas';
$SEARCH['MATCH']                             = 'Otsingurežiim';
$SEARCH['PAGES']                             = 'Lehed';
$SEARCH['TIPS_TITLE']                        = 'Otsingunõuanded:';
$SEARCH['TIP_FEWER']                         = 'Kasuta vähem otsingusõnu';
$SEARCH['TIP_OR']                            = 'VÕI-otsing:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'teineSõna';
$SEARCH['TIP_NOT']                           = 'Välista:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'välista';
$SEARCH['TIP_PHRASE']                        = 'Täpne fraas:';
$SEARCH['TIP_WILDCARD']                      = 'Metamärk:';
$SEARCH['TIP_FUZZY']                         = 'Luba trükivigu:';
$SEARCH['DID_YOU_MEAN']                      = 'Kas mõtlesid:';
$SEARCH['SCOPE_TITLE']                       = 'Ainult pealkiri';
$SEARCH['SCOPE_CONTENT']                     = 'Ainult sisu';
$SEARCH['SEARCH_OR']                         = 'VÕI-otsing (vähemalt üks sõna)';
$SEARCH['AREAS_TITLE']                       = 'Sirvi teemade kaupa:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Sageli otsitud:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'otsitud üks kord',
    'other' => 'otsitud %d korda',
];
$SEARCH['HIT_CONTENT']                       = 'Sisu';
$SEARCH['HIT_KEYWORD']                       = 'Märksõna';
$SEARCH['HIT_DESCRIPTION']                   = 'Kirjeldus';
$SEARCH['HIT_TITLE']                         = 'Pealkiri';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Metamärk';
$SEARCH['LEGEND_FUZZY']                      = 'Luba trükivigu';
$SEARCH['LEGEND_PHRASE']                     = 'Täpne fraas';
$SEARCH['LEGEND_EXCLUDE']                    = 'Välista sõna';
$SEARCH['LEGEND_OR']                         = 'Üks või teine sõna';
$SEARCH['LEGEND_COMBINATION']                = 'Kombinatsioon';
$SEARCH['LEGEND_OPERATORS']                  = 'Operaatorid';
$SEARCH['OP_EXCLUDE']                        = 'välista';
$SEARCH['OP_WILDCARD']                       = 'metamärk';
$SEARCH['OP_TYPOS']                          = 'trükivead';
$SEARCH['OP_PHRASE']                         = 'fraas';
$SEARCH['OP_OR']                             = 'või';
$SEARCH['EXAMPLE_WORD']                      = 'sinep';
$SEARCH['EXAMPLE_WORD2']                     = 'mahe';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'terav';
$SEARCH['EXAMPLE_OR']                        = 'ketšup';
$SEARCH['EXAMPLE_PHRASE']                    = 'kollane sinep';
$SEARCH['EXAMPLE_PHRASE2']                   = 'maisist';
$SEARCH['LABEL_LEGEND']                      = 'Legend';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Sõna leiti lehe sisust';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Sõna leiti lehe märksõnadest';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Sõna leiti lehe kirjeldusest';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Sõna leiti pealkirjast';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Sõna sisus ja märksõnades';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Sõna sisus ja kirjelduses';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Sõna märksõnades ja kirjelduses';
$SEARCH['LEGEND_HIT_ALL']                    = 'Sõna kõigis kolmes väljas';
$SEARCH['PAGE_PREV']                         = 'Eelmine leht';
$SEARCH['PAGE_NEXT']                         = 'Järgmine leht';
$SEARCH['DROPLET_DESCRIPTION']               = 'Enim otsitud sõnade pilv. Parameetrid: max=20, min_count=1, desc=Silt, active=true (false = peidetud)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Ülevaade';
$SEARCH['MENU_MODULES']                      = 'Moodulid';
$SEARCH['MENU_LAYOUT']                       = 'Paigutus';
$SEARCH['MENU_SETTINGS']                     = 'Seaded';
$SEARCH['MENU_STATS']                        = 'Statistika';
$SEARCH['CRUMB_OVERVIEW']                    = 'Otsinguindeksi olek ja hooldus';
$SEARCH['CRUMB_MODULES']                     = 'Millised moodulid täidavad otsinguindeksit';
$SEARCH['CRUMB_LAYOUT']                      = 'Tulemuste lehe mall';
$SEARCH['CRUMB_SETTINGS']                    = 'Otsingu käitumine, kiirotsing, märksõnapilv';
$SEARCH['CRUMB_STATS']                       = 'Mida külastajad otsivad';
$SEARCH['LEDE_OVERVIEW']                     = 'Otsinguindeksi ja veebilehe otsingu praegune olek.';
$SEARCH['LEDE_MODULES']                      = 'Kuidas iga paigaldatud moodulit indekseeritakse. Ilma definitsioonita moodulid annavad ainult oma lehe pealkirja.';
$SEARCH['LEDE_LAYOUT']                       = 'Millist paigutust ja stiililehte kasutavad otsinguleht ja märksõnapilv. Kaasasolevad failid ja malli failid jäävad muutmata; muudad alati oma koopiat.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Tulemuste leht';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Lehe /search/ paigutus';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Märksõnapilv';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Dropleti [[wbce_search_tagcloud]] paigutus';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Stiileht';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Tulemuste lehele ja märksõnapilvele';
$SEARCH['LAYOUT_CSS_LEDE']                   = '%1$s CSS kuvatakse siin · „Muuda” loob faili %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Stiililehte pole';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'mall toob kõik stiilid ise';
$SEARCH['LAYOUT_ACTIVE']                     = 'aktiivne';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'oma fail';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'mallist „%s”';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'kaasasolev';
$SEARCH['LAYOUT_READONLY']                   = 'kirjutuskaitstud';
$SEARCH['LAYOUT_MODIFIED']                   = 'muudetud %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'malli fail %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'kaasasolev fail %s';
$SEARCH['BTN_EDIT']                          = 'Muuda';
$SEARCH['BTN_DELETE']                        = 'Kustuta';
$SEARCH['BTN_BACK']                          = 'Tagasi';
$SEARCH['BTN_SAVE_BACK']                     = 'Salvesta ja tagasi';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Luuakse uus fail %1\$s faili %2\$s koopiana.\n\nKoopiat muudetakse ja sellest saab aktiivne paigutus; originaal jääb muutmata.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s on juba olemas. Kas kirjutada see üle faili %2\$s sisuga ja muuta?\n\nSinu praegune %1\$s versioon läheb kaotsi.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Kas kustutada %s?\n\nSeda ei saa tagasi võtta.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Aktiivne paigutus: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s loodud';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s kustutatud';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Stiileht: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Punktiarvestus, väljavõtted, kiirotsing ja märksõnapilv.';
$SEARCH['LEDE_STATS']                        = 'Märksõnapilve jaoks salvestatud otsingusõnad (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Otsinguindeks';
$SEARCH['INDEX_BUILD']                       = 'Täielik ülesehitus';
$SEARCH['INDEX_UPDATE']                      = 'Uuenda muudatused';
$SEARCH['INDEX_CLEAR']                       = 'Tühjenda indeks';
$SEARCH['ENTRIES']                           = 'Kirjed';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Indeks loodud — pole midagi indekseerida.',
    'one' => 'Indeks loodud: %d kirje.',
    'other' => 'Indeks loodud: %d kirjet.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Pole midagi uuendada.',
    'one' => '%d kirje uuendatud.',
    'other' => '%d kirjet uuendatud.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Indeks kustutatud.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Kas tõesti kustutada kogu indeks?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Veebilehe otsing';
$SEARCH['LABEL_LAST_INDEXED']                = 'Viimati indekseeritud';
$SEARCH['INDEX_BUILD_DESC']                  = 'Loeb <b>kõik</b> otsitavad sektsioonid uuesti. Suurtel veebilehtedel võtab aega.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Loeb ainult muudetud või puuduvad sektsioonid. Kiirem kui täielik ülesehitus.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Loeb ainult muudetud või puuduvad sektsioonid. Praegu pole midagi teha.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Tühjendab indeksi. Otsing ei leia midagi enne, kui see on uuesti üles ehitatud.';
$SEARCH['LABEL_FRESHNESS']                   = 'Ajakohasus';
$SEARCH['FRESH_ALL']                         = '<b>Indeks on ajakohane</b> — kõik %d sektsiooni vastavad viimasele muudatusele.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d / %2$d</b> sektsiooni on muudetud või puudu.';
$SEARCH['FRESH_NONE']                        = 'Otsitavaid sektsioone veel pole.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Veebilehe otsing';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Seaded › Otsing';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Avalik';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Registreeritud';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privaatne';
$SEARCH['SITE_SEARCH_NONE']                  = 'Väljas';
$SEARCH['HINT_SITE_SEARCH']                  = 'Kes tohib otsida — iga veebilehe otsinguvälja jaoks, ükskõik milline otsing selle taga on. Sama seade nagu jaotises <a href="%s">Seaded › Otsing</a>; „Registreeritud” ja „Privaatne” tähendavad mõlemad: ainult sisseloginud külastajad.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Kas seada veebilehe otsing olekusse „%s”?\n\nSee muudab veebilehe seadet „Otsing” kõigi külastajate jaoks.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Veebilehe otsing: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Keeled';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Keeleteave puudub';
$SEARCH['VIS_HIDDEN']                        = 'Peidetud';
$SEARCH['VIS_PUBLIC']                        = 'Avalik';
$SEARCH['VIS_PRIVATE']                       = 'Privaatne';
$SEARCH['VIS_REGISTERED']                    = 'Registreeritud';
$SEARCH['VIS_NONE']                          = 'Puudub';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Paigutus on tühi ja seda ei salvestatud.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Faili search_custom.htt ei saanud kirjutada. Kontrolli kausta layouts kirjutusõigusi.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Kui „AjaxSave” on märgitud, salvestavad Salvesta ja Ctrl+S lehte uuesti laadimata; „Salvesta ja tagasi” peidetakse siis.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Minimaalne sõnapikkus';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Lühemaid sõnu eiratakse';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Pealkirja kaal';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Vasted pealkirjas × tegur';
$SEARCH['SET_MAX_EXCERPT']                   = 'Väljavõtte max pikkus';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Märke väljavõtte kohta';
$SEARCH['SET_HIGHLIGHT']                     = 'Esiletõstmine';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Tõsta otsingusõnad väljavõttes esile';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Esiletõstmise silt';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'Esiletõstmiseks kasutatav HTML-silt';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Tulemusi lehel';
$SEARCH['SET_AUTO_REINDEX']                  = 'Automaatne uuesti indekseerimine otsingul';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Uuendab aegunud kirjeid vaikselt iga otsingu ajal';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Näita märksõnapilve';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Otsingulehel. Dropletil on oma parameeter active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Salvesta otsingud';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Salvestab otsingud märksõnapilve ja statistika jaoks — väljalülitamine ei peida pilve';
$SEARCH['SET_AJAX_SUGGEST']                  = 'AJAX kiirotsing';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Näita kirjutamise ajal soovitusi';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Silumisrežiim';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Näita iga otsingutulemuse all tehnilisi andmeid (ainult administraatorid)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Otsingulehe mall';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Frontendi mall, milles lehte /search/ näidatakse.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Veebilehe vaikemall (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Otsing';
$SEARCH['GROUP_DISPLAY']                     = 'Tulemuste kuvamine';
$SEARCH['GROUP_INDEX']                       = 'Indeksi hooldus';
$SEARCH['GROUP_LIVE']                        = 'Kiirotsing';
$SEARCH['GROUP_TAGCLOUD']                    = 'Märksõnapilv';
$SEARCH['GROUP_ADMIN']                       = 'Haldustööriist';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Tulemuste lehe suurus';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Keelefilter';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Näita ainult külastaja keeles lehti (veebilehe vaikimisi: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Täpsem otsing';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Näita otsinguvormis ulatuse märkeruute ja VÕI-valikut';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Max sektsioone otsingu kohta';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Automaatse uuesti indekseerimise piir (koormuse kontroll)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Soovituste allikas';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Hübriid näitab esmalt pealkirja vasteid ja täiendab lehtedega, mille tekstis sõna esineb';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Max soovitusi';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Näidatavate soovituste arv';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Pildid soovitustes';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Näitab elemendi pilti (kataloog, uudised …) soovituse kõrval, kui moodul seda indekseerib';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Max märksõnu';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Pilves näidatavate sõnade arv';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min otsinguid';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Otsingute minimaalne arv, enne kui sõna ilmub';
$SEARCH['SET_NAV_STYLE']                     = 'Navigeerimine';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Vahelehed üleval või ikooniriba vasakul';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Kõigepealt pealkirjad, täiendatud täistekstist (soovitatav)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Pealkiri + kirjeldus (kiire)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Täistekstiindeks (põhjalik)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Vahelehed üleval';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Külgriba vasakul';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Lõpp-punkt';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Tuvastatakse otsingulehel automaatselt väljadel, mille nimi on „string”, type="search" või klass ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Seaded salvestatud.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Otsingustatistika kustutatud.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Kas tõesti kustutada kogu statistika?';
$SEARCH['STATS_DELETE']                      = 'Kustuta statistika';
$SEARCH['STATS_TERM']                        = 'Otsingusõna';
$SEARCH['STATS_COUNT']                       = 'Arv';
$SEARCH['STATS_LAST']                        = 'Viimati otsitud';
$SEARCH['STATS_TERMS']                       = 'Sõnad';
$SEARCH['STATS_SEARCHES']                    = 'Otsingud';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 / %d sõna.',
    'other' => 'Top 100 / %d sõna.',
];
$SEARCH['STATS_EMPTY']                       = 'Otsingusõnu pole veel salvestatud.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Otsitud, midagi ei leitud';
$SEARCH['HINT_STATS_MISSES']                 = 'Terved otsingud ilma tulemuseta — vihje sisule, mida külastajad ootavad, kuid ei leia. Ei näidata kunagi avalikult.';
$SEARCH['STATS_QUERY']                       = 'Päring';
$SEARCH['STATS_MISSES_EMPTY']                = 'Tulemuseta otsinguid pole salvestatud.';
$SEARCH['CARD_WORDS']                        = 'Sõnaindeks';
$SEARCH['HINT_WORDS']                        = 'Suurtele veebilehtedele: kõigi sõnade loend, et otsing ei peaks enam kogu indeksit läbi lugema. Luuakse automaatselt alates %s indeksikirjest.';
$SEARCH['WORDS_INACTIVE']                    = 'Pole aktiivne — veebileht on alla läve (%2$s indeksikirjet, praegu %1$s); tavaline otsing on piisavalt kiire.';
$SEARCH['WORDS_OFF']                         = 'Seadetes välja lülitatud.';
$SEARCH['WORDS_BUILDING']                    = 'Ehitamisel';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Jätka ehitamist';
$SEARCH['MSG_WORDS_READY']                   = 'Sõnaindeks valmis.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Sõnaindeks: %d kirje veel ootel — seni kasutatakse tavalist otsingut.',
    'other' => 'Sõnaindeks: %d kirjet veel ootel — seni kasutatakse tavalist otsingut.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'Kasutusel — %d sõnakirje.',
    'other' => 'Kasutusel — %d sõnakirjet.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Sõnaindeks';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automaatne: luuakse ainult siis, kui veebileht jõuab allpool toodud läveni. Väikesed veebilehed seda ei vaja.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automaatne';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Alati sees';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Väljas';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Sõnaindeks alates';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Indekseeritud kirjete (sektsioonid ja moodulite elemendid) arv, millest alates sõnaindeks automaatselt luuakse';
$SEARCH['BTN_DELETE_TERM']                   = 'Eemalda see sõna';
$SEARCH['MSG_TERM_DELETED']                  = 'Sõna eemaldatud.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Mooduli <b>%s</b> poolkonfiguratsioon eeltäidetud failist search.php — kontrolli ja kohanda.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Mooduli \'%s\' poolkonfiguratsioon salvestatud.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Mooduli %s konfiguratsioon ja indeksikirjed kustutatud.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php loodud. Ehita indeks uuesti üles.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Kas kustutada mooduli %s konfiguratsioon ja indeksikirjed?';
$SEARCH['STATUS_SEMI']                       = 'Poolkonfiguratsioon';
$SEARCH['LABEL_GUIDE']                       = 'Näita selle mooduli juhendit';
$SEARCH['LABEL_TABLE_HINT']                  = 'Vali tabel → veerud laaditakse automaatselt';
$SEARCH['LABEL_TABLE_SELECT']                = 'Vali tabel';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'WBCE lehe ankur';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Ainult otsitavad lehed';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Kõik sektsioonid (sisukogum)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Ainult aktiivsed kirjed (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Ajastus (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Liitmised (valikuline, max 3) — andmed lisatabelitest';
$SEARCH['LABEL_GENERATE_DEF']                = 'Loo module_defs fail';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Failist search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Kustuta konfiguratsioon';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Tekstiveerge pole';
$SEARCH['LABEL_ERROR']                       = 'Viga';
$SEARCH['LABEL_MODULE']                      = 'Moodul';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Pole otsitav';
$SEARCH['LABEL_HELP']                        = 'Abi';
$SEARCH['BTN_CONFIGURE']                     = 'Seadista';
$SEARCH['BTN_CLOSE']                         = 'Sulge';
$SEARCH['DEF_GENERATED']                     = 'loodud';
$SEARCH['DEF_SHIPPED']                       = 'sisseehitatud';
$SEARCH['LABEL_KIND']                        = 'Tüüp';
$SEARCH['LABEL_INDEXING']                    = 'Indekseerimine';
$SEARCH['LABEL_SECTIONS']                    = 'Sektsioonid';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtreeri …';
$SEARCH['MODULES_SHOWN']                     = 'Näidatakse %1$d / %2$d moodulit';
$SEARCH['KIND_PAGE']                         = 'Lehemoodulid';
$SEARCH['KIND_SNIPPET']                      = 'Snippetid';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtrid';
$SEARCH['KIND_TOOL']                         = 'Haldustööriistad';
$SEARCH['BADGE_PAGE']                        = 'Leht';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filter';
$SEARCH['BADGE_TOOL']                        = 'Tööriist';
$SEARCH['GROUP_DEF']                         = 'definitsiooniga';
$SEARCH['GROUP_OPEN']                        = 'puudulik';
$SEARCH['GROUP_TITLE']                       = 'ainult lehe pealkiri';
$SEARCH['SOURCE_MODULE']                     = 'Moodulist';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Sisseehitatud';
$SEARCH['SOURCE_GENERATED']                  = 'Poolkonfiguratsioon';
$SEARCH['SOURCE_SEMI']                       = 'Poolkonfiguratsioon – loomata';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php leitud';
$SEARCH['SOURCE_TITLE']                      = 'Ainult lehe pealkiri';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Moodulil on oma otsingudefinitsioon (search_index.php) — siin muudetav pole.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indekseeritakse PHP-callbacki kaudu — siin muudetav pole.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'WBCE Searchiga kaasas olev definitsioon (module_defs/). Poolkonfiguratsioon on ülimuslik.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definitsioon loodud poolkonfiguratsioonist.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Poolkonfiguratsioon salvestatud, kuid definitsiooni pole veel loodud.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Definitsiooni veel pole — saab eeltäita mooduli vanast search.php-st.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Definitsioon puudub — indeks sisaldab ainult lehe pealkirja.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Lehe sektsioone pole — pole midagi indekseerida.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Otsing on sellel lehel välja lülitatud';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Sisseehitatud definitsioon. Salvestamine loob poolkonfiguratsiooni, mis on ülimuslik.';
$SEARCH['LABEL_TABLE']                       = 'Tabel';
$SEARCH['LABEL_OWN_TABLES']                  = 'Selle mooduli tabelid';
$SEARCH['LABEL_OTHER_TABLES']                = 'Teiste moodulite tabelid';
$SEARCH['HINT_TABLE']                        = 'Indekseerida saab ainult mod_* tabeleid, millel on veerg section_id.';
$SEARCH['LABEL_ID_FIELD']                    = 'ID-veerg';
$SEARCH['LABEL_ITEM_KEY']                    = 'Elemendi võti';
$SEARCH['HINT_ITEM_KEY']                     = 'Unikaalne võti elemendi kohta (mitmikrežiim).';
$SEARCH['LABEL_TITLE_COL']                   = 'Pealkirja veerg';
$SEARCH['LABEL_TEXT_COLS']                   = 'Tekstiveerud';
$SEARCH['LABEL_LINK_COL']                    = 'Lingi veerg';
$SEARCH['HINT_LINK_PREFIX']                  = 'Valikuline eesliide: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Pildi veerg';
$SEARCH['HINT_IMAGE_PATH']                   = 'Tee kaustas /media, kohatäited nagu {item_id} lubatud.';
$SEARCH['LABEL_NONE']                        = 'puudub';
$SEARCH['LABEL_MODE']                        = 'Režiim';
$SEARCH['MODE_SINGLE']                       = 'Üksik — üks kirje sektsiooni kohta';
$SEARCH['MODE_MULTI']                        = 'Mitmik — üks kirje elemendi kohta';
$SEARCH['LABEL_INDEX_BASE']                  = 'Indeksi alus';
$SEARCH['LABEL_FILTER']                      = 'Filter';
$SEARCH['LABEL_NO_JOIN']                     = 'liitmist pole';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Vali kehtiv mooduli tabel.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'Mooduli %s search.php-st ei leitud kasutatavat tabelit.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Lehti pole',
    'one' => '%d leht',
    'other' => '%d lehte',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Salvesta';
$SEARCH['MSG_SECURITY_ERROR']                = 'Turvakontroll ebaõnnestus.';
$SEARCH['STATUS_ACTIVE']                     = 'Aktiivne';
$SEARCH['STATUS_INACTIVE']                   = 'Mitteaktiivne';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'aga','ainult','alla','asi','et','ei','ega','eks','ja','jah','juba','just',
    'kas','keda','kes','kelle','kogu','kui','kuid','kus','kõik','ma','mida','mille',
    'mis','mu','mul','mulle','ka','me','meie','mina','minu','nad','nagu','neid',
    'nende','nii','nüüd','ning','oled','oleme','olen','oli','olid','olla','on',
    'ongi','pole','saab','sa','see','seda','sellel','selle','sest','siin','siis',
    'sina','sinu','te','teie','tema','temal','tuleb','ta','teda','veel','või','üle',
];
