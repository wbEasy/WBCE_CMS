<?php
/**
 * wbce_search — WbceSearchWords
 *
 * Word index ("Stichwortverzeichnis") for large sites: every word of every
 * index entry, one row per (word, entry, field). The normal search reads the
 * whole {TP_SEARCH}index into PHP and checks each row — fine for a
 * few hundred entries, but memory grows linearly (≈10 MB per 1 000 entries)
 * and the request dies at roughly 13 000 entries with a 128 MB limit. With
 * the word index the database answers "which entries contain X" through an
 * index lookup and PHP only loads the text of the hits actually displayed.
 *
 * It is only built when it pays off: setting word_index = auto (default)
 * activates it from word_index_threshold searchable entries on; small sites
 * never get the extra table rows or the slower indexing.
 *
 * Consistency: the search only uses the word index when no searchable entry
 * is waiting to be tokenised (column `tokenized` = 0). Until the backlog is
 * worked off (backfill() — admin rebuild/update, a few per visitor search)
 * the normal search runs, so results are never incomplete.
 *
 * Portability (MySQL/MariaDB + SQLite): no FULLTEXT/FTS, prefix search as a
 * range (word >= 'abc' AND word < 'abc' + U+10FFFF) so it uses the primary
 * key on both drivers. The word column is utf8mb4_bin on MySQL — with the
 * default _ci collation "o" and "ö" collide in the primary key; SQLite
 * compares bytes anyway (importSql() strips the COLLATE clause).
 *
 * @license GNU General Public License
 */

declare(strict_types=1);

defined('WB_PATH') or die();

class WbceSearchWords
{
    /** Field codes stored in the `field` column. */
    public const FIELDS = ['content' => 0, 'title' => 1, 'item_title' => 2, 'keywords' => 3, 'description' => 4];

    /** Longest word stored (column width); longer tokens are cut, not dropped. */
    public const MAX_LEN = 64;

    /** Upper bound for prefix ranges — sorts after every real character. */
    public const RANGE_END = "\u{10FFFF}";

    /** Rows per multi-row INSERT — 4 params each, stays below SQLite's old 999-variable limit. */
    private const BATCH = 200;

    private static ?bool $active = null;
    private static ?bool $available = null;

    /**
     * Words of a text, lower-cased, with their count. Word characters are the
     * same as WbceSearch::containsWord() treats as word characters (letters,
     * marks, digits, underscore). Stop words are skipped — the search drops
     * them from every query anyway (WbceSearch::filterWords()).
     *
     * @return array<string,int>
     */
    public static function tokenize(string $text, array $stopwords): array
    {
        $tokens = self::split($text);
        $out = [];
        foreach ($tokens as $t) {
            if (isset($stopwords[$t])) continue;
            if (mb_strlen($t) > self::MAX_LEN) $t = mb_substr($t, 0, self::MAX_LEN);
            $out[$t] = ($out[$t] ?? 0) + 1;
        }
        return $out;
    }

    /**
     * Lower case for display and storage. mb_strtolower() follows the general
     * Unicode rules, not the Turkish ones: the capital İ becomes "i" plus a
     * combining dot (U+0307) — a different word than "i" for every compare.
     * The dot is dropped here, so "İstanbul" → "istanbul".
     */
    public static function lower(string $text): string
    {
        return str_replace("i\u{0307}", 'i', mb_strtolower($text, 'UTF-8'));
    }

    /**
     * Lower case for matching only (index words, query terms, stop words):
     * lower() plus the dotless ı folded to i. Turkish capitals lose the
     * difference (IRMAK → irmak, but the word is "ırmak"), so the search
     * treats i and ı as the same letter — a few extra hits (kır/kir) instead
     * of missing every capitalised word. Never shown to visitors.
     */
    public static function fold(string $text): string
    {
        return str_replace('ı', 'i', self::lower($text));
    }

    /**
     * preg_quote() of a term for an /iu pattern, with every i-letter matching
     * all four Turkish forms — /iu alone does not pair İ with i nor I with ı.
     */
    public static function regex(string $term, string $delimiter = '/'): string
    {
        return strtr(preg_quote($term, $delimiter), ['i' => '[iIıİ]', 'I' => '[iIıİ]', 'ı' => '[iIıİ]', 'İ' => '[iIıİ]']);
    }

    /**
     * Case-insensitive mb_stripos() that also pairs the Turkish i-letters.
     * Returns the character position in $haystack itself (not in a lowered
     * copy, whose length can differ), or false.
     */
    public static function ipos(string $haystack, string $needle): int|false
    {
        if ($needle === '' || !preg_match('/' . self::regex($needle) . '/iu', $haystack, $m, PREG_OFFSET_CAPTURE)) {
            return false;
        }
        return mb_strlen(substr($haystack, 0, $m[0][1]), 'UTF-8');
    }

    /**
     * LIKE pattern body for a term: wildcards escaped ('!' as ESCAPE char) and
     * every i-letter replaced by '_' (any one character). MySQL's
     * utf8mb4_unicode_ci treats ı and i as different letters and SQLite does
     * not pair İ with i, so a literal i would let the database drop rows the
     * PHP checks would keep. '_' only lets more rows through, never fewer.
     */
    public static function likeBody(string $term): string
    {
        $esc = str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $term);
        return str_replace(['i', 'I', 'ı', 'İ'], '_', $esc);
    }

    /** Folded word list of a text or a search term ("e-mail" → e, mail). */
    public static function split(string $text): array
    {
        $text = self::fold($text);
        $parts = preg_split('/[^\p{L}\p{M}\p{N}_]+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        if ($parts === false) {
            // Invalid UTF-8 makes preg_* with /u return false — clean it and retry
            // instead of silently indexing nothing for this entry.
            $text  = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
            $parts = preg_split('/[^\p{L}\p{M}\p{N}_]+/u', $text, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        }
        return $parts;
    }

    // ── State ─────────────────────────────────────────────────────────────

    /**
     * Table present — false between copying new module files and running the
     * module upgrade, so nothing here may break a search in that window.
     */
    public static function available($db): bool
    {
        return self::$available ??= $db->tableExists('{TP_SEARCH}words');
    }

    /** word_index = on | off | auto (auto: from word_index_threshold searchable entries). */
    public static function isActive($db): bool
    {
        if (self::$active !== null) return self::$active;
        if (!self::available($db)) return self::$active = false;
        $mode = WbceSearchSettings::get('word_index');
        if ($mode === 'on')  return self::$active = true;
        if ($mode === 'off') return self::$active = false;
        $n = (int) $db->fetchValue("SELECT COUNT(*) FROM `{TP_SEARCH}index` WHERE `searching` = 1");
        return self::$active = $n >= (int) WbceSearchSettings::get('word_index_threshold');
    }

    /** Forget the cached state (after settings change or within tests). */
    public static function reset(): void
    {
        self::$active = self::$available = null;
    }

    /** Searchable entries not yet in the word index. */
    public static function backlog($db): int
    {
        return (int) $db->fetchValue(
            "SELECT COUNT(*) FROM `{TP_SEARCH}index` WHERE `searching` = 1 AND `tokenized` = 0"
        );
    }

    /** Active and complete — only then may the search rely on it. */
    public static function usable($db): bool
    {
        return self::isActive($db) && self::backlog($db) === 0;
    }

    // ── Writing ───────────────────────────────────────────────────────────

    /**
     * Tokenises the given entries (or the next untokenised ones) and marks
     * them tokenized = 1. Stops after $limit entries or $seconds.
     *
     * @return int entries processed
     */
    public static function backfill($db, int $limit = 500, float $seconds = 20.0, ?int $sectionId = null): int
    {
        $stop  = array_flip(WbceSearchStopwords::forSite($db));
        $start = microtime(true);
        $done  = 0;

        while ($done < $limit && (microtime(true) - $start) < $seconds) {
            $chunk = min(100, $limit - $done);
            $sql = "SELECT `id`, `title`, `item_title`, `keywords`, `description`, `content`
                    FROM `{TP_SEARCH}index`
                    WHERE `tokenized` = 0 AND `searching` = 1";
            $params = [];
            if ($sectionId !== null) { $sql .= " AND `section_id` = ?"; $params[] = $sectionId; }
            $rows = $db->fetchAll($sql . " ORDER BY `id` LIMIT " . $chunk, $params);
            if (!$rows) break;

            $ids  = array_map(fn ($r) => (int) $r['id'], $rows);
            $ph   = implode(',', array_fill(0, count($ids), '?'));
            // An entry may have been tokenised before (re-run after an error) — start clean.
            self::write($db, "DELETE FROM `{TP_SEARCH}words` WHERE `entry_id` IN ($ph)", $ids);

            $batch = [];
            foreach ($rows as $r) {
                foreach (self::FIELDS as $col => $code) {
                    foreach (self::tokenize((string) ($r[$col] ?? ''), $stop) as $word => $hits) {
                        $batch[] = [$word, (int) $r['id'], $code, min($hits, 32767)];
                        if (count($batch) >= self::BATCH) { self::insert($db, $batch); $batch = []; }
                    }
                }
            }
            self::insert($db, $batch);
            self::write($db, "UPDATE `{TP_SEARCH}index` SET `tokenized` = 1 WHERE `id` IN ($ph)", $ids);
            $done += count($rows);
        }
        return $done;
    }

    private static function insert($db, array $batch): void
    {
        if (!$batch) return;
        $ph = implode(',', array_fill(0, count($batch), '(?,?,?,?)'));
        self::write(
            $db,
            "INSERT INTO `{TP_SEARCH}words` (`word`, `entry_id`, `field`, `hits`) VALUES $ph",
            array_merge(...$batch)
        );
    }

    /**
     * Every write goes through here: the error state is reset by the next
     * query, so a failed batch in the middle of a run was invisible when
     * only the last statement was checked. Throws instead — the callers
     * (admin ops, lazy reindex) catch and report.
     */
    private static function write($db, string $sql, array $params = []): void
    {
        $db->query($sql, $params);
        if ($db->hasError()) {
            throw new RuntimeException('wbce_search word index: ' . $db->getError());
        }
    }

    /** Removes word rows whose entry no longer exists (re-indexed sections get new ids). */
    public static function pruneOrphans($db): void
    {
        self::write(
            $db,
            "DELETE FROM `{TP_SEARCH}words`
             WHERE `entry_id` NOT IN (SELECT `id` FROM `{TP_SEARCH}index`)"
        );
    }

    /** Word rows of the entries of one section — called before those entries are deleted. */
    public static function deleteSection($db, int $sectionId): void
    {
        self::write(
            $db,
            "DELETE FROM `{TP_SEARCH}words` WHERE `entry_id` IN
             (SELECT `id` FROM `{TP_SEARCH}index` WHERE `section_id` = ?)",
            [$sectionId]
        );
    }

    public static function clear($db): void
    {
        self::write($db, "DELETE FROM `{TP_SEARCH}words`");
        self::write($db, "UPDATE `{TP_SEARCH}index` SET `tokenized` = 0");
    }

    // ── Reading ───────────────────────────────────────────────────────────

    /**
     * SQL condition "entry i contains this search term" for the given field
     * codes, plus its params. A term may split into several words ("e-mail"):
     * all must be present. $prefix: the last word is a prefix (senf*).
     * Returns null when the term has no word characters at all.
     *
     * @return array{0:string,1:array}|null
     */
    public static function termCondition(string $term, array $fieldCodes, bool $prefix = false): ?array
    {
        $words = self::split($term);
        if (!$words) return null;
        $fields = implode(',', array_map('intval', $fieldCodes));
        $sql = []; $params = [];
        $last = count($words) - 1;
        foreach ($words as $k => $w) {
            $w = mb_substr($w, 0, self::MAX_LEN);
            if ($prefix && $k === $last) {
                $sql[] = "i.`id` IN (SELECT `entry_id` FROM `{TP_SEARCH}words`
                          WHERE `word` >= ? AND `word` < ? AND `field` IN ($fields))";
                array_push($params, $w, $w . self::RANGE_END);
            } else {
                $sql[] = "i.`id` IN (SELECT `entry_id` FROM `{TP_SEARCH}words`
                          WHERE `word` = ? AND `field` IN ($fields))";
                $params[] = $w;
            }
        }
        return ['(' . implode(' AND ', $sql) . ')', $params];
    }

    /**
     * Word rows matching any of the given terms, restricted to the entries
     * selected by $entrySql — used to score hits and to tell in which field
     * (content, keywords, description …) a term was found.
     *
     * @param array<int,array{0:string,1:bool}> $terms [term, isPrefix]
     * @return array<int,array<int,array<int,true>>> entry_id → term# → field codes
     */
    public static function hitsFor($db, array $terms, string $entrySql, array $entryParams): array
    {
        $or = []; $params = []; $map = [];
        foreach ($terms as $n => [$term, $prefix]) {
            $words = self::split($term);
            if (!$words) continue;
            $last = count($words) - 1;
            foreach ($words as $k => $w) {
                $w = mb_substr($w, 0, self::MAX_LEN);
                if ($prefix && $k === $last) {
                    $or[] = "(w.`word` >= ? AND w.`word` < ?)";
                    array_push($params, $w, $w . self::RANGE_END);
                    $map[] = [$n, $w, true];
                } else {
                    $or[] = "w.`word` = ?";
                    $params[] = $w;
                    $map[] = [$n, $w, false];
                }
            }
        }
        if (!$or) return [];

        $rows = $db->fetchAll(
            "SELECT w.`entry_id`, w.`word`, w.`field` FROM `{TP_SEARCH}words` w
             WHERE (" . implode(' OR ', $or) . ") AND w.`entry_id` IN ($entrySql)",
            array_merge($params, $entryParams)
        );

        $out = [];
        foreach ($rows as $r) {
            foreach ($map as [$n, $w, $isPrefix]) {
                if ($isPrefix ? str_starts_with($r['word'], $w) : $r['word'] === $w) {
                    $out[(int) $r['entry_id']][$n][(int) $r['field']] = true;
                }
            }
        }
        return $out;
    }
}
