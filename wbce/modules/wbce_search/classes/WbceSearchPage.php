<?php
/**
 * wbce_search - WbceSearchPage.php
 * The search results page (/search/) and the live-search endpoint:
 * request → search → grouped hits → template data → layout.
 *
 * The page hands the layout plain data only — no HTML built in PHP. A
 * result's sections are a list (R.SECTIONS) the layout loops over; lists
 * are tested directly ({if RESULTS}), no HAS_* flags.
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

final class WbceSearchPage
{
    /** Wording from the Lang registry (namespace SEARCH): the caller loads the module's language files first. */
    public function __construct(
        private Database $db,
        private WbceSearch $engine,
    ) {}

    // ── Live search (?ws_ajax=1) ────────────────────────────────────────────

    /** JSON list of suggestions — "[]" when live search is off or $q too short. */
    public function suggestJson(string $q): string
    {
        $q = trim($q);
        if (!WbceSearchSettings::get('ajax_suggest') || mb_strlen($q) < 2) {
            return '[]';
        }
        $limit = max(1, min(20, (int) WbceSearchSettings::get('ajax_suggest_limit')));
        $mode  = (string) WbceSearchSettings::get('ajax_suggest_mode');
        return (string) json_encode((new WbceSearchSuggest($this->db))->suggest($q, $limit, $mode), JSON_UNESCAPED_UNICODE);
    }

    // ── Results page ────────────────────────────────────────────────────────

    /**
     * The whole page as HTML.
     *
     * @param array<string, mixed> $get     $_GET
     * @param array<string, mixed> $request $_REQUEST (the core search form posts)
     */
    public function render(array $get, array $request, string $requestUri): string
    {
        $in = $this->readInput($get, $request);

        if ($in['string'] !== '') {
            $this->lazyReindex();
        }

        $parsed  = $this->parseQuery($in);
        // "a | b" / "a OR b" in the query is OR mode — the checkbox shows it,
        // and "did you mean" searches the same way.
        $in['or'] = $in['or'] || !empty($parsed['or']);
        $hits    = $in['string'] !== '' ? $this->engine->searchParsed($parsed) : [];
        $groups  = $this->groupHits($hits);

        $dym = ($in['string'] !== '' && $groups === []) ? $this->didYouMean($parsed, $in, $get) : null;
        $this->track($parsed, $in['string'], $groups !== []);

        $baseUrl = $this->baseUrl($get, $requestUri);
        $paged   = $this->paginate($groups, $in['page'], $baseUrl);
        $sstring = $this->highlightTerms($parsed);

        $this->queueAssets();

        return $this->parseLayout($this->templateData($in, $paged, $baseUrl, $sstring, $dym));
    }

    /**
     * The search layout picked in the Layout view (WbceSearchLayouts), filled
     * with $data. A broken layout (e.g. an admin's own copy) is logged and
     * leaves the content area empty — the page around it still renders.
     */
    private function parseLayout(array $data): string
    {
        try {
            // parseFile(): relative {insertCssFile} paths in the layout resolve
            // against its own folder (e.g. a template's search/ folder).
            return (new LayoutParser())->parseFile(WbceSearchLayouts::file('search'), $data);
        } catch (\Throwable $e) {
            trigger_error('[wbce_search] search layout: ' . $e->getMessage(), E_USER_WARNING);
            return '';
        }
    }

    /**
     * @return array{string: string, match: string, page: int, scope: list<string>, or: bool}
     */
    private function readInput(array $get, array $request): array
    {
        $match = $request['match'] ?? 'all';
        $match = in_array($match, ['all', 'any', 'exact'], true) ? $match : 'all';

        $string = '';
        // is_string(): ?string[]=x used to search for the literal word "Array".
        if (!empty($request['string']) && is_string($request['string'])) {
            // No stripslashes(): a leftover of PHP's magic quotes — nothing adds
            // slashes any more, so it only removed real ones ("C:\temp" → "C:temp").
            $raw    = html_entity_decode($request['string'], ENT_QUOTES, 'UTF-8');
            $string = trim((string) preg_replace('/\s+/', ' ', $raw));
            $string = str_replace(['[[', ']]'], '', $string);
        }

        // Scope from the URL: only 'title'/'content', always an array (a plain
        // string used to be a fatal TypeError in WbceSearch::searchParsed()).
        $scope = array_values(array_intersect((array) ($get['ws_scope'] ?? []), ['title', 'content']));

        return [
            'string' => $string,
            'match'  => $match,
            'page'   => max(1, (int) ($get['ws_page'] ?? 1)),
            'scope'  => $scope ?: ['title', 'content'],
            // match=any / match=exact come from the WBCE standard search form
            // (and template search boxes) — mapped onto the OR / phrase modes.
            'or'     => !empty($get['ws_or']) || $match === 'any',
        ];
    }

    /**
     * Option C: silently update stale index entries. Runs inside a visitor's
     * request — a failing reindex must not cost the visitor the results: log
     * it and search what is already indexed.
     */
    private function lazyReindex(): void
    {
        if (!WbceSearchSettings::get('auto_reindex')) {
            return;
        }
        try {
            (new WbceSearchIndexer($this->db))->lazyReindex(max(1, (int) WbceSearchSettings::get('auto_reindex_limit')));
        } catch (\Throwable $e) {
            trigger_error('[wbce_search] lazy reindex: ' . $e->getMessage(), E_USER_WARNING);
            $this->db->setError('');
        }
    }

    private function parseQuery(array $in): array
    {
        if ($in['string'] === '') {
            return ['scope' => $in['scope']];
        }
        $parsed = $this->engine->parseQuery(
            $in['match'] === 'exact' ? '"' . str_replace('"', '', $in['string']) . '"' : $in['string']
        );
        return $this->withMode($parsed, $in['or'] || !empty($parsed['or']), $in['scope']);
    }

    /** OR mode: every must term becomes a must_any term. */
    private function withMode(array $parsed, bool $or, array $scope): array
    {
        if ($or && !empty($parsed['must'])) {
            $parsed['must_any'] = $parsed['must'];
            $parsed['must']     = [];
        }
        $parsed['scope'] = $scope;
        return $parsed;
    }

    /**
     * One result per page and kind of match; a module item (catalogue,
     * news …) is a result of its own. Groups without sections are dropped,
     * the rest sorted by their best score.
     *
     * @return list<array{page_id: int, score: int|float, match_type: string, meta_label: string, sections: list<array>}>
     */
    private function groupHits(array $hits): array
    {
        $groups = [];
        foreach ($hits as $hit) {
            $item = (int) ($hit['item_id'] ?? 0);

            if ($item > 0) {
                $groups[($hit['module'] ?? '') . '_item_' . $item] = [
                    'page_id'    => $hit['page_id'],
                    'score'      => $hit['score'],
                    'match_type' => 'multi',
                    'meta_label' => $this->hitLabel($hit),
                    'sections'   => [$hit],
                ];
                continue;
            }

            // A content hit is "fulltext" (all matching sections listed); a
            // hit in title/keywords/description only is "meta" (one entry).
            $type = !empty($hit['in_content']) ? 'fulltext' : 'meta';
            $key  = 'page_' . $hit['page_id'] . '_' . $type;
            $groups[$key] ??= [
                'page_id'    => $hit['page_id'],
                'score'      => $hit['score'],
                'match_type' => $type,
                'meta_label' => $this->hitLabel($hit),
                'sections'   => [],
            ];

            if ($type === 'fulltext' || $groups[$key]['sections'] === []) {
                $groups[$key]['sections'][] = $hit;
            }
            if ($hit['score'] > $groups[$key]['score']) {
                $groups[$key]['score'] = $hit['score'];
            }
        }

        $groups = array_filter($groups, fn(array $g): bool => $g['sections'] !== []);
        uasort($groups, fn(array $a, array $b): int => $b['score'] <=> $a['score']);
        return array_values($groups);
    }

    /** Where the terms were found: "Content", "Keyword & Description" … (engine flags). */
    private function hitLabel(array $hit): string
    {
        $parts = [];
        if (!empty($hit['in_content']))  $parts[] = L_('SEARCH:HIT_CONTENT');
        if (!empty($hit['in_keywords'])) $parts[] = L_('SEARCH:HIT_KEYWORD');
        if (!empty($hit['in_desc']))     $parts[] = L_('SEARCH:HIT_DESCRIPTION');

        return match (count($parts)) {
            0       => L_('SEARCH:HIT_TITLE'),
            1       => $parts[0],
            2       => $parts[0] . ' & ' . $parts[1],
            default => $parts[0] . ', ' . $parts[1] . ' & ' . $parts[2],
        };
    }

    /**
     * "Did you mean …?" — only offered when the corrected query finds something.
     *
     * @return array{0: string, 1: string}|null [suggestion, its search URL]
     */
    private function didYouMean(array $parsed, array $in, array $get): ?array
    {
        $dym = $this->engine->didYouMean($parsed, $in['string']);
        if ($dym === null) {
            return null;
        }
        $parsed2 = $this->withMode($this->engine->parseQuery($dym), $in['or'], $in['scope']);
        if (!$this->engine->searchParsed($parsed2)) {
            return null;
        }
        $qs = $get;
        unset($qs['ws_page'], $qs['ws_ajax']);
        $qs['string'] = $dym;
        return [$dym, WB_URL . '/search/index.php?' . http_build_query($qs)];
    }

    /**
     * Hits feed the public tag cloud, misses only the admin's "searched,
     * nothing found" list. ~ terms are left out on purpose: they are often
     * typos and the tag cloud is public.
     */
    private function track(array $parsed, string $string, bool $found): void
    {
        $words = array_merge(
            $parsed['must']     ?? [],
            $parsed['must_any'] ?? [],
            $parsed['wildcard'] ?? [],
            $this->phraseWords($parsed)
        );
        if ($words !== [] && $found) {
            (new WbceSearchStats($this->db))->trackSearch($words);
        } elseif ($string !== '' && !$found) {
            (new WbceSearchStats($this->db))->trackMiss($string);
        }
    }

    /**
     * Terms the target page highlights (core: ?searchresult=1&sstring=,
     * split at spaces) and fe_search_jump.js scrolls to. Plain words only — no
     * -exclusions, quotes or * — and NOT url-encoded here: prepareResult()
     * encodes it. Encoding it twice turned "Roger Boswarva" into
     * "Roger+Boswarva" on the target page, so multi-word searches
     * highlighted nothing.
     */
    private function highlightTerms(array $parsed): string
    {
        $words = array_merge(
            $parsed['must']     ?? [],
            $parsed['wildcard'] ?? [],
            $this->phraseWords($parsed),
            $parsed['must_any'] ?? []
        );
        return implode(' ', array_values(array_unique(array_filter(
            $words,
            fn($w): bool => mb_strlen((string) $w) >= 2
        ))));
    }

    /** @return list<string> */
    private function phraseWords(array $parsed): array
    {
        return array_merge(...array_map(fn(string $p): array => explode(' ', $p), $parsed['phrase'] ?? []));
    }

    /** The current URL without ws_page — base of the pagination links. */
    private function baseUrl(array $get, string $requestUri): string
    {
        $base = (string) strtok($requestUri, '?');
        unset($get['ws_page'], $get['wb_search'], $get['referrer']);
        return $get !== [] ? $base . '?' . http_build_query($get) : $base;
    }

    // ── Template data ───────────────────────────────────────────────────────

    private function templateData(array $in, array $paged, string $baseUrl, string $sstring, ?array $dym): array
    {
        $results = $this->resultRows($paged['items'], $sstring);
        $areas   = ($results === [] && $in['string'] !== '') ? $this->suggestionAreas() : [];
        $sep     = str_contains($baseUrl, '?') ? '&' : '?';
        $total   = (int) ($paged['total'] ?? 0);

        return [
            // Form
            'SEARCH_URL'    => WB_URL . '/search/index.php',
            'SEARCH_STRING' => $in['string'],
            'ALL_CHECKED'   => $in['match'] === 'all'   ? 'checked' : '',
            'ANY_CHECKED'   => $in['match'] === 'any'   ? 'checked' : '',
            'EXACT_CHECKED' => $in['match'] === 'exact' ? 'checked' : '',
            // Results
            'RESULTS'       => $results,
            'TOTAL'         => $total,
            // "1 result" / "5 results" / "No results"
            'TOTAL_TEXT'    => Ln_('SEARCH:RESULT_COUNT', $total),
            // Pagination
            'PAGES'         => $paged['pages'] ?? 0,
            'PREV_PAGE'     => $paged['prev_page'] ?? 0,
            'NEXT_PAGE'     => $paged['next_page'] ?? 0,
            'PREV_URL'      => ($paged['prev_page'] ?? 0) ? $baseUrl . $sep . 'ws_page=' . $paged['prev_page'] : '',
            'NEXT_URL'      => ($paged['next_page'] ?? 0) ? $baseUrl . $sep . 'ws_page=' . $paged['next_page'] : '',
            'PAGE_LINKS'    => $paged['page_links'],
            // Tag cloud: HTML from the 'tagcloud' layout ([TAGCLOUD|raw])
            'TAGCLOUD'      => $this->tagCloud(),
            'DEBUG_MODE'    => $this->debugMode() ? '1' : '',
            // Advanced search
            'ADVANCED_SEARCH'       => WbceSearchSettings::get('advanced_search') ? '1' : '',
            'SCOPE_TITLE_CHECKED'   => in_array('title', $in['scope'], true)   ? 'checked' : '',
            'SCOPE_CONTENT_CHECKED' => in_array('content', $in['scope'], true) ? 'checked' : '',
            'WS_OR_CHECKED'         => $in['or'] ? 'checked' : '',
            // No results: "did you mean …?" + suggested areas
            'DID_YOU_MEAN'         => $dym[0] ?? '',
            'DID_YOU_MEAN_URL'     => $dym[1] ?? '',
            'SUGGESTION_AREAS'     => $areas,
            // Every plain text of the language files (EN + site language) as
            // [TEXT.KEY] — layouts (also a custom search_custom.htt) need no
            // hard-coded wording. Plural arrays are left out; the counts
            // arrive pre-formatted (TOTAL_TEXT, the tag cloud's tooltips).
            'TEXT' => array_filter(Lang::getRegistry()['SEARCH'] ?? [], 'is_string'),
        ];
    }

    /**
     * One row per result of this page. Hits from the word index carry no
     * text yet — it is loaded here, for the hits shown only.
     *
     * R.SECTIONS: the matching sections of a full-text or module-item result
     * (empty for a title/keyword/description-only result, which shows
     * R.EXCERPT instead). Each: LINK, TITLE, ITEM_TITLE, THUMB_URL (plain
     * values, the parser escapes them) and EXCERPT (HTML with <mark>).
     */
    private function resultRows(array $groups, string $sstring): array
    {
        $pages = $this->pageMap(array_values(array_unique(array_column($groups, 'page_id'))));
        $rows  = [];

        foreach ($groups as $group) {
            $pageInfo = $pages[(int) $group['page_id']] ?? [];
            $sections = [];
            foreach ($this->engine->hydrate($group['sections']) as $hit) {
                $sections[] = $this->engine->prepareResult($hit, $pageInfo, $sstring);
            }
            $listed = $group['match_type'] === 'fulltext' || $group['match_type'] === 'multi';

            // The first section's fields are the result's own (R.LINK, R.EXCERPT …).
            $rows[] = array_merge($sections[0] ?? [], [
                'SECTIONS'      => $listed ? $sections : [],
                'MATCH_TYPE'    => $group['match_type'],
                'IS_META'       => $group['match_type'] === 'meta' ? '1' : '',
                'IS_FULLTEXT'   => $listed ? '1' : '',
                'IS_MULTI'      => $group['match_type'] === 'multi' ? '1' : '',
                'META_LABEL'    => $group['meta_label'],
                'SECTION_COUNT' => count($sections),
            ]);
        }
        return $rows;
    }

    /** @return array<int, array{page_id: mixed, page_title: mixed, link: mixed}> */
    private function pageMap(array $pageIds): array
    {
        if ($pageIds === []) {
            return [];
        }
        $rows = $this->db->fetchAll(
            "SELECT `page_id`, `page_title`, `link` FROM `{TP}pages` WHERE `page_id` IN("
                . implode(',', array_fill(0, count($pageIds), '?')) . ')',
            $pageIds
        );
        $map = [];
        foreach ($rows as $r) {
            $map[(int) $r['page_id']] = $r;
        }
        return $map;
    }

    /** This page's slice of the result groups, plus what the pagination needs. */
    private function paginate(array $groups, int $page, string $baseUrl): array
    {
        $per   = max(1, (int) WbceSearchSettings::get('results_per_page'));
        $total = count($groups);
        $pages = (int) ceil($total / $per);
        $cur   = max(1, min($pages ?: 1, $page));

        return [
            'items'      => array_slice($groups, ($cur - 1) * $per, $per),
            'total'      => $total,
            'pages'      => $pages,
            'prev_page'  => $cur > 1 ? $cur - 1 : null,
            'next_page'  => $cur < $pages ? $cur + 1 : null,
            'page_links' => $this->pageLinks($cur, $pages, $baseUrl),
        ];
    }

    /**
     * Page numbers: all up to 7 pages, else the first two, the last two and
     * ±2 around the current one — with a gap entry ("…", URL '') between
     * non-adjacent ones. CURRENT marks the current page.
     */
    private function pageLinks(int $cur, int $pages, string $baseUrl): array
    {
        if ($pages <= 1) {
            return [];
        }
        $nums = $pages <= 7
            ? range(1, $pages)
            : array_unique(array_merge([1, 2], range(max(2, $cur - 2), min($pages - 1, $cur + 2)), [$pages - 1, $pages]));
        sort($nums);

        $sep  = str_contains($baseUrl, '?') ? '&' : '?';
        $out  = [];
        $prev = null;
        foreach ($nums as $n) {
            if ($prev !== null && $n > $prev + 1) {
                $out[] = ['NUM' => '…', 'URL' => '', 'CURRENT' => false];
            }
            $out[] = ['NUM' => $n, 'URL' => $baseUrl . $sep . 'ws_page=' . $n, 'CURRENT' => $n === $cur];
            $prev  = $n;
        }
        return $out;
    }

    /** Searchable top-level pages, offered when nothing was found. */
    private function suggestionAreas(): array
    {
        $rows = $this->db->fetchAll(
            "SELECT `page_id`, `page_title`, `link`
               FROM `{TP}pages`
              WHERE `visibility` = 'public' AND `level` = 0
           ORDER BY `position` ASC
              LIMIT 8"
        );
        $areas = [];
        foreach ($rows as $r) {
            $areas[] = [
                'TITLE' => html_entity_decode((string) $r['page_title'], ENT_QUOTES, 'UTF-8'), // escaped by the layout
                'URL'   => WB_URL . PAGES_DIRECTORY . $r['link'] . PAGE_EXTENSION,
            ];
        }
        return $areas;
    }

    /**
     * The tag cloud as HTML, in the same 'tagcloud' layout as the droplet.
     * 'tagcloud_show' hides it on this page ('tagcloud_track' only stops
     * recording; the droplet has its own active=true/false).
     */
    private function tagCloud(): string
    {
        return WbceSearchSettings::get('tagcloud_show')
            ? WbceSearchLayouts::renderTagCloud((new WbceSearchStats($this->db))->getTagCloud())
            : '';
    }

    /**
     * Debug boxes under each result: the setting is on AND the visitor is an
     * administrator — checked against the users table, not the session's
     * group list alone. No query at all while the setting is off.
     */
    private function debugMode(): bool
    {
        if (!WbceSearchSettings::get('debug_results')) {
            return false;
        }
        $uid = (int) ($_SESSION['USER_ID'] ?? 0);
        return $uid > 0
            && (int) $this->db->fetchValue("SELECT `group_id` FROM `{TP}users` WHERE `user_id` = ?", [$uid]) === 1;
    }

    private function queueAssets(): void
    {
        if (!class_exists('I')) {
            return;
        }
        WbceSearchLayouts::queueStylesheet();   // as picked in the Layout tab (or none)
        if (WbceSearchSettings::get('ajax_suggest')) {
            // Same ids as initialize_fe.php: queued twice, it is still output once.
            I::insertJsCode('window.WS_SEARCH_CFG=' . json_encode([
                'ajax_url'  => WB_URL . '/search/index.php?ws_ajax=1',
                'min_chars' => max(2, (int) WbceSearchSettings::get('min_length')),
                'delay'     => 300,
            ]) . ';', 'body_late', 'search_cfg');
            I::insertJsFile(WB_URL . '/modules/wbce_search/assets/fe_search.js', 'body_late', 'search_js');
            I::insertCssFile(WB_URL . '/modules/wbce_search/assets/fe_search_suggest.css', 'head_late', 'search_suggest_css');
        }
    }
}
