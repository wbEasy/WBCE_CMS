<?php
/**
 * wbce_search - WbceSearchStopwords.php
 * Stop words: never searched, never put into the word index.
 *
 * Each language file brings its own list ($SEARCH['STOPWORDS']). The site
 * uses the lists of the languages its searchable pages are written in —
 * not the visitor's or the admin's language. Index and search must use the
 * SAME list: a word left out of the word index but searched for would find
 * nothing. So the set is a property of the site, stored as state
 * 'stopword_languages' ("DE" / "DE,EN") and refreshed by every indexer run;
 * when it changes, the word index is re-tokenised (WbceSearchIndexer).
 *
 * @module    wbce_search
 * @author    Peter Kitzinger (Slugger)
 * @author    Christian M. Stefan (https://www.wbEasy.de)
 * @copyright WBCE Project (2026-)
 * @license   GNU General Public License
 * @platform  WBCE 1.7.0+
 *
 * Developed with AI assistance (Claude).
 */

declare(strict_types=1);

defined('WB_PATH') or die('No direct access');

final class WbceSearchStopwords
{
    public const CFG_KEY = 'stopword_languages';

    private const LANG_DIR = WB_PATH . '/modules/wbce_search/languages/';

    /** @var array<string, list<string>> per language list ("DE,EN"), per request */
    private static array $cache = [];

    /**
     * The site's stop words: the languages stored by the last indexer run,
     * or — never indexed yet — the page languages read directly.
     *
     * @return list<string>
     */
    public static function forSite(object $db): array
    {
        $stored = (string) WbceSearchSettings::state(self::CFG_KEY);
        return self::forLanguages($stored !== '' ? explode(',', $stored) : self::siteLanguages($db));
    }

    /**
     * Union of the lists of these languages — lower case, each word once.
     * A language without a module language file has no stop words.
     *
     * @param  list<string> $languages e.g. ['DE', 'EN']
     * @return list<string>
     */
    public static function forLanguages(array $languages): array
    {
        $languages = self::normalise($languages);
        $key       = implode(',', $languages);
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $words = [];
        foreach ($languages as $lang) {
            foreach (self::fromFile(self::LANG_DIR . $lang . '.php') as $w) {
                $words[WbceSearchWords::fold(trim((string) $w))] = true;
            }
        }
        unset($words['']);
        return self::$cache[$key] = array_keys($words);
    }

    /**
     * Languages of the pages that get indexed (same conditions as the
     * indexer), sorted — e.g. ['DE'] or ['DE', 'EN'].
     *
     * @return list<string>
     */
    public static function siteLanguages(object $db): array
    {
        $rows = $db->fetchAll(
            "SELECT DISTINCT p.`language`
             FROM `{TP}pages` p
             WHERE p.`visibility` NOT IN ('none','deleted') AND p.`searching` = '1'"
        );
        return self::normalise(array_column($rows, 'language'));
    }

    /** Forget the per-request cache (after the language set changed). */
    public static function reset(): void
    {
        self::$cache = [];
    }

    /** @return list<string> unique two-letter codes, upper case, sorted */
    private static function normalise(array $languages): array
    {
        $out = [];
        foreach ($languages as $l) {
            $l = strtoupper(trim((string) $l));
            if (preg_match('/^[A-Z]{2}$/', $l)) {
                $out[$l] = true;
            }
        }
        $out = array_keys($out);
        sort($out);
        return $out;
    }

    /** $SEARCH['STOPWORDS'] of one language file, read in a scope of its own. */
    private static function fromFile(string $file): array
    {
        if (!is_file($file)) {
            return [];
        }
        return (static function (string $__file): array {
            $SEARCH = [];
            include $__file;
            return is_array($SEARCH['STOPWORDS'] ?? null) ? $SEARCH['STOPWORDS'] : [];
        })($file);
    }
}
