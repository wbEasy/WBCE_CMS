<?php
/**
 * wbce_search - WbceSearchSuggest.php
 * Live-search suggestions (search/index.php?ws_ajax=1): pages and module
 * items whose title, description or text contain every typed word —
 * only what the current visitor may see.
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

final class WbceSearchSuggest
{
    public function __construct(private object $db) {}

    /**
     * Live-search suggestions: [['title', 'description', 'snippet', 'url', 'thumb'], …].
     *
     * $mode: 'title'    — page title + description only (cheapest);
     *        'fulltext' — the search index (finds words that only occur in
     *                     the page text);
     *        'hybrid'   — title matches first, topped up from the full text
     *                     while fewer than $limit were found (default since
     *                     0.5.2: with 'title', a name that appears all over
     *                     the content but in no title suggested nothing,
     *                     although the search itself found the pages).
     */
    public function suggest(string $q, int $limit = 5, string $mode = 'hybrid'): array
    {
        $q = WbceSearchWords::lower(trim($q));
        if ($q === '' || $limit < 1) return [];
        // LIKE wildcards in the visitor's input are literal characters.
        // ESCAPE '!' explicitly — SQLite has no default escape character.
        // Every typed word must occur (any order, any distance) — matching the
        // whole input as one phrase stopped all suggestions at the first space:
        // "roger bos" found nothing although the text says "Roger E. Boswarva".
        $likes = array_map(
            fn($w) => '%' . WbceSearchWords::likeBody($w) . '%',
            array_values(array_unique(preg_split('/\s+/u', $q, -1, PREG_SPLIT_NO_EMPTY)))
        );

        // Over-fetch, then drop what this visitor may not see — before 0.4
        // titles, descriptions and URLs of private/registered pages were
        // suggested to anonymous visitors (and probing via the full-text
        // mode revealed their content).
        $fetch = max($limit * 4, 20);
        $pages = [];   // page_id => row, in suggestion order

        if ($mode !== 'fulltext') {
            $this->collectSuggestions($pages, $this->suggestFromTitles($likes, $fetch), $limit);
        }
        if ($mode === 'fulltext' || ($mode === 'hybrid' && count($pages) < $limit)) {
            $this->collectSuggestions($pages, $this->suggestFromIndex($q, $likes, $fetch), $limit);
        }

        // Words the visitor typed — the dropdown has to show where they matched.
        $needles = array_values(array_unique(array_filter(
            array_merge([$q], preg_split('/\s+/u', $q)),
            fn($w) => mb_strlen($w) >= 2
        )));

        $thumbs  = (bool) WbceSearchSettings::get('ajax_suggest_thumbs');
        $results = [];
        foreach ($pages as $row) {
            $pageUrl = WB_URL . PAGES_DIRECTORY . ($row['link'] ?? '') . PAGE_EXTENSION;
            $isItem  = (int) ($row['item_id'] ?? 0) > 0 && trim((string) ($row['item_title'] ?? '')) !== '';

            if ($isItem) {
                // A module item (catalogue entry, news post …): its own title
                // and link; the page title becomes the context line, since
                // the page description says nothing about this one item.
                $title       = trim((string) $row['item_title']);
                $description = (string) ($row['title'] ?? '');
                $url         = WbceSearch::urlFromToken((string) ($row['detail_url'] ?? '')) ?: $pageUrl;
                $snippet     = $this->findNeedle($title, $needles)
                    ? '' : $this->snippetAround((string) ($row['content'] ?? ''), $needles);
            } else {
                $title       = (string) ($row['title'] ?? '');
                $description = trim(strip_tags((string) ($row['description'] ?? '')));
                $url         = $pageUrl;
                // Matched in the title: the title shows it, the description adds
                // context. Otherwise the description is unrelated to what was
                // typed — show the passage that matched instead.
                $snippet = '';
                if (!$this->findNeedle($title, $needles)) {
                    $snippet = $this->snippetAround($description, $needles)
                        ?: $this->snippetAround($this->matchingContent((int) $row['page_id'], $needles), $needles);
                }
            }
            $results[] = [
                'title'       => $title,
                'description' => mb_substr($description, 0, 80),
                'snippet'     => $snippet,
                'url'         => WbceSearch::withHighlight($url, $q),
                'thumb'       => $thumbs ? WbceSearch::urlFromToken((string) ($row['thumb_url'] ?? '')) : '',
            ];
        }
        return $results;
    }

    /** Position of the first needle found in $text (case-insensitive), or null. */
    private function findNeedle(string $text, array $needles): ?array
    {
        foreach ($needles as $n) {
            $p = WbceSearchWords::ipos($text, $n);
            if ($p !== false) return [$p, mb_strlen($n)];
        }
        return null;
    }

    /** ~90 characters of $text around the first match, cut at word boundaries; '' if no match. */
    private function snippetAround(string $text, array $needles, int $width = 90): string
    {
        $text = trim(preg_replace('/\s+/u', ' ', $text));
        $hit  = $text === '' ? null : $this->findNeedle($text, $needles);
        if ($hit === null) return '';
        [$pos, $len] = $hit;
        $start = max(0, $pos - (int) (($width - $len) / 3));
        if ($start > 0) {
            $sp = mb_strpos($text, ' ', $start);
            if ($sp !== false && $sp < $pos) $start = $sp + 1;
        }
        $cut = mb_substr($text, $start, $width);
        if ($start + $width < mb_strlen($text)) {
            $sp = mb_strrpos($cut, ' ');
            if ($sp !== false && $sp > $pos - $start + $len) $cut = mb_substr($cut, 0, $sp);
            $cut .= '…';
        }
        return ($start > 0 ? '…' : '') . $cut;
    }

    /** Indexed text of a page that contains one of the needles ('' if none). */
    private function matchingContent(int $pageId, array $needles): string
    {
        if ($needles === []) return '';
        // Whole input first, then the single words ("roger bos" as a phrase is
        // rarely in the text, "roger" is).
        foreach ($needles as $needle) {
            $like = '%' . WbceSearchWords::likeBody($needle) . '%';
            $row = $this->db->fetchValue(
                "SELECT `content` FROM `{TP_SEARCH}index`
                 WHERE `page_id` = ? AND `searching` = 1 AND LOWER(`content`) LIKE ? ESCAPE '!'
                 LIMIT 1",
                [$pageId, $like]
            );
            if ($row) return (string) $row;
        }
        // Several words, only some of them in this entry: take any searchable text
        // of the page, snippetAround() then looks for the other needles.
        return (string) $this->db->fetchValue(
            "SELECT `content` FROM `{TP_SEARCH}index`
             WHERE `page_id` = ? AND `searching` = 1 AND `content` <> '' LIMIT 1",
            [$pageId]
        );
    }

    /**
     * Append viewable rows to $pages up to $limit, without duplicates: one
     * entry per page, plus one per module item (item_id > 0 with its own
     * title) — a catalogue page then suggests its matching entries, not just
     * itself.
     */
    private function collectSuggestions(array &$pages, array $rows, int $limit): void
    {
        foreach ($rows as $row) {
            if (count($pages) >= $limit) return;
            $iid = trim((string) ($row['item_title'] ?? '')) !== '' ? (int) ($row['item_id'] ?? 0) : 0;
            $key = (int) $row['page_id'] . ':' . $iid;
            if (isset($pages[$key]) || !WbceSearch::userCanView($row)) continue;
            $pages[$key] = $row;
        }
    }

    /** Suggestion candidates from page title + description ({TP}pages only). */
    private function suggestFromTitles(array $likes, int $fetch): array
    {
        [$cond, $params] = $this->likeEach($likes, ['LOWER(`page_title`)', 'LOWER(`description`)']);
        return $this->db->fetchAll(
            "SELECT `page_id`, `page_title` AS `title`, `link`, `description`,
                    `visibility`, `viewing_groups`, `viewing_users`
             FROM `{TP}pages`
             WHERE `visibility` NOT IN ('none','deleted')
               AND `searching` = '1'
               AND $cond
             ORDER BY CASE WHEN LOWER(`page_title`) LIKE ? ESCAPE '!' THEN 0 ELSE 1 END
             LIMIT " . $fetch,
            array_merge($params, [$likes[0]])
        );
    }

    /**
     * "(col1 LIKE w1 OR col2 LIKE w1) AND (col1 LIKE w2 OR col2 LIKE w2) …" —
     * every word in at least one of the columns. Returns [sql, params].
     */
    private function likeEach(array $likes, array $columns): array
    {
        $and = []; $params = [];
        foreach ($likes as $like) {
            $or = [];
            foreach ($columns as $col) { $or[] = "$col LIKE ? ESCAPE '!'"; $params[] = $like; }
            $and[] = '(' . implode(' OR ', $or) . ')';
        }
        return [implode(' AND ', $and), $params];
    }

    /**
     * Suggestion candidates from the search index (titles + page text).
     * Module items (item_id > 0) come back as their own rows with item title,
     * detail link, thumbnail and text — collectSuggestions() keeps one entry
     * per page plus one per item. An item row matches by ITS title, not the
     * page title stored on every row: otherwise typing the page name would
     * suggest every entry of that catalogue.
     */
    private function suggestFromIndex(string $q, array $likes, int $fetch): array
    {
        $select = "SELECT p.`page_id`, p.`page_title` AS `title`, p.`link`, p.`description`,
                          p.`visibility`, p.`viewing_groups`, p.`viewing_users`,
                          i.`item_id`, i.`item_title`, i.`detail_url`, i.`thumb_url`, i.`content`
                   FROM `{TP_SEARCH}index` i
                   INNER JOIN `{TP}pages` p ON i.page_id = p.page_id
                   WHERE p.`visibility` NOT IN ('none','deleted')
                     AND p.`searching` = '1' AND i.`searching` = 1";
        $titleCol = "CASE WHEN i.`item_id` > 0 AND i.`item_title` <> '' THEN LOWER(i.`item_title`) ELSE LOWER(i.`title`) END";

        $wordCond = WbceSearchWords::usable($this->db)
            ? WbceSearchWords::termCondition($q, array_values(WbceSearchWords::FIELDS), true)
            : null;
        if ($wordCond !== null) {
            // Large site: every word typed so far, the last one as prefix
            // ("garten hau" → garten + hau*) — an index lookup instead of
            // LIKE '%…%' over the whole text on every keystroke.
            return $this->db->fetchAll(
                "$select AND " . $wordCond[0] . "
                 ORDER BY CASE WHEN $titleCol LIKE ? ESCAPE '!' THEN 0 ELSE 1 END
                 LIMIT " . $fetch,
                array_merge($wordCond[1], [$likes[0]])
            );
        }
        [$cond, $params] = $this->likeEach($likes, [$titleCol, 'LOWER(i.`content`)']);
        return $this->db->fetchAll(
            "$select AND $cond
             ORDER BY CASE WHEN $titleCol LIKE ? ESCAPE '!' THEN 0 ELSE 1 END
             LIMIT " . $fetch,
            array_merge($params, [$likes[0]])
        );
    }
}
