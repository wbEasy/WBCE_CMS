<?php
/**
 * wbce_search - languages/LV.php
 * Latviešu
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Paplašināti meklēšanas iestatījumi. WBCE CMS meklēšanas indekss, moduļi, izkārtojumi un statistika: pilnteksta meklēšana ar operatoriem, ieteikumi rakstīšanas laikā, rezultātu izcelšana mērķa lapā un birku mākonis.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Meklēt';
$SEARCH['SEARCH_HEADING']                    = 'Meklēšana';
$SEARCH['RESULTS_FOR']                       = 'Rezultāti vaicājumam';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Nav rezultātu',
    'one' => '%d rezultāts',
    'other' => '%d rezultāti',
];
$SEARCH['NO_RESULTS']                        = 'Rezultāti nav atrasti.';
$SEARCH['ALL_WORDS']                         = 'Visi vārdi';
$SEARCH['ANY_WORDS']                         = 'Jebkurš vārds';
$SEARCH['EXACT_MATCH']                       = 'Precīza frāze';
$SEARCH['MATCH']                             = 'Meklēšanas režīms';
$SEARCH['PAGES']                             = 'Lapas';
$SEARCH['TIPS_TITLE']                        = 'Meklēšanas padomi:';
$SEARCH['TIP_FEWER']                         = 'Izmantojiet mazāk vārdu';
$SEARCH['TIP_OR']                            = 'VAI meklēšana:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'citsVārds';
$SEARCH['TIP_NOT']                           = 'Izslēgt:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'izslēgt';
$SEARCH['TIP_PHRASE']                        = 'Precīza frāze:';
$SEARCH['TIP_WILDCARD']                      = 'Aizstājējzīme:';
$SEARCH['TIP_FUZZY']                         = 'Pieļaut drukas kļūdas:';
$SEARCH['DID_YOU_MEAN']                      = 'Vai domājāt:';
$SEARCH['SCOPE_TITLE']                       = 'Tikai virsraksts';
$SEARCH['SCOPE_CONTENT']                     = 'Tikai saturs';
$SEARCH['SEARCH_OR']                         = 'VAI meklēšana (vismaz viens vārds)';
$SEARCH['AREAS_TITLE']                       = 'Pārlūkot pēc tēmas:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Bieži meklēts:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'meklēts %d reizi',
    'other' => 'meklēts %d reizes',
];
$SEARCH['HIT_CONTENT']                       = 'Saturs';
$SEARCH['HIT_KEYWORD']                       = 'Atslēgvārds';
$SEARCH['HIT_DESCRIPTION']                   = 'Apraksts';
$SEARCH['HIT_TITLE']                         = 'Virsraksts';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Aizstājējzīme';
$SEARCH['LEGEND_FUZZY']                      = 'Pieļaut drukas kļūdas';
$SEARCH['LEGEND_PHRASE']                     = 'Precīza frāze';
$SEARCH['LEGEND_EXCLUDE']                    = 'Izslēgt vārdu';
$SEARCH['LEGEND_OR']                         = 'Viens no vārdiem';
$SEARCH['LEGEND_COMBINATION']                = 'Kombinācija';
$SEARCH['LEGEND_OPERATORS']                  = 'Operatori';
$SEARCH['OP_EXCLUDE']                        = 'izslēgt';
$SEARCH['OP_WILDCARD']                       = 'aizstājējzīme';
$SEARCH['OP_TYPOS']                          = 'kļūdas';
$SEARCH['OP_PHRASE']                         = 'frāze';
$SEARCH['OP_OR']                             = 'vai';
$SEARCH['EXAMPLE_WORD']                      = 'sinepes';
$SEARCH['EXAMPLE_WORD2']                     = 'bioloģiskas';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'asas';
$SEARCH['EXAMPLE_OR']                        = 'kečups';
$SEARCH['EXAMPLE_PHRASE']                    = 'dzeltenas sinepes';
$SEARCH['EXAMPLE_PHRASE2']                   = 'no kukurūzas';
$SEARCH['LABEL_LEGEND']                      = 'Leģenda';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Vārds atrasts lapas saturā';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Vārds atrasts lapas atslēgvārdos';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Vārds atrasts lapas aprakstā';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Vārds atrasts virsrakstā';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Vārds saturā un atslēgvārdos';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Vārds saturā un aprakstā';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Vārds atslēgvārdos un aprakstā';
$SEARCH['LEGEND_HIT_ALL']                    = 'Vārds visos trīs laukos';
$SEARCH['PAGE_PREV']                         = 'Iepriekšējā lapa';
$SEARCH['PAGE_NEXT']                         = 'Nākamā lapa';
$SEARCH['DROPLET_DESCRIPTION']               = 'Biežāk meklēto vārdu mākonis. Parametri: max=20, min_count=1, desc=Uzraksts, active=true (false = paslēpts)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Pārskats';
$SEARCH['MENU_MODULES']                      = 'Moduļi';
$SEARCH['MENU_LAYOUT']                       = 'Izkārtojums';
$SEARCH['MENU_SETTINGS']                     = 'Iestatījumi';
$SEARCH['MENU_STATS']                        = 'Statistika';
$SEARCH['CRUMB_OVERVIEW']                    = 'Meklēšanas indeksa stāvoklis un uzturēšana';
$SEARCH['CRUMB_MODULES']                     = 'Kuri moduļi papildina meklēšanas indeksu';
$SEARCH['CRUMB_LAYOUT']                      = 'Rezultātu lapas veidne';
$SEARCH['CRUMB_SETTINGS']                    = 'Meklēšanas darbība, tiešā meklēšana, birku mākonis';
$SEARCH['CRUMB_STATS']                       = 'Ko meklē apmeklētāji';
$SEARCH['LEDE_OVERVIEW']                     = 'Meklēšanas indeksa un vietnes meklēšanas pašreizējais stāvoklis.';
$SEARCH['LEDE_MODULES']                      = 'Kā tiek indeksēts katrs instalētais modulis. Moduļi bez definīcijas sniedz tikai savas lapas virsrakstu.';
$SEARCH['LEDE_LAYOUT']                       = 'Kādu izkārtojumu un stila lapu izmanto meklēšanas lapa un birku mākonis. Piegādātie faili un veidnes faili paliek nemainīti; jūs vienmēr rediģējat savu kopiju.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Rezultātu lapa';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Lapas /search/ izkārtojums';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Birku mākonis';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Dropleta [[wbce_search_tagcloud]] izkārtojums';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Stila lapa';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Rezultātu lapai un birku mākonim';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'CSS no %1$s tiek rādīts šeit · „Rediģēt” izveido %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Bez stila lapas';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'veidne pati nodrošina visus stilus';
$SEARCH['LAYOUT_ACTIVE']                     = 'aktīvs';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'savs fails';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'no veidnes „%s”';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'piegādāts';
$SEARCH['LAYOUT_READONLY']                   = 'tikai lasāms';
$SEARCH['LAYOUT_MODIFIED']                   = 'mainīts %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'veidnes failu %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'piegādāto failu %s';
$SEARCH['BTN_EDIT']                          = 'Rediģēt';
$SEARCH['BTN_DELETE']                        = 'Dzēst';
$SEARCH['BTN_BACK']                          = 'Atpakaļ';
$SEARCH['BTN_SAVE_BACK']                     = 'Saglabāt un atpakaļ';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Tiks izveidots jauns fails %1\$s kā %2\$s kopija.\n\nKopija tiek rediģēta un kļūst par aktīvo izkārtojumu; oriģināls paliek nemainīts.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s jau pastāv. Pārrakstīt to ar %2\$s saturu un rediģēt?\n\nJūsu pašreizējā %1\$s versija tiks zaudēta.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Dzēst %s?\n\nŠo darbību nevar atsaukt.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Aktīvais izkārtojums: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s izveidots';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s izdzēsts';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Stila lapa: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Vērtēšana, fragmenti, tiešā meklēšana un birku mākonis.';
$SEARCH['LEDE_STATS']                        = 'Birku mākonim reģistrētie meklēšanas vārdi (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Meklēšanas indekss';
$SEARCH['INDEX_BUILD']                       = 'Pilna pārbūve';
$SEARCH['INDEX_UPDATE']                      = 'Atjaunināt izmaiņas';
$SEARCH['INDEX_CLEAR']                       = 'Iztukšot indeksu';
$SEARCH['ENTRIES']                           = 'Ieraksti';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Indekss izveidots — nav ko indeksēt.',
    'one' => 'Indekss izveidots: %d ieraksts.',
    'other' => 'Indekss izveidots: %d ieraksti.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Nav ko atjaunināt.',
    'one' => 'Atjaunināts %d ieraksts.',
    'other' => 'Atjaunināti %d ieraksti.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Indekss izdzēsts.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Tiešām dzēst visu indeksu?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Meklēšana vietnē';
$SEARCH['LABEL_LAST_INDEXED']                = 'Pēdējoreiz indeksēts';
$SEARCH['INDEX_BUILD_DESC']                  = 'No jauna nolasa <b>visas</b> meklējamās sadaļas. Lielās vietnēs tas aizņem laiku.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Nolasa tikai mainītās vai trūkstošās sadaļas. Ātrāk nekā pilna pārbūve.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Nolasa tikai mainītās vai trūkstošās sadaļas. Pašlaik nav ko darīt.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Iztukšo indeksu. Meklēšana neko neatrod, līdz tas tiek pārbūvēts.';
$SEARCH['LABEL_FRESHNESS']                   = 'Aktualitāte';
$SEARCH['FRESH_ALL']                         = '<b>Indekss ir aktuāls</b> — visas sadaļas (%d) atbilst savām pēdējām izmaiņām.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d no %2$d</b> sadaļām ir mainītas vai trūkst.';
$SEARCH['FRESH_NONE']                        = 'Vēl nav meklējamu sadaļu.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Meklēšana vietnē';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Iestatījumi › Meklēšana';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Publiska';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Reģistrētie';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privāta';
$SEARCH['SITE_SEARCH_NONE']                  = 'Izslēgta';
$SEARCH['HINT_SITE_SEARCH']                  = 'Kas drīkst meklēt — katram vietnes meklēšanas laukam neatkarīgi no tā, kāda meklēšana ir aiz tā. Tas pats iestatījums, kas sadaļā <a href="%s">Iestatījumi › Meklēšana</a>; „Reģistrētie” un „Privāta” abi nozīmē: tikai pieteikušies apmeklētāji.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Iestatīt meklēšanu vietnē uz „%s”?\n\nTas maina vietnes iestatījumu „Meklēšana” visiem apmeklētājiem.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Meklēšana vietnē: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Valodas';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Nav informācijas par valodu';
$SEARCH['VIS_HIDDEN']                        = 'Paslēpta';
$SEARCH['VIS_PUBLIC']                        = 'Publiska';
$SEARCH['VIS_PRIVATE']                       = 'Privāta';
$SEARCH['VIS_REGISTERED']                    = 'Reģistrētie';
$SEARCH['VIS_NONE']                          = 'Nav';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Izkārtojums ir tukšs un netika saglabāts.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Neizdevās ierakstīt search_custom.htt. Pārbaudiet mapes layouts rakstīšanas tiesības.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Ja „AjaxSave” ir atzīmēts, Saglabāt un Ctrl+S saglabā, nepārlādējot lapu; „Saglabāt un atpakaļ” tad tiek paslēpts.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Minimālais vārda garums';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Īsāki vārdi tiek ignorēti';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Virsraksta svars';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Atbilstības virsrakstā × koeficients';
$SEARCH['SET_MAX_EXCERPT']                   = 'Maks. fragmenta garums';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Rakstzīmes fragmentā';
$SEARCH['SET_HIGHLIGHT']                     = 'Izcelšana';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Izcelt meklētos vārdus fragmentā';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Izcelšanas tags';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'HTML tags, ko izmanto izcelšanai';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Rezultāti lapā';
$SEARCH['SET_AUTO_REINDEX']                  = 'Automātiska pārindeksēšana meklējot';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Katras meklēšanas laikā nemanāmi atjaunina novecojušos ierakstus';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Rādīt birku mākoni';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Meklēšanas lapā. Dropletam ir savs parametrs active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Reģistrēt meklējumus';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Reģistrē meklējumus birku mākonim un statistikai — izslēgšana mākoni nepaslēpj';
$SEARCH['SET_AJAX_SUGGEST']                  = 'AJAX tiešā meklēšana';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Rādīt ieteikumus rakstīšanas laikā';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Atkļūdošanas režīms';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Rādīt tehniskos datus zem katra rezultāta (tikai administratoriem)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Meklēšanas lapas veidne';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Vietnes veidne, kurā tiek rādīta lapa /search/.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Vietnes noklusējuma veidne (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Meklēšana';
$SEARCH['GROUP_DISPLAY']                     = 'Rezultātu attēlošana';
$SEARCH['GROUP_INDEX']                       = 'Indeksa uzturēšana';
$SEARCH['GROUP_LIVE']                        = 'Tiešā meklēšana';
$SEARCH['GROUP_TAGCLOUD']                    = 'Birku mākonis';
$SEARCH['GROUP_ADMIN']                       = 'Administrēšanas rīks';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Rezultātu saraksta lapas izmērs';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Valodas filtrs';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Rādīt tikai lapas apmeklētāja valodā (vietnes noklusējums: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Paplašinātā meklēšana';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Rādīt meklēšanas formā tvēruma izvēles rūtiņas un VAI opciju';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Maks. sadaļas vienā meklēšanā';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Automātiskās pārindeksēšanas ierobežojums (slodzes kontrole)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Ieteikumu avots';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Hibrīdais režīms vispirms parāda virsrakstu atbilstības un papildina ar lapām, kuru tekstā ir šis vārds';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Maks. ieteikumi';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Rādīto ieteikumu skaits';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Attēli ieteikumos';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Rāda vienuma attēlu (katalogs, jaunumi …) blakus ieteikumam, ja modulis to indeksē';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Maks. birkas';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Birku mākonī rādīto vārdu skaits';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min. meklējumi';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Minimālais meklējumu skaits, pirms vārds parādās';
$SEARCH['SET_NAV_STYLE']                     = 'Navigācija';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Cilnes augšā vai ikonu josla pa kreisi';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Vispirms virsraksti, papildināti no pilnā teksta (ieteicams)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Virsraksts + apraksts (ātri)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Pilnteksta indekss (rūpīgi)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Cilnes augšā';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Sānjosla pa kreisi';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Galapunkts';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Meklēšanas lapā tiek automātiski atpazīts laukiem ar nosaukumu „string”, type="search" vai klasi ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Iestatījumi saglabāti.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Meklēšanas statistika izdzēsta.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Tiešām dzēst visu statistiku?';
$SEARCH['STATS_DELETE']                      = 'Dzēst statistiku';
$SEARCH['STATS_TERM']                        = 'Meklēšanas vārds';
$SEARCH['STATS_COUNT']                       = 'Skaits';
$SEARCH['STATS_LAST']                        = 'Pēdējoreiz meklēts';
$SEARCH['STATS_TERMS']                       = 'Vārdi';
$SEARCH['STATS_SEARCHES']                    = 'Meklējumi';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 no %d vārda.',
    'other' => 'Top 100 no %d vārdiem.',
];
$SEARCH['STATS_EMPTY']                       = 'Vēl nav reģistrētu meklēšanas vārdu.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Meklēts, nekas nav atrasts';
$SEARCH['HINT_STATS_MISSES']                 = 'Veseli meklējumi bez rezultāta — norāde uz saturu, ko apmeklētāji gaida, bet neatrod. Nekad netiek rādīts publiski.';
$SEARCH['STATS_QUERY']                       = 'Vaicājums';
$SEARCH['STATS_MISSES_EMPTY']                = 'Nav reģistrētu meklējumu bez rezultāta.';
$SEARCH['CARD_WORDS']                        = 'Vārdu indekss';
$SEARCH['HINT_WORDS']                        = 'Lielām vietnēm: visu vārdu saraksts, lai meklēšanai vairs nebūtu jālasa viss indekss. Tiek izveidots automātiski, sākot no %s indeksa ierakstiem.';
$SEARCH['WORDS_INACTIVE']                    = 'Nav aktīvs — vietne ir zem sliekšņa (%2$s indeksa ieraksti, pašlaik %1$s); parastā meklēšana ir pietiekami ātra.';
$SEARCH['WORDS_OFF']                         = 'Izslēgts iestatījumos.';
$SEARCH['WORDS_BUILDING']                    = 'Tiek veidots';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Turpināt veidošanu';
$SEARCH['MSG_WORDS_READY']                   = 'Vārdu indekss ir pabeigts.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Vārdu indekss: vēl gaida %d ieraksts — līdz tam tiek izmantota parastā meklēšana.',
    'other' => 'Vārdu indekss: vēl gaida %d ieraksti — līdz tam tiek izmantota parastā meklēšana.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'Lietošanā — %d vārda ieraksts.',
    'other' => 'Lietošanā — %d vārdu ieraksti.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Vārdu indekss';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automātiski: tiek veidots tikai tad, kad vietne sasniedz zemāk norādīto slieksni. Mazām vietnēm tas nav vajadzīgs.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automātiski';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Vienmēr ieslēgts';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Izslēgts';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Vārdu indekss no';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Indeksēto ierakstu (sadaļas un moduļu vienumi) skaits, no kura vārdu indekss tiek veidots automātiski';
$SEARCH['BTN_DELETE_TERM']                   = 'Noņemt šo vārdu';
$SEARCH['MSG_TERM_DELETED']                  = 'Vārds noņemts.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Moduļa <b>%s</b> daļējā konfigurācija iepriekš aizpildīta no search.php — pārbaudiet un pielāgojiet.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Moduļa \'%s\' daļējā konfigurācija saglabāta.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Moduļa %s konfigurācija un indeksa ieraksti izdzēsti.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php izveidots. Lūdzu, pārbūvējiet indeksu.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Dzēst moduļa %s konfigurāciju un indeksa ierakstus?';
$SEARCH['STATUS_SEMI']                       = 'Daļējā konfigurācija';
$SEARCH['LABEL_GUIDE']                       = 'Rādīt šī moduļa ceļvedi';
$SEARCH['LABEL_TABLE_HINT']                  = 'Izvēlieties tabulu → kolonnas ielādējas automātiski';
$SEARCH['LABEL_TABLE_SELECT']                = 'Izvēlieties tabulu';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'WBCE lapas enkurs';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Tikai meklējamās lapas';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Visas sadaļas (satura krātuve)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Tikai aktīvie ieraksti (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Laika vadība (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Join (neobligāti, maks. 3) — dati no papildu tabulām';
$SEARCH['LABEL_GENERATE_DEF']                = 'Izveidot module_defs failu';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'No search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Dzēst konfigurāciju';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Nav teksta kolonnu';
$SEARCH['LABEL_ERROR']                       = 'Kļūda';
$SEARCH['LABEL_MODULE']                      = 'Modulis';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Nav meklējams';
$SEARCH['LABEL_HELP']                        = 'Palīdzība';
$SEARCH['BTN_CONFIGURE']                     = 'Konfigurēt';
$SEARCH['BTN_CLOSE']                         = 'Aizvērt';
$SEARCH['DEF_GENERATED']                     = 'izveidota';
$SEARCH['DEF_SHIPPED']                       = 'iebūvēta';
$SEARCH['LABEL_KIND']                        = 'Veids';
$SEARCH['LABEL_INDEXING']                    = 'Indeksēšana';
$SEARCH['LABEL_SECTIONS']                    = 'Sadaļas';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtrēt …';
$SEARCH['MODULES_SHOWN']                     = 'Rādīti %1$d no %2$d moduļiem';
$SEARCH['KIND_PAGE']                         = 'Lapu moduļi';
$SEARCH['KIND_SNIPPET']                      = 'Fragmenti';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtri';
$SEARCH['KIND_TOOL']                         = 'Administrēšanas rīki';
$SEARCH['BADGE_PAGE']                        = 'Lapa';
$SEARCH['BADGE_SNIPPET']                     = 'Fragments';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filtrs';
$SEARCH['BADGE_TOOL']                        = 'Rīks';
$SEARCH['GROUP_DEF']                         = 'ar definīciju';
$SEARCH['GROUP_OPEN']                        = 'nepilnīgi';
$SEARCH['GROUP_TITLE']                       = 'tikai lapas virsraksts';
$SEARCH['SOURCE_MODULE']                     = 'No moduļa';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Iebūvēta';
$SEARCH['SOURCE_GENERATED']                  = 'Daļējā konfigurācija';
$SEARCH['SOURCE_SEMI']                       = 'Daļējā konfigurācija – nav izveidota';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'Atrasts search.php';
$SEARCH['SOURCE_TITLE']                      = 'Tikai lapas virsraksts';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Modulim ir sava meklēšanas definīcija (search_index.php) — šeit nav rediģējama.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indeksēts ar PHP callback — šeit nav rediģējams.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Ar WBCE Search piegādāta definīcija (module_defs/). Daļējai konfigurācijai ir priekšroka.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definīcija izveidota no daļējās konfigurācijas.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Daļējā konfigurācija saglabāta, bet definīcija vēl nav izveidota.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Vēl nav definīcijas — var iepriekš aizpildīt no moduļa vecā search.php.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Nav definīcijas — indekss satur tikai lapas virsrakstu.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Nav lapu sadaļu — nav ko indeksēt.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Meklēšana šai lapai ir izslēgta';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Iebūvēta definīcija. Saglabājot tiek izveidota daļējā konfigurācija, kurai ir priekšroka.';
$SEARCH['LABEL_TABLE']                       = 'Tabula';
$SEARCH['LABEL_OWN_TABLES']                  = 'Šī moduļa tabulas';
$SEARCH['LABEL_OTHER_TABLES']                = 'Citu moduļu tabulas';
$SEARCH['HINT_TABLE']                        = 'Indeksēt var tikai mod_* tabulas ar kolonnu section_id.';
$SEARCH['LABEL_ID_FIELD']                    = 'ID kolonna';
$SEARCH['LABEL_ITEM_KEY']                    = 'Vienuma atslēga';
$SEARCH['HINT_ITEM_KEY']                     = 'Unikāla atslēga katram vienumam (vairāku režīms).';
$SEARCH['LABEL_TITLE_COL']                   = 'Virsraksta kolonna';
$SEARCH['LABEL_TEXT_COLS']                   = 'Teksta kolonnas';
$SEARCH['LABEL_LINK_COL']                    = 'Saites kolonna';
$SEARCH['HINT_LINK_PREFIX']                  = 'Neobligāts prefikss: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Attēla kolonna';
$SEARCH['HINT_IMAGE_PATH']                   = 'Ceļš zem /media, atļauti vietturi, piemēram, {item_id}.';
$SEARCH['LABEL_NONE']                        = 'nav';
$SEARCH['LABEL_MODE']                        = 'Režīms';
$SEARCH['MODE_SINGLE']                       = 'Viens — viens ieraksts katrai sadaļai';
$SEARCH['MODE_MULTI']                        = 'Vairāki — viens ieraksts katram vienumam';
$SEARCH['LABEL_INDEX_BASE']                  = 'Indeksa pamats';
$SEARCH['LABEL_FILTER']                      = 'Filtrs';
$SEARCH['LABEL_NO_JOIN']                     = 'bez join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Lūdzu, izvēlieties derīgu moduļa tabulu.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'Moduļa %s search.php netika atrasta izmantojama tabula.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Nav lapu',
    'one' => '%d lapa',
    'other' => '%d lapas',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Saglabāt';
$SEARCH['MSG_SECURITY_ERROR']                = 'Drošības pārbaude neizdevās.';
$SEARCH['STATUS_ACTIVE']                     = 'Aktīvs';
$SEARCH['STATUS_INACTIVE']                   = 'Neaktīvs';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'aiz','ap','ar','apakš','ārpus','augšpus','bez','caur','dēļ','gar','iekš','iz',
    'kopš','labad','lejpus','līdz','no','otrpus','pa','par','pār','pēc','pie',
    'pirms','pret','priekš','starp','šaipus','uz','viņpus','virs','virspus','zem',
    'un','bet','vai','jo','ka','kad','kas','kā','ja','lai','nekā','ne','nav','nu',
    'tad','tak','taču','tikai','arī','vēl','jau','gan','te','tur','es','tu','viņš',
    'viņa','mēs','jūs','viņi','viņas','sevi','mans','tavs','savs','tas','tā','tie',
    'tās','šis','šī','šie','šīs','ir','būt','bija','biju','būs','esmu','esi','esam',
    'esat','tiek','tika','tikt','var','kur','kāpēc','cik','kurš','kura',
];
