<?php
/**
 * wbce_search - languages/RU.php
 * Русский
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Расширенные настройки поиска. Индекс, модули, шаблоны и статистика поиска WBCE CMS: полнотекстовый поиск с операторами, подсказки при вводе, выделение найденного на целевой странице и облако тегов.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Найти';
$SEARCH['SEARCH_HEADING']                    = 'Поиск';
$SEARCH['RESULTS_FOR']                       = 'Результаты по запросу';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Нет результатов',
    'one' => '%d результат',
    'few' => '%d результата',
    'many' => '%d результатов',
    'other' => '%d результата',
];
$SEARCH['NO_RESULTS']                        = 'Ничего не найдено.';
$SEARCH['ALL_WORDS']                         = 'Все слова';
$SEARCH['ANY_WORDS']                         = 'Любое слово';
$SEARCH['EXACT_MATCH']                       = 'Точная фраза';
$SEARCH['MATCH']                             = 'Режим поиска';
$SEARCH['PAGES']                             = 'Страницы';
$SEARCH['TIPS_TITLE']                        = 'Советы по поиску:';
$SEARCH['TIP_FEWER']                         = 'Используйте меньше слов';
$SEARCH['TIP_OR']                            = 'Поиск ИЛИ:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'другоеСлово';
$SEARCH['TIP_NOT']                           = 'Исключить:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'исключить';
$SEARCH['TIP_PHRASE']                        = 'Точная фраза:';
$SEARCH['TIP_WILDCARD']                      = 'Подстановочный знак:';
$SEARCH['TIP_FUZZY']                         = 'Допускать опечатки:';
$SEARCH['DID_YOU_MEAN']                      = 'Возможно, вы имели в виду:';
$SEARCH['SCOPE_TITLE']                       = 'Только заголовок';
$SEARCH['SCOPE_CONTENT']                     = 'Только содержимое';
$SEARCH['SEARCH_OR']                         = 'Поиск ИЛИ (хотя бы одно слово)';
$SEARCH['AREAS_TITLE']                       = 'Обзор по темам:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Часто ищут:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'искали %d раз',
    'few' => 'искали %d раза',
    'many' => 'искали %d раз',
    'other' => 'искали %d раза',
];
$SEARCH['HIT_CONTENT']                       = 'Содержимое';
$SEARCH['HIT_KEYWORD']                       = 'Ключевое слово';
$SEARCH['HIT_DESCRIPTION']                   = 'Описание';
$SEARCH['HIT_TITLE']                         = 'Заголовок';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Подстановочный знак';
$SEARCH['LEGEND_FUZZY']                      = 'Допускать опечатки';
$SEARCH['LEGEND_PHRASE']                     = 'Точная фраза';
$SEARCH['LEGEND_EXCLUDE']                    = 'Исключить слово';
$SEARCH['LEGEND_OR']                         = 'Одно из слов';
$SEARCH['LEGEND_COMBINATION']                = 'Комбинация';
$SEARCH['LEGEND_OPERATORS']                  = 'Операторы';
$SEARCH['OP_EXCLUDE']                        = 'исключить';
$SEARCH['OP_WILDCARD']                       = 'шаблон';
$SEARCH['OP_TYPOS']                          = 'опечатки';
$SEARCH['OP_PHRASE']                         = 'фраза';
$SEARCH['OP_OR']                             = 'или';
$SEARCH['EXAMPLE_WORD']                      = 'горчица';
$SEARCH['EXAMPLE_WORD2']                     = 'органическая';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'острая';
$SEARCH['EXAMPLE_OR']                        = 'кетчуп';
$SEARCH['EXAMPLE_PHRASE']                    = 'жёлтая горчица';
$SEARCH['EXAMPLE_PHRASE2']                   = 'из кукурузы';
$SEARCH['LABEL_LEGEND']                      = 'Обозначения';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Слово найдено в содержимом страницы';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Слово найдено в ключевых словах страницы';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Слово найдено в описании страницы';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Слово найдено в заголовке';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Слово в содержимом и ключевых словах';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Слово в содержимом и описании';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Слово в ключевых словах и описании';
$SEARCH['LEGEND_HIT_ALL']                    = 'Слово во всех трёх полях';
$SEARCH['PAGE_PREV']                         = 'Предыдущая страница';
$SEARCH['PAGE_NEXT']                         = 'Следующая страница';
$SEARCH['DROPLET_DESCRIPTION']               = 'Облако самых частых запросов. Параметры: max=20, min_count=1, desc=Подпись, active=true (false = скрыто)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Обзор';
$SEARCH['MENU_MODULES']                      = 'Модули';
$SEARCH['MENU_LAYOUT']                       = 'Макет';
$SEARCH['MENU_SETTINGS']                     = 'Настройки';
$SEARCH['MENU_STATS']                        = 'Статистика';
$SEARCH['CRUMB_OVERVIEW']                    = 'Состояние и обслуживание поискового индекса';
$SEARCH['CRUMB_MODULES']                     = 'Какие модули наполняют поисковый индекс';
$SEARCH['CRUMB_LAYOUT']                      = 'Шаблон страницы результатов';
$SEARCH['CRUMB_SETTINGS']                    = 'Поведение поиска, живой поиск, облако тегов';
$SEARCH['CRUMB_STATS']                       = 'Что ищут посетители';
$SEARCH['LEDE_OVERVIEW']                     = 'Текущее состояние поискового индекса и поиска на сайте.';
$SEARCH['LEDE_MODULES']                      = 'Как индексируется каждый установленный модуль. Модули без определения дают только заголовок своей страницы.';
$SEARCH['LEDE_LAYOUT']                       = 'Какой макет и какую таблицу стилей используют страница поиска и облако тегов. Поставляемые файлы и файлы шаблона остаются без изменений; вы всегда редактируете собственную копию.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Страница результатов';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Макет страницы /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Облако тегов';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Макет дроплета [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Таблица стилей';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Для страницы результатов и облака тегов';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'CSS из %1$s отображается здесь · «Редактировать» создаёт %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Без таблицы стилей';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'шаблон сам содержит все стили';
$SEARCH['LAYOUT_ACTIVE']                     = 'активен';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'свой файл';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'из шаблона «%s»';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'поставляемый';
$SEARCH['LAYOUT_READONLY']                   = 'только чтение';
$SEARCH['LAYOUT_MODIFIED']                   = 'изменён %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'файл шаблона %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'поставляемый файл %s';
$SEARCH['BTN_EDIT']                          = 'Редактировать';
$SEARCH['BTN_DELETE']                        = 'Удалить';
$SEARCH['BTN_BACK']                          = 'Назад';
$SEARCH['BTN_SAVE_BACK']                     = 'Сохранить и назад';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Будет создан новый файл %1\$s как копия %2\$s.\n\nКопия редактируется и становится активным макетом; оригинал остаётся без изменений.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s уже существует. Перезаписать его содержимым %2\$s и редактировать?\n\nВаша текущая версия %1\$s будет потеряна.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Удалить %s?\n\nЭто действие нельзя отменить.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Активный макет: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s создан';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s удалён';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Таблица стилей: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Оценка, фрагменты, живой поиск и облако тегов.';
$SEARCH['LEDE_STATS']                        = 'Поисковые запросы, записанные для облака тегов (топ-100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Поисковый индекс';
$SEARCH['INDEX_BUILD']                       = 'Полная перестройка';
$SEARCH['INDEX_UPDATE']                      = 'Обновить изменения';
$SEARCH['INDEX_CLEAR']                       = 'Очистить индекс';
$SEARCH['ENTRIES']                           = 'Записи';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Индекс построен — индексировать нечего.',
    'one' => 'Индекс построен: %d запись.',
    'few' => 'Индекс построен: %d записи.',
    'many' => 'Индекс построен: %d записей.',
    'other' => 'Индекс построен: %d записи.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Нечего обновлять.',
    'one' => 'Обновлена %d запись.',
    'few' => 'Обновлено %d записи.',
    'many' => 'Обновлено %d записей.',
    'other' => 'Обновлено %d записи.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Индекс удалён.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Действительно удалить весь индекс?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Поиск на сайте';
$SEARCH['LABEL_LAST_INDEXED']                = 'Последняя индексация';
$SEARCH['INDEX_BUILD_DESC']                  = 'Заново читает <b>все</b> доступные для поиска разделы. На больших сайтах занимает время.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Читает только изменённые или отсутствующие разделы. Быстрее полной перестройки.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Читает только изменённые или отсутствующие разделы. Сейчас делать нечего.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Очищает индекс. Поиск ничего не находит, пока индекс не будет перестроен.';
$SEARCH['LABEL_FRESHNESS']                   = 'Актуальность';
$SEARCH['FRESH_ALL']                         = '<b>Индекс актуален</b> — все разделы (%d) соответствуют своему последнему изменению.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d из %2$d</b> разделов изменены или отсутствуют.';
$SEARCH['FRESH_NONE']                        = 'Пока нет доступных для поиска разделов.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Поиск на сайте';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Настройки › Поиск';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Публичный';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Зарегистрированные';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Приватный';
$SEARCH['SITE_SEARCH_NONE']                  = 'Выключен';
$SEARCH['HINT_SITE_SEARCH']                  = 'Кто может искать — для каждого поля поиска на сайте, какой бы поиск за ним ни стоял. Та же настройка, что и в <a href="%s">Настройки › Поиск</a>; «Зарегистрированные» и «Приватный» означают одно: только вошедшие посетители.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Установить поиск на сайте в «%s»?\n\nЭто меняет настройку сайта «Поиск» для всех посетителей.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Поиск на сайте: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Языки';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Нет информации о языке';
$SEARCH['VIS_HIDDEN']                        = 'Скрыто';
$SEARCH['VIS_PUBLIC']                        = 'Публично';
$SEARCH['VIS_PRIVATE']                       = 'Приватно';
$SEARCH['VIS_REGISTERED']                    = 'Зарегистрированные';
$SEARCH['VIS_NONE']                          = 'Нет';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Макет пуст и не был сохранён.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Не удалось записать search_custom.htt. Проверьте права на запись в папку layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'При включённом «AjaxSave» кнопка Сохранить и Ctrl+S сохраняют без перезагрузки страницы; «Сохранить и назад» тогда скрыта.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Минимальная длина слова';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Более короткие слова игнорируются';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Вес заголовка';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Совпадения в заголовке × коэффициент';
$SEARCH['SET_MAX_EXCERPT']                   = 'Макс. длина фрагмента';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Символов во фрагменте';
$SEARCH['SET_HIGHLIGHT']                     = 'Подсветка';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Подсвечивать искомые слова во фрагменте';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Тег подсветки';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'HTML-тег, используемый для подсветки';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Результатов на странице';
$SEARCH['SET_AUTO_REINDEX']                  = 'Автоматическая переиндексация при поиске';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Незаметно обновляет устаревшие записи при каждом поиске';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Показывать облако тегов';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'На странице поиска. У дроплета свой параметр active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Записывать запросы';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Записывает запросы для облака тегов и статистики — отключение не скрывает облако';
$SEARCH['SET_AJAX_SUGGEST']                  = 'Живой поиск AJAX';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Показывать подсказки при вводе';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Режим отладки';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Показывать технические данные под каждым результатом (только для администраторов)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Шаблон страницы поиска';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Шаблон сайта, в котором показывается страница /search/.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Шаблон сайта по умолчанию (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Поиск';
$SEARCH['GROUP_DISPLAY']                     = 'Вывод результатов';
$SEARCH['GROUP_INDEX']                       = 'Обслуживание индекса';
$SEARCH['GROUP_LIVE']                        = 'Живой поиск';
$SEARCH['GROUP_TAGCLOUD']                    = 'Облако тегов';
$SEARCH['GROUP_ADMIN']                       = 'Инструмент администратора';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Размер страницы списка результатов';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Языковой фильтр';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Показывать только страницы на языке посетителя (по умолчанию для сайта: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Расширенный поиск';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Показывать в форме флажки области поиска и опцию ИЛИ';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Макс. разделов за поиск';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Лимит автоматической переиндексации (контроль нагрузки)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Источник подсказок';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Гибридный режим сначала выводит совпадения в заголовках, затем дополняет страницами, в тексте которых есть слово';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Макс. подсказок';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Количество показываемых подсказок';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Изображения в подсказках';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Показывает изображение элемента (каталог, новости …) рядом с подсказкой, если модуль его индексирует';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Макс. тегов';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Количество слов в облаке тегов';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Мин. запросов';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Минимальное число запросов, прежде чем слово появится';
$SEARCH['SET_NAV_STYLE']                     = 'Навигация';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Вкладки сверху или панель значков слева';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Сначала заголовки, дополненные из полного текста (рекомендуется)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Заголовок + описание (быстро)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Полнотекстовый индекс (тщательно)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Вкладки сверху';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Боковая панель слева';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Конечная точка';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Определяется автоматически на странице поиска для полей с именем «string», type="search" или классом ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Настройки сохранены.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Статистика поиска удалена.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Действительно удалить всю статистику?';
$SEARCH['STATS_DELETE']                      = 'Удалить статистику';
$SEARCH['STATS_TERM']                        = 'Запрос';
$SEARCH['STATS_COUNT']                       = 'Количество';
$SEARCH['STATS_LAST']                        = 'Последний поиск';
$SEARCH['STATS_TERMS']                       = 'Запросы';
$SEARCH['STATS_SEARCHES']                    = 'Поиски';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Топ-100 из %d запроса.',
    'few' => 'Топ-100 из %d запросов.',
    'many' => 'Топ-100 из %d запросов.',
    'other' => 'Топ-100 из %d запроса.',
];
$SEARCH['STATS_EMPTY']                       = 'Поисковые запросы ещё не записаны.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Искали, ничего не нашли';
$SEARCH['HINT_STATS_MISSES']                 = 'Целые запросы без результата — подсказка о содержимом, которое посетители ожидают, но не находят. Никогда не показывается публично.';
$SEARCH['STATS_QUERY']                       = 'Запрос';
$SEARCH['STATS_MISSES_EMPTY']                = 'Запросов без результата не записано.';
$SEARCH['CARD_WORDS']                        = 'Индекс слов';
$SEARCH['HINT_WORDS']                        = 'Для больших сайтов: список всех слов, чтобы поиску не приходилось читать весь индекс. Строится автоматически начиная с %s записей индекса.';
$SEARCH['WORDS_INACTIVE']                    = 'Не активен — сайт ниже порога (%2$s записей индекса, сейчас %1$s); обычный поиск достаточно быстр.';
$SEARCH['WORDS_OFF']                         = 'Выключен в настройках.';
$SEARCH['WORDS_BUILDING']                    = 'Строится';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Продолжить построение';
$SEARCH['MSG_WORDS_READY']                   = 'Индекс слов готов.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Индекс слов: осталась %d запись — до тех пор используется обычный поиск.',
    'few' => 'Индекс слов: осталось %d записи — до тех пор используется обычный поиск.',
    'many' => 'Индекс слов: осталось %d записей — до тех пор используется обычный поиск.',
    'other' => 'Индекс слов: осталось %d записи — до тех пор используется обычный поиск.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'Используется — %d запись слов.',
    'few' => 'Используется — %d записи слов.',
    'many' => 'Используется — %d записей слов.',
    'other' => 'Используется — %d записи слов.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Индекс слов';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Автоматически: строится только когда сайт достигает порога ниже. Небольшим сайтам он не нужен.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Автоматически';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Всегда включён';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Выключен';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Индекс слов от';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Число проиндексированных записей (разделы и элементы модулей), начиная с которого индекс слов строится автоматически';
$SEARCH['BTN_DELETE_TERM']                   = 'Удалить этот запрос';
$SEARCH['MSG_TERM_DELETED']                  = 'Запрос удалён.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Полуконфигурация для <b>%s</b> предзаполнена из search.php — проверьте и настройте.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Полуконфигурация для \'%s\' сохранена.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Конфигурация и записи индекса для %s удалены.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php создан. Перестройте индекс.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Удалить конфигурацию и записи индекса для %s?';
$SEARCH['STATUS_SEMI']                       = 'Полуконфигурация';
$SEARCH['LABEL_GUIDE']                       = 'Показать руководство для этого модуля';
$SEARCH['LABEL_TABLE_HINT']                  = 'Выберите таблицу → столбцы загрузятся автоматически';
$SEARCH['LABEL_TABLE_SELECT']                = 'Выберите таблицу';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'Якорь страницы WBCE';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Только страницы, доступные для поиска';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Все разделы (пул контента)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Только активные записи (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Управление временем (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Join-ы (необязательно, макс. 3) — данные из дополнительных таблиц';
$SEARCH['LABEL_GENERATE_DEF']                = 'Создать файл module_defs';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Из search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Удалить конфигурацию';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Нет текстовых столбцов';
$SEARCH['LABEL_ERROR']                       = 'Ошибка';
$SEARCH['LABEL_MODULE']                      = 'Модуль';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Не участвует в поиске';
$SEARCH['LABEL_HELP']                        = 'Справка';
$SEARCH['BTN_CONFIGURE']                     = 'Настроить';
$SEARCH['BTN_CLOSE']                         = 'Закрыть';
$SEARCH['DEF_GENERATED']                     = 'создано';
$SEARCH['DEF_SHIPPED']                       = 'встроено';
$SEARCH['LABEL_KIND']                        = 'Тип';
$SEARCH['LABEL_INDEXING']                    = 'Индексация';
$SEARCH['LABEL_SECTIONS']                    = 'Разделы';
$SEARCH['PLACEHOLDER_FILTER']                = 'Фильтр …';
$SEARCH['MODULES_SHOWN']                     = 'Показано модулей: %1$d из %2$d';
$SEARCH['KIND_PAGE']                         = 'Модули страниц';
$SEARCH['KIND_SNIPPET']                      = 'Сниппеты';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Фильтры';
$SEARCH['KIND_TOOL']                         = 'Инструменты администратора';
$SEARCH['BADGE_PAGE']                        = 'Страница';
$SEARCH['BADGE_SNIPPET']                     = 'Сниппет';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Фильтр';
$SEARCH['BADGE_TOOL']                        = 'Инструмент';
$SEARCH['GROUP_DEF']                         = 'с определением';
$SEARCH['GROUP_OPEN']                        = 'неполные';
$SEARCH['GROUP_TITLE']                       = 'только заголовок страницы';
$SEARCH['SOURCE_MODULE']                     = 'Из модуля';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Встроено';
$SEARCH['SOURCE_GENERATED']                  = 'Полуконфигурация';
$SEARCH['SOURCE_SEMI']                       = 'Полуконфигурация – не создано';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'Найден search.php';
$SEARCH['SOURCE_TITLE']                      = 'Только заголовок страницы';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Модуль поставляет собственное определение поиска (search_index.php) — здесь не редактируется.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Индексируется через PHP-callback — здесь не редактируется.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Определение, поставляемое с WBCE Search (module_defs/). Полуконфигурация имеет приоритет.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Определение создано из полуконфигурации.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Полуконфигурация сохранена, но определение ещё не создано.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Определения пока нет — можно предзаполнить из старого search.php модуля.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Нет определения — индекс содержит только заголовок страницы.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Нет разделов страниц — индексировать нечего.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Поиск для этой страницы выключен';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Встроенное определение. Сохранение создаёт полуконфигурацию с приоритетом.';
$SEARCH['LABEL_TABLE']                       = 'Таблица';
$SEARCH['LABEL_OWN_TABLES']                  = 'Таблицы этого модуля';
$SEARCH['LABEL_OTHER_TABLES']                = 'Другие таблицы модулей';
$SEARCH['HINT_TABLE']                        = 'Индексировать можно только таблицы mod_* со столбцом section_id.';
$SEARCH['LABEL_ID_FIELD']                    = 'Столбец ID';
$SEARCH['LABEL_ITEM_KEY']                    = 'Ключ элемента';
$SEARCH['HINT_ITEM_KEY']                     = 'Уникальный ключ для каждого элемента (режим «много»).';
$SEARCH['LABEL_TITLE_COL']                   = 'Столбец заголовка';
$SEARCH['LABEL_TEXT_COLS']                   = 'Текстовые столбцы';
$SEARCH['LABEL_LINK_COL']                    = 'Столбец ссылки';
$SEARCH['HINT_LINK_PREFIX']                  = 'Необязательный префикс: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Столбец изображения';
$SEARCH['HINT_IMAGE_PATH']                   = 'Путь внутри /media, допускаются подстановки вроде {item_id}.';
$SEARCH['LABEL_NONE']                        = 'нет';
$SEARCH['LABEL_MODE']                        = 'Режим';
$SEARCH['MODE_SINGLE']                       = 'Один — одна запись на раздел';
$SEARCH['MODE_MULTI']                        = 'Много — одна запись на элемент';
$SEARCH['LABEL_INDEX_BASE']                  = 'Основа индекса';
$SEARCH['LABEL_FILTER']                      = 'Фильтр';
$SEARCH['LABEL_NO_JOIN']                     = 'без join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Выберите корректную таблицу модуля.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'В search.php модуля %s не найдено подходящей таблицы.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Нет страниц',
    'one' => '%d страница',
    'few' => '%d страницы',
    'many' => '%d страниц',
    'other' => '%d страницы',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Сохранить';
$SEARCH['MSG_SECURITY_ERROR']                = 'Проверка безопасности не пройдена.';
$SEARCH['STATUS_ACTIVE']                     = 'Активен';
$SEARCH['STATUS_INACTIVE']                   = 'Неактивен';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'а','без','более','бы','был','была','были','было','быть','в','вам','вас','весь',
    'во','вот','все','всё','всего','всех','вы','где','да','даже','для','до','его',
    'ее','её','если','есть','еще','ещё','же','за','здесь','и','из','или','им','их',
    'к','как','когда','кто','ли','либо','мне','может','мы','на','над','надо','наш',
    'не','него','нее','неё','нет','ни','них','но','ну','о','об','однако','он','она',
    'они','оно','от','очень','по','под','при','с','со','так','также','такой','там',
    'те','тем','то','того','тоже','той','только','том','ты','у','уже','хотя','чего',
    'чем','что','чтобы','чье','чья','эта','эти','это','этот','я',
];
