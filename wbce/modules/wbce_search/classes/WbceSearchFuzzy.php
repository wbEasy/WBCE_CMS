<?php
/**
 * wbce_search — WbceSearchFuzzy
 *
 * Typo tolerance: the ~ operator ("senf~" also finds "senft", "semf") and the
 * "Did you mean …?" suggestion when a search finds nothing. Both compare the
 * search word against the site's vocabulary by Levenshtein distance.
 *
 * Vocabulary: the words of PUBLIC searchable pages only (visibility public or
 * hidden) — a suggestion must never reveal a word that exists only on a
 * private or members-only page. Built from the word index when it is in use,
 * otherwise from the index text (small sites), and cached in
 * var/wbce_search/vocab.ser: rebuilt by the admin Rebuild/Update, on small
 * sites also when older than self::MAX_AGE. Large sites never build it inside
 * a visitor request (a full scan of the word table) — without a cache file
 * there the ~ operator matches exact words only and no suggestion appears.
 *
 * Distance per character, not per byte: PHP's levenshtein() counts bytes, so
 * "müller"/"muller" would be 2 instead of 1. Words are therefore stored with
 * every non-ASCII character mapped to one spare byte (map kept in the cache),
 * which keeps the fast C levenshtein(). Sites with more than 127 distinct
 * non-ASCII characters (e.g. Cyrillic) fall back to a PHP implementation.
 *
 * @license GNU General Public License
 */

declare(strict_types=1);

defined('WB_PATH') or die();

class WbceSearchFuzzy
{
    /** Seconds before a small site rebuilds the vocabulary on demand. */
    private const MAX_AGE = 3600;

    /** At most this many spelling variants per ~ term (closest, then most frequent). */
    private const MAX_VARIANTS = 20;

    private static ?array $cache = null;

    /**
     * Allowed typos by word length: short words would match almost anything
     * ("ton~" with distance 2: tor, rot, bon …).
     */
    public static function maxDistance(int $len): int
    {
        return $len <= 4 ? 0 : ($len <= 7 ? 1 : 2);
    }

    public static function cacheFile(): string
    {
        return WB_PATH . '/var/wbce_search/vocab.ser';
    }

    /** Drop the cached vocabulary — after the index changed in the admin tool. */
    public static function invalidate(): void
    {
        self::$cache = null;
        @unlink(self::cacheFile());
    }

    /**
     * Spelling variants of $term in the vocabulary, closest first:
     * [word => distance]. Always contains the term itself (distance 0), so a
     * ~ term never matches less than the plain term.
     */
    public static function variants($db, string $term): array
    {
        $term = WbceSearchWords::fold(trim($term));
        $out  = [$term => 0];
        $max  = self::maxDistance(mb_strlen($term));
        if ($max === 0) return $out;

        foreach (self::candidates($db, $term, $max) as [$word, $dist, $freq]) {
            $out[$word] = min($out[$word] ?? PHP_INT_MAX, $dist);
            if (count($out) > self::MAX_VARIANTS) break;
        }
        return $out;
    }

    /**
     * Best correction for a word that is NOT in the vocabulary, or null.
     * Allows one typo from 4 letters on, so "hasu" → "haus" still works.
     */
    public static function correct($db, string $word): ?string
    {
        $word = WbceSearchWords::fold(trim($word));
        $len  = mb_strlen($word);
        if ($len < 4) return null;
        $vocab = self::load($db);
        if ($vocab === null) return null;
        if (isset($vocab['words'][self::encode($word, $vocab['map'])])) return null;   // known word
        $max = max(1, self::maxDistance($len));
        foreach (self::candidates($db, $word, $max) as [$cand, $dist]) {
            if ($dist > 0) return $cand;
        }
        return null;
    }

    /**
     * Vocabulary words within $max typos of $word, sorted by distance, then
     * frequency (number of entries containing the word).
     *
     * @return list<array{0:string,1:int,2:int}> [word, distance, frequency]
     */
    private static function candidates($db, string $word, int $max): array
    {
        $vocab = self::load($db);
        if ($vocab === null) return [];
        $len   = mb_strlen($word);
        $enc   = self::encode($word, $vocab['map']);
        $mapOk = $vocab['map_ok'];

        $found = [];
        for ($l = max(1, $len - $max); $l <= $len + $max; $l++) {
            foreach ($vocab['by_len'][$l] ?? [] as $encWord) {
                $d = $mapOk ? levenshtein($enc, $encWord) : self::mbLevenshtein($word, $vocab['words'][$encWord][0]);
                if ($d <= $max) {
                    [$orig, $freq] = $vocab['words'][$encWord];
                    $found[] = [$orig, $d, $freq];
                }
            }
        }
        usort($found, fn ($a, $b) => [$a[1], -$a[2]] <=> [$b[1], -$b[2]]);
        return $found;
    }

    // ── Vocabulary cache ──────────────────────────────────────────────────

    /** Cached vocabulary, (re)built where allowed; null when not available. */
    private static function load($db): ?array
    {
        if (self::$cache !== null) return self::$cache;

        $large = WbceSearchWords::usable($db);
        $file  = self::cacheFile();
        $fresh = is_file($file) && ($large || filemtime($file) > time() - self::MAX_AGE);

        if ($fresh) {
            $data = @unserialize((string) file_get_contents($file), ['allowed_classes' => false]);
            if (is_array($data) && isset($data['words'])) return self::$cache = $data;
        }
        // Large sites: only the admin tool builds it (full word-table scan).
        if ($large) return null;
        return self::$cache = self::build($db);
    }

    /**
     * Collects word frequencies of public entries and writes the cache.
     * Called by the admin Rebuild/Update and, on small sites, on demand.
     */
    public static function build($db): array
    {
        $freq   = [];
        $public = "p.`visibility` IN ('public','hidden') AND p.`searching` = '1' AND i.`searching` = 1";

        if (WbceSearchWords::usable($db)) {
            $rows = $db->fetchAll(
                "SELECT w.`word`, COUNT(DISTINCT w.`entry_id`) AS f
                 FROM `{TP_SEARCH}words` w
                 INNER JOIN `{TP_SEARCH}index` i ON i.`id` = w.`entry_id`
                 INNER JOIN `{TP}pages` p ON p.`page_id` = i.`page_id`
                 WHERE $public
                 GROUP BY w.`word`"
            );
            foreach ($rows as $r) $freq[(string) $r['word']] = (int) $r['f'];
        } else {
            $stop = array_flip(WbceSearchStopwords::forSite($db));
            $rows = $db->fetchAll(
                "SELECT i.`title`, i.`item_title`, i.`keywords`, i.`description`, i.`content`
                 FROM `{TP_SEARCH}index` i
                 INNER JOIN `{TP}pages` p ON p.`page_id` = i.`page_id`
                 WHERE $public"
            );
            foreach ($rows as $r) {
                $seen = [];
                foreach ($r as $text) {
                    foreach (WbceSearchWords::tokenize((string) $text, $stop) as $w => $_) $seen[$w] = true;
                }
                foreach ($seen as $w => $_) $freq[$w] = ($freq[$w] ?? 0) + 1;
            }
        }

        // Spare-byte map for the non-ASCII characters of this site.
        $map = [];
        foreach (array_keys($freq) as $w) {
            foreach (preg_split('//u', (string) $w, -1, PREG_SPLIT_NO_EMPTY) as $ch) {
                if (strlen($ch) > 1 && !isset($map[$ch])) $map[$ch] = count($map);
            }
        }
        $mapOk = count($map) <= 127;
        $map   = $mapOk ? array_map(fn ($n) => chr(128 + $n), $map) : [];

        $data = ['map' => $map, 'map_ok' => $mapOk, 'words' => [], 'by_len' => [], 'built' => time()];
        foreach ($freq as $w => $f) {
            $w   = (string) $w;
            $enc = self::encode($w, $map);
            $data['words'][$enc] = [$w, $f];
            $data['by_len'][mb_strlen($w)][] = $enc;
        }

        $dir = dirname(self::cacheFile());
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
            @file_put_contents($dir . '/index.php', "<?php header('Location: ../../index.php'); exit;\n");
        }
        @file_put_contents(self::cacheFile(), serialize($data), LOCK_EX);
        return self::$cache = $data;
    }

    /** Word with every mapped multi-byte character replaced by its spare byte. */
    private static function encode(string $word, array $map): string
    {
        return $map ? strtr($word, $map) : $word;
    }

    /** Character-based Levenshtein for sites whose characters do not fit the byte map. */
    private static function mbLevenshtein(string $a, string $b): int
    {
        $a = preg_split('//u', $a, -1, PREG_SPLIT_NO_EMPTY);
        $b = preg_split('//u', $b, -1, PREG_SPLIT_NO_EMPTY);
        $prev = range(0, count($b));
        foreach ($a as $i => $ca) {
            $cur = [$i + 1];
            foreach ($b as $j => $cb) {
                $cur[] = min($prev[$j + 1] + 1, $cur[$j] + 1, $prev[$j] + ($ca === $cb ? 0 : 1));
            }
            $prev = $cur;
        }
        return $prev[count($b)];
    }
}
