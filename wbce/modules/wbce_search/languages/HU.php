<?php
/**
 * wbce_search - languages/HU.php
 * Magyar
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Speciális keresési beállítások. A WBCE CMS keresésének indexe, moduljai, elrendezései és statisztikái: teljes szöveges keresés operátorokkal, élő javaslatok, a találatok kiemelése a céloldalon és címkefelhő.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Keresés';
$SEARCH['SEARCH_HEADING']                    = 'Keresés';
$SEARCH['RESULTS_FOR']                       = 'Találatok erre:';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Nincs találat',
    'one' => '%d találat',
    'other' => '%d találat',
];
$SEARCH['NO_RESULTS']                        = 'Nincs találat.';
$SEARCH['ALL_WORDS']                         = 'Minden szó';
$SEARCH['ANY_WORDS']                         = 'Bármelyik szó';
$SEARCH['EXACT_MATCH']                       = 'Pontos kifejezés';
$SEARCH['MATCH']                             = 'Keresési mód';
$SEARCH['PAGES']                             = 'Oldalak';
$SEARCH['TIPS_TITLE']                        = 'Keresési tippek:';
$SEARCH['TIP_FEWER']                         = 'Használjon kevesebb kifejezést';
$SEARCH['TIP_OR']                            = 'VAGY-keresés:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'másikSzó';
$SEARCH['TIP_NOT']                           = 'Kizárás:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'kizárt';
$SEARCH['TIP_PHRASE']                        = 'Pontos kifejezés:';
$SEARCH['TIP_WILDCARD']                      = 'Helyettesítő karakter:';
$SEARCH['TIP_FUZZY']                         = 'Elgépelések tűrése:';
$SEARCH['DID_YOU_MEAN']                      = 'Erre gondolt:';
$SEARCH['SCOPE_TITLE']                       = 'Csak a címben';
$SEARCH['SCOPE_CONTENT']                     = 'Csak a tartalomban';
$SEARCH['SEARCH_OR']                         = 'VAGY-keresés (legalább egy kifejezés)';
$SEARCH['AREAS_TITLE']                       = 'Böngészés téma szerint:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Gyakran keresett:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'egyszer keresték',
    'other' => '%d alkalommal keresték',
];
$SEARCH['HIT_CONTENT']                       = 'Tartalom';
$SEARCH['HIT_KEYWORD']                       = 'Kulcsszó';
$SEARCH['HIT_DESCRIPTION']                   = 'Leírás';
$SEARCH['HIT_TITLE']                         = 'Cím';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Helyettesítő karakter';
$SEARCH['LEGEND_FUZZY']                      = 'Elgépelések tűrése';
$SEARCH['LEGEND_PHRASE']                     = 'Pontos kifejezés';
$SEARCH['LEGEND_EXCLUDE']                    = 'Kifejezés kizárása';
$SEARCH['LEGEND_OR']                         = 'Bármelyik kifejezés';
$SEARCH['LEGEND_COMBINATION']                = 'Kombináció';
$SEARCH['LEGEND_OPERATORS']                  = 'Operátorok';
$SEARCH['OP_EXCLUDE']                        = 'kizár';
$SEARCH['OP_WILDCARD']                       = 'helyettesítő';
$SEARCH['OP_TYPOS']                          = 'elgépelés';
$SEARCH['OP_PHRASE']                         = 'kifejezés';
$SEARCH['OP_OR']                             = 'vagy';
$SEARCH['EXAMPLE_WORD']                      = 'mustár';
$SEARCH['EXAMPLE_WORD2']                     = 'bio';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'csípős';
$SEARCH['EXAMPLE_OR']                        = 'ketchup';
$SEARCH['EXAMPLE_PHRASE']                    = 'sárga mustár';
$SEARCH['EXAMPLE_PHRASE2']                   = 'kukoricából';
$SEARCH['LABEL_LEGEND']                      = 'Jelmagyarázat';
$SEARCH['LEGEND_HIT_CONTENT']                = 'A kifejezés az oldal tartalmában szerepel';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'A kifejezés az oldal kulcsszavai között szerepel';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'A kifejezés az oldal leírásában szerepel';
$SEARCH['LEGEND_HIT_TITLE']                  = 'A kifejezés a címben szerepel';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Kifejezés a tartalomban és a kulcsszavakban';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Kifejezés a tartalomban és a leírásban';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Kifejezés a kulcsszavakban és a leírásban';
$SEARCH['LEGEND_HIT_ALL']                    = 'Kifejezés mindhárom mezőben';
$SEARCH['PAGE_PREV']                         = 'Előző oldal';
$SEARCH['PAGE_NEXT']                         = 'Következő oldal';
$SEARCH['DROPLET_DESCRIPTION']               = 'A leggyakrabban keresett kifejezések felhője. Paraméterek: max=20, min_count=1, desc=Felirat, active=true (false = rejtett)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Áttekintés';
$SEARCH['MENU_MODULES']                      = 'Modulok';
$SEARCH['MENU_LAYOUT']                       = 'Elrendezés';
$SEARCH['MENU_SETTINGS']                     = 'Beállítások';
$SEARCH['MENU_STATS']                        = 'Statisztika';
$SEARCH['CRUMB_OVERVIEW']                    = 'A keresési index állapota és karbantartása';
$SEARCH['CRUMB_MODULES']                     = 'Mely modulok töltik a keresési indexet';
$SEARCH['CRUMB_LAYOUT']                      = 'A találati oldal sablonja';
$SEARCH['CRUMB_SETTINGS']                    = 'Keresési viselkedés, élő keresés, címkefelhő';
$SEARCH['CRUMB_STATS']                       = 'Mit keresnek a látogatók';
$SEARCH['LEDE_OVERVIEW']                     = 'A keresési index és a weboldal keresésének jelenlegi állapota.';
$SEARCH['LEDE_MODULES']                      = 'Hogyan indexelődik az egyes telepített modulok tartalma. A definíció nélküli modulok csak az oldal címét adják.';
$SEARCH['LEDE_LAYOUT']                       = 'Milyen elrendezést és stíluslapot használ a keresőoldal és a címkefelhő. A mellékelt és a sablonból származó fájlok változatlanok maradnak; mindig a saját másolatát szerkeszti.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Találati oldal';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'A /search/ oldal elrendezése';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Címkefelhő';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'A [[wbce_search_tagcloud]] droplet elrendezése';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Stíluslap';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'A találati oldalhoz és a címkefelhőhöz';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'A(z) %1$s CSS-e itt jelenik meg · a „Szerkesztés” létrehozza: %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Nincs stíluslap';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'a sablon maga hozza az összes stílust';
$SEARCH['LAYOUT_ACTIVE']                     = 'aktív';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'saját fájl';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'a(z) „%s” sablonból';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'mellékelt';
$SEARCH['LAYOUT_READONLY']                   = 'csak olvasható';
$SEARCH['LAYOUT_MODIFIED']                   = 'módosítva: %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'a sablon fájlja: %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'a mellékelt fájl: %s';
$SEARCH['BTN_EDIT']                          = 'Szerkesztés';
$SEARCH['BTN_DELETE']                        = 'Törlés';
$SEARCH['BTN_BACK']                          = 'Vissza';
$SEARCH['BTN_SAVE_BACK']                     = 'Mentés és vissza';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Új fájl jön létre: %1\$s, a(z) %2\$s másolataként.\n\nA másolatot szerkeszti, és az lesz az aktív elrendezés; az eredeti változatlan marad.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s már létezik. Felülírja a(z) %2\$s tartalmával és szerkeszti?\n\nA(z) %1\$s jelenlegi változata elvész.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Törli: %s?\n\nEz nem vonható vissza.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Aktív elrendezés: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s létrehozva';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s törölve';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Stíluslap: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Pontozás, kivonatok, élő keresés és címkefelhő.';
$SEARCH['LEDE_STATS']                        = 'A címkefelhőhöz rögzített keresőkifejezések (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Keresési index';
$SEARCH['INDEX_BUILD']                       = 'Teljes újraépítés';
$SEARCH['INDEX_UPDATE']                      = 'Változások frissítése';
$SEARCH['INDEX_CLEAR']                       = 'Index ürítése';
$SEARCH['ENTRIES']                           = 'Bejegyzések';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Index elkészült — nincs mit indexelni.',
    'one' => 'Index elkészült: %d bejegyzés.',
    'other' => 'Index elkészült: %d bejegyzés.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Nincs mit frissíteni.',
    'one' => '%d bejegyzés frissítve.',
    'other' => '%d bejegyzés frissítve.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Index törölve.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Valóban törli a teljes indexet?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Keresés a weboldalon';
$SEARCH['LABEL_LAST_INDEXED']                = 'Utolsó indexelés';
$SEARCH['INDEX_BUILD_DESC']                  = 'Újraolvassa az <b>összes</b> kereshető szakaszt. Nagy weboldalakon eltart egy ideig.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Csak a módosult vagy hiányzó szakaszokat olvassa be. Gyorsabb a teljes újraépítésnél.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Csak a módosult vagy hiányzó szakaszokat olvassa be. Jelenleg nincs teendő.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Kiüríti az indexet. A keresés semmit sem talál, amíg újra nem épül.';
$SEARCH['LABEL_FRESHNESS']                   = 'Naprakészség';
$SEARCH['FRESH_ALL']                         = '<b>Az index naprakész</b> — mind a(z) %d szakasz megfelel a legutóbbi módosításának.';
$SEARCH['FRESH_STALE']                       = '<b>%2$d szakaszból %1$d</b> módosult vagy hiányzik.';
$SEARCH['FRESH_NONE']                        = 'Még nincsenek kereshető szakaszok.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Keresés a weboldalon';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Beállítások › Keresés';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Nyilvános';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Regisztráltak';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privát';
$SEARCH['SITE_SEARCH_NONE']                  = 'Ki';
$SEARCH['HINT_SITE_SEARCH']                  = 'Ki kereshet — a weboldal minden keresőmezőjére, bármilyen keresés is áll mögötte. Ugyanaz a beállítás, mint a <a href="%s">Beállítások › Keresés</a> alatt; a „Regisztráltak” és a „Privát” egyaránt azt jelenti: csak bejelentkezett látogatók.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Beállítja a weboldal keresését erre: „%s”?\n\nEz minden látogató számára módosítja a weboldal „Keresés” beállítását.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Keresés a weboldalon: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Nyelvek';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Nincs nyelvi információ';
$SEARCH['VIS_HIDDEN']                        = 'Rejtett';
$SEARCH['VIS_PUBLIC']                        = 'Nyilvános';
$SEARCH['VIS_PRIVATE']                       = 'Privát';
$SEARCH['VIS_REGISTERED']                    = 'Regisztráltak';
$SEARCH['VIS_NONE']                          = 'Nincs';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Az elrendezés üres, ezért nem lett mentve.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'A search_custom.htt nem írható. Ellenőrizze a layouts mappa írási jogait.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Bejelölt „AjaxSave” esetén a Mentés és a Ctrl+S az oldal újratöltése nélkül ment; a „Mentés és vissza” ilyenkor rejtve van.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Minimális szóhossz';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'A rövidebb szavakat figyelmen kívül hagyja';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Címsúlyozás';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Találatok a címben × szorzó';
$SEARCH['SET_MAX_EXCERPT']                   = 'Kivonat max. hossza';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Karakter kivonatonként';
$SEARCH['SET_HIGHLIGHT']                     = 'Kiemelés';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'A keresett kifejezések kiemelése a kivonatban';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Kiemelő tag';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'A kiemeléshez használt HTML-tag';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Találat oldalanként';
$SEARCH['SET_AUTO_REINDEX']                  = 'Automatikus újraindexelés keresésnél';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Minden keresésnél csendben frissíti az elavult bejegyzéseket';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Címkefelhő megjelenítése';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'A keresőoldalon. A dropletnek saját active=true/false paramétere van';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Keresések rögzítése';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Rögzíti a kereséseket a címkefelhőhöz és a statisztikához — kikapcsolása nem rejti el a felhőt';
$SEARCH['SET_AJAX_SUGGEST']                  = 'AJAX élő keresés';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Javaslatok gépelés közben';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Hibakereső mód';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Technikai adatok minden találat alatt (csak adminisztrátoroknak)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'A keresőoldal sablonja';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Frontend-sablon, amelyben a /search/ oldal megjelenik.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'A weboldal alapértelmezett sablonja (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Keresés';
$SEARCH['GROUP_DISPLAY']                     = 'Találatok megjelenítése';
$SEARCH['GROUP_INDEX']                       = 'Index karbantartása';
$SEARCH['GROUP_LIVE']                        = 'Élő keresés';
$SEARCH['GROUP_TAGCLOUD']                    = 'Címkefelhő';
$SEARCH['GROUP_ADMIN']                       = 'Adminisztrációs eszköz';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'A találati lista oldalmérete';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Nyelvi szűrő';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Csak a látogató nyelvén írt oldalak (a weboldal alapértelmezése: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Részletes keresés';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Hatókör-jelölőnégyzetek és VAGY-opció a keresőűrlapon';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Max. szakasz keresésenként';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Az automatikus újraindexelés korlátja (terheléskezelés)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Javaslatok forrása';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'A hibrid előbb a címtalálatokat listázza, majd olyan oldalakkal egészíti ki, amelyek szövegében szerepel a szó';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Max. javaslat';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Megjelenített javaslatok száma';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Képek a javaslatokban';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Az elem képét (katalógus, hírek …) a javaslat mellett mutatja, ha a modul indexel ilyet';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Max. címke';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'A felhőben megjelenő kifejezések száma';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min. keresés';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Keresések minimális száma, mielőtt egy kifejezés megjelenik';
$SEARCH['SET_NAV_STYLE']                     = 'Navigáció';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Fülek felül vagy ikonsáv bal oldalon';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Előbb címek, kiegészítve a teljes szövegből (ajánlott)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Cím + leírás (gyors)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Teljes szöveges index (alapos)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Fülek felül';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Oldalsáv bal oldalon';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Végpont';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'A keresőoldalon automatikusan felismeri a „string” nevű, type="search" típusú vagy ws-input osztályú mezőket.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Beállítások mentve.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Keresési statisztika törölve.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Valóban törli az összes statisztikát?';
$SEARCH['STATS_DELETE']                      = 'Statisztika törlése';
$SEARCH['STATS_TERM']                        = 'Keresőkifejezés';
$SEARCH['STATS_COUNT']                       = 'Szám';
$SEARCH['STATS_LAST']                        = 'Utoljára keresve';
$SEARCH['STATS_TERMS']                       = 'Kifejezések';
$SEARCH['STATS_SEARCHES']                    = 'Keresések';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 / %d kifejezés.',
    'other' => 'Top 100 / %d kifejezés.',
];
$SEARCH['STATS_EMPTY']                       = 'Még nincs rögzített keresőkifejezés.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Keresett, nem talált';
$SEARCH['HINT_STATS_MISSES']                 = 'Találat nélküli teljes keresések — utalás olyan tartalomra, amelyet a látogatók várnak, de nem találnak. Soha nem jelenik meg nyilvánosan.';
$SEARCH['STATS_QUERY']                       = 'Lekérdezés';
$SEARCH['STATS_MISSES_EMPTY']                = 'Nincs rögzített találat nélküli keresés.';
$SEARCH['CARD_WORDS']                        = 'Szóindex';
$SEARCH['HINT_WORDS']                        = 'Nagy weboldalakhoz: az összes szó listája, hogy a keresésnek ne kelljen a teljes indexet végigolvasnia. %s indexbejegyzéstől automatikusan épül.';
$SEARCH['WORDS_INACTIVE']                    = 'Nem aktív — a weboldal a küszöb alatt van (%2$s indexbejegyzés, jelenleg %1$s); a normál keresés elég gyors.';
$SEARCH['WORDS_OFF']                         = 'A beállításokban kikapcsolva.';
$SEARCH['WORDS_BUILDING']                    = 'Épül';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Építés folytatása';
$SEARCH['MSG_WORDS_READY']                   = 'A szóindex elkészült.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Szóindex: még %d bejegyzés függőben — addig a normál keresés működik.',
    'other' => 'Szóindex: még %d bejegyzés függőben — addig a normál keresés működik.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'Használatban — %d szóbejegyzés.',
    'other' => 'Használatban — %d szóbejegyzés.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Szóindex';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automatikus: csak akkor épül, ha a weboldal eléri az alábbi küszöböt. Kis weboldalaknak nincs rá szükségük.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automatikus';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Mindig be';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Ki';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Szóindex ettől';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Indexelt bejegyzések (szakaszok és modulelemek) száma, amelytől a szóindex automatikusan épül';
$SEARCH['BTN_DELETE_TERM']                   = 'Kifejezés eltávolítása';
$SEARCH['MSG_TERM_DELETED']                  = 'Kifejezés eltávolítva.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'A(z) <b>%s</b> félkonfigurációja előtöltve a search.php-ből — kérjük, ellenőrizze és igazítsa.';
$SEARCH['MSG_SEMI_SAVED']                    = 'A(z) \'%s\' félkonfigurációja mentve.';
$SEARCH['MSG_SEMI_DELETED']                  = 'A(z) %s konfigurációja és indexbejegyzései törölve.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php létrehozva. Kérjük, építse újra az indexet.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Törli a(z) %s konfigurációját és indexbejegyzéseit?';
$SEARCH['STATUS_SEMI']                       = 'Félkonfiguráció';
$SEARCH['LABEL_GUIDE']                       = 'A modul útmutatójának megjelenítése';
$SEARCH['LABEL_TABLE_HINT']                  = 'Válasszon táblát → az oszlopok automatikusan betöltődnek';
$SEARCH['LABEL_TABLE_SELECT']                = 'Tábla kiválasztása';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'WBCE oldalhorgony';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Csak kereshető oldalak';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Minden szakasz (tartalomkészlet)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Csak aktív bejegyzések (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Időzítés (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joinok (opcionális, max. 3) — adatok további táblákból';
$SEARCH['LABEL_GENERATE_DEF']                = 'module_defs fájl létrehozása';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'search.php-ből';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Konfiguráció törlése';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Nincsenek szöveges oszlopok';
$SEARCH['LABEL_ERROR']                       = 'Hiba';
$SEARCH['LABEL_MODULE']                      = 'Modul';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Nem kereshető';
$SEARCH['LABEL_HELP']                        = 'Súgó';
$SEARCH['BTN_CONFIGURE']                     = 'Beállítás';
$SEARCH['BTN_CLOSE']                         = 'Bezárás';
$SEARCH['DEF_GENERATED']                     = 'generált';
$SEARCH['DEF_SHIPPED']                       = 'beépített';
$SEARCH['LABEL_KIND']                        = 'Típus';
$SEARCH['LABEL_INDEXING']                    = 'Indexelés';
$SEARCH['LABEL_SECTIONS']                    = 'Szakaszok';
$SEARCH['PLACEHOLDER_FILTER']                = 'Szűrés …';
$SEARCH['MODULES_SHOWN']                     = '%2$d modulból %1$d látható';
$SEARCH['KIND_PAGE']                         = 'Oldalmodulok';
$SEARCH['KIND_SNIPPET']                      = 'Snippetek';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Szűrők';
$SEARCH['KIND_TOOL']                         = 'Adminisztrációs eszközök';
$SEARCH['BADGE_PAGE']                        = 'Oldal';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Szűrő';
$SEARCH['BADGE_TOOL']                        = 'Eszköz';
$SEARCH['GROUP_DEF']                         = 'definícióval';
$SEARCH['GROUP_OPEN']                        = 'hiányos';
$SEARCH['GROUP_TITLE']                       = 'csak oldalcím';
$SEARCH['SOURCE_MODULE']                     = 'Modulból';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Beépített';
$SEARCH['SOURCE_GENERATED']                  = 'Félkonfiguráció';
$SEARCH['SOURCE_SEMI']                       = 'Félkonfiguráció – nincs generálva';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php megtalálva';
$SEARCH['SOURCE_TITLE']                      = 'Csak oldalcím';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'A modul saját keresési definíciót hoz (search_index.php) — itt nem szerkeszthető.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'PHP-callbackkel indexelődik — itt nem szerkeszthető.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'A WBCE Search-csel szállított definíció (module_defs/). A félkonfiguráció elsőbbséget élvez.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'A félkonfigurációból generált definíció.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Félkonfiguráció mentve, de még nincs generált definíció.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Még nincs definíció — a modul régi search.php-jéből előtölthető.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Nincs definíció — az index csak az oldal címét tartalmazza.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Nincsenek oldalszakaszok — nincs mit indexelni.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Ezen az oldalon a keresés ki van kapcsolva';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Beépített definíció. Mentéskor elsőbbséget élvező félkonfiguráció jön létre.';
$SEARCH['LABEL_TABLE']                       = 'Tábla';
$SEARCH['LABEL_OWN_TABLES']                  = 'A modul táblái';
$SEARCH['LABEL_OTHER_TABLES']                = 'Más modulok táblái';
$SEARCH['HINT_TABLE']                        = 'Csak section_id oszloppal rendelkező mod_* táblák indexelhetők.';
$SEARCH['LABEL_ID_FIELD']                    = 'ID-oszlop';
$SEARCH['LABEL_ITEM_KEY']                    = 'Elemkulcs';
$SEARCH['HINT_ITEM_KEY']                     = 'Elemenként egyedi kulcs (többes mód).';
$SEARCH['LABEL_TITLE_COL']                   = 'Címoszlop';
$SEARCH['LABEL_TEXT_COLS']                   = 'Szöveges oszlopok';
$SEARCH['LABEL_LINK_COL']                    = 'Hivatkozásoszlop';
$SEARCH['HINT_LINK_PREFIX']                  = 'Opcionális előtag: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Képoszlop';
$SEARCH['HINT_IMAGE_PATH']                   = 'Útvonal a /media alatt, helyőrzők, pl. {item_id} engedélyezettek.';
$SEARCH['LABEL_NONE']                        = 'nincs';
$SEARCH['LABEL_MODE']                        = 'Mód';
$SEARCH['MODE_SINGLE']                       = 'Egyes — egy bejegyzés szakaszonként';
$SEARCH['MODE_MULTI']                        = 'Többes — egy bejegyzés elemenként';
$SEARCH['LABEL_INDEX_BASE']                  = 'Index alapja';
$SEARCH['LABEL_FILTER']                      = 'Szűrő';
$SEARCH['LABEL_NO_JOIN']                     = 'nincs join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Kérjük, válasszon érvényes modultáblát.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'Nem található használható tábla a(z) %s search.php fájljában.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Nincsenek oldalak',
    'one' => '%d oldal',
    'other' => '%d oldal',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Mentés';
$SEARCH['MSG_SECURITY_ERROR']                = 'A biztonsági ellenőrzés sikertelen.';
$SEARCH['STATUS_ACTIVE']                     = 'Aktív';
$SEARCH['STATUS_INACTIVE']                   = 'Inaktív';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'a','az','abban','ahhoz','ahogy','ahol','aki','akik','akkor','alatt','által',
    'amely','amelyek','amelyik','ami','amikor','amit','amolyan','annak','arra',
    'arról','át','azért','azok','azon','azt','azután','azzal','be','benne','bár',
    'csak','de','e','egy','egyes','egyik','el','ez','ezek','ezen','ezt','és','fel',
    'hogy','hol','ide','igen','is','itt','ki','le','lesz','lett','meg','mellett',
    'mert','mi','mint','minden','mit','mivel','most','még','nagy','nem','neki',
    'nekem','nincs','ő','ők','pedig','például','rá','sem','sok','szerint','te',
    'több','után','vagy','vagyok','van','vannak','volt','voltak','én',
];
