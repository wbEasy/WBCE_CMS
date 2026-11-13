<?php
/**
 * wbce_search - WbceSearchStats.php
 * Search statistics ({TP_SEARCH}stats): the terms visitors search
 * for (count, the public tag cloud) and the queries that found nothing
 * (misses, the admin's "searched, nothing found" list).
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

final class WbceSearchStats
{
    public function __construct(private object $db) {}

    /**
     * Counts the search terms of a query. Each term once per session; stop
     * words, terms shorter than min_length and overlong junk are skipped —
     * the tag cloud is public.
     */
    public function trackSearch(array $words): void
    {
        if (!WbceSearchSettings::get('tagcloud_track')) return;

        $min       = (int) WbceSearchSettings::get('min_length');
        $stopwords = WbceSearchStopwords::forSite($this->db);
        if (!isset($_SESSION['ws_tracked'])) $_SESSION['ws_tracked'] = [];

        foreach ($words as $word) {
            // Stored as typed (lower case, ı kept) — the tag cloud shows it;
            // only the stop-word check uses the folded form.
            $term = WbceSearchWords::lower(trim($word));
            if (mb_strlen($term) < $min) continue;
            if (mb_strlen($term) > 50 || in_array(WbceSearchWords::fold($term), $stopwords, true)) continue;

            // Already counted in this session? → skip
            if (in_array($term, $_SESSION['ws_tracked'], true)) continue;
            $_SESSION['ws_tracked'][] = $term;

            // Portable increment-or-insert (ON DUPLICATE KEY is MySQL-only).
            $exists = (int) $this->db->fetchValue(
                "SELECT COUNT(*) FROM `{TP_SEARCH}stats` WHERE `term` = ?", [$term]
            );
            if ($exists) {
                $this->db->query(
                    "UPDATE `{TP_SEARCH}stats` SET `count` = `count` + 1, `last_search` = ? WHERE `term` = ?",
                    [time(), $term]
                );
            } else {
                $this->db->insertRow('{TP_SEARCH}stats', [
                    'term' => $term, 'count' => 1, 'last_search' => time(),
                ]);
            }
            $this->logError();
        }
    }

    /**
     * Records a search WITHOUT results — the whole query as typed, for the
     * admin's "searched, nothing found" list (which content is missing on
     * the site?). Stored in the same table with count = 0, so it never
     * reaches the public tag cloud (tagcloud_min_count is at least 1).
     * Once per query and session, like trackSearch().
     */
    public function trackMiss(string $query): void
    {
        if (!WbceSearchSettings::get('tagcloud_track')) return;
        $term = WbceSearchWords::lower(trim(preg_replace('/\s+/u', ' ', $query)));
        if ($term === '' || mb_strlen($term) > 100) return;

        if (!isset($_SESSION['ws_missed'])) $_SESSION['ws_missed'] = [];
        if (in_array($term, $_SESSION['ws_missed'], true)) return;
        $_SESSION['ws_missed'][] = $term;

        $exists = (int) $this->db->fetchValue(
            "SELECT COUNT(*) FROM `{TP_SEARCH}stats` WHERE `term` = ?", [$term]
        );
        if ($exists) {
            $this->db->query(
                "UPDATE `{TP_SEARCH}stats` SET `misses` = `misses` + 1, `last_search` = ? WHERE `term` = ?",
                [time(), $term]
            );
        } else {
            $this->db->insertRow('{TP_SEARCH}stats', [
                'term' => $term, 'count' => 0, 'last_search' => time(), 'misses' => 1,
            ]);
        }
        $this->logError();
    }

    /**
     * Tag-cloud data: rows of term, count and size (1–5, for the CSS class),
     * sorted alphabetically. Pure data — whether a cloud is shown is decided
     * by the caller: the search page by the setting 'tagcloud_show', the
     * droplet by its own parameter 'active'. Null = the setting.
     */
    public function getTagCloud(?int $max = null, ?int $min_count = null): array
    {
        $max       = $max       ?? (int) WbceSearchSettings::get('tagcloud_max');
        $min_count = $min_count ?? (int) WbceSearchSettings::get('tagcloud_min_count');

        $rows = $this->db->fetchAll(
            "SELECT `term`, `count` FROM `{TP_SEARCH}stats`
             WHERE `count` >= ? ORDER BY `count` DESC LIMIT " . (int) $max,
            // count = 0 rows are misses (trackMiss) — never public.
            [max(1, $min_count)]
        );
        if (empty($rows)) return [];

        $max_count = (int) $rows[0]['count'];
        $min_c     = (int) end($rows)['count'];
        $range     = max(1, $max_count - $min_c);

        foreach ($rows as &$row) {
            $row['size'] = (int) round(1 + (((int) $row['count'] - $min_c) / $range) * 4);
        }
        unset($row);

        usort($rows, fn($a, $b) => strcmp($a['term'], $b['term']));
        return $rows;
    }

    /**
     * Statistics are a side effect of a visitor's search: a failed write
     * (e.g. two requests inserting the same new term at once) is logged,
     * never allowed to break the result page.
     */
    private function logError(): void
    {
        if ($this->db->hasError()) {
            trigger_error('[wbce_search] search statistics: ' . $this->db->getError(), E_USER_NOTICE);
            $this->db->setError('');
        }
    }
}
