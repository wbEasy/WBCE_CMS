<?php
/**
 * wbce_search - languages/PL.php
 * Polski (Polish)
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'Wyszukiwarka WBCE';
$module_description = 'Zaawansowane ustawienia wyszukiwania. Indeks, moduły, układy i statystyki wyszukiwarki WBCE CMS: wyszukiwanie pełnotekstowe z operatorami, podpowiedzi na żywo, wyróżnianie wyników na stronie docelowej i chmura tagów.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Szukaj';
$SEARCH['SEARCH_HEADING']                    = 'Wyszukiwarka';
$SEARCH['RESULTS_FOR']                       = 'Wyniki dla';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Brak wyników',
    'one' => '%d wynik',
    'few' => '%d wyniki',
    'many' => '%d wyników',
    'other' => '%d wyniku',
];
$SEARCH['NO_RESULTS']                        = 'Nie znaleziono wyników.';
$SEARCH['ALL_WORDS']                         = 'Wszystkie słowa';
$SEARCH['ANY_WORDS']                         = 'Dowolne słowo';
$SEARCH['EXACT_MATCH']                       = 'Dokładna fraza';
$SEARCH['MATCH']                             = 'Tryb wyszukiwania';
$SEARCH['PAGES']                             = 'Strony';
$SEARCH['TIPS_TITLE']                        = 'Wskazówki:';
$SEARCH['TIP_FEWER']                         = 'Użyj mniejszej liczby słów';
$SEARCH['TIP_OR']                            = 'Wyszukiwanie LUB:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'inneSłowo';
$SEARCH['TIP_NOT']                           = 'Wyklucz:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'wyklucz';
$SEARCH['TIP_PHRASE']                        = 'Dokładna fraza:';
$SEARCH['TIP_WILDCARD']                      = 'Symbol wieloznaczny:';
$SEARCH['TIP_FUZZY']                         = 'Dopuszczaj literówki:';
$SEARCH['DID_YOU_MEAN']                      = 'Czy chodziło Ci o:';
$SEARCH['SCOPE_TITLE']                       = 'Tylko tytuł';
$SEARCH['SCOPE_CONTENT']                     = 'Tylko treść';
$SEARCH['SEARCH_OR']                         = 'Wyszukiwanie LUB (co najmniej jedno słowo)';
$SEARCH['AREAS_TITLE']                       = 'Przeglądaj według tematu:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Często wyszukiwane:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'wyszukiwano %d raz',
    'few' => 'wyszukiwano %d razy',
    'many' => 'wyszukiwano %d razy',
    'other' => 'wyszukiwano %d razy',
];
$SEARCH['HIT_CONTENT']                       = 'Treść';
$SEARCH['HIT_KEYWORD']                       = 'Słowo kluczowe';
$SEARCH['HIT_DESCRIPTION']                   = 'Opis';
$SEARCH['HIT_TITLE']                         = 'Tytuł';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Symbol wieloznaczny';
$SEARCH['LEGEND_FUZZY']                      = 'Dopuszczaj literówki';
$SEARCH['LEGEND_PHRASE']                     = 'Dokładna fraza';
$SEARCH['LEGEND_EXCLUDE']                    = 'Wyklucz wyraz';
$SEARCH['LEGEND_OR']                         = 'Jeden z wyrazów';
$SEARCH['LEGEND_COMBINATION']                = 'Kombinacja';
$SEARCH['LEGEND_OPERATORS']                  = 'Operatory';
$SEARCH['OP_EXCLUDE']                        = 'wyklucz';
$SEARCH['OP_WILDCARD']                       = 'symbol wieloznaczny';
$SEARCH['OP_TYPOS']                          = 'literówki';
$SEARCH['OP_PHRASE']                         = 'fraza';
$SEARCH['OP_OR']                             = 'lub';
$SEARCH['EXAMPLE_WORD']                      = 'musztarda';
$SEARCH['EXAMPLE_WORD2']                     = 'bio';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'ostra';
$SEARCH['EXAMPLE_OR']                        = 'ketchup';
$SEARCH['EXAMPLE_PHRASE']                    = 'żółta musztarda';
$SEARCH['EXAMPLE_PHRASE2']                   = 'z kukurydzy';
$SEARCH['LABEL_LEGEND']                      = 'Legenda';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Wyraz znaleziony w treści strony';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Wyraz znaleziony w słowach kluczowych strony';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Wyraz znaleziony w opisie strony';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Wyraz znaleziony w tytule';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Wyraz w treści i słowach kluczowych';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Wyraz w treści i opisie';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Wyraz w słowach kluczowych i opisie';
$SEARCH['LEGEND_HIT_ALL']                    = 'Wyraz we wszystkich trzech polach';
$SEARCH['PAGE_PREV']                         = 'Poprzednia strona';
$SEARCH['PAGE_NEXT']                         = 'Następna strona';
$SEARCH['DROPLET_DESCRIPTION']               = 'Chmura najczęściej wyszukiwanych haseł. Parametry: max=20, min_count=1, desc=Etykieta, active=true (false = ukryta)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Przegląd';
$SEARCH['MENU_MODULES']                      = 'Moduły';
$SEARCH['MENU_LAYOUT']                       = 'Szablon';
$SEARCH['MENU_SETTINGS']                     = 'Ustawienia';
$SEARCH['MENU_STATS']                        = 'Statystyki';
$SEARCH['CRUMB_OVERVIEW']                    = 'Stan i utrzymanie indeksu wyszukiwania';
$SEARCH['CRUMB_MODULES']                     = 'Które moduły zasilają indeks wyszukiwania';
$SEARCH['CRUMB_LAYOUT']                      = 'Szablon strony wyników wyszukiwania';
$SEARCH['CRUMB_SETTINGS']                    = 'Zachowanie wyszukiwania, wyszukiwanie na żywo, chmura tagów';
$SEARCH['CRUMB_STATS']                       = 'Czego szukają odwiedzający';
$SEARCH['LEDE_OVERVIEW']                     = 'Aktualny stan indeksu wyszukiwania i wyszukiwarki na stronie.';
$SEARCH['LEDE_MODULES']                      = 'Jak indeksowany jest każdy zainstalowany moduł. Moduły bez definicji dostarczają tylko tytuł strony.';
$SEARCH['LEDE_LAYOUT']                       = 'Który układ używa strona wyszukiwania i chmura tagów oraz który arkusz stylów. Pliki dostarczone i pliki z szablonu pozostają bez zmian; edytujesz zawsze własną kopię.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Strona wyników wyszukiwania';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Układ strony /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Chmura tagów';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Układ dropletu [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Arkusz stylów';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Dla strony wyników i chmury tagów';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'CSS z %1$s pojawia się tutaj · „Edytuj” tworzy %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Bez arkusza stylów';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'szablon zawiera wszystkie style';
$SEARCH['LAYOUT_ACTIVE']                     = 'aktywny';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'własny plik';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'z szablonu „%s”';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'dostarczony';
$SEARCH['LAYOUT_READONLY']                   = 'tylko do odczytu';
$SEARCH['LAYOUT_MODIFIED']                   = 'zmieniono %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'pliku szablonu %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'dostarczonego pliku %s';
$SEARCH['BTN_EDIT']                          = 'Edytuj';
$SEARCH['BTN_DELETE']                        = 'Usuń';
$SEARCH['BTN_BACK']                          = 'Wróć';
$SEARCH['BTN_SAVE_BACK']                     = 'Zapisz i wróć';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Zostanie utworzony nowy plik %1\$s jako kopia %2\$s.\n\nKopia będzie edytowana i stanie się aktywnym układem; oryginał pozostaje bez zmian.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s już istnieje. Nadpisać go treścią %2\$s i edytować?\n\nObecna wersja %1\$s zostanie utracona.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Usunąć %s?\n\nTej operacji nie można cofnąć.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Aktywny układ: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = 'Utworzono %s';
$SEARCH['MSG_LAYOUT_DELETED']                = 'Usunięto %s';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Arkusz stylów: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Punktacja, fragmenty tekstu, wyszukiwanie na żywo i chmura tagów.';
$SEARCH['LEDE_STATS']                        = 'Hasła zapisane dla chmury tagów (100 najczęstszych).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Indeks wyszukiwania';
$SEARCH['INDEX_BUILD']                       = 'Przebuduj całość';
$SEARCH['INDEX_UPDATE']                      = 'Aktualizuj zmienione';
$SEARCH['INDEX_CLEAR']                       = 'Wyczyść indeks';
$SEARCH['ENTRIES']                           = 'Wpisy';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Indeks zbudowany — brak treści do indeksowania.',
    'one' => 'Indeks zbudowany: %d wpis.',
    'few' => 'Indeks zbudowany: %d wpisy.',
    'many' => 'Indeks zbudowany: %d wpisów.',
    'other' => 'Indeks zbudowany: %d wpisu.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Nic do zaktualizowania.',
    'one' => 'Zaktualizowano %d wpis.',
    'few' => 'Zaktualizowano %d wpisy.',
    'many' => 'Zaktualizowano %d wpisów.',
    'other' => 'Zaktualizowano %d wpisu.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Indeks usunięty.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Czy na pewno usunąć cały indeks?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Wyszukiwarka na stronie';
$SEARCH['LABEL_LAST_INDEXED']                = 'Ostatnie indeksowanie';
$SEARCH['INDEX_BUILD_DESC']                  = 'Ponownie wczytuje <b>wszystkie</b> przeszukiwalne sekcje. Na dużych witrynach trwa to dłużej.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Wczytuje tylko zmienione lub brakujące sekcje. Szybciej niż pełna przebudowa.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Wczytuje tylko zmienione lub brakujące sekcje. W tej chwili nie ma nic do zrobienia.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Opróżnia indeks. Wyszukiwanie nic nie znajdzie, dopóki nie zostanie przebudowany.';
$SEARCH['LABEL_FRESHNESS']                   = 'Aktualność';
$SEARCH['FRESH_ALL']                         = '<b>Indeks jest aktualny</b> — wszystkie sekcje (%d) odpowiadają ostatniej zmianie.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d z %2$d</b> sekcji zostało zmienionych lub brakuje.';
$SEARCH['FRESH_NONE']                        = 'Brak jeszcze przeszukiwalnych sekcji.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Wyszukiwanie na stronie';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Ustawienia › Wyszukiwanie';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Publiczne';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Zarejestrowani';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Prywatne';
$SEARCH['SITE_SEARCH_NONE']                  = 'Wyłączone';
$SEARCH['HINT_SITE_SEARCH']                  = 'Kto może wyszukiwać — dla każdego pola wyszukiwania na stronie, niezależnie od wyszukiwarki. To samo ustawienie co w <a href="%s">Ustawienia › Wyszukiwanie</a>; „Zarejestrowani” i „Prywatne” oznaczają: tylko zalogowani odwiedzający.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Ustawić wyszukiwanie na stronie na „%s”?\n\nTo zmienia ustawienie witryny „Wyszukiwanie” dla wszystkich odwiedzających.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Wyszukiwanie na stronie: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Języki';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Brak informacji o języku';
$SEARCH['VIS_HIDDEN']                        = 'Ukryta';
$SEARCH['VIS_PUBLIC']                        = 'Publiczna';
$SEARCH['VIS_PRIVATE']                       = 'Prywatna';
$SEARCH['VIS_REGISTERED']                    = 'Dla zarejestrowanych';
$SEARCH['VIS_NONE']                          = 'Brak';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Szablon jest pusty i nie został zapisany.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Nie można zapisać pliku search_custom.htt. Sprawdź uprawnienia zapisu folderu layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Gdy zaznaczono „AjaxSave”, „Zapisz” i Ctrl+S zapisują bez przeładowania strony; „Zapisz i wróć” jest wtedy ukryty.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Minimalna długość słowa';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Krótsze słowa są pomijane';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Waga tytułu';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Trafienia w tytule × mnożnik';
$SEARCH['SET_MAX_EXCERPT']                   = 'Maks. długość fragmentu';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Liczba znaków we fragmencie';
$SEARCH['SET_HIGHLIGHT']                     = 'Wyróżnianie';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Wyróżniaj szukane słowa we fragmencie';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Znacznik wyróżnienia';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'Znacznik HTML używany do wyróżniania';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Wyników na stronę';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Liczba wyników na jednej stronie wyników';
$SEARCH['SET_AUTO_REINDEX']                  = 'Automatyczne indeksowanie przy wyszukiwaniu';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Po cichu aktualizuj nieaktualne wpisy przy każdym wyszukiwaniu';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Maks. sekcji na wyszukiwanie';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Limit automatycznego indeksowania (kontrola obciążenia)';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Pokazuj chmurę tagów';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Na stronie wyszukiwania. Droplet ma własny parametr active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Zapisuj wyszukiwania do chmury tagów';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Zapisuj wyszukiwania dla chmury tagów i statystyk — wyłączenie nie ukrywa chmury';
$SEARCH['SET_AJAX_SUGGEST']                  = 'Wyszukiwanie na żywo (AJAX)';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Pokazuj podpowiedzi podczas pisania';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Źródło podpowiedzi';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Tryb hybrydowy pokazuje najpierw trafienia w tytułach i uzupełnia stronami, które zawierają słowo w treści';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Maks. podpowiedzi';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Liczba wyświetlanych podpowiedzi';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']          = 'Obrazy w podpowiedziach';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']     = 'Pokazuje obraz wpisu (katalog, aktualności …) obok podpowiedzi, jeśli moduł go indeksuje';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Tryb debugowania';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Pokazuj dane techniczne pod każdym wynikiem (tylko administratorzy)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Szablon strony wyszukiwania';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Szablon frontendu, w którym wyświetlana jest strona /search/.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Domyślny szablon witryny (%s)';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Filtr języka';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Pokazuj tylko strony w języku odwiedzającego (domyślny język witryny: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Wyszukiwanie zaawansowane';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Pokazuj w formularzu pola zakresu i opcję LUB';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Maks. haseł';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Liczba haseł wyświetlanych w chmurze tagów';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min. liczba wyszukiwań';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Od ilu wyszukiwań hasło pojawia się w chmurze';
$SEARCH['SET_NAV_STYLE']                     = 'Nawigacja';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Zakładki u góry lub pasek ikon po lewej';
$SEARCH['GROUP_SEARCH']                      = 'Wyszukiwanie';
$SEARCH['GROUP_DISPLAY']                     = 'Wyświetlanie wyników';
$SEARCH['GROUP_INDEX']                       = 'Utrzymanie indeksu';
$SEARCH['GROUP_LIVE']                        = 'Wyszukiwanie na żywo';
$SEARCH['GROUP_TAGCLOUD']                    = 'Chmura tagów';
$SEARCH['GROUP_ADMIN']                       = 'Narzędzie administracyjne';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Najpierw tytuły, uzupełnione pełnym tekstem (zalecane)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Tytuł + opis (szybko)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Indeks pełnotekstowy (dokładnie)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Zakładki u góry';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Pasek po lewej';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Punkt końcowy';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Na stronie wyszukiwania wykrywane automatycznie dla pól o nazwie "string", type="search" lub z klasą ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Ustawienia zapisane.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['STATS_DELETE']                      = 'Usuń statystyki';
$SEARCH['STATS_TERM']                        = 'Hasło';
$SEARCH['STATS_COUNT']                       = 'Liczba';
$SEARCH['STATS_LAST']                        = 'Ostatnio wyszukiwane';
$SEARCH['STATS_TERMS']                       = 'Hasła';
$SEARCH['STATS_SEARCHES']                    = 'Wyszukiwania';
$SEARCH['STATS_SHOWING']                     = [
    'one' => '100 najczęstszych z %d hasła.',
    'few' => '100 najczęstszych z %d haseł.',
    'many' => '100 najczęstszych z %d haseł.',
    'other' => '100 najczęstszych z %d haseł.',
];
$SEARCH['STATS_EMPTY']                       = 'Nie zapisano jeszcze żadnych haseł.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Szukano, nic nie znaleziono';
$SEARCH['HINT_STATS_MISSES']                 = 'Całe zapytania bez wyniku — wskazówka, jakich treści odwiedzający oczekują, a nie znajdują. Nigdy nie są pokazywane publicznie.';
$SEARCH['STATS_QUERY']                       = 'Zapytanie';
$SEARCH['STATS_MISSES_EMPTY']                = 'Brak zapisanych wyszukiwań bez wyniku.';
$SEARCH['CARD_WORDS']                        = 'Indeks słów';
$SEARCH['HINT_WORDS']                        = 'Dla dużych witryn: spis wszystkich słów, dzięki czemu wyszukiwanie nie musi czytać całego indeksu. Budowany automatycznie od %s wpisów indeksu.';
$SEARCH['WORDS_INACTIVE']                    = 'Nieaktywny — witryna jest poniżej progu (%2$s wpisów indeksu, obecnie %1$s); zwykłe wyszukiwanie jest wystarczająco szybkie.';
$SEARCH['WORDS_OFF']                         = 'Wyłączony w ustawieniach.';
$SEARCH['WORDS_BUILDING']                    = 'W budowie';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Kontynuuj budowę';
$SEARCH['MSG_WORDS_READY']                   = 'Indeks słów kompletny.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Indeks słów: oczekuje jeszcze %d wpis — do tego czasu używane jest zwykłe wyszukiwanie.',
    'few' => 'Indeks słów: oczekują jeszcze %d wpisy — do tego czasu używane jest zwykłe wyszukiwanie.',
    'many' => 'Indeks słów: oczekuje jeszcze %d wpisów — do tego czasu używane jest zwykłe wyszukiwanie.',
    'other' => 'Indeks słów: oczekuje jeszcze %d wpisu — do tego czasu używane jest zwykłe wyszukiwanie.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'W użyciu — %d wpis słowa.',
    'few' => 'W użyciu — %d wpisy słów.',
    'many' => 'W użyciu — %d wpisów słów.',
    'other' => 'W użyciu — %d wpisu słów.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Indeks słów';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automatycznie: budowany dopiero, gdy witryna osiągnie poniższy próg. Małe witryny go nie potrzebują.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automatycznie';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Zawsze włączony';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Wyłączony';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Indeks słów od';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Liczba zaindeksowanych wpisów (sekcji i elementów modułów), od której indeks słów jest budowany automatycznie';
$SEARCH['BTN_DELETE_TERM']                   = 'Usuń to hasło';
$SEARCH['MSG_TERM_DELETED']                  = 'Hasło usunięte.';
$SEARCH['MSG_STATS_DELETED']                 = 'Statystyki wyszukiwania usunięte.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Czy na pewno usunąć wszystkie statystyki?';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['STATUS_SEMI']                       = 'Półkonfiguracja';
$SEARCH['DEF_GENERATED']                     = 'wygenerowana';
$SEARCH['DEF_SHIPPED']                       = 'wbudowana';
$SEARCH['LABEL_KIND']                        = 'Rodzaj';
$SEARCH['LABEL_INDEXING']                    = 'Indeksowanie';
$SEARCH['LABEL_SECTIONS']                    = 'Sekcje';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtruj …';
$SEARCH['MODULES_SHOWN']                     = 'Wyświetlono %1$d z %2$d modułów';
$SEARCH['KIND_PAGE']                         = 'Moduły stron';
$SEARCH['KIND_SNIPPET']                      = 'Snippety';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtry';
$SEARCH['KIND_TOOL']                         = 'Narzędzia';
$SEARCH['BADGE_PAGE']                        = 'Strona';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filtr';
$SEARCH['BADGE_TOOL']                        = 'Narzędzie';
$SEARCH['GROUP_DEF']                         = 'z definicją';
$SEARCH['GROUP_OPEN']                        = 'niekompletne';
$SEARCH['GROUP_TITLE']                       = 'tylko tytuł strony';
$SEARCH['SOURCE_MODULE']                     = 'Z modułu';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Wbudowana';
$SEARCH['SOURCE_GENERATED']                  = 'Półkonfiguracja';
$SEARCH['SOURCE_SEMI']                       = 'Półkonfiguracja – niewygenerowana';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'Wykryto search.php';
$SEARCH['SOURCE_TITLE']                      = 'Tylko tytuł strony';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Moduł dostarcza własną definicję wyszukiwania (search_index.php) — nie można jej tutaj edytować.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indeksowany przez callback PHP — nie można go tutaj edytować.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definicja dostarczana z WBCE Search (module_defs/). Półkonfiguracja ma pierwszeństwo.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definicja wygenerowana z półkonfiguracji.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Półkonfiguracja zapisana, ale definicja nie została jeszcze wygenerowana.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Brak definicji — można ją wstępnie wypełnić na podstawie starego search.php modułu.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Brak definicji — indeks zawiera tylko tytuł strony.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Brak sekcji stron — nie ma czego indeksować.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Wyszukiwanie wyłączone dla tej strony';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Brak stron',
    'one' => '%d strona',
    'few' => '%d strony',
    'many' => '%d stron',
    'other' => '%d strony',
];
$SEARCH['LABEL_GUIDE']                       = 'Pokaż instrukcję dla tego modułu';
$SEARCH['LABEL_TABLE_HINT']                  = 'Wybierz tabelę → kolumny wczytają się automatycznie';
$SEARCH['LABEL_TABLE_SELECT']                = 'Wybierz tabelę';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'Kotwica strony WBCE';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Tylko strony z włączonym wyszukiwaniem';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Wszystkie sekcje (pula treści)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Tylko aktywne wpisy (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Sterowanie czasem (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Złączenia (opcjonalnie, maks. 3) — dane z dodatkowych tabel';
$SEARCH['LABEL_GENERATE_DEF']                = 'Wygeneruj plik module_defs';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Z search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Usuń konfigurację';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Brak kolumn tekstowych';
$SEARCH['LABEL_MODULE']                      = 'Moduł';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Wyszukiwanie wyłączone';
$SEARCH['LABEL_HELP']                        = 'Pomoc';
$SEARCH['BTN_CONFIGURE']                     = 'Konfiguruj';
$SEARCH['BTN_CLOSE']                         = 'Zamknij';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Definicja wbudowana. Zapis tworzy półkonfigurację, która ma pierwszeństwo.';
$SEARCH['LABEL_TABLE']                       = 'Tabela';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tabele tego modułu';
$SEARCH['LABEL_OTHER_TABLES']                = 'Inne tabele modułów';
$SEARCH['HINT_TABLE']                        = 'Indeksować można tylko tabele mod_* z kolumną section_id.';
$SEARCH['LABEL_ID_FIELD']                    = 'Kolumna ID';
$SEARCH['LABEL_ITEM_KEY']                    = 'Klucz elementu';
$SEARCH['HINT_ITEM_KEY']                     = 'Unikalny klucz dla każdego elementu (tryb multi).';
$SEARCH['LABEL_TITLE_COL']                   = 'Kolumna tytułu';
$SEARCH['LABEL_TEXT_COLS']                   = 'Kolumny tekstowe';
$SEARCH['LABEL_LINK_COL']                    = 'Kolumna linku';
$SEARCH['HINT_LINK_PREFIX']                  = 'Opcjonalny prefiks: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Kolumna obrazu';
$SEARCH['HINT_IMAGE_PATH']                   = 'Ścieżka wewnątrz /media, dozwolone symbole zastępcze, np. {item_id}.';
$SEARCH['LABEL_NONE']                        = 'brak';
$SEARCH['LABEL_MODE']                        = 'Tryb';
$SEARCH['MODE_SINGLE']                       = 'Single — jeden wpis na sekcję';
$SEARCH['MODE_MULTI']                        = 'Multi — jeden wpis na element';
$SEARCH['LABEL_INDEX_BASE']                  = 'Podstawa indeksu';
$SEARCH['LABEL_FILTER']                      = 'Filtr';
$SEARCH['LABEL_NO_JOIN']                     = 'bez złączenia';
$SEARCH['MSG_SEMI_PRESET']                   = 'Półkonfiguracja dla <b>%s</b> utworzona na podstawie search.php — sprawdź ją i dostosuj.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Półkonfiguracja dla \'%s\' zapisana.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Usunięto konfigurację i wpisy indeksu dla %s.';
$SEARCH['MSG_DEF_GENERATED']                 = 'Wygenerowano module_defs/%s.php. Przebuduj indeks.';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Wybierz prawidłową tabelę modułu.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'W search.php modułu %s nie znaleziono odpowiedniej tabeli.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Usunąć konfigurację i wpisy indeksu dla %s?';
$SEARCH['LABEL_ERROR']                       = 'Błąd';

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Zapisz';
$SEARCH['MSG_SECURITY_ERROR']                = 'Kontrola bezpieczeństwa nie powiodła się.';
$SEARCH['STATUS_ACTIVE']                     = 'Aktywny';
$SEARCH['STATUS_INACTIVE']                   = 'Nieaktywny';

// ── Stop words (słowa pomijane) ────────────────────────────────────────────
// Nigdy nie wyszukiwane i nie trafiają do indeksu słów — małymi literami.
// Używane, gdy strona ma podstrony w tym języku (WbceSearchStopwords).
$SEARCH['STOPWORDS'] = [
    'a','aby','ale','bo','by','być','był','była','było','były','co','czy','dla',
    'do','gdy','gdzie','go','i','ich','im','jak','jako','je','jego','jej','jest',
    'jestem','jeszcze','już','ku','lub','ma','mi','mnie','może','na','nad','nam',
    'nas','nawet','nic','nie','niż','o','od','on','ona','one','oni','ono','oraz',
    'po','pod','przez','przy','są','się','ta','tak','także','tam','te','tego',
    'tej','ten','to','tu','tym','u','w','we','więc','z','za','ze','że','żeby',
];
