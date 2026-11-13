<?php
/**
 * wbce_search - languages/FI.php
 * Suomi
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Haun lisäasetukset. WBCE CMS:n haun hakemisto, moduulit, asettelut ja tilastot: kokotekstihaku operaattoreilla, ehdotukset kirjoitettaessa, osumien korostus kohdesivulla ja tagipilvi.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Hae';
$SEARCH['SEARCH_HEADING']                    = 'Haku';
$SEARCH['RESULTS_FOR']                       = 'Tulokset haulle';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Ei tuloksia',
    'one' => '%d tulos',
    'other' => '%d tulosta',
];
$SEARCH['NO_RESULTS']                        = 'Tuloksia ei löytynyt.';
$SEARCH['ALL_WORDS']                         = 'Kaikki sanat';
$SEARCH['ANY_WORDS']                         = 'Mikä tahansa sana';
$SEARCH['EXACT_MATCH']                       = 'Tarkka lause';
$SEARCH['MATCH']                             = 'Hakutila';
$SEARCH['PAGES']                             = 'Sivut';
$SEARCH['TIPS_TITLE']                        = 'Hakuvinkit:';
$SEARCH['TIP_FEWER']                         = 'Käytä vähemmän hakusanoja';
$SEARCH['TIP_OR']                            = 'TAI-haku:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'toinenSana';
$SEARCH['TIP_NOT']                           = 'Jätä pois:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'poissuljettu';
$SEARCH['TIP_PHRASE']                        = 'Tarkka lause:';
$SEARCH['TIP_WILDCARD']                      = 'Jokerimerkki:';
$SEARCH['TIP_FUZZY']                         = 'Salli kirjoitusvirheet:';
$SEARCH['DID_YOU_MEAN']                      = 'Tarkoititko:';
$SEARCH['SCOPE_TITLE']                       = 'Vain otsikko';
$SEARCH['SCOPE_CONTENT']                     = 'Vain sisältö';
$SEARCH['SEARCH_OR']                         = 'TAI-haku (vähintään yksi sana)';
$SEARCH['AREAS_TITLE']                       = 'Selaa aiheittain:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Usein haettu:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'haettu kerran',
    'other' => 'haettu %d kertaa',
];
$SEARCH['HIT_CONTENT']                       = 'Sisältö';
$SEARCH['HIT_KEYWORD']                       = 'Avainsana';
$SEARCH['HIT_DESCRIPTION']                   = 'Kuvaus';
$SEARCH['HIT_TITLE']                         = 'Otsikko';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Jokerimerkki';
$SEARCH['LEGEND_FUZZY']                      = 'Salli kirjoitusvirheet';
$SEARCH['LEGEND_PHRASE']                     = 'Tarkka lause';
$SEARCH['LEGEND_EXCLUDE']                    = 'Jätä sana pois';
$SEARCH['LEGEND_OR']                         = 'Jompikumpi sana';
$SEARCH['LEGEND_COMBINATION']                = 'Yhdistelmä';
$SEARCH['LEGEND_OPERATORS']                  = 'Operaattorit';
$SEARCH['OP_EXCLUDE']                        = 'pois';
$SEARCH['OP_WILDCARD']                       = 'jokeri';
$SEARCH['OP_TYPOS']                          = 'virheet';
$SEARCH['OP_PHRASE']                         = 'lause';
$SEARCH['OP_OR']                             = 'tai';
$SEARCH['EXAMPLE_WORD']                      = 'sinappi';
$SEARCH['EXAMPLE_WORD2']                     = 'luomu';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'tulinen';
$SEARCH['EXAMPLE_OR']                        = 'ketsuppi';
$SEARCH['EXAMPLE_PHRASE']                    = 'keltainen sinappi';
$SEARCH['EXAMPLE_PHRASE2']                   = 'maissista';
$SEARCH['LABEL_LEGEND']                      = 'Selite';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Sana löytyi sivun sisällöstä';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Sana löytyi sivun avainsanoista';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Sana löytyi sivun kuvauksesta';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Sana löytyi otsikosta';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Sana sisällössä ja avainsanoissa';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Sana sisällössä ja kuvauksessa';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Sana avainsanoissa ja kuvauksessa';
$SEARCH['LEGEND_HIT_ALL']                    = 'Sana kaikissa kolmessa kentässä';
$SEARCH['PAGE_PREV']                         = 'Edellinen sivu';
$SEARCH['PAGE_NEXT']                         = 'Seuraava sivu';
$SEARCH['DROPLET_DESCRIPTION']               = 'Pilvi haetuimmista sanoista. Parametrit: max=20, min_count=1, desc=Otsikko, active=true (false = piilotettu)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Yleiskatsaus';
$SEARCH['MENU_MODULES']                      = 'Moduulit';
$SEARCH['MENU_LAYOUT']                       = 'Asettelu';
$SEARCH['MENU_SETTINGS']                     = 'Asetukset';
$SEARCH['MENU_STATS']                        = 'Tilastot';
$SEARCH['CRUMB_OVERVIEW']                    = 'Hakuhakemiston tila ja ylläpito';
$SEARCH['CRUMB_MODULES']                     = 'Mitkä moduulit täyttävät hakuhakemiston';
$SEARCH['CRUMB_LAYOUT']                      = 'Tulossivun malli';
$SEARCH['CRUMB_SETTINGS']                    = 'Haun toiminta, pikahaku, avainsanapilvi';
$SEARCH['CRUMB_STATS']                       = 'Mitä kävijät hakevat';
$SEARCH['LEDE_OVERVIEW']                     = 'Hakuhakemiston ja sivuston haun nykyinen tila.';
$SEARCH['LEDE_MODULES']                      = 'Miten kukin asennettu moduuli indeksoidaan. Moduulit ilman määrittelyä tuovat vain sivunsa otsikon.';
$SEARCH['LEDE_LAYOUT']                       = 'Mitä asettelua ja tyylitiedostoa hakusivu ja avainsanapilvi käyttävät. Mukana tulevat tiedostot ja mallin tiedostot pysyvät ennallaan; muokkaat aina omaa kopiotasi.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Tulossivu';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Sivun /search/ asettelu';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Avainsanapilvi';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Dropletin [[wbce_search_tagcloud]] asettelu';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Tyylitiedosto';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Tulossivulle ja avainsanapilvelle';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'Kohteen %1$s CSS näkyy tässä · ”Muokkaa” luo tiedoston %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Ei tyylitiedostoa';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'malli tuo kaikki tyylit itse';
$SEARCH['LAYOUT_ACTIVE']                     = 'käytössä';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'oma tiedosto';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'mallista ”%s”';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'mukana tuleva';
$SEARCH['LAYOUT_READONLY']                   = 'vain luku';
$SEARCH['LAYOUT_MODIFIED']                   = 'muutettu %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'mallin tiedosto %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'mukana tuleva tiedosto %s';
$SEARCH['BTN_EDIT']                          = 'Muokkaa';
$SEARCH['BTN_DELETE']                        = 'Poista';
$SEARCH['BTN_BACK']                          = 'Takaisin';
$SEARCH['BTN_SAVE_BACK']                     = 'Tallenna ja palaa';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Uusi tiedosto %1\$s luodaan kopiona tiedostosta %2\$s.\n\nKopiota muokataan ja siitä tulee käytössä oleva asettelu; alkuperäinen pysyy ennallaan.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s on jo olemassa. Korvataanko se tiedoston %2\$s sisällöllä ja muokataan?\n\nNykyinen versiosi tiedostosta %1\$s menetetään.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Poistetaanko %s?\n\nToimintoa ei voi kumota.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Käytössä oleva asettelu: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s luotu';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s poistettu';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Tyylitiedosto: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Pisteytys, otteet, pikahaku ja avainsanapilvi.';
$SEARCH['LEDE_STATS']                        = 'Avainsanapilveä varten tallennetut hakusanat (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Hakuhakemisto';
$SEARCH['INDEX_BUILD']                       = 'Täysi uudelleenrakennus';
$SEARCH['INDEX_UPDATE']                      = 'Päivitä muutokset';
$SEARCH['INDEX_CLEAR']                       = 'Tyhjennä hakemisto';
$SEARCH['ENTRIES']                           = 'Merkinnät';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Hakemisto rakennettu — ei indeksoitavaa.',
    'one' => 'Hakemisto rakennettu: %d merkintä.',
    'other' => 'Hakemisto rakennettu: %d merkintää.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Ei päivitettävää.',
    'one' => '%d merkintä päivitetty.',
    'other' => '%d merkintää päivitetty.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Hakemisto poistettu.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Poistetaanko koko hakemisto todella?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Sivuston haku';
$SEARCH['LABEL_LAST_INDEXED']                = 'Viimeksi indeksoitu';
$SEARCH['INDEX_BUILD_DESC']                  = 'Lukee <b>kaikki</b> haettavat osiot uudelleen. Kestää suurilla sivustoilla.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Lukee vain muuttuneet tai puuttuvat osiot. Nopeampi kuin täysi uudelleenrakennus.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Lukee vain muuttuneet tai puuttuvat osiot. Tällä hetkellä ei tehtävää.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Tyhjentää hakemiston. Haku ei löydä mitään ennen uudelleenrakennusta.';
$SEARCH['LABEL_FRESHNESS']                   = 'Ajantasaisuus';
$SEARCH['FRESH_ALL']                         = '<b>Hakemisto on ajan tasalla</b> — kaikki %d osiota vastaavat viimeisintä muutostaan.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d / %2$d</b> osiota on muuttunut tai puuttuu.';
$SEARCH['FRESH_NONE']                        = 'Ei vielä haettavia osioita.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Sivuston haku';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Asetukset › Haku';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Julkinen';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Rekisteröityneet';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Yksityinen';
$SEARCH['SITE_SEARCH_NONE']                  = 'Pois';
$SEARCH['HINT_SITE_SEARCH']                  = 'Kuka saa hakea — jokaisessa sivuston hakukentässä riippumatta siitä, mikä haku sen takana on. Sama asetus kuin kohdassa <a href="%s">Asetukset › Haku</a>; ”Rekisteröityneet” ja ”Yksityinen” tarkoittavat molemmat: vain kirjautuneet kävijät.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Asetetaanko sivuston haku tilaan ”%s”?\n\nTämä muuttaa sivuston asetusta ”Haku” kaikille kävijöille.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Sivuston haku: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Kielet';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Ei kielitietoja';
$SEARCH['VIS_HIDDEN']                        = 'Piilotettu';
$SEARCH['VIS_PUBLIC']                        = 'Julkinen';
$SEARCH['VIS_PRIVATE']                       = 'Yksityinen';
$SEARCH['VIS_REGISTERED']                    = 'Rekisteröityneet';
$SEARCH['VIS_NONE']                          = 'Ei mitään';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Asettelu on tyhjä eikä sitä tallennettu.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Tiedostoa search_custom.htt ei voitu kirjoittaa. Tarkista layouts-kansion kirjoitusoikeudet.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Kun ”AjaxSave” on valittuna, Tallenna ja Ctrl+S tallentavat lataamatta sivua uudelleen; ”Tallenna ja palaa” piilotetaan silloin.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Sanan vähimmäispituus';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Lyhyemmät sanat ohitetaan';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Otsikon painotus';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Osumat otsikossa × kerroin';
$SEARCH['SET_MAX_EXCERPT']                   = 'Otteen enimmäispituus';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Merkkiä otetta kohden';
$SEARCH['SET_HIGHLIGHT']                     = 'Korostus';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Korosta hakusanat otteessa';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Korostustagi';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'Korostukseen käytettävä HTML-tagi';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Tuloksia sivulla';
$SEARCH['SET_AUTO_REINDEX']                  = 'Automaattinen uudelleenindeksointi haussa';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Päivittää vanhentuneet merkinnät huomaamatta jokaisen haun yhteydessä';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Näytä avainsanapilvi';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Hakusivulla. Dropletilla on oma parametri active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Tallenna haut';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Tallentaa haut avainsanapilveä ja tilastoja varten — poiskytkentä ei piilota pilveä';
$SEARCH['SET_AJAX_SUGGEST']                  = 'AJAX-pikahaku';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Näytä ehdotuksia kirjoittaessa';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Vianetsintätila';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Näytä teknisiä tietoja jokaisen hakutuloksen alla (vain ylläpitäjät)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Hakusivun malli';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Frontend-malli, jossa sivu /search/ näytetään.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Sivuston oletusmalli (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Haku';
$SEARCH['GROUP_DISPLAY']                     = 'Tulosten näyttö';
$SEARCH['GROUP_INDEX']                       = 'Hakemiston ylläpito';
$SEARCH['GROUP_LIVE']                        = 'Pikahaku';
$SEARCH['GROUP_TAGCLOUD']                    = 'Avainsanapilvi';
$SEARCH['GROUP_ADMIN']                       = 'Ylläpitotyökalu';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Tulossivun sivukoko';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Kielisuodatin';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Näytä vain kävijän kieliset sivut (sivuston oletus: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Tarkennettu haku';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Näytä hakulomakkeessa rajausvalinnat ja TAI-vaihtoehto';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Enint. osioita hakua kohden';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Automaattisen uudelleenindeksoinnin raja (kuormanhallinta)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Ehdotusten lähde';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Hybridi näyttää ensin otsikko-osumat ja täydentää sivuilla, joiden tekstissä sana esiintyy';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Enint. ehdotuksia';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Näytettävien ehdotusten määrä';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Kuvat ehdotuksissa';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Näyttää kohteen kuvan (luettelo, uutiset …) ehdotuksen vieressä, jos moduuli indeksoi sellaisen';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Enint. avainsanoja';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Pilvessä näytettävien sanojen määrä';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Väh. hakuja';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Hakujen vähimmäismäärä ennen kuin sana näkyy';
$SEARCH['SET_NAV_STYLE']                     = 'Navigointi';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Välilehdet ylhäällä tai kuvakepalkki vasemmalla';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Otsikot ensin, täydennettynä kokotekstistä (suositus)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Otsikko + kuvaus (nopea)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Kokotekstihakemisto (perusteellinen)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Välilehdet ylhäällä';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Sivupalkki vasemmalla';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Päätepiste';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Tunnistetaan hakusivulla automaattisesti kentistä, joiden nimi on ”string”, type="search" tai luokka ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Asetukset tallennettu.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Hakutilastot poistettu.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Poistetaanko kaikki tilastot todella?';
$SEARCH['STATS_DELETE']                      = 'Poista tilastot';
$SEARCH['STATS_TERM']                        = 'Hakusana';
$SEARCH['STATS_COUNT']                       = 'Määrä';
$SEARCH['STATS_LAST']                        = 'Viimeksi haettu';
$SEARCH['STATS_TERMS']                       = 'Sanat';
$SEARCH['STATS_SEARCHES']                    = 'Haut';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 / %d sana.',
    'other' => 'Top 100 / %d sanaa.',
];
$SEARCH['STATS_EMPTY']                       = 'Hakusanoja ei ole vielä tallennettu.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Haettu, ei löytynyt';
$SEARCH['HINT_STATS_MISSES']                 = 'Kokonaiset haut ilman tulosta — vihje sisällöstä, jota kävijät odottavat mutta eivät löydä. Ei koskaan näytetä julkisesti.';
$SEARCH['STATS_QUERY']                       = 'Haku';
$SEARCH['STATS_MISSES_EMPTY']                = 'Tuloksettomia hakuja ei ole tallennettu.';
$SEARCH['CARD_WORDS']                        = 'Sanahakemisto';
$SEARCH['HINT_WORDS']                        = 'Suurille sivustoille: luettelo kaikista sanoista, jotta haun ei tarvitse lukea koko hakemistoa. Rakennetaan automaattisesti %s hakemistomerkinnästä alkaen.';
$SEARCH['WORDS_INACTIVE']                    = 'Ei käytössä — sivusto on kynnyksen alla (%2$s hakemistomerkintää, nyt %1$s); tavallinen haku on riittävän nopea.';
$SEARCH['WORDS_OFF']                         = 'Kytketty pois asetuksista.';
$SEARCH['WORDS_BUILDING']                    = 'Rakennetaan';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Jatka rakentamista';
$SEARCH['MSG_WORDS_READY']                   = 'Sanahakemisto valmis.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Sanahakemisto: %d merkintä vielä odottaa — siihen asti käytetään tavallista hakua.',
    'other' => 'Sanahakemisto: %d merkintää vielä odottaa — siihen asti käytetään tavallista hakua.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'Käytössä — %d sanamerkintä.',
    'other' => 'Käytössä — %d sanamerkintää.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Sanahakemisto';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automaattinen: rakennetaan vain, kun sivusto saavuttaa alla olevan kynnyksen. Pienet sivustot eivät tarvitse sitä.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automaattinen';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Aina päällä';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Pois';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Sanahakemisto alkaen';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Indeksoitujen merkintöjen (osiot ja moduulikohteet) määrä, josta alkaen sanahakemisto rakennetaan automaattisesti';
$SEARCH['BTN_DELETE_TERM']                   = 'Poista tämä sana';
$SEARCH['MSG_TERM_DELETED']                  = 'Sana poistettu.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Moduulin <b>%s</b> puolimääritys esitäytetty search.php:stä — tarkista ja säädä.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Moduulin \'%s\' puolimääritys tallennettu.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Moduulin %s määritys ja hakemistomerkinnät poistettu.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php luotu. Rakenna hakemisto uudelleen.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Poistetaanko moduulin %s määritys ja hakemistomerkinnät?';
$SEARCH['STATUS_SEMI']                       = 'Puolimääritys';
$SEARCH['LABEL_GUIDE']                       = 'Näytä tämän moduulin ohje';
$SEARCH['LABEL_TABLE_HINT']                  = 'Valitse taulu → sarakkeet latautuvat automaattisesti';
$SEARCH['LABEL_TABLE_SELECT']                = 'Valitse taulu';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'WBCE-sivuankkuri';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Vain haettavat sivut';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Kaikki osiot (sisältöpooli)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Vain aktiiviset merkinnät (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Ajastus (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Liitokset (valinnainen, enint. 3) — tietoja muista tauluista';
$SEARCH['LABEL_GENERATE_DEF']                = 'Luo module_defs-tiedosto';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'search.php:stä';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Poista määritys';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Ei tekstisarakkeita';
$SEARCH['LABEL_ERROR']                       = 'Virhe';
$SEARCH['LABEL_MODULE']                      = 'Moduuli';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Ei haettavissa';
$SEARCH['LABEL_HELP']                        = 'Ohje';
$SEARCH['BTN_CONFIGURE']                     = 'Määritä';
$SEARCH['BTN_CLOSE']                         = 'Sulje';
$SEARCH['DEF_GENERATED']                     = 'luotu';
$SEARCH['DEF_SHIPPED']                       = 'sisäänrakennettu';
$SEARCH['LABEL_KIND']                        = 'Tyyppi';
$SEARCH['LABEL_INDEXING']                    = 'Indeksointi';
$SEARCH['LABEL_SECTIONS']                    = 'Osiot';
$SEARCH['PLACEHOLDER_FILTER']                = 'Suodata …';
$SEARCH['MODULES_SHOWN']                     = '%1$d / %2$d moduulia näytetään';
$SEARCH['KIND_PAGE']                         = 'Sivumoduulit';
$SEARCH['KIND_SNIPPET']                      = 'Snippetit';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Suodattimet';
$SEARCH['KIND_TOOL']                         = 'Ylläpitotyökalut';
$SEARCH['BADGE_PAGE']                        = 'Sivu';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Suodatin';
$SEARCH['BADGE_TOOL']                        = 'Työkalu';
$SEARCH['GROUP_DEF']                         = 'määrittelyn kanssa';
$SEARCH['GROUP_OPEN']                        = 'keskeneräinen';
$SEARCH['GROUP_TITLE']                       = 'vain sivun otsikko';
$SEARCH['SOURCE_MODULE']                     = 'Moduulista';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Sisäänrakennettu';
$SEARCH['SOURCE_GENERATED']                  = 'Puolimääritys';
$SEARCH['SOURCE_SEMI']                       = 'Puolimääritys – ei luotu';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php löytyi';
$SEARCH['SOURCE_TITLE']                      = 'Vain sivun otsikko';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Moduulilla on oma hakumäärittely (search_index.php) — ei muokattavissa tässä.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indeksoidaan PHP-callbackilla — ei muokattavissa tässä.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'WBCE Searchin mukana tuleva määrittely (module_defs/). Puolimääritys menee sen edelle.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Määrittely luotu puolimäärityksestä.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Puolimääritys tallennettu, mutta määrittelyä ei ole vielä luotu.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Ei vielä määrittelyä — voidaan esitäyttää moduulin vanhasta search.php:stä.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Ei määrittelyä — hakemisto sisältää vain sivun otsikon.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Ei sivuosioita — ei indeksoitavaa.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Haku kytketty pois tältä sivulta';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Sisäänrakennettu määrittely. Tallennus luo puolimäärityksen, joka menee sen edelle.';
$SEARCH['LABEL_TABLE']                       = 'Taulu';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tämän moduulin taulut';
$SEARCH['LABEL_OTHER_TABLES']                = 'Muut moduulitaulut';
$SEARCH['HINT_TABLE']                        = 'Vain mod_*-taulut, joissa on section_id-sarake, voidaan indeksoida.';
$SEARCH['LABEL_ID_FIELD']                    = 'ID-sarake';
$SEARCH['LABEL_ITEM_KEY']                    = 'Kohteen avain';
$SEARCH['HINT_ITEM_KEY']                     = 'Yksilöllinen avain kohdetta kohden (monitila).';
$SEARCH['LABEL_TITLE_COL']                   = 'Otsikkosarake';
$SEARCH['LABEL_TEXT_COLS']                   = 'Tekstisarakkeet';
$SEARCH['LABEL_LINK_COL']                    = 'Linkkisarake';
$SEARCH['HINT_LINK_PREFIX']                  = 'Valinnainen etuliite: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Kuvasarake';
$SEARCH['HINT_IMAGE_PATH']                   = 'Polku kansion /media alla, paikkamerkit kuten {item_id} sallittu.';
$SEARCH['LABEL_NONE']                        = 'ei mitään';
$SEARCH['LABEL_MODE']                        = 'Tila';
$SEARCH['MODE_SINGLE']                       = 'Yksi — yksi merkintä osiota kohden';
$SEARCH['MODE_MULTI']                        = 'Moni — yksi merkintä kohdetta kohden';
$SEARCH['LABEL_INDEX_BASE']                  = 'Hakemiston perusta';
$SEARCH['LABEL_FILTER']                      = 'Suodatin';
$SEARCH['LABEL_NO_JOIN']                     = 'ei liitosta';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Valitse kelvollinen moduulitaulu.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'Moduulin %s search.php:stä ei löytynyt käyttökelpoista taulua.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Ei sivuja',
    'one' => '%d sivu',
    'other' => '%d sivua',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Tallenna';
$SEARCH['MSG_SECURITY_ERROR']                = 'Turvatarkistus epäonnistui.';
$SEARCH['STATUS_ACTIVE']                     = 'Aktiivinen';
$SEARCH['STATUS_INACTIVE']                   = 'Ei aktiivinen';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'ei','eivät','emme','en','et','ette','että','he','heidän','hän','hänen','ja',
    'jo','joka','jos','jotka','kanssa','keitä','kenen','kuin','kuka','kun','me',
    'meidän','mikä','mitä','mutta','myös','ne','niin','nyt','olen','olet','oli',
    'olivat','olla','olemme','olette','on','ovat','se','sekä','sen','siis','sinä',
    'sinun','tai','te','teidän','tämä','tässä','tuo','vaan','vai','vain','voi',
    'yli','minä','minun','mikään','niiden','sitä','tätä','joita','johon','jossa',
    'josta','siihen','siinä','siitä','kaikki','paljon','missä','miksi','miten',
    'koska',
];
