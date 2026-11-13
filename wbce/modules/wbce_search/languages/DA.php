<?php
/**
 * wbce_search - languages/DA.php
 * Dansk
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Avancerede søgeindstillinger. Indeks, moduler, layouts og statistik for WBCE CMS-søgningen: fuldtekstsøgning med operatorer, forslag mens du skriver, fremhævning af resultater på målsiden og tag-sky.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Søg';
$SEARCH['SEARCH_HEADING']                    = 'Søgning';
$SEARCH['RESULTS_FOR']                       = 'Resultater for';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Ingen resultater',
    'one' => '%d resultat',
    'other' => '%d resultater',
];
$SEARCH['NO_RESULTS']                        = 'Ingen resultater fundet.';
$SEARCH['ALL_WORDS']                         = 'Alle ord';
$SEARCH['ANY_WORDS']                         = 'Et af ordene';
$SEARCH['EXACT_MATCH']                       = 'Præcis sætning';
$SEARCH['MATCH']                             = 'Søgetilstand';
$SEARCH['PAGES']                             = 'Sider';
$SEARCH['TIPS_TITLE']                        = 'Søgetips:';
$SEARCH['TIP_FEWER']                         = 'Brug færre søgeord';
$SEARCH['TIP_OR']                            = 'ELLER-søgning:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'andetOrd';
$SEARCH['TIP_NOT']                           = 'Udelad:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'udelad';
$SEARCH['TIP_PHRASE']                        = 'Præcis sætning:';
$SEARCH['TIP_WILDCARD']                      = 'Jokertegn:';
$SEARCH['TIP_FUZZY']                         = 'Tillad tastefejl:';
$SEARCH['DID_YOU_MEAN']                      = 'Mente du:';
$SEARCH['SCOPE_TITLE']                       = 'Kun titel';
$SEARCH['SCOPE_CONTENT']                     = 'Kun indhold';
$SEARCH['SEARCH_OR']                         = 'ELLER-søgning (mindst ét ord)';
$SEARCH['AREAS_TITLE']                       = 'Gennemse efter emne:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Ofte søgt:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'søgt én gang',
    'other' => 'søgt %d gange',
];
$SEARCH['HIT_CONTENT']                       = 'Indhold';
$SEARCH['HIT_KEYWORD']                       = 'Nøgleord';
$SEARCH['HIT_DESCRIPTION']                   = 'Beskrivelse';
$SEARCH['HIT_TITLE']                         = 'Titel';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Jokertegn';
$SEARCH['LEGEND_FUZZY']                      = 'Tillad tastefejl';
$SEARCH['LEGEND_PHRASE']                     = 'Præcis sætning';
$SEARCH['LEGEND_EXCLUDE']                    = 'Udelad ord';
$SEARCH['LEGEND_OR']                         = 'Et af ordene';
$SEARCH['LEGEND_COMBINATION']                = 'Kombination';
$SEARCH['LEGEND_OPERATORS']                  = 'Operatorer';
$SEARCH['OP_EXCLUDE']                        = 'udelad';
$SEARCH['OP_WILDCARD']                       = 'joker';
$SEARCH['OP_TYPOS']                          = 'tastefejl';
$SEARCH['OP_PHRASE']                         = 'sætning';
$SEARCH['OP_OR']                             = 'eller';
$SEARCH['EXAMPLE_WORD']                      = 'sennep';
$SEARCH['EXAMPLE_WORD2']                     = 'økologisk';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'stærk';
$SEARCH['EXAMPLE_OR']                        = 'ketchup';
$SEARCH['EXAMPLE_PHRASE']                    = 'gul sennep';
$SEARCH['EXAMPLE_PHRASE2']                   = 'af majs';
$SEARCH['LABEL_LEGEND']                      = 'Signaturforklaring';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Ord fundet i sidens indhold';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Ord fundet i sidens nøgleord';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Ord fundet i sidens beskrivelse';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Ord fundet i titlen';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Ord i indhold og nøgleord';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Ord i indhold og beskrivelse';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Ord i nøgleord og beskrivelse';
$SEARCH['LEGEND_HIT_ALL']                    = 'Ord i alle tre felter';
$SEARCH['PAGE_PREV']                         = 'Forrige side';
$SEARCH['PAGE_NEXT']                         = 'Næste side';
$SEARCH['DROPLET_DESCRIPTION']               = 'Tagsky med de mest søgte ord. Parametre: max=20, min_count=1, desc=Etiket, active=true (false = skjult)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Oversigt';
$SEARCH['MENU_MODULES']                      = 'Moduler';
$SEARCH['MENU_LAYOUT']                       = 'Layout';
$SEARCH['MENU_SETTINGS']                     = 'Indstillinger';
$SEARCH['MENU_STATS']                        = 'Statistik';
$SEARCH['CRUMB_OVERVIEW']                    = 'Søgeindeksets status og vedligeholdelse';
$SEARCH['CRUMB_MODULES']                     = 'Hvilke moduler der fylder søgeindekset';
$SEARCH['CRUMB_LAYOUT']                      = 'Skabelon for resultatsiden';
$SEARCH['CRUMB_SETTINGS']                    = 'Søgeadfærd, live-søgning, tagsky';
$SEARCH['CRUMB_STATS']                       = 'Hvad besøgende søger efter';
$SEARCH['LEDE_OVERVIEW']                     = 'Aktuel status for søgeindekset og søgningen på hjemmesiden.';
$SEARCH['LEDE_MODULES']                      = 'Hvordan hvert installeret modul indekseres. Moduler uden definition bidrager kun med deres sidetitel.';
$SEARCH['LEDE_LAYOUT']                       = 'Hvilket layout og hvilket stylesheet søgesiden og tagskyen bruger. Medfølgende filer og filer fra skabelonen forbliver uændrede; du redigerer altid din egen kopi.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Resultatside';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Layout af siden /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Tagsky';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Layout af droplet [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Stylesheet';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Til resultatsiden og tagskyen';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'CSS fra %1$s vises her · "Rediger" opretter %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Intet stylesheet';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'skabelonen leverer selv alle stilarter';
$SEARCH['LAYOUT_ACTIVE']                     = 'aktiv';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'egen fil';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'fra skabelonen "%s"';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'medfølgende';
$SEARCH['LAYOUT_READONLY']                   = 'skrivebeskyttet';
$SEARCH['LAYOUT_MODIFIED']                   = 'ændret %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'skabelonfilen %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'den medfølgende fil %s';
$SEARCH['BTN_EDIT']                          = 'Rediger';
$SEARCH['BTN_DELETE']                        = 'Slet';
$SEARCH['BTN_BACK']                          = 'Tilbage';
$SEARCH['BTN_SAVE_BACK']                     = 'Gem & tilbage';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "En ny fil %1\$s oprettes som kopi af %2\$s.\n\nKopien redigeres og bliver det aktive layout; originalen forbliver uændret.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s findes allerede. Overskrive den med indholdet af %2\$s og redigere den?\n\nDin nuværende version af %1\$s går tabt.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Slet %s?\n\nDette kan ikke fortrydes.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Aktivt layout: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s oprettet';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s slettet';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Stylesheet: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Vægtning, uddrag, live-søgning og tagsky.';
$SEARCH['LEDE_STATS']                        = 'Søgeord registreret til tagskyen (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Søgeindeks';
$SEARCH['INDEX_BUILD']                       = 'Fuld genopbygning';
$SEARCH['INDEX_UPDATE']                      = 'Opdater ændringer';
$SEARCH['INDEX_CLEAR']                       = 'Tøm indeks';
$SEARCH['ENTRIES']                           = 'Poster';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Indeks bygget — intet at indeksere.',
    'one' => 'Indeks bygget: %d post.',
    'other' => 'Indeks bygget: %d poster.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Intet at opdatere.',
    'one' => '%d post opdateret.',
    'other' => '%d poster opdateret.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Indeks slettet.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Vil du virkelig slette hele indekset?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Søgning på hjemmesiden';
$SEARCH['LABEL_LAST_INDEXED']                = 'Senest indekseret';
$SEARCH['INDEX_BUILD_DESC']                  = 'Læser <b>alle</b> søgbare sektioner igen. Tager tid på store hjemmesider.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Læser kun ændrede eller manglende sektioner. Hurtigere end en fuld genopbygning.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Læser kun ændrede eller manglende sektioner. Intet at gøre lige nu.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Tømmer indekset. Søgningen finder intet, før det er genopbygget.';
$SEARCH['LABEL_FRESHNESS']                   = 'Aktualitet';
$SEARCH['FRESH_ALL']                         = '<b>Indekset er opdateret</b> — alle %d sektioner svarer til deres seneste ændring.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d af %2$d</b> sektioner er ændret eller mangler.';
$SEARCH['FRESH_NONE']                        = 'Endnu ingen søgbare sektioner.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Søgning på hjemmesiden';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Indstillinger › Søgning';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Offentlig';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Registrerede';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privat';
$SEARCH['SITE_SEARCH_NONE']                  = 'Fra';
$SEARCH['HINT_SITE_SEARCH']                  = 'Hvem må søge — for hvert søgefelt på hjemmesiden, uanset hvilken søgning der ligger bag. Samme indstilling som under <a href="%s">Indstillinger › Søgning</a>; "Registrerede" og "Privat" betyder begge: kun indloggede besøgende.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Sæt søgningen på hjemmesiden til \"%s\"?\n\nDette ændrer hjemmesidens indstilling \"Søgning\" for alle besøgende.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Søgning på hjemmesiden: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Sprog';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Ingen sproginformation';
$SEARCH['VIS_HIDDEN']                        = 'Skjult';
$SEARCH['VIS_PUBLIC']                        = 'Offentlig';
$SEARCH['VIS_PRIVATE']                       = 'Privat';
$SEARCH['VIS_REGISTERED']                    = 'Registrerede';
$SEARCH['VIS_NONE']                          = 'Ingen';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Layoutet er tomt og blev ikke gemt.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Kunne ikke skrive search_custom.htt. Kontroller skriverettighederne for mappen layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Når "AjaxSave" er markeret, gemmer Gem og Ctrl+S uden at genindlæse siden; "Gem & tilbage" skjules da.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Minimum ordlængde';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Kortere ord ignoreres';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Titelvægtning';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Træf i titlen × faktor';
$SEARCH['SET_MAX_EXCERPT']                   = 'Maks. længde af uddrag';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Tegn pr. uddrag';
$SEARCH['SET_HIGHLIGHT']                     = 'Fremhævning';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Fremhæv søgeord i uddraget';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Fremhævningstag';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'HTML-tag til fremhævningen';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Resultater pr. side';
$SEARCH['SET_AUTO_REINDEX']                  = 'Automatisk genindeksering ved søgning';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Opdaterer forældede poster i det stille ved hver søgning';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Vis tagsky';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'På søgesiden. Droplet har sin egen parameter active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Registrer søgninger';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Registrerer søgninger til tagskyen og statistikken — at slå det fra skjuler ikke skyen';
$SEARCH['SET_AJAX_SUGGEST']                  = 'AJAX live-søgning';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Vis forslag under indtastning';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Fejlfindingstilstand';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Vis tekniske data under hvert søgeresultat (kun administratorer)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Skabelon for søgesiden';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Frontend-skabelon som siden /search/ vises i.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Hjemmesidens standardskabelon (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Søgning';
$SEARCH['GROUP_DISPLAY']                     = 'Visning af resultater';
$SEARCH['GROUP_INDEX']                       = 'Vedligeholdelse af indeks';
$SEARCH['GROUP_LIVE']                        = 'Live-søgning';
$SEARCH['GROUP_TAGCLOUD']                    = 'Tagsky';
$SEARCH['GROUP_ADMIN']                       = 'Admin-værktøj';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Sidestørrelse for resultatlisten';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Sprogfilter';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Vis kun sider på den besøgendes sprog (hjemmesidens standard: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Avanceret søgning';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Vis afkrydsningsfelter for søgeområde og ELLER-valg i søgeformularen';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Maks. sektioner pr. søgning';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Grænse for automatisk genindeksering (belastningsstyring)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Kilde til forslag';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Hybrid viser først titeltræf og supplerer med sider, der indeholder ordet i deres tekst';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Maks. forslag';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Antal viste forslag';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Billeder i forslag';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Viser elementets billede (katalog, nyheder …) ved siden af forslaget, hvis modulet indekserer et';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Maks. tags';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Antal ord vist i tagskyen';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min. søgninger';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Mindste antal søgninger, før et ord vises';
$SEARCH['SET_NAV_STYLE']                     = 'Navigation';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Faner foroven eller en ikonbjælke til venstre';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Titler først, suppleret fra fuldteksten (anbefalet)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Titel + beskrivelse (hurtig)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Fuldtekstindeks (grundig)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Faner foroven';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Sidebjælke til venstre';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Endpoint';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Registreres automatisk på søgesiden for felter med navnet "string", type="search" eller klassen ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Indstillinger gemt.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Søgestatistik slettet.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Vil du virkelig slette al statistik?';
$SEARCH['STATS_DELETE']                      = 'Slet statistik';
$SEARCH['STATS_TERM']                        = 'Søgeord';
$SEARCH['STATS_COUNT']                       = 'Antal';
$SEARCH['STATS_LAST']                        = 'Senest søgt';
$SEARCH['STATS_TERMS']                       = 'Ord';
$SEARCH['STATS_SEARCHES']                    = 'Søgninger';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 af %d ord.',
    'other' => 'Top 100 af %d ord.',
];
$SEARCH['STATS_EMPTY']                       = 'Endnu ingen søgeord registreret.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Søgt, intet fundet';
$SEARCH['HINT_STATS_MISSES']                 = 'Hele søgninger uden resultat — et fingerpeg om indhold, dine besøgende forventer men ikke finder. Vises aldrig offentligt.';
$SEARCH['STATS_QUERY']                       = 'Søgning';
$SEARCH['STATS_MISSES_EMPTY']                = 'Ingen søgninger uden resultat registreret.';
$SEARCH['CARD_WORDS']                        = 'Ordindeks';
$SEARCH['HINT_WORDS']                        = 'Til store hjemmesider: en liste over alle ord, så en søgning ikke længere skal læse hele indekset. Bygges automatisk fra %s indeksposter.';
$SEARCH['WORDS_INACTIVE']                    = 'Ikke aktivt — hjemmesiden ligger under tærsklen (%2$s indeksposter, i øjeblikket %1$s); den normale søgning er hurtig nok.';
$SEARCH['WORDS_OFF']                         = 'Slået fra i indstillingerne.';
$SEARCH['WORDS_BUILDING']                    = 'Under opbygning';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Fortsæt opbygningen';
$SEARCH['MSG_WORDS_READY']                   = 'Ordindeks færdigt.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Ordindeks: %d post mangler stadig — indtil da bruges den normale søgning.',
    'other' => 'Ordindeks: %d poster mangler stadig — indtil da bruges den normale søgning.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'I brug — %d ordpost.',
    'other' => 'I brug — %d ordposter.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Ordindeks';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automatisk: bygges kun, når hjemmesiden når tærsklen nedenfor. Små hjemmesider har ikke brug for det.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automatisk';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Altid til';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Fra';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Ordindeks fra';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Antal indekserede poster (sektioner og modulelementer), hvorfra ordindekset bygges automatisk';
$SEARCH['BTN_DELETE_TERM']                   = 'Fjern dette ord';
$SEARCH['MSG_TERM_DELETED']                  = 'Ord fjernet.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Semi-konfiguration for <b>%s</b> forudfyldt fra search.php — kontroller og tilpas.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Semi-konfiguration for \'%s\' gemt.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Konfiguration og indeksposter for %s slettet.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php genereret. Genopbyg venligst indekset.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Slet konfiguration og indeksposter for %s?';
$SEARCH['STATUS_SEMI']                       = 'Semi-konfiguration';
$SEARCH['LABEL_GUIDE']                       = 'Vis vejledning til dette modul';
$SEARCH['LABEL_TABLE_HINT']                  = 'Vælg tabel → kolonnerne indlæses automatisk';
$SEARCH['LABEL_TABLE_SELECT']                = 'Vælg tabel';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'WBCE-sideanker';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Kun søgbare sider';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Alle sektioner (indholdspulje)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Kun aktive poster (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Tidsstyring (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joins (valgfrit, maks. 3) — data fra yderligere tabeller';
$SEARCH['LABEL_GENERATE_DEF']                = 'Generer module_defs-fil';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Fra search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Slet konfiguration';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Ingen tekstkolonner';
$SEARCH['LABEL_ERROR']                       = 'Fejl';
$SEARCH['LABEL_MODULE']                      = 'Modul';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Ikke søgbar';
$SEARCH['LABEL_HELP']                        = 'Hjælp';
$SEARCH['BTN_CONFIGURE']                     = 'Konfigurer';
$SEARCH['BTN_CLOSE']                         = 'Luk';
$SEARCH['DEF_GENERATED']                     = 'genereret';
$SEARCH['DEF_SHIPPED']                       = 'indbygget';
$SEARCH['LABEL_KIND']                        = 'Type';
$SEARCH['LABEL_INDEXING']                    = 'Indeksering';
$SEARCH['LABEL_SECTIONS']                    = 'Sektioner';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtrer …';
$SEARCH['MODULES_SHOWN']                     = '%1$d af %2$d moduler vist';
$SEARCH['KIND_PAGE']                         = 'Sidemoduler';
$SEARCH['KIND_SNIPPET']                      = 'Snippets';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtre';
$SEARCH['KIND_TOOL']                         = 'Admin-værktøjer';
$SEARCH['BADGE_PAGE']                        = 'Side';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filter';
$SEARCH['BADGE_TOOL']                        = 'Værktøj';
$SEARCH['GROUP_DEF']                         = 'med definition';
$SEARCH['GROUP_OPEN']                        = 'ufuldstændig';
$SEARCH['GROUP_TITLE']                       = 'kun sidetitel';
$SEARCH['SOURCE_MODULE']                     = 'Fra modul';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Indbygget';
$SEARCH['SOURCE_GENERATED']                  = 'Semi-konfiguration';
$SEARCH['SOURCE_SEMI']                       = 'Semi-konfiguration – ikke genereret';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php fundet';
$SEARCH['SOURCE_TITLE']                      = 'Kun sidetitel';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Modulet leverer sin egen søgedefinition (search_index.php) — kan ikke redigeres her.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indekseres via et PHP-callback — kan ikke redigeres her.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definition leveret med WBCE Search (module_defs/). En semi-konfiguration har forrang.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definition genereret ud fra semi-konfigurationen.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Semi-konfiguration gemt, men endnu ingen definition genereret.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Endnu ingen definition — kan forudfyldes fra modulets gamle search.php.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Ingen definition — indekset indeholder kun sidetitlen.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Ingen sidesektioner — intet at indeksere.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Søgning slået fra for denne side';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Indbygget definition. Når du gemmer, oprettes en semi-konfiguration, der har forrang.';
$SEARCH['LABEL_TABLE']                       = 'Tabel';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tabeller i dette modul';
$SEARCH['LABEL_OTHER_TABLES']                = 'Andre modultabeller';
$SEARCH['HINT_TABLE']                        = 'Kun mod_*-tabeller med en section_id-kolonne kan indekseres.';
$SEARCH['LABEL_ID_FIELD']                    = 'ID-kolonne';
$SEARCH['LABEL_ITEM_KEY']                    = 'Elementnøgle';
$SEARCH['HINT_ITEM_KEY']                     = 'Unik nøgle pr. element (multitilstand).';
$SEARCH['LABEL_TITLE_COL']                   = 'Titelkolonne';
$SEARCH['LABEL_TEXT_COLS']                   = 'Tekstkolonner';
$SEARCH['LABEL_LINK_COL']                    = 'Linkkolonne';
$SEARCH['HINT_LINK_PREFIX']                  = 'Valgfrit præfiks: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Billedkolonne';
$SEARCH['HINT_IMAGE_PATH']                   = 'Sti under /media, pladsholdere som {item_id} tilladt.';
$SEARCH['LABEL_NONE']                        = 'ingen';
$SEARCH['LABEL_MODE']                        = 'Tilstand';
$SEARCH['MODE_SINGLE']                       = 'Enkelt — én post pr. sektion';
$SEARCH['MODE_MULTI']                        = 'Multi — én post pr. element';
$SEARCH['LABEL_INDEX_BASE']                  = 'Indeksgrundlag';
$SEARCH['LABEL_FILTER']                      = 'Filter';
$SEARCH['LABEL_NO_JOIN']                     = 'ingen join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Vælg en gyldig modultabel.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'Ingen brugbar tabel fundet i search.php for %s.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Ingen sider',
    'one' => '%d side',
    'other' => '%d sider',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Gem';
$SEARCH['MSG_SECURITY_ERROR']                = 'Sikkerhedskontrol mislykkedes.';
$SEARCH['STATUS_ACTIVE']                     = 'Aktiv';
$SEARCH['STATUS_INACTIVE']                   = 'Inaktiv';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'af','alle','alt','anden','at','blev','blive','bliver','da','de','dem','den',
    'denne','der','deres','det','dette','dig','din','dine','disse','dit','dog','du',
    'efter','eller','en','end','er','et','for','fra','ham','han','hans','har',
    'havde','have','hende','hendes','her','hos','hun','hvad','hvis','hvor','i',
    'ikke','ind','jeg','jer','jo','kan','kunne','man','mange','med','meget','men',
    'mig','min','mine','mit','mod','ned','noget','nogle','nu','når','og','også',
    'om','op','os','over','på','selv','sig','sin','sine','sit','skal','skulle',
    'som','sådan','thi','til','ud','under','var','vi','vil','ville','vor','være',
    'været',
];
