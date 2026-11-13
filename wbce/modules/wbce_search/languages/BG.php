<?php
/**
 * wbce_search - languages/BG.php
 * Български
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Разширени настройки за търсене. Индекс, модули, оформления и статистика на търсенето в WBCE CMS: пълнотекстово търсене с оператори, предложения в реално време, маркиране на резултатите на целевата страница и облак от етикети.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Търси';
$SEARCH['SEARCH_HEADING']                    = 'Търсене';
$SEARCH['RESULTS_FOR']                       = 'Резултати за';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Няма резултати',
    'one' => '%d резултат',
    'other' => '%d резултата',
];
$SEARCH['NO_RESULTS']                        = 'Не са намерени резултати.';
$SEARCH['ALL_WORDS']                         = 'Всички думи';
$SEARCH['ANY_WORDS']                         = 'Някоя от думите';
$SEARCH['EXACT_MATCH']                       = 'Точна фраза';
$SEARCH['MATCH']                             = 'Режим на търсене';
$SEARCH['PAGES']                             = 'Страници';
$SEARCH['TIPS_TITLE']                        = 'Съвети за търсене:';
$SEARCH['TIP_FEWER']                         = 'Използвайте по-малко думи';
$SEARCH['TIP_OR']                            = 'Търсене ИЛИ:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'другаДума';
$SEARCH['TIP_NOT']                           = 'Изключване:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'изключи';
$SEARCH['TIP_PHRASE']                        = 'Точна фраза:';
$SEARCH['TIP_WILDCARD']                      = 'Заместващ знак:';
$SEARCH['TIP_FUZZY']                         = 'Допускане на правописни грешки:';
$SEARCH['DID_YOU_MEAN']                      = 'Може би имахте предвид:';
$SEARCH['SCOPE_TITLE']                       = 'Само заглавие';
$SEARCH['SCOPE_CONTENT']                     = 'Само съдържание';
$SEARCH['SEARCH_OR']                         = 'Търсене ИЛИ (поне една дума)';
$SEARCH['AREAS_TITLE']                       = 'Разглеждане по тема:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Често търсени:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'търсено веднъж',
    'other' => 'търсено %d пъти',
];
$SEARCH['HIT_CONTENT']                       = 'Съдържание';
$SEARCH['HIT_KEYWORD']                       = 'Ключова дума';
$SEARCH['HIT_DESCRIPTION']                   = 'Описание';
$SEARCH['HIT_TITLE']                         = 'Заглавие';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Заместващ знак';
$SEARCH['LEGEND_FUZZY']                      = 'Допускане на грешки';
$SEARCH['LEGEND_PHRASE']                     = 'Точна фраза';
$SEARCH['LEGEND_EXCLUDE']                    = 'Изключване на дума';
$SEARCH['LEGEND_OR']                         = 'Една от думите';
$SEARCH['LEGEND_COMBINATION']                = 'Комбинация';
$SEARCH['LEGEND_OPERATORS']                  = 'Оператори';
$SEARCH['OP_EXCLUDE']                        = 'изключи';
$SEARCH['OP_WILDCARD']                       = 'заместител';
$SEARCH['OP_TYPOS']                          = 'грешки';
$SEARCH['OP_PHRASE']                         = 'фраза';
$SEARCH['OP_OR']                             = 'или';
$SEARCH['EXAMPLE_WORD']                      = 'горчица';
$SEARCH['EXAMPLE_WORD2']                     = 'биологична';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'люта';
$SEARCH['EXAMPLE_OR']                        = 'кетчуп';
$SEARCH['EXAMPLE_PHRASE']                    = 'жълта горчица';
$SEARCH['EXAMPLE_PHRASE2']                   = 'от царевица';
$SEARCH['LABEL_LEGEND']                      = 'Легенда';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Думата е намерена в съдържанието на страницата';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Думата е намерена в ключовите думи на страницата';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Думата е намерена в описанието на страницата';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Думата е намерена в заглавието';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Дума в съдържанието и ключовите думи';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Дума в съдържанието и описанието';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Дума в ключовите думи и описанието';
$SEARCH['LEGEND_HIT_ALL']                    = 'Дума и в трите полета';
$SEARCH['PAGE_PREV']                         = 'Предишна страница';
$SEARCH['PAGE_NEXT']                         = 'Следваща страница';
$SEARCH['DROPLET_DESCRIPTION']               = 'Облак от най-търсените думи. Параметри: max=20, min_count=1, desc=Надпис, active=true (false = скрит)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Преглед';
$SEARCH['MENU_MODULES']                      = 'Модули';
$SEARCH['MENU_LAYOUT']                       = 'Оформление';
$SEARCH['MENU_SETTINGS']                     = 'Настройки';
$SEARCH['MENU_STATS']                        = 'Статистика';
$SEARCH['CRUMB_OVERVIEW']                    = 'Състояние и поддръжка на индекса за търсене';
$SEARCH['CRUMB_MODULES']                     = 'Кои модули захранват индекса за търсене';
$SEARCH['CRUMB_LAYOUT']                      = 'Шаблон на страницата с резултати';
$SEARCH['CRUMB_SETTINGS']                    = 'Поведение на търсенето, търсене в реално време, облак от етикети';
$SEARCH['CRUMB_STATS']                       = 'Какво търсят посетителите';
$SEARCH['LEDE_OVERVIEW']                     = 'Текущо състояние на индекса и на търсенето в сайта.';
$SEARCH['LEDE_MODULES']                      = 'Как се индексира всеки инсталиран модул. Модулите без дефиниция дават само заглавието на страницата си.';
$SEARCH['LEDE_LAYOUT']                       = 'Какво оформление и какъв стилов файл използват страницата за търсене и облакът от етикети. Доставените файлове и файловете от шаблона остават непроменени; винаги редактирате собствено копие.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Страница с резултати';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Оформление на страницата /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Облак от етикети';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Оформление на droplet [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Стилов файл';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'За страницата с резултати и облака от етикети';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'CSS от %1$s се показва тук · „Редактиране“ създава %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Без стилов файл';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'шаблонът сам носи всички стилове';
$SEARCH['LAYOUT_ACTIVE']                     = 'активно';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'собствен файл';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'от шаблона „%s“';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'доставен';
$SEARCH['LAYOUT_READONLY']                   = 'само за четене';
$SEARCH['LAYOUT_MODIFIED']                   = 'променен %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'файла от шаблона %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'доставения файл %s';
$SEARCH['BTN_EDIT']                          = 'Редактиране';
$SEARCH['BTN_DELETE']                        = 'Изтриване';
$SEARCH['BTN_BACK']                          = 'Назад';
$SEARCH['BTN_SAVE_BACK']                     = 'Запис и назад';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Ще бъде създаден нов файл %1\$s като копие на %2\$s.\n\nКопието се редактира и става активното оформление; оригиналът остава непроменен.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s вече съществува. Да бъде ли презаписан със съдържанието на %2\$s и редактиран?\n\nТекущата ви версия на %1\$s ще бъде загубена.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Изтриване на %s?\n\nТова не може да бъде отменено.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Активно оформление: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s е създаден';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s е изтрит';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Стилов файл: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Точкуване, откъси, търсене в реално време и облак от етикети.';
$SEARCH['LEDE_STATS']                        = 'Думи за търсене, записани за облака от етикети (топ 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Индекс за търсене';
$SEARCH['INDEX_BUILD']                       = 'Пълно преизграждане';
$SEARCH['INDEX_UPDATE']                      = 'Обновяване на промените';
$SEARCH['INDEX_CLEAR']                       = 'Изчистване на индекса';
$SEARCH['ENTRIES']                           = 'Записи';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Индексът е изграден — няма нищо за индексиране.',
    'one' => 'Индексът е изграден: %d запис.',
    'other' => 'Индексът е изграден: %d записа.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Няма нищо за обновяване.',
    'one' => '%d запис е обновен.',
    'other' => '%d записа са обновени.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Индексът е изтрит.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Наистина ли да се изтрие целият индекс?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Търсене в сайта';
$SEARCH['LABEL_LAST_INDEXED']                = 'Последно индексиране';
$SEARCH['INDEX_BUILD_DESC']                  = 'Прочита отново <b>всички</b> секции за търсене. При големи сайтове отнема време.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Прочита само променените или липсващите секции. По-бързо от пълно преизграждане.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Прочита само променените или липсващите секции. В момента няма какво да се прави.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Изпразва индекса. Търсенето не намира нищо, докато не бъде преизграден.';
$SEARCH['LABEL_FRESHNESS']                   = 'Актуалност';
$SEARCH['FRESH_ALL']                         = '<b>Индексът е актуален</b> — всички %d секции съответстват на последната си промяна.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d от %2$d</b> секции са променени или липсват.';
$SEARCH['FRESH_NONE']                        = 'Все още няма секции за търсене.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Търсене в сайта';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Настройки › Търсене';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Публично';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Регистрирани';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Лично';
$SEARCH['SITE_SEARCH_NONE']                  = 'Изключено';
$SEARCH['HINT_SITE_SEARCH']                  = 'Кой може да търси — за всяко поле за търсене в сайта, независимо какво търсене стои зад него. Същата настройка като в <a href="%s">Настройки › Търсене</a>; „Регистрирани“ и „Лично“ означават едно и също: само влезли посетители.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Да се зададе търсенето в сайта на „%s“?\n\nТова променя настройката „Търсене“ на сайта за всички посетители.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Търсене в сайта: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Езици';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Няма информация за езика';
$SEARCH['VIS_HIDDEN']                        = 'Скрито';
$SEARCH['VIS_PUBLIC']                        = 'Публично';
$SEARCH['VIS_PRIVATE']                       = 'Лично';
$SEARCH['VIS_REGISTERED']                    = 'Регистрирани';
$SEARCH['VIS_NONE']                          = 'Няма';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Оформлението е празно и не е записано.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'search_custom.htt не можа да бъде записан. Проверете правата за запис на папката layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'При отметнато „AjaxSave“ Запис и Ctrl+S записват без презареждане на страницата; тогава „Запис и назад“ се скрива.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Минимална дължина на думата';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'По-кратките думи се пренебрегват';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Тежест на заглавието';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Съвпадения в заглавието × коефициент';
$SEARCH['SET_MAX_EXCERPT']                   = 'Макс. дължина на откъса';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Знаци в откъс';
$SEARCH['SET_HIGHLIGHT']                     = 'Открояване';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Откроява търсените думи в откъса';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Етикет за открояване';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'HTML етикет, използван за открояване';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Резултати на страница';
$SEARCH['SET_AUTO_REINDEX']                  = 'Автоматично преиндексиране при търсене';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Незабелязано обновява остарелите записи при всяко търсене';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Показване на облака от етикети';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'На страницата за търсене. Droplet-ът има собствен параметър active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Записване на търсенията';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Записва търсенията за облака от етикети и статистиката — изключването не скрива облака';
$SEARCH['SET_AJAX_SUGGEST']                  = 'AJAX търсене в реално време';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Показва предложения по време на писане';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Режим за отстраняване на грешки';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Показва технически данни под всеки резултат (само за администратори)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Шаблон на страницата за търсене';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Шаблон за сайта, в който се показва страницата /search/.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Шаблон по подразбиране на сайта (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Търсене';
$SEARCH['GROUP_DISPLAY']                     = 'Показване на резултатите';
$SEARCH['GROUP_INDEX']                       = 'Поддръжка на индекса';
$SEARCH['GROUP_LIVE']                        = 'Търсене в реално време';
$SEARCH['GROUP_TAGCLOUD']                    = 'Облак от етикети';
$SEARCH['GROUP_ADMIN']                       = 'Администраторски инструмент';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Размер на страницата със списъка резултати';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Езиков филтър';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Показва само страници на езика на посетителя (по подразбиране за сайта: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Разширено търсене';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Показва във формата отметки за обхват и опция ИЛИ';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Макс. секции на търсене';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Лимит за автоматичното преиндексиране (контрол на натоварването)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Източник на предложенията';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Хибридният режим показва първо съвпаденията в заглавията и допълва със страници, съдържащи думата в текста';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Макс. предложения';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Брой показвани предложения';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Изображения в предложенията';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Показва изображението на елемента (каталог, новини …) до предложението, ако модулът индексира такова';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Макс. етикети';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Брой думи в облака от етикети';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Мин. търсения';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Минимален брой търсения, преди дадена дума да се появи';
$SEARCH['SET_NAV_STYLE']                     = 'Навигация';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Раздели отгоре или лента с икони отляво';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Първо заглавия, допълнени от пълния текст (препоръчително)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Заглавие + описание (бързо)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Пълнотекстов индекс (задълбочено)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Раздели отгоре';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Странична лента отляво';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Крайна точка';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Разпознава се автоматично на страницата за търсене за полета с име „string“, type="search" или клас ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Настройките са записани.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Статистиката за търсенето е изтрита.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Наистина ли да се изтрие цялата статистика?';
$SEARCH['STATS_DELETE']                      = 'Изтриване на статистиката';
$SEARCH['STATS_TERM']                        = 'Дума за търсене';
$SEARCH['STATS_COUNT']                       = 'Брой';
$SEARCH['STATS_LAST']                        = 'Последно търсене';
$SEARCH['STATS_TERMS']                       = 'Думи';
$SEARCH['STATS_SEARCHES']                    = 'Търсения';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Топ 100 от %d дума.',
    'other' => 'Топ 100 от %d думи.',
];
$SEARCH['STATS_EMPTY']                       = 'Все още няма записани думи за търсене.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Търсено, нищо не е намерено';
$SEARCH['HINT_STATS_MISSES']                 = 'Цели търсения без резултат — подсказка за съдържание, което посетителите очакват, но не намират. Никога не се показва публично.';
$SEARCH['STATS_QUERY']                       = 'Заявка';
$SEARCH['STATS_MISSES_EMPTY']                = 'Няма записани търсения без резултат.';
$SEARCH['CARD_WORDS']                        = 'Индекс на думите';
$SEARCH['HINT_WORDS']                        = 'За големи сайтове: списък на всички думи, за да не се налага търсенето да чете целия индекс. Изгражда се автоматично от %s записа в индекса нагоре.';
$SEARCH['WORDS_INACTIVE']                    = 'Неактивен — сайтът е под прага (%2$s записа в индекса, в момента %1$s); обикновеното търсене е достатъчно бързо.';
$SEARCH['WORDS_OFF']                         = 'Изключен в настройките.';
$SEARCH['WORDS_BUILDING']                    = 'Изгражда се';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Продължаване на изграждането';
$SEARCH['MSG_WORDS_READY']                   = 'Индексът на думите е завършен.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Индекс на думите: остава %d запис — дотогава се използва обикновеното търсене.',
    'other' => 'Индекс на думите: остават %d записа — дотогава се използва обикновеното търсене.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'В употреба — %d запис на дума.',
    'other' => 'В употреба — %d записа на думи.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Индекс на думите';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Автоматично: изгражда се само когато сайтът достигне прага по-долу. Малките сайтове нямат нужда от него.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Автоматично';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Винаги включен';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Изключен';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Индекс на думите от';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Брой индексирани записи (секции и елементи на модули), от който индексът на думите се изгражда автоматично';
$SEARCH['BTN_DELETE_TERM']                   = 'Премахване на думата';
$SEARCH['MSG_TERM_DELETED']                  = 'Думата е премахната.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Полуконфигурацията за <b>%s</b> е предварително попълнена от search.php — проверете и коригирайте.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Полуконфигурацията за \'%s\' е записана.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Конфигурацията и записите в индекса за %s са изтрити.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php е създаден. Моля, преизградете индекса.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Изтриване на конфигурацията и записите в индекса за %s?';
$SEARCH['STATUS_SEMI']                       = 'Полуконфигурация';
$SEARCH['LABEL_GUIDE']                       = 'Показване на ръководството за този модул';
$SEARCH['LABEL_TABLE_HINT']                  = 'Изберете таблица → колоните се зареждат автоматично';
$SEARCH['LABEL_TABLE_SELECT']                = 'Изберете таблица';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'Котва на страница в WBCE';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Само страници за търсене';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Всички секции (пул от съдържание)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Само активни записи (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Времеви контрол (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Join-ове (по избор, макс. 3) — данни от допълнителни таблици';
$SEARCH['LABEL_GENERATE_DEF']                = 'Създаване на файл module_defs';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'От search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Изтриване на конфигурацията';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Няма текстови колони';
$SEARCH['LABEL_ERROR']                       = 'Грешка';
$SEARCH['LABEL_MODULE']                      = 'Модул';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Не е за търсене';
$SEARCH['LABEL_HELP']                        = 'Помощ';
$SEARCH['BTN_CONFIGURE']                     = 'Конфигуриране';
$SEARCH['BTN_CLOSE']                         = 'Затваряне';
$SEARCH['DEF_GENERATED']                     = 'създадена';
$SEARCH['DEF_SHIPPED']                       = 'вградена';
$SEARCH['LABEL_KIND']                        = 'Вид';
$SEARCH['LABEL_INDEXING']                    = 'Индексиране';
$SEARCH['LABEL_SECTIONS']                    = 'Секции';
$SEARCH['PLACEHOLDER_FILTER']                = 'Филтър …';
$SEARCH['MODULES_SHOWN']                     = 'Показани %1$d от %2$d модула';
$SEARCH['KIND_PAGE']                         = 'Модули за страници';
$SEARCH['KIND_SNIPPET']                      = 'Фрагменти';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Филтри';
$SEARCH['KIND_TOOL']                         = 'Администраторски инструменти';
$SEARCH['BADGE_PAGE']                        = 'Страница';
$SEARCH['BADGE_SNIPPET']                     = 'Фрагмент';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Филтър';
$SEARCH['BADGE_TOOL']                        = 'Инструмент';
$SEARCH['GROUP_DEF']                         = 'с дефиниция';
$SEARCH['GROUP_OPEN']                        = 'непълни';
$SEARCH['GROUP_TITLE']                       = 'само заглавие на страницата';
$SEARCH['SOURCE_MODULE']                     = 'От модула';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Вградена';
$SEARCH['SOURCE_GENERATED']                  = 'Полуконфигурация';
$SEARCH['SOURCE_SEMI']                       = 'Полуконфигурация – не е създадена';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'Открит е search.php';
$SEARCH['SOURCE_TITLE']                      = 'Само заглавие на страницата';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Модулът носи собствена дефиниция за търсене (search_index.php) — не може да се редактира тук.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Индексира се чрез PHP callback — не може да се редактира тук.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Дефиниция, доставена с WBCE Search (module_defs/). Полуконфигурацията има предимство.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Дефиниция, създадена от полуконфигурацията.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Полуконфигурацията е записана, но все още няма създадена дефиниция.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Все още няма дефиниция — може да се попълни предварително от стария search.php на модула.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Няма дефиниция — индексът съдържа само заглавието на страницата.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Няма секции на страници — няма нищо за индексиране.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Търсенето е изключено за тази страница';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Вградена дефиниция. Записът създава полуконфигурация с предимство.';
$SEARCH['LABEL_TABLE']                       = 'Таблица';
$SEARCH['LABEL_OWN_TABLES']                  = 'Таблици на този модул';
$SEARCH['LABEL_OTHER_TABLES']                = 'Други таблици на модули';
$SEARCH['HINT_TABLE']                        = 'Могат да се индексират само таблици mod_* с колона section_id.';
$SEARCH['LABEL_ID_FIELD']                    = 'Колона ID';
$SEARCH['LABEL_ITEM_KEY']                    = 'Ключ на елемента';
$SEARCH['HINT_ITEM_KEY']                     = 'Уникален ключ за всеки елемент (режим за много).';
$SEARCH['LABEL_TITLE_COL']                   = 'Колона за заглавие';
$SEARCH['LABEL_TEXT_COLS']                   = 'Текстови колони';
$SEARCH['LABEL_LINK_COL']                    = 'Колона за връзка';
$SEARCH['HINT_LINK_PREFIX']                  = 'Незадължителен префикс: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Колона за изображение';
$SEARCH['HINT_IMAGE_PATH']                   = 'Път под /media, позволени са заместители като {item_id}.';
$SEARCH['LABEL_NONE']                        = 'няма';
$SEARCH['LABEL_MODE']                        = 'Режим';
$SEARCH['MODE_SINGLE']                       = 'Единичен — един запис на секция';
$SEARCH['MODE_MULTI']                        = 'Многократен — един запис на елемент';
$SEARCH['LABEL_INDEX_BASE']                  = 'Основа на индекса';
$SEARCH['LABEL_FILTER']                      = 'Филтър';
$SEARCH['LABEL_NO_JOIN']                     = 'без join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Моля, изберете валидна таблица на модул.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'В search.php на %s не е намерена използваема таблица.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Няма страници',
    'one' => '%d страница',
    'other' => '%d страници',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Запис';
$SEARCH['MSG_SECURITY_ERROR']                = 'Проверката за сигурност е неуспешна.';
$SEARCH['STATUS_ACTIVE']                     = 'Активен';
$SEARCH['STATUS_INACTIVE']                   = 'Неактивен';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'а','аз','ако','ала','бе','без','би','бил','била','били','било','близо','бъде',
    'във','в','вас','ваш','ваша','вие','все','всеки','всички','всичко','вън','го',
    'да','дали','до','докато','е','единствено','за','зад','и','из','или','им','има',
    'ин','как','каква','какво','като','кой','която','което','които','кога','когато',
    'към','ли','ме','между','ми','много','може','му','на','над','нас','не','него',
    'нея','ни','ние','никой','нищо','но','ну','няма','о','обаче','около','от',
    'отгоре','още','па','по','под','при','с','са','само','се','си','сме','със',
    'също','сте','съм','т','та','така','там','те','тези','ти','то','това','този',
    'той','тук','тя','у','че','чрез','щом','ще','я',
];
