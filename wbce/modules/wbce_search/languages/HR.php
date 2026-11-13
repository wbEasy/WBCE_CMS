<?php
/**
 * wbce_search - languages/HR.php
 * Hrvatski
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Napredne postavke pretraživanja. Indeks, moduli, predlošci i statistika pretraživanja WBCE CMS-a: pretraživanje cijelog teksta s operatorima, prijedlozi uživo, isticanje rezultata na odredišnoj stranici i oblak oznaka.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Traži';
$SEARCH['SEARCH_HEADING']                    = 'Pretraživanje';
$SEARCH['RESULTS_FOR']                       = 'Rezultati za';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Nema rezultata',
    'one' => '%d rezultat',
    'few' => '%d rezultata',
    'other' => '%d rezultata',
];
$SEARCH['NO_RESULTS']                        = 'Nema pronađenih rezultata.';
$SEARCH['ALL_WORDS']                         = 'Sve riječi';
$SEARCH['ANY_WORDS']                         = 'Bilo koja riječ';
$SEARCH['EXACT_MATCH']                       = 'Točan izraz';
$SEARCH['MATCH']                             = 'Način pretraživanja';
$SEARCH['PAGES']                             = 'Stranice';
$SEARCH['TIPS_TITLE']                        = 'Savjeti za pretraživanje:';
$SEARCH['TIP_FEWER']                         = 'Koristite manje pojmova';
$SEARCH['TIP_OR']                            = 'Pretraživanje ILI:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'drugiPojam';
$SEARCH['TIP_NOT']                           = 'Isključi:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'isključi';
$SEARCH['TIP_PHRASE']                        = 'Točan izraz:';
$SEARCH['TIP_WILDCARD']                      = 'Zamjenski znak:';
$SEARCH['TIP_FUZZY']                         = 'Toleriraj tipfelere:';
$SEARCH['DID_YOU_MEAN']                      = 'Jeste li mislili:';
$SEARCH['SCOPE_TITLE']                       = 'Samo naslov';
$SEARCH['SCOPE_CONTENT']                     = 'Samo sadržaj';
$SEARCH['SEARCH_OR']                         = 'Pretraživanje ILI (barem jedan pojam)';
$SEARCH['AREAS_TITLE']                       = 'Pregled po temama:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Često traženo:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'traženo %d put',
    'few' => 'traženo %d puta',
    'other' => 'traženo %d puta',
];
$SEARCH['HIT_CONTENT']                       = 'Sadržaj';
$SEARCH['HIT_KEYWORD']                       = 'Ključna riječ';
$SEARCH['HIT_DESCRIPTION']                   = 'Opis';
$SEARCH['HIT_TITLE']                         = 'Naslov';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Zamjenski znak';
$SEARCH['LEGEND_FUZZY']                      = 'Toleriraj tipfelere';
$SEARCH['LEGEND_PHRASE']                     = 'Točan izraz';
$SEARCH['LEGEND_EXCLUDE']                    = 'Isključi pojam';
$SEARCH['LEGEND_OR']                         = 'Jedan od pojmova';
$SEARCH['LEGEND_COMBINATION']                = 'Kombinacija';
$SEARCH['LEGEND_OPERATORS']                  = 'Operatori';
$SEARCH['OP_EXCLUDE']                        = 'isključi';
$SEARCH['OP_WILDCARD']                       = 'zamjenski znak';
$SEARCH['OP_TYPOS']                          = 'tipfeleri';
$SEARCH['OP_PHRASE']                         = 'izraz';
$SEARCH['OP_OR']                             = 'ili';
$SEARCH['EXAMPLE_WORD']                      = 'senf';
$SEARCH['EXAMPLE_WORD2']                     = 'eko';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'ljuti';
$SEARCH['EXAMPLE_OR']                        = 'kečap';
$SEARCH['EXAMPLE_PHRASE']                    = 'žuti senf';
$SEARCH['EXAMPLE_PHRASE2']                   = 'od kukuruza';
$SEARCH['LABEL_LEGEND']                      = 'Legenda';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Pojam pronađen u sadržaju stranice';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Pojam pronađen u ključnim riječima stranice';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Pojam pronađen u opisu stranice';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Pojam pronađen u naslovu';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Pojam u sadržaju i ključnim riječima';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Pojam u sadržaju i opisu';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Pojam u ključnim riječima i opisu';
$SEARCH['LEGEND_HIT_ALL']                    = 'Pojam u sva tri polja';
$SEARCH['PAGE_PREV']                         = 'Prethodna stranica';
$SEARCH['PAGE_NEXT']                         = 'Sljedeća stranica';
$SEARCH['DROPLET_DESCRIPTION']               = 'Oblak najtraženijih pojmova. Parametri: max=20, min_count=1, desc=Oznaka, active=true (false = skriveno)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Pregled';
$SEARCH['MENU_MODULES']                      = 'Moduli';
$SEARCH['MENU_LAYOUT']                       = 'Izgled';
$SEARCH['MENU_SETTINGS']                     = 'Postavke';
$SEARCH['MENU_STATS']                        = 'Statistika';
$SEARCH['CRUMB_OVERVIEW']                    = 'Stanje i održavanje indeksa pretraživanja';
$SEARCH['CRUMB_MODULES']                     = 'Koji moduli pune indeks pretraživanja';
$SEARCH['CRUMB_LAYOUT']                      = 'Predložak stranice s rezultatima';
$SEARCH['CRUMB_SETTINGS']                    = 'Ponašanje pretraživanja, pretraživanje uživo, oblak oznaka';
$SEARCH['CRUMB_STATS']                       = 'Što posjetitelji traže';
$SEARCH['LEDE_OVERVIEW']                     = 'Trenutačno stanje indeksa pretraživanja i pretraživanja na webu.';
$SEARCH['LEDE_MODULES']                      = 'Kako se indeksira svaki instalirani modul. Moduli bez definicije daju samo naslov svoje stranice.';
$SEARCH['LEDE_LAYOUT']                       = 'Koji izgled i koji stilski list koriste stranica pretraživanja i oblak oznaka. Isporučene datoteke i datoteke iz predloška ostaju nepromijenjene; uvijek uređujete vlastitu kopiju.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Stranica s rezultatima';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Izgled stranice /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Oblak oznaka';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Izgled dropleta [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Stilski list';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Za stranicu s rezultatima i oblak oznaka';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'CSS iz %1$s prikazuje se ovdje · „Uredi” stvara %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Bez stilskog lista';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'predložak sam donosi sve stilove';
$SEARCH['LAYOUT_ACTIVE']                     = 'aktivno';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'vlastita datoteka';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'iz predloška „%s”';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'isporučeno';
$SEARCH['LAYOUT_READONLY']                   = 'samo za čitanje';
$SEARCH['LAYOUT_MODIFIED']                   = 'promijenjeno %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'datoteku predloška %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'isporučenu datoteku %s';
$SEARCH['BTN_EDIT']                          = 'Uredi';
$SEARCH['BTN_DELETE']                        = 'Obriši';
$SEARCH['BTN_BACK']                          = 'Natrag';
$SEARCH['BTN_SAVE_BACK']                     = 'Spremi i natrag';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Stvorit će se nova datoteka %1\$s kao kopija od %2\$s.\n\nKopija se uređuje i postaje aktivni izgled; izvornik ostaje nepromijenjen.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s već postoji. Prebrisati je sadržajem od %2\$s i urediti?\n\nVaša trenutačna verzija %1\$s bit će izgubljena.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Obrisati %s?\n\nOvo se ne može poništiti.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Aktivni izgled: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s stvoren';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s obrisan';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Stilski list: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Bodovanje, izvadci, pretraživanje uživo i oblak oznaka.';
$SEARCH['LEDE_STATS']                        = 'Pojmovi pretraživanja zabilježeni za oblak oznaka (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Indeks pretraživanja';
$SEARCH['INDEX_BUILD']                       = 'Potpuna ponovna izgradnja';
$SEARCH['INDEX_UPDATE']                      = 'Ažuriraj promjene';
$SEARCH['INDEX_CLEAR']                       = 'Isprazni indeks';
$SEARCH['ENTRIES']                           = 'Unosi';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Indeks izgrađen — nema ništa za indeksiranje.',
    'one' => 'Indeks izgrađen: %d unos.',
    'few' => 'Indeks izgrađen: %d unosa.',
    'other' => 'Indeks izgrađen: %d unosa.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Nema ništa za ažuriranje.',
    'one' => 'Ažuriran %d unos.',
    'few' => 'Ažurirana %d unosa.',
    'other' => 'Ažurirano %d unosa.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Indeks obrisan.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Stvarno obrisati cijeli indeks?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Pretraživanje weba';
$SEARCH['LABEL_LAST_INDEXED']                = 'Zadnje indeksiranje';
$SEARCH['INDEX_BUILD_DESC']                  = 'Ponovno čita <b>sve</b> pretražive sekcije. Na velikim webovima traje neko vrijeme.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Čita samo promijenjene ili nedostajuće sekcije. Brže od potpune ponovne izgradnje.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Čita samo promijenjene ili nedostajuće sekcije. Trenutačno nema ništa za napraviti.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Prazni indeks. Pretraživanje ne pronalazi ništa dok se ponovno ne izgradi.';
$SEARCH['LABEL_FRESHNESS']                   = 'Ažurnost';
$SEARCH['FRESH_ALL']                         = '<b>Indeks je ažuran</b> — svih %d sekcija odgovara svojoj zadnjoj promjeni.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d od %2$d</b> sekcija promijenjeno je ili nedostaje.';
$SEARCH['FRESH_NONE']                        = 'Još nema pretraživih sekcija.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Pretraživanje weba';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Postavke › Pretraživanje';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Javno';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Registrirani';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privatno';
$SEARCH['SITE_SEARCH_NONE']                  = 'Isključeno';
$SEARCH['HINT_SITE_SEARCH']                  = 'Tko smije pretraživati — za svako polje za pretraživanje na webu, bez obzira koje je pretraživanje iza njega. Ista postavka kao pod <a href="%s">Postavke › Pretraživanje</a>; „Registrirani” i „Privatno” oboje znače: samo prijavljeni posjetitelji.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Postaviti pretraživanje weba na „%s”?\n\nTime se mijenja postavka weba „Pretraživanje” za sve posjetitelje.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Pretraživanje weba: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Jezici';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Nema podataka o jeziku';
$SEARCH['VIS_HIDDEN']                        = 'Skriveno';
$SEARCH['VIS_PUBLIC']                        = 'Javno';
$SEARCH['VIS_PRIVATE']                       = 'Privatno';
$SEARCH['VIS_REGISTERED']                    = 'Registrirani';
$SEARCH['VIS_NONE']                          = 'Nema';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Izgled je prazan i nije spremljen.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Nije moguće zapisati search_custom.htt. Provjerite prava pisanja za mapu layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Kad je „AjaxSave” označen, Spremi i Ctrl+S spremaju bez ponovnog učitavanja stranice; „Spremi i natrag” je tada skriven.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Minimalna duljina riječi';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Kraće riječi se zanemaruju';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Težina naslova';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Pogoci u naslovu × faktor';
$SEARCH['SET_MAX_EXCERPT']                   = 'Maks. duljina izvatka';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Znakova po izvatku';
$SEARCH['SET_HIGHLIGHT']                     = 'Isticanje';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Istakni tražene pojmove u izvatku';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Oznaka za isticanje';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'HTML oznaka koja se koristi za isticanje';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Rezultata po stranici';
$SEARCH['SET_AUTO_REINDEX']                  = 'Automatsko ponovno indeksiranje pri pretraživanju';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Pri svakom pretraživanju neprimjetno ažurira zastarjele unose';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Prikaži oblak oznaka';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Na stranici pretraživanja. Droplet ima vlastiti parametar active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Bilježi pretraživanja';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Bilježi pretraživanja za oblak oznaka i statistiku — isključivanje ne skriva oblak';
$SEARCH['SET_AJAX_SUGGEST']                  = 'AJAX pretraživanje uživo';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Prikaži prijedloge tijekom tipkanja';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Način otklanjanja grešaka';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Prikaži tehničke podatke ispod svakog rezultata (samo administratori)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Predložak stranice pretraživanja';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Predložak weba u kojem se prikazuje stranica /search/.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Zadani predložak weba (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Pretraživanje';
$SEARCH['GROUP_DISPLAY']                     = 'Prikaz rezultata';
$SEARCH['GROUP_INDEX']                       = 'Održavanje indeksa';
$SEARCH['GROUP_LIVE']                        = 'Pretraživanje uživo';
$SEARCH['GROUP_TAGCLOUD']                    = 'Oblak oznaka';
$SEARCH['GROUP_ADMIN']                       = 'Administratorski alat';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Veličina stranice popisa rezultata';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Filtar jezika';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Prikaži samo stranice na jeziku posjetitelja (zadano za web: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Napredno pretraživanje';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Prikaži u obrascu potvrdne okvire opsega i opciju ILI';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Maks. sekcija po pretraživanju';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Ograničenje automatskog ponovnog indeksiranja (kontrola opterećenja)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Izvor prijedloga';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Hibridni način najprije navodi pogotke u naslovu, a zatim dopunjuje stranicama koje sadrže riječ u tekstu';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Maks. prijedloga';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Broj prikazanih prijedloga';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Slike u prijedlozima';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Prikazuje sliku stavke (katalog, vijesti …) pokraj prijedloga, ako je modul indeksira';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Maks. oznaka';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Broj pojmova u oblaku oznaka';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min. pretraživanja';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Minimalan broj pretraživanja prije nego se pojam pojavi';
$SEARCH['SET_NAV_STYLE']                     = 'Navigacija';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Kartice gore ili traka ikona lijevo';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Najprije naslovi, dopunjeni iz punog teksta (preporučeno)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Naslov + opis (brzo)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Indeks punog teksta (temeljito)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Kartice gore';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Bočna traka lijevo';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Krajnja točka';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Na stranici pretraživanja automatski se prepoznaje za polja naziva „string”, type="search" ili klase ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Postavke spremljene.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Statistika pretraživanja obrisana.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Stvarno obrisati svu statistiku?';
$SEARCH['STATS_DELETE']                      = 'Obriši statistiku';
$SEARCH['STATS_TERM']                        = 'Pojam pretraživanja';
$SEARCH['STATS_COUNT']                       = 'Broj';
$SEARCH['STATS_LAST']                        = 'Zadnje traženo';
$SEARCH['STATS_TERMS']                       = 'Pojmovi';
$SEARCH['STATS_SEARCHES']                    = 'Pretraživanja';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 od %d pojma.',
    'few' => 'Top 100 od %d pojma.',
    'other' => 'Top 100 od %d pojmova.',
];
$SEARCH['STATS_EMPTY']                       = 'Još nema zabilježenih pojmova pretraživanja.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Traženo, ništa pronađeno';
$SEARCH['HINT_STATS_MISSES']                 = 'Cijela pretraživanja bez rezultata — naznaka sadržaja koji posjetitelji očekuju, ali ne pronalaze. Nikad se ne prikazuje javno.';
$SEARCH['STATS_QUERY']                       = 'Upit';
$SEARCH['STATS_MISSES_EMPTY']                = 'Nema zabilježenih pretraživanja bez rezultata.';
$SEARCH['CARD_WORDS']                        = 'Indeks riječi';
$SEARCH['HINT_WORDS']                        = 'Za velike webove: popis svih riječi, tako da pretraživanje više ne mora čitati cijeli indeks. Gradi se automatski od %s unosa indeksa naviše.';
$SEARCH['WORDS_INACTIVE']                    = 'Nije aktivno — web je ispod praga (%2$s unosa indeksa, trenutačno %1$s); obično pretraživanje je dovoljno brzo.';
$SEARCH['WORDS_OFF']                         = 'Isključeno u postavkama.';
$SEARCH['WORDS_BUILDING']                    = 'U izgradnji';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Nastavi izgradnju';
$SEARCH['MSG_WORDS_READY']                   = 'Indeks riječi je dovršen.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Indeks riječi: preostaje još %d unos — do tada se koristi obično pretraživanje.',
    'few' => 'Indeks riječi: preostaju još %d unosa — do tada se koristi obično pretraživanje.',
    'other' => 'Indeks riječi: preostaje još %d unosa — do tada se koristi obično pretraživanje.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'U upotrebi — %d unos riječi.',
    'few' => 'U upotrebi — %d unosa riječi.',
    'other' => 'U upotrebi — %d unosa riječi.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Indeks riječi';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automatski: gradi se samo kad web dosegne prag u nastavku. Malim webovima nije potreban.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automatski';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Uvijek uključeno';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Isključeno';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Indeks riječi od';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Broj indeksiranih unosa (sekcije i stavke modula) od kojeg se indeks riječi gradi automatski';
$SEARCH['BTN_DELETE_TERM']                   = 'Ukloni ovaj pojam';
$SEARCH['MSG_TERM_DELETED']                  = 'Pojam uklonjen.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Polukonfiguracija za <b>%s</b> unaprijed popunjena iz search.php — provjerite i prilagodite.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Polukonfiguracija za \'%s\' spremljena.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Konfiguracija i unosi indeksa za %s obrisani.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php stvoren. Ponovno izgradite indeks.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Obrisati konfiguraciju i unose indeksa za %s?';
$SEARCH['STATUS_SEMI']                       = 'Polukonfiguracija';
$SEARCH['LABEL_GUIDE']                       = 'Prikaži vodič za ovaj modul';
$SEARCH['LABEL_TABLE_HINT']                  = 'Odaberite tablicu → stupci se učitavaju automatski';
$SEARCH['LABEL_TABLE_SELECT']                = 'Odaberite tablicu';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'Sidro stranice WBCE';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Samo pretražive stranice';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Sve sekcije (spremnik sadržaja)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Samo aktivni unosi (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Vremensko upravljanje (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joinovi (neobavezno, maks. 3) — podaci iz dodatnih tablica';
$SEARCH['LABEL_GENERATE_DEF']                = 'Stvori datoteku module_defs';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Iz search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Obriši konfiguraciju';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Nema tekstualnih stupaca';
$SEARCH['LABEL_ERROR']                       = 'Pogreška';
$SEARCH['LABEL_MODULE']                      = 'Modul';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Nije pretraživo';
$SEARCH['LABEL_HELP']                        = 'Pomoć';
$SEARCH['BTN_CONFIGURE']                     = 'Konfiguriraj';
$SEARCH['BTN_CLOSE']                         = 'Zatvori';
$SEARCH['DEF_GENERATED']                     = 'stvoreno';
$SEARCH['DEF_SHIPPED']                       = 'ugrađeno';
$SEARCH['LABEL_KIND']                        = 'Vrsta';
$SEARCH['LABEL_INDEXING']                    = 'Indeksiranje';
$SEARCH['LABEL_SECTIONS']                    = 'Sekcije';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtriraj …';
$SEARCH['MODULES_SHOWN']                     = 'Prikazano %1$d od %2$d modula';
$SEARCH['KIND_PAGE']                         = 'Moduli stranica';
$SEARCH['KIND_SNIPPET']                      = 'Snippeti';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtri';
$SEARCH['KIND_TOOL']                         = 'Administratorski alati';
$SEARCH['BADGE_PAGE']                        = 'Stranica';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filtar';
$SEARCH['BADGE_TOOL']                        = 'Alat';
$SEARCH['GROUP_DEF']                         = 's definicijom';
$SEARCH['GROUP_OPEN']                        = 'nepotpuno';
$SEARCH['GROUP_TITLE']                       = 'samo naslov stranice';
$SEARCH['SOURCE_MODULE']                     = 'Iz modula';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Ugrađeno';
$SEARCH['SOURCE_GENERATED']                  = 'Polukonfiguracija';
$SEARCH['SOURCE_SEMI']                       = 'Polukonfiguracija – nije stvoreno';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'Pronađen search.php';
$SEARCH['SOURCE_TITLE']                      = 'Samo naslov stranice';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Modul donosi vlastitu definiciju pretraživanja (search_index.php) — ovdje se ne može uređivati.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indeksira se putem PHP callbacka — ovdje se ne može uređivati.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definicija isporučena s WBCE Search (module_defs/). Polukonfiguracija ima prednost.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definicija stvorena iz polukonfiguracije.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Polukonfiguracija spremljena, ali definicija još nije stvorena.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Još nema definicije — može se unaprijed popuniti iz starog search.php modula.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Nema definicije — indeks sadrži samo naslov stranice.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Nema sekcija stranica — nema ništa za indeksiranje.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Pretraživanje je za ovu stranicu isključeno';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Ugrađena definicija. Spremanjem nastaje polukonfiguracija koja ima prednost.';
$SEARCH['LABEL_TABLE']                       = 'Tablica';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tablice ovog modula';
$SEARCH['LABEL_OTHER_TABLES']                = 'Ostale tablice modula';
$SEARCH['HINT_TABLE']                        = 'Indeksirati se mogu samo tablice mod_* sa stupcem section_id.';
$SEARCH['LABEL_ID_FIELD']                    = 'Stupac ID';
$SEARCH['LABEL_ITEM_KEY']                    = 'Ključ stavke';
$SEARCH['HINT_ITEM_KEY']                     = 'Jedinstveni ključ po stavci (višestruki način).';
$SEARCH['LABEL_TITLE_COL']                   = 'Stupac naslova';
$SEARCH['LABEL_TEXT_COLS']                   = 'Tekstualni stupci';
$SEARCH['LABEL_LINK_COL']                    = 'Stupac poveznice';
$SEARCH['HINT_LINK_PREFIX']                  = 'Neobavezni prefiks: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Stupac slike';
$SEARCH['HINT_IMAGE_PATH']                   = 'Putanja ispod /media, dopušteni su zamjenski znakovi poput {item_id}.';
$SEARCH['LABEL_NONE']                        = 'nema';
$SEARCH['LABEL_MODE']                        = 'Način';
$SEARCH['MODE_SINGLE']                       = 'Pojedinačno — jedan unos po sekciji';
$SEARCH['MODE_MULTI']                        = 'Višestruko — jedan unos po stavci';
$SEARCH['LABEL_INDEX_BASE']                  = 'Osnova indeksa';
$SEARCH['LABEL_FILTER']                      = 'Filtar';
$SEARCH['LABEL_NO_JOIN']                     = 'bez joina';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Odaberite valjanu tablicu modula.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'U search.php modula %s nije pronađena upotrebljiva tablica.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Nema stranica',
    'one' => '%d stranica',
    'few' => '%d stranice',
    'other' => '%d stranica',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Spremi';
$SEARCH['MSG_SECURITY_ERROR']                = 'Sigurnosna provjera nije uspjela.';
$SEARCH['STATUS_ACTIVE']                     = 'Aktivno';
$SEARCH['STATUS_INACTIVE']                   = 'Neaktivno';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'a','ako','ali','bi','bih','bila','bili','bilo','bio','biti','bez','da','do',
    'dok','ga','gdje','i','ih','ili','im','iz','ja','je','jer','jesam','jesi',
    'jest','još','ju','kad','kada','kako','koja','koje','koji','kojima','koju','li',
    'me','mene','meni','mi','mu','na','nad','nakon','nam','nas','ne','nego','neki',
    'nešto','ni','nije','nisam','niti','no','o','od','on','ona','one','oni','ono',
    'ova','ovaj','ovo','pa','po','pod','pored','prema','pri','s','sa','sam','samo',
    'se','si','smo','ste','su','sve','svi','ta','taj','te','ti','to','tu','u','uz',
    'vam','vas','već','vi','za','zbog',
];
