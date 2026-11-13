<?php
/**
 * wbce_search - languages/NO.php
 * Norsk (bokmål)
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Avanserte søkeinnstillinger. Indeks, moduler, oppsett og statistikk for søket i WBCE CMS: fulltekstsøk med operatorer, forslag mens du skriver, utheving av treff på målsiden og stikkordsky.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Søk';
$SEARCH['SEARCH_HEADING']                    = 'Søk';
$SEARCH['RESULTS_FOR']                       = 'Resultater for';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Ingen resultater',
    'one' => '%d resultat',
    'other' => '%d resultater',
];
$SEARCH['NO_RESULTS']                        = 'Ingen resultater funnet.';
$SEARCH['ALL_WORDS']                         = 'Alle ord';
$SEARCH['ANY_WORDS']                         = 'Ett av ordene';
$SEARCH['EXACT_MATCH']                       = 'Nøyaktig frase';
$SEARCH['MATCH']                             = 'Søkemodus';
$SEARCH['PAGES']                             = 'Sider';
$SEARCH['TIPS_TITLE']                        = 'Søketips:';
$SEARCH['TIP_FEWER']                         = 'Bruk færre søkeord';
$SEARCH['TIP_OR']                            = 'ELLER-søk:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'annetOrd';
$SEARCH['TIP_NOT']                           = 'Utelat:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'utelat';
$SEARCH['TIP_PHRASE']                        = 'Nøyaktig frase:';
$SEARCH['TIP_WILDCARD']                      = 'Jokertegn:';
$SEARCH['TIP_FUZZY']                         = 'Tillat skrivefeil:';
$SEARCH['DID_YOU_MEAN']                      = 'Mente du:';
$SEARCH['SCOPE_TITLE']                       = 'Bare tittel';
$SEARCH['SCOPE_CONTENT']                     = 'Bare innhold';
$SEARCH['SEARCH_OR']                         = 'ELLER-søk (minst ett ord)';
$SEARCH['AREAS_TITLE']                       = 'Bla etter emne:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Ofte søkt:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'søkt én gang',
    'other' => 'søkt %d ganger',
];
$SEARCH['HIT_CONTENT']                       = 'Innhold';
$SEARCH['HIT_KEYWORD']                       = 'Nøkkelord';
$SEARCH['HIT_DESCRIPTION']                   = 'Beskrivelse';
$SEARCH['HIT_TITLE']                         = 'Tittel';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Jokertegn';
$SEARCH['LEGEND_FUZZY']                      = 'Tillat skrivefeil';
$SEARCH['LEGEND_PHRASE']                     = 'Nøyaktig frase';
$SEARCH['LEGEND_EXCLUDE']                    = 'Utelat ord';
$SEARCH['LEGEND_OR']                         = 'Ett av ordene';
$SEARCH['LEGEND_COMBINATION']                = 'Kombinasjon';
$SEARCH['LEGEND_OPERATORS']                  = 'Operatorer';
$SEARCH['OP_EXCLUDE']                        = 'utelat';
$SEARCH['OP_WILDCARD']                       = 'joker';
$SEARCH['OP_TYPOS']                          = 'skrivefeil';
$SEARCH['OP_PHRASE']                         = 'frase';
$SEARCH['OP_OR']                             = 'eller';
$SEARCH['EXAMPLE_WORD']                      = 'sennep';
$SEARCH['EXAMPLE_WORD2']                     = 'økologisk';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'sterk';
$SEARCH['EXAMPLE_OR']                        = 'ketchup';
$SEARCH['EXAMPLE_PHRASE']                    = 'gul sennep';
$SEARCH['EXAMPLE_PHRASE2']                   = 'av mais';
$SEARCH['LABEL_LEGEND']                      = 'Tegnforklaring';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Ordet funnet i sidens innhold';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Ordet funnet i sidens nøkkelord';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Ordet funnet i sidens beskrivelse';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Ordet funnet i tittelen';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Ord i innhold og nøkkelord';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Ord i innhold og beskrivelse';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Ord i nøkkelord og beskrivelse';
$SEARCH['LEGEND_HIT_ALL']                    = 'Ord i alle tre feltene';
$SEARCH['PAGE_PREV']                         = 'Forrige side';
$SEARCH['PAGE_NEXT']                         = 'Neste side';
$SEARCH['DROPLET_DESCRIPTION']               = 'Ordsky med de mest søkte ordene. Parametere: max=20, min_count=1, desc=Etikett, active=true (false = skjult)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Oversikt';
$SEARCH['MENU_MODULES']                      = 'Moduler';
$SEARCH['MENU_LAYOUT']                       = 'Layout';
$SEARCH['MENU_SETTINGS']                     = 'Innstillinger';
$SEARCH['MENU_STATS']                        = 'Statistikk';
$SEARCH['CRUMB_OVERVIEW']                    = 'Søkeindeksens status og vedlikehold';
$SEARCH['CRUMB_MODULES']                     = 'Hvilke moduler som fyller søkeindeksen';
$SEARCH['CRUMB_LAYOUT']                      = 'Mal for resultatsiden';
$SEARCH['CRUMB_SETTINGS']                    = 'Søkeatferd, direktesøk, ordsky';
$SEARCH['CRUMB_STATS']                       = 'Hva besøkende søker etter';
$SEARCH['LEDE_OVERVIEW']                     = 'Nåværende status for søkeindeksen og søket på nettstedet.';
$SEARCH['LEDE_MODULES']                      = 'Hvordan hver installerte modul indekseres. Moduler uten definisjon bidrar bare med sidetittelen.';
$SEARCH['LEDE_LAYOUT']                       = 'Hvilken layout og hvilket stilark søkesiden og ordskyen bruker. Medfølgende filer og filer fra malen forblir uendret; du redigerer alltid din egen kopi.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Resultatside';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Layout for siden /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Ordsky';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Layout for droplet [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Stilark';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'For resultatsiden og ordskyen';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'CSS fra %1$s vises her · «Rediger» oppretter %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Intet stilark';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'malen har alle stiler selv';
$SEARCH['LAYOUT_ACTIVE']                     = 'aktiv';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'egen fil';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'fra malen «%s»';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'medfølgende';
$SEARCH['LAYOUT_READONLY']                   = 'skrivebeskyttet';
$SEARCH['LAYOUT_MODIFIED']                   = 'endret %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'malfilen %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'den medfølgende filen %s';
$SEARCH['BTN_EDIT']                          = 'Rediger';
$SEARCH['BTN_DELETE']                        = 'Slett';
$SEARCH['BTN_BACK']                          = 'Tilbake';
$SEARCH['BTN_SAVE_BACK']                     = 'Lagre og tilbake';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "En ny fil %1\$s opprettes som kopi av %2\$s.\n\nKopien redigeres og blir den aktive layouten; originalen forblir uendret.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s finnes allerede. Overskrive den med innholdet i %2\$s og redigere den?\n\nDin nåværende versjon av %1\$s går tapt.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Slette %s?\n\nDette kan ikke angres.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Aktiv layout: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s opprettet';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s slettet';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Stilark: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Vekting, utdrag, direktesøk og ordsky.';
$SEARCH['LEDE_STATS']                        = 'Søkeord registrert for ordskyen (topp 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Søkeindeks';
$SEARCH['INDEX_BUILD']                       = 'Full gjenoppbygging';
$SEARCH['INDEX_UPDATE']                      = 'Oppdater endringer';
$SEARCH['INDEX_CLEAR']                       = 'Tøm indeks';
$SEARCH['ENTRIES']                           = 'Oppføringer';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Indeks bygget — ingenting å indeksere.',
    'one' => 'Indeks bygget: %d oppføring.',
    'other' => 'Indeks bygget: %d oppføringer.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Ingenting å oppdatere.',
    'one' => '%d oppføring oppdatert.',
    'other' => '%d oppføringer oppdatert.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Indeks slettet.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Vil du virkelig slette hele indeksen?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Søk på nettstedet';
$SEARCH['LABEL_LAST_INDEXED']                = 'Sist indeksert';
$SEARCH['INDEX_BUILD_DESC']                  = 'Leser <b>alle</b> søkbare seksjoner på nytt. Tar tid på store nettsteder.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Leser bare endrede eller manglende seksjoner. Raskere enn full gjenoppbygging.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Leser bare endrede eller manglende seksjoner. Ingenting å gjøre akkurat nå.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Tømmer indeksen. Søket finner ingenting før den er bygget på nytt.';
$SEARCH['LABEL_FRESHNESS']                   = 'Aktualitet';
$SEARCH['FRESH_ALL']                         = '<b>Indeksen er oppdatert</b> — alle %d seksjoner samsvarer med siste endring.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d av %2$d</b> seksjoner er endret eller mangler.';
$SEARCH['FRESH_NONE']                        = 'Ingen søkbare seksjoner ennå.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Søk på nettstedet';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Innstillinger › Søk';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Offentlig';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Registrerte';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privat';
$SEARCH['SITE_SEARCH_NONE']                  = 'Av';
$SEARCH['HINT_SITE_SEARCH']                  = 'Hvem som kan søke — for hvert søkefelt på nettstedet, uansett hvilket søk som ligger bak. Samme innstilling som under <a href="%s">Innstillinger › Søk</a>; «Registrerte» og «Privat» betyr begge: bare innloggede besøkende.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Sette søket på nettstedet til «%s»?\n\nDette endrer nettstedets innstilling «Søk» for alle besøkende.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Søk på nettstedet: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Språk';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Ingen språkinformasjon';
$SEARCH['VIS_HIDDEN']                        = 'Skjult';
$SEARCH['VIS_PUBLIC']                        = 'Offentlig';
$SEARCH['VIS_PRIVATE']                       = 'Privat';
$SEARCH['VIS_REGISTERED']                    = 'Registrerte';
$SEARCH['VIS_NONE']                          = 'Ingen';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Layouten er tom og ble ikke lagret.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Kunne ikke skrive search_custom.htt. Kontroller skrivetilgangen til mappen layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Når «AjaxSave» er krysset av, lagrer Lagre og Ctrl+S uten å laste siden på nytt; «Lagre og tilbake» skjules da.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Minste ordlengde';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Kortere ord ignoreres';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Titelvekting';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Treff i tittelen × faktor';
$SEARCH['SET_MAX_EXCERPT']                   = 'Maks. lengde på utdrag';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Tegn per utdrag';
$SEARCH['SET_HIGHLIGHT']                     = 'Utheving';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Uthev søkeord i utdraget';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Uthevingstagg';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'HTML-tagg som brukes til uthevingen';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Resultater per side';
$SEARCH['SET_AUTO_REINDEX']                  = 'Automatisk reindeksering ved søk';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Oppdaterer utdaterte oppføringer i det stille ved hvert søk';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Vis ordsky';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'På søkesiden. Droplet har sin egen parameter active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Registrer søk';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Registrerer søk for ordskyen og statistikken — å slå det av skjuler ikke skyen';
$SEARCH['SET_AJAX_SUGGEST']                  = 'AJAX direktesøk';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Vis forslag mens du skriver';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Feilsøkingsmodus';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Vis tekniske data under hvert søkeresultat (bare administratorer)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Mal for søkesiden';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Frontend-mal som siden /search/ vises i.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Nettstedets standardmal (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Søk';
$SEARCH['GROUP_DISPLAY']                     = 'Visning av resultater';
$SEARCH['GROUP_INDEX']                       = 'Vedlikehold av indeks';
$SEARCH['GROUP_LIVE']                        = 'Direktesøk';
$SEARCH['GROUP_TAGCLOUD']                    = 'Ordsky';
$SEARCH['GROUP_ADMIN']                       = 'Adminverktøy';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Sidestørrelse for resultatlisten';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Språkfilter';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Vis bare sider på den besøkendes språk (nettstedets standard: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Avansert søk';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Vis avkrysningsbokser for søkeområde og ELLER-valg i søkeskjemaet';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Maks. seksjoner per søk';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Grense for automatisk reindeksering (belastningskontroll)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Kilde for forslag';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Hybrid viser først titteltreff og fyller på med sider som inneholder ordet i teksten';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Maks. forslag';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Antall forslag som vises';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Bilder i forslag';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Viser elementets bilde (katalog, nyheter …) ved siden av forslaget, hvis modulen indekserer et';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Maks. tagger';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Antall ord som vises i ordskyen';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min. søk';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Minste antall søk før et ord vises';
$SEARCH['SET_NAV_STYLE']                     = 'Navigasjon';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Faner øverst eller en ikonlinje til venstre';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Titler først, supplert fra fulltekst (anbefalt)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Tittel + beskrivelse (raskt)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Fulltekstindeks (grundig)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Faner øverst';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Sidelinje til venstre';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Endepunkt';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Gjenkjennes automatisk på søkesiden for felt med navnet «string», type="search" eller klassen ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Innstillinger lagret.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Søkestatistikk slettet.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Vil du virkelig slette all statistikk?';
$SEARCH['STATS_DELETE']                      = 'Slett statistikk';
$SEARCH['STATS_TERM']                        = 'Søkeord';
$SEARCH['STATS_COUNT']                       = 'Antall';
$SEARCH['STATS_LAST']                        = 'Sist søkt';
$SEARCH['STATS_TERMS']                       = 'Ord';
$SEARCH['STATS_SEARCHES']                    = 'Søk';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Topp 100 av %d ord.',
    'other' => 'Topp 100 av %d ord.',
];
$SEARCH['STATS_EMPTY']                       = 'Ingen søkeord registrert ennå.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Søkt, ingenting funnet';
$SEARCH['HINT_STATS_MISSES']                 = 'Hele søk uten resultat — et hint om innhold de besøkende forventer, men ikke finner. Vises aldri offentlig.';
$SEARCH['STATS_QUERY']                       = 'Søk';
$SEARCH['STATS_MISSES_EMPTY']                = 'Ingen søk uten resultat registrert.';
$SEARCH['CARD_WORDS']                        = 'Ordindeks';
$SEARCH['HINT_WORDS']                        = 'For store nettsteder: en liste over alle ord, slik at et søk ikke lenger må lese hele indeksen. Bygges automatisk fra %s indeksoppføringer.';
$SEARCH['WORDS_INACTIVE']                    = 'Ikke aktiv — nettstedet er under terskelen (%2$s indeksoppføringer, nå %1$s); det vanlige søket er raskt nok.';
$SEARCH['WORDS_OFF']                         = 'Slått av i innstillingene.';
$SEARCH['WORDS_BUILDING']                    = 'Bygges';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Fortsett byggingen';
$SEARCH['MSG_WORDS_READY']                   = 'Ordindeks ferdig.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Ordindeks: %d oppføring gjenstår — til da brukes det vanlige søket.',
    'other' => 'Ordindeks: %d oppføringer gjenstår — til da brukes det vanlige søket.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'I bruk — %d ordoppføring.',
    'other' => 'I bruk — %d ordoppføringer.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Ordindeks';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automatisk: bygges bare når nettstedet når terskelen nedenfor. Små nettsteder trenger den ikke.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automatisk';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Alltid på';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Av';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Ordindeks fra';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Antall indekserte oppføringer (seksjoner og modulelementer) som ordindeksen bygges automatisk fra';
$SEARCH['BTN_DELETE_TERM']                   = 'Fjern dette ordet';
$SEARCH['MSG_TERM_DELETED']                  = 'Ord fjernet.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Semikonfigurasjon for <b>%s</b> forhåndsutfylt fra search.php — kontroller og juster.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Semikonfigurasjon for \'%s\' lagret.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Konfigurasjon og indeksoppføringer for %s slettet.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php generert. Bygg indeksen på nytt.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Slette konfigurasjon og indeksoppføringer for %s?';
$SEARCH['STATUS_SEMI']                       = 'Semikonfigurasjon';
$SEARCH['LABEL_GUIDE']                       = 'Vis veiledning for denne modulen';
$SEARCH['LABEL_TABLE_HINT']                  = 'Velg tabell → kolonnene lastes automatisk';
$SEARCH['LABEL_TABLE_SELECT']                = 'Velg tabell';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'WBCE-sideanker';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Bare søkbare sider';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Alle seksjoner (innholdsbasseng)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Bare aktive oppføringer (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Tidsstyring (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joins (valgfritt, maks. 3) — data fra flere tabeller';
$SEARCH['LABEL_GENERATE_DEF']                = 'Generer module_defs-fil';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Fra search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Slett konfigurasjon';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Ingen tekstkolonner';
$SEARCH['LABEL_ERROR']                       = 'Feil';
$SEARCH['LABEL_MODULE']                      = 'Modul';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Ikke søkbar';
$SEARCH['LABEL_HELP']                        = 'Hjelp';
$SEARCH['BTN_CONFIGURE']                     = 'Konfigurer';
$SEARCH['BTN_CLOSE']                         = 'Lukk';
$SEARCH['DEF_GENERATED']                     = 'generert';
$SEARCH['DEF_SHIPPED']                       = 'innebygd';
$SEARCH['LABEL_KIND']                        = 'Type';
$SEARCH['LABEL_INDEXING']                    = 'Indeksering';
$SEARCH['LABEL_SECTIONS']                    = 'Seksjoner';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtrer …';
$SEARCH['MODULES_SHOWN']                     = '%1$d av %2$d moduler vist';
$SEARCH['KIND_PAGE']                         = 'Sidemoduler';
$SEARCH['KIND_SNIPPET']                      = 'Snippets';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtre';
$SEARCH['KIND_TOOL']                         = 'Adminverktøy';
$SEARCH['BADGE_PAGE']                        = 'Side';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filter';
$SEARCH['BADGE_TOOL']                        = 'Verktøy';
$SEARCH['GROUP_DEF']                         = 'med definisjon';
$SEARCH['GROUP_OPEN']                        = 'ufullstendig';
$SEARCH['GROUP_TITLE']                       = 'bare sidetittel';
$SEARCH['SOURCE_MODULE']                     = 'Fra modul';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Innebygd';
$SEARCH['SOURCE_GENERATED']                  = 'Semikonfigurasjon';
$SEARCH['SOURCE_SEMI']                       = 'Semikonfigurasjon – ikke generert';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php funnet';
$SEARCH['SOURCE_TITLE']                      = 'Bare sidetittel';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Modulen har sin egen søkedefinisjon (search_index.php) — kan ikke redigeres her.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indekseres via en PHP-callback — kan ikke redigeres her.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definisjon levert med WBCE Search (module_defs/). En semikonfigurasjon har forrang.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definisjon generert fra semikonfigurasjonen.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Semikonfigurasjon lagret, men ingen definisjon generert ennå.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Ingen definisjon ennå — kan forhåndsutfylles fra modulens gamle search.php.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Ingen definisjon — indeksen inneholder bare sidetittelen.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Ingen sideseksjoner — ingenting å indeksere.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Søk slått av for denne siden';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Innebygd definisjon. Lagring oppretter en semikonfigurasjon som har forrang.';
$SEARCH['LABEL_TABLE']                       = 'Tabell';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tabeller i denne modulen';
$SEARCH['LABEL_OTHER_TABLES']                = 'Andre modultabeller';
$SEARCH['HINT_TABLE']                        = 'Bare mod_*-tabeller med en section_id-kolonne kan indekseres.';
$SEARCH['LABEL_ID_FIELD']                    = 'ID-kolonne';
$SEARCH['LABEL_ITEM_KEY']                    = 'Elementnøkkel';
$SEARCH['HINT_ITEM_KEY']                     = 'Unik nøkkel per element (multimodus).';
$SEARCH['LABEL_TITLE_COL']                   = 'Tittelkolonne';
$SEARCH['LABEL_TEXT_COLS']                   = 'Tekstkolonner';
$SEARCH['LABEL_LINK_COL']                    = 'Lenkekolonne';
$SEARCH['HINT_LINK_PREFIX']                  = 'Valgfritt prefiks: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Bildekolonne';
$SEARCH['HINT_IMAGE_PATH']                   = 'Sti under /media, plassholdere som {item_id} er tillatt.';
$SEARCH['LABEL_NONE']                        = 'ingen';
$SEARCH['LABEL_MODE']                        = 'Modus';
$SEARCH['MODE_SINGLE']                       = 'Enkel — én oppføring per seksjon';
$SEARCH['MODE_MULTI']                        = 'Multi — én oppføring per element';
$SEARCH['LABEL_INDEX_BASE']                  = 'Indeksgrunnlag';
$SEARCH['LABEL_FILTER']                      = 'Filter';
$SEARCH['LABEL_NO_JOIN']                     = 'ingen join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Velg en gyldig modultabell.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'Ingen brukbar tabell funnet i search.php for %s.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Ingen sider',
    'one' => '%d side',
    'other' => '%d sider',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Lagre';
$SEARCH['MSG_SECURITY_ERROR']                = 'Sikkerhetskontrollen mislyktes.';
$SEARCH['STATUS_ACTIVE']                     = 'Aktiv';
$SEARCH['STATUS_INACTIVE']                   = 'Inaktiv';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'alle','at','av','bare','begge','ble','bli','blir','da','de','deg','dem','den',
    'denne','der','deres','det','dette','di','din','disse','ditt','du','eg','ein',
    'eit','eller','en','enn','er','et','etter','for','fordi','fra','før','ha',
    'hadde','han','hans','har','hennar','henne','hennes','her','hjå','ho','hun',
    'hva','hvem','hver','hvilke','hvis','hvor','hvordan','i','ikke','ikkje','ingen',
    'inn','jeg','kan','kom','kun','kunne','man','mange','me','med','meg','men','mi',
    'min','mitt','mot','mye','må','ned','noe','noen','nå','når','og','også','om',
    'opp','oss','over','på','seg','selv','sin','sine','sitt','skal','skulle','slik',
    'som','så','til','under','ut','var','vart','ved','vi','vil','ville','vore',
    'vår','være','vært',
];
