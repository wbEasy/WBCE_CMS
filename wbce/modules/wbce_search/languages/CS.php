<?php
/**
 * wbce_search - languages/CS.php
 * Čeština
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Pokročilá nastavení vyhledávání. Index, moduly, šablony a statistiky vyhledávání WBCE CMS: fulltextové vyhledávání s operátory, živé návrhy, zvýraznění výsledků na cílové stránce a oblak štítků.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Hledat';
$SEARCH['SEARCH_HEADING']                    = 'Vyhledávání';
$SEARCH['RESULTS_FOR']                       = 'Výsledky pro';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Žádné výsledky',
    'one' => '%d výsledek',
    'few' => '%d výsledky',
    'many' => '%d výsledků',
    'other' => '%d výsledků',
];
$SEARCH['NO_RESULTS']                        = 'Nebyly nalezeny žádné výsledky.';
$SEARCH['ALL_WORDS']                         = 'Všechna slova';
$SEARCH['ANY_WORDS']                         = 'Kterékoli slovo';
$SEARCH['EXACT_MATCH']                       = 'Přesná fráze';
$SEARCH['MATCH']                             = 'Režim vyhledávání';
$SEARCH['PAGES']                             = 'Stránky';
$SEARCH['TIPS_TITLE']                        = 'Tipy pro vyhledávání:';
$SEARCH['TIP_FEWER']                         = 'Použijte méně výrazů';
$SEARCH['TIP_OR']                            = 'Hledání NEBO:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'jinýVýraz';
$SEARCH['TIP_NOT']                           = 'Vyloučit:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'vyloučit';
$SEARCH['TIP_PHRASE']                        = 'Přesná fráze:';
$SEARCH['TIP_WILDCARD']                      = 'Zástupný znak:';
$SEARCH['TIP_FUZZY']                         = 'Tolerovat překlepy:';
$SEARCH['DID_YOU_MEAN']                      = 'Měli jste na mysli:';
$SEARCH['SCOPE_TITLE']                       = 'Pouze titulek';
$SEARCH['SCOPE_CONTENT']                     = 'Pouze obsah';
$SEARCH['SEARCH_OR']                         = 'Hledání NEBO (alespoň jeden výraz)';
$SEARCH['AREAS_TITLE']                       = 'Procházet podle tématu:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Často hledané:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'hledáno jednou',
    'few' => 'hledáno %dkrát',
    'many' => 'hledáno %dkrát',
    'other' => 'hledáno %dkrát',
];
$SEARCH['HIT_CONTENT']                       = 'Obsah';
$SEARCH['HIT_KEYWORD']                       = 'Klíčové slovo';
$SEARCH['HIT_DESCRIPTION']                   = 'Popis';
$SEARCH['HIT_TITLE']                         = 'Titulek';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Zástupný znak';
$SEARCH['LEGEND_FUZZY']                      = 'Tolerovat překlepy';
$SEARCH['LEGEND_PHRASE']                     = 'Přesná fráze';
$SEARCH['LEGEND_EXCLUDE']                    = 'Vyloučit výraz';
$SEARCH['LEGEND_OR']                         = 'Jeden z výrazů';
$SEARCH['LEGEND_COMBINATION']                = 'Kombinace';
$SEARCH['LEGEND_OPERATORS']                  = 'Operátory';
$SEARCH['OP_EXCLUDE']                        = 'vyloučit';
$SEARCH['OP_WILDCARD']                       = 'zástupný znak';
$SEARCH['OP_TYPOS']                          = 'překlepy';
$SEARCH['OP_PHRASE']                         = 'fráze';
$SEARCH['OP_OR']                             = 'nebo';
$SEARCH['EXAMPLE_WORD']                      = 'hořčice';
$SEARCH['EXAMPLE_WORD2']                     = 'bio';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'pálivá';
$SEARCH['EXAMPLE_OR']                        = 'kečup';
$SEARCH['EXAMPLE_PHRASE']                    = 'žlutá hořčice';
$SEARCH['EXAMPLE_PHRASE2']                   = 'z kukuřice';
$SEARCH['LABEL_LEGEND']                      = 'Legenda';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Výraz nalezen v obsahu stránky';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Výraz nalezen v klíčových slovech stránky';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Výraz nalezen v popisu stránky';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Výraz nalezen v titulku';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Výraz v obsahu a klíčových slovech';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Výraz v obsahu a popisu';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Výraz v klíčových slovech a popisu';
$SEARCH['LEGEND_HIT_ALL']                    = 'Výraz ve všech třech polích';
$SEARCH['PAGE_PREV']                         = 'Předchozí stránka';
$SEARCH['PAGE_NEXT']                         = 'Další stránka';
$SEARCH['DROPLET_DESCRIPTION']               = 'Oblak nejhledanějších výrazů. Parametry: max=20, min_count=1, desc=Popisek, active=true (false = skryto)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Přehled';
$SEARCH['MENU_MODULES']                      = 'Moduly';
$SEARCH['MENU_LAYOUT']                       = 'Rozvržení';
$SEARCH['MENU_SETTINGS']                     = 'Nastavení';
$SEARCH['MENU_STATS']                        = 'Statistiky';
$SEARCH['CRUMB_OVERVIEW']                    = 'Stav a údržba vyhledávacího indexu';
$SEARCH['CRUMB_MODULES']                     = 'Které moduly plní vyhledávací index';
$SEARCH['CRUMB_LAYOUT']                      = 'Šablona stránky s výsledky';
$SEARCH['CRUMB_SETTINGS']                    = 'Chování vyhledávání, živé vyhledávání, oblak štítků';
$SEARCH['CRUMB_STATS']                       = 'Co návštěvníci hledají';
$SEARCH['LEDE_OVERVIEW']                     = 'Aktuální stav vyhledávacího indexu a vyhledávání na webu.';
$SEARCH['LEDE_MODULES']                      = 'Jak se indexuje každý nainstalovaný modul. Moduly bez definice přispívají jen titulkem své stránky.';
$SEARCH['LEDE_LAYOUT']                       = 'Jaké rozvržení a jaký styl používá stránka vyhledávání a oblak štítků. Dodávané soubory a soubory ze šablony zůstávají beze změny; vždy upravujete vlastní kopii.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Stránka s výsledky';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Rozvržení stránky /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Oblak štítků';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Rozvržení dropletu [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Styl';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Pro stránku s výsledky a oblak štítků';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'CSS z %1$s se zobrazí zde · „Upravit“ vytvoří %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Bez stylu';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'šablona si přináší všechny styly sama';
$SEARCH['LAYOUT_ACTIVE']                     = 'aktivní';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'vlastní soubor';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'ze šablony „%s“';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'dodávaný';
$SEARCH['LAYOUT_READONLY']                   = 'pouze ke čtení';
$SEARCH['LAYOUT_MODIFIED']                   = 'změněno %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'soubor šablony %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'dodávaný soubor %s';
$SEARCH['BTN_EDIT']                          = 'Upravit';
$SEARCH['BTN_DELETE']                        = 'Smazat';
$SEARCH['BTN_BACK']                          = 'Zpět';
$SEARCH['BTN_SAVE_BACK']                     = 'Uložit a zpět';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Bude vytvořen nový soubor %1\$s jako kopie %2\$s.\n\nKopie se upraví a stane se aktivním rozvržením; originál zůstane beze změny.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s již existuje. Přepsat jej obsahem %2\$s a upravit?\n\nVaše aktuální verze %1\$s bude ztracena.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Smazat %s?\n\nTuto akci nelze vrátit.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Aktivní rozvržení: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s vytvořen';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s smazán';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Styl: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Hodnocení, úryvky, živé vyhledávání a oblak štítků.';
$SEARCH['LEDE_STATS']                        = 'Hledané výrazy zaznamenané pro oblak štítků (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Vyhledávací index';
$SEARCH['INDEX_BUILD']                       = 'Úplné přestavění';
$SEARCH['INDEX_UPDATE']                      = 'Aktualizovat změny';
$SEARCH['INDEX_CLEAR']                       = 'Vyprázdnit index';
$SEARCH['ENTRIES']                           = 'Záznamy';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Index vytvořen — není co indexovat.',
    'one' => 'Index vytvořen: %d záznam.',
    'few' => 'Index vytvořen: %d záznamy.',
    'many' => 'Index vytvořen: %d záznamů.',
    'other' => 'Index vytvořen: %d záznamů.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Není co aktualizovat.',
    'one' => 'Aktualizován %d záznam.',
    'few' => 'Aktualizovány %d záznamy.',
    'many' => 'Aktualizováno %d záznamů.',
    'other' => 'Aktualizováno %d záznamů.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Index smazán.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Opravdu smazat celý index?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Vyhledávání na webu';
$SEARCH['LABEL_LAST_INDEXED']                = 'Naposledy indexováno';
$SEARCH['INDEX_BUILD_DESC']                  = 'Znovu načte <b>všechny</b> prohledávatelné sekce. Na velkých webech to chvíli trvá.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Načte jen změněné nebo chybějící sekce. Rychlejší než úplné přestavění.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Načte jen změněné nebo chybějící sekce. Momentálně není co dělat.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Vyprázdní index. Vyhledávání nic nenajde, dokud nebude znovu vytvořen.';
$SEARCH['LABEL_FRESHNESS']                   = 'Aktuálnost';
$SEARCH['FRESH_ALL']                         = '<b>Index je aktuální</b> — všech %d sekcí odpovídá své poslední změně.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d z %2$d</b> sekcí bylo změněno nebo chybí.';
$SEARCH['FRESH_NONE']                        = 'Zatím žádné prohledávatelné sekce.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Vyhledávání na webu';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Nastavení › Vyhledávání';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Veřejné';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Registrovaní';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Soukromé';
$SEARCH['SITE_SEARCH_NONE']                  = 'Vypnuto';
$SEARCH['HINT_SITE_SEARCH']                  = 'Kdo smí vyhledávat — pro každé vyhledávací pole na webu, ať je za ním jakékoli vyhledávání. Stejné nastavení jako v <a href="%s">Nastavení › Vyhledávání</a>; „Registrovaní“ i „Soukromé“ znamenají: jen přihlášení návštěvníci.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Nastavit vyhledávání na webu na „%s“?\n\nTím se změní nastavení webu „Vyhledávání“ pro všechny návštěvníky.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Vyhledávání na webu: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Jazyky';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Žádné informace o jazyce';
$SEARCH['VIS_HIDDEN']                        = 'Skryté';
$SEARCH['VIS_PUBLIC']                        = 'Veřejné';
$SEARCH['VIS_PRIVATE']                       = 'Soukromé';
$SEARCH['VIS_REGISTERED']                    = 'Registrovaní';
$SEARCH['VIS_NONE']                          = 'Žádné';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Rozvržení je prázdné a nebylo uloženo.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Soubor search_custom.htt nelze zapsat. Zkontrolujte oprávnění k zápisu do složky layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Při zaškrtnutém „AjaxSave“ ukládá Uložit a Ctrl+S bez opětovného načtení stránky; „Uložit a zpět“ je pak skryto.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Minimální délka slova';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Kratší slova se ignorují';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Váha titulku';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Shody v titulku × koeficient';
$SEARCH['SET_MAX_EXCERPT']                   = 'Max. délka úryvku';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Znaků na úryvek';
$SEARCH['SET_HIGHLIGHT']                     = 'Zvýraznění';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Zvýraznit hledané výrazy v úryvku';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Značka zvýraznění';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'HTML značka použitá pro zvýraznění';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Výsledků na stránku';
$SEARCH['SET_AUTO_REINDEX']                  = 'Automatická reindexace při hledání';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Při každém hledání tiše aktualizuje zastaralé záznamy';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Zobrazit oblak štítků';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Na stránce vyhledávání. Droplet má vlastní parametr active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Zaznamenávat hledání';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Zaznamenává hledání pro oblak štítků a statistiky — vypnutí oblak neskryje';
$SEARCH['SET_AJAX_SUGGEST']                  = 'Živé vyhledávání AJAX';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Zobrazovat návrhy během psaní';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Režim ladění';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Zobrazit technická data pod každým výsledkem (jen administrátoři)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Šablona stránky vyhledávání';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Šablona webu, ve které se zobrazuje stránka /search/.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Výchozí šablona webu (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Vyhledávání';
$SEARCH['GROUP_DISPLAY']                     = 'Zobrazení výsledků';
$SEARCH['GROUP_INDEX']                       = 'Údržba indexu';
$SEARCH['GROUP_LIVE']                        = 'Živé vyhledávání';
$SEARCH['GROUP_TAGCLOUD']                    = 'Oblak štítků';
$SEARCH['GROUP_ADMIN']                       = 'Nástroj správy';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Velikost stránky seznamu výsledků';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Jazykový filtr';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Zobrazit jen stránky v jazyce návštěvníka (výchozí jazyk webu: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Pokročilé vyhledávání';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Zobrazit ve formuláři zaškrtávací pole rozsahu a volbu NEBO';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Max. sekcí na hledání';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Limit automatické reindexace (řízení zátěže)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Zdroj návrhů';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Hybridní režim nejprve vypíše shody v titulcích a doplní stránkami, které slovo obsahují v textu';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Max. návrhů';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Počet zobrazených návrhů';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Obrázky v návrzích';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Zobrazí obrázek položky (katalog, novinky …) vedle návrhu, pokud jej modul indexuje';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Max. štítků';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Počet výrazů v oblaku štítků';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min. hledání';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Minimální počet hledání, než se výraz zobrazí';
$SEARCH['SET_NAV_STYLE']                     = 'Navigace';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Záložky nahoře nebo lišta ikon vlevo';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Nejprve titulky, doplněné z plného textu (doporučeno)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Titulek + popis (rychlé)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Fulltextový index (důkladné)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Záložky nahoře';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Boční panel vlevo';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Koncový bod';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Na stránce vyhledávání se rozpozná automaticky u polí s názvem „string“, type="search" nebo třídou ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Nastavení uloženo.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Statistiky vyhledávání smazány.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Opravdu smazat všechny statistiky?';
$SEARCH['STATS_DELETE']                      = 'Smazat statistiky';
$SEARCH['STATS_TERM']                        = 'Hledaný výraz';
$SEARCH['STATS_COUNT']                       = 'Počet';
$SEARCH['STATS_LAST']                        = 'Naposledy hledáno';
$SEARCH['STATS_TERMS']                       = 'Výrazy';
$SEARCH['STATS_SEARCHES']                    = 'Hledání';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 z %d výrazu.',
    'few' => 'Top 100 z %d výrazů.',
    'many' => 'Top 100 z %d výrazů.',
    'other' => 'Top 100 z %d výrazů.',
];
$SEARCH['STATS_EMPTY']                       = 'Zatím nebyly zaznamenány žádné hledané výrazy.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Hledáno, nic nenalezeno';
$SEARCH['HINT_STATS_MISSES']                 = 'Celá hledání bez výsledku — vodítko k obsahu, který návštěvníci očekávají, ale nenacházejí. Nikdy se nezobrazuje veřejně.';
$SEARCH['STATS_QUERY']                       = 'Dotaz';
$SEARCH['STATS_MISSES_EMPTY']                = 'Nezaznamenána žádná hledání bez výsledku.';
$SEARCH['CARD_WORDS']                        = 'Index slov';
$SEARCH['HINT_WORDS']                        = 'Pro velké weby: seznam všech slov, aby vyhledávání nemuselo číst celý index. Vytváří se automaticky od %s záznamů indexu.';
$SEARCH['WORDS_INACTIVE']                    = 'Neaktivní — web je pod prahem (%2$s záznamů indexu, nyní %1$s); běžné vyhledávání je dost rychlé.';
$SEARCH['WORDS_OFF']                         = 'Vypnuto v nastavení.';
$SEARCH['WORDS_BUILDING']                    = 'Vytváří se';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Pokračovat ve vytváření';
$SEARCH['MSG_WORDS_READY']                   = 'Index slov je hotový.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Index slov: zbývá %d záznam — do té doby se používá běžné vyhledávání.',
    'few' => 'Index slov: zbývají %d záznamy — do té doby se používá běžné vyhledávání.',
    'many' => 'Index slov: zbývá %d záznamů — do té doby se používá běžné vyhledávání.',
    'other' => 'Index slov: zbývá %d záznamů — do té doby se používá běžné vyhledávání.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'Používá se — %d záznam slov.',
    'few' => 'Používá se — %d záznamy slov.',
    'many' => 'Používá se — %d záznamů slov.',
    'other' => 'Používá se — %d záznamů slov.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Index slov';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automaticky: vytvoří se jen tehdy, když web dosáhne níže uvedeného prahu. Malé weby jej nepotřebují.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automaticky';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Vždy zapnuto';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Vypnuto';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Index slov od';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Počet indexovaných záznamů (sekce a položky modulů), od kterého se index slov vytváří automaticky';
$SEARCH['BTN_DELETE_TERM']                   = 'Odebrat tento výraz';
$SEARCH['MSG_TERM_DELETED']                  = 'Výraz odebrán.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Polokonfigurace pro <b>%s</b> předvyplněna ze search.php — zkontrolujte a upravte.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Polokonfigurace pro \'%s\' uložena.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Konfigurace a záznamy indexu pro %s smazány.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php vytvořen. Přestavte prosím index.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Smazat konfiguraci a záznamy indexu pro %s?';
$SEARCH['STATUS_SEMI']                       = 'Polokonfigurace';
$SEARCH['LABEL_GUIDE']                       = 'Zobrazit návod k tomuto modulu';
$SEARCH['LABEL_TABLE_HINT']                  = 'Vyberte tabulku → sloupce se načtou automaticky';
$SEARCH['LABEL_TABLE_SELECT']                = 'Vyberte tabulku';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'Kotva stránky WBCE';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Pouze prohledávatelné stránky';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Všechny sekce (zásobník obsahu)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Pouze aktivní záznamy (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Časové řízení (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joiny (volitelné, max. 3) — data z dalších tabulek';
$SEARCH['LABEL_GENERATE_DEF']                = 'Vytvořit soubor module_defs';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Ze search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Smazat konfiguraci';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Žádné textové sloupce';
$SEARCH['LABEL_ERROR']                       = 'Chyba';
$SEARCH['LABEL_MODULE']                      = 'Modul';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Neprohledávatelné';
$SEARCH['LABEL_HELP']                        = 'Nápověda';
$SEARCH['BTN_CONFIGURE']                     = 'Konfigurovat';
$SEARCH['BTN_CLOSE']                         = 'Zavřít';
$SEARCH['DEF_GENERATED']                     = 'vytvořeno';
$SEARCH['DEF_SHIPPED']                       = 'vestavěno';
$SEARCH['LABEL_KIND']                        = 'Typ';
$SEARCH['LABEL_INDEXING']                    = 'Indexování';
$SEARCH['LABEL_SECTIONS']                    = 'Sekce';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtrovat …';
$SEARCH['MODULES_SHOWN']                     = 'Zobrazeno %1$d z %2$d modulů';
$SEARCH['KIND_PAGE']                         = 'Moduly stránek';
$SEARCH['KIND_SNIPPET']                      = 'Snippety';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtry';
$SEARCH['KIND_TOOL']                         = 'Nástroje správy';
$SEARCH['BADGE_PAGE']                        = 'Stránka';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filtr';
$SEARCH['BADGE_TOOL']                        = 'Nástroj';
$SEARCH['GROUP_DEF']                         = 's definicí';
$SEARCH['GROUP_OPEN']                        = 'neúplné';
$SEARCH['GROUP_TITLE']                       = 'jen titulek stránky';
$SEARCH['SOURCE_MODULE']                     = 'Z modulu';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Vestavěno';
$SEARCH['SOURCE_GENERATED']                  = 'Polokonfigurace';
$SEARCH['SOURCE_SEMI']                       = 'Polokonfigurace – nevytvořeno';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'Nalezen search.php';
$SEARCH['SOURCE_TITLE']                      = 'Jen titulek stránky';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Modul přináší vlastní definici vyhledávání (search_index.php) — zde ji nelze upravit.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indexováno pomocí PHP callbacku — zde nelze upravit.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definice dodávaná s WBCE Search (module_defs/). Polokonfigurace má přednost.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definice vytvořená z polokonfigurace.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Polokonfigurace uložena, ale definice zatím nebyla vytvořena.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Zatím bez definice — lze předvyplnit ze starého search.php modulu.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Bez definice — index obsahuje jen titulek stránky.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Žádné sekce stránek — není co indexovat.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Vyhledávání je pro tuto stránku vypnuto';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Vestavěná definice. Uložením vznikne polokonfigurace, která má přednost.';
$SEARCH['LABEL_TABLE']                       = 'Tabulka';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tabulky tohoto modulu';
$SEARCH['LABEL_OTHER_TABLES']                = 'Další tabulky modulů';
$SEARCH['HINT_TABLE']                        = 'Indexovat lze jen tabulky mod_* se sloupcem section_id.';
$SEARCH['LABEL_ID_FIELD']                    = 'Sloupec ID';
$SEARCH['LABEL_ITEM_KEY']                    = 'Klíč položky';
$SEARCH['HINT_ITEM_KEY']                     = 'Jedinečný klíč pro každou položku (režim více).';
$SEARCH['LABEL_TITLE_COL']                   = 'Sloupec titulku';
$SEARCH['LABEL_TEXT_COLS']                   = 'Textové sloupce';
$SEARCH['LABEL_LINK_COL']                    = 'Sloupec odkazu';
$SEARCH['HINT_LINK_PREFIX']                  = 'Volitelná předpona: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Sloupec obrázku';
$SEARCH['HINT_IMAGE_PATH']                   = 'Cesta pod /media, zástupné symboly jako {item_id} jsou povoleny.';
$SEARCH['LABEL_NONE']                        = 'žádný';
$SEARCH['LABEL_MODE']                        = 'Režim';
$SEARCH['MODE_SINGLE']                       = 'Jeden — jeden záznam na sekci';
$SEARCH['MODE_MULTI']                        = 'Více — jeden záznam na položku';
$SEARCH['LABEL_INDEX_BASE']                  = 'Základ indexu';
$SEARCH['LABEL_FILTER']                      = 'Filtr';
$SEARCH['LABEL_NO_JOIN']                     = 'bez joinu';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Vyberte prosím platnou tabulku modulu.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'V search.php modulu %s nebyla nalezena použitelná tabulka.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Žádné stránky',
    'one' => '%d stránka',
    'few' => '%d stránky',
    'many' => '%d stránek',
    'other' => '%d stránek',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Uložit';
$SEARCH['MSG_SECURITY_ERROR']                = 'Bezpečnostní kontrola selhala.';
$SEARCH['STATUS_ACTIVE']                     = 'Aktivní';
$SEARCH['STATUS_INACTIVE']                   = 'Neaktivní';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'a','aby','ale','ani','ano','asi','až','bez','by','byl','byla','byli','bylo',
    'být','co','či','do','ho','i','já','jak','jako','je','jeho','její','jejich',
    'jen','ještě','ji','jsem','jsi','jsme','jsou','jste','k','kam','kde','kdo',
    'kdy','když','ke','která','které','který','kteří','mezi','mi','mít','mně',
    'mnou','my','na','nad','nám','nás','ne','nebo','něco','není','nic','o','od',
    'on','ona','oni','ono','pak','po','pod','podle','pokud','pouze','pro','proč',
    'proto','protože','před','při','s','se','si','sice','tak','také','takže','tam',
    'te','tedy','ten','to','tohle','toho','tom','tomto','tu','tuto','ty','tyto','u',
    'už','v','vám','vás','ve','však','všechno','vy','z','za','ze','že',
];
