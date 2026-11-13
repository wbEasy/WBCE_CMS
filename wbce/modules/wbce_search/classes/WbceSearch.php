<?php
/**
 * wbce_search - WbceSearch.php
 * The search engine: query parser, row scan / word-index lookup, scoring,
 * result rows with excerpts, visitor permissions. Live suggestions:
 * WbceSearchSuggest; statistics + tag cloud: WbceSearchStats; the page
 * itself: WbceSearchPage.
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

class WbceSearch
{
    /**
     * Stored in place of WB_URL in detail_url/thumb_url, so the index keeps
     * working after a move to another domain or folder without a rebuild
     * (the lazy reindex only notices changed pages). Same token as wysiwyg
     * and the output filter dashboard use.
     */
    public const URL_TOKEN = '{SYSVAR:WB_URL}';

    /** Absolute site URL → stored form. Foreign URLs pass through unchanged. */
    public static function urlToToken(string $url): string
    {
        return $url === '' ? '' : str_replace(WB_URL, self::URL_TOKEN, $url);
    }

    /**
     * Add ?searchresult=1&sstring=… to a link on this site: the core then
     * highlights the terms on the target page and fe_search_jump.js scrolls to
     * the first one. $terms is plain text, space-separated. Foreign URLs stay unchanged.
     */
    public static function withHighlight(string $url, string $terms): string
    {
        $terms = trim($terms);
        if ($url === '' || $terms === '' || !str_starts_with($url, WB_URL)) return $url;
        return $url . (str_contains($url, '?') ? '&' : '?')
            . 'searchresult=1&sstring=' . rawurlencode($terms);
    }

    /** Stored form → absolute URL for output. Absolute URLs (old rows) pass through. */
    public static function urlFromToken(string $url): string
    {
        return $url === '' ? '' : str_replace(self::URL_TOKEN, WB_URL, $url);
    }

    private object $db;
    /** @var array<string, int|string> the settings (WbceSearchSettings::all(): cast, defaults filled in) */
    private array  $cfg;
    private array  $stopwords;

    public function __construct(object $database)
    {
        $this->db  = $database;
        $this->cfg = WbceSearchSettings::all();   // {TP}settings is loaded by the core already

        // Stop words of the site's page languages — the same set the word
        // index was built with.
        $this->stopwords = WbceSearchStopwords::forSite($this->db);
    }

    // ── Public API ─────────────────────────────────────────────────────────

    /**
     * Query parser: operators, phrases, wildcards, exclusions, ~ variants.
     * Input:  bio senf -scharf "gelber senf" senf* senf~ (| or OR: OR mode)
     * Output: ['must'=>[...], 'must_not'=>[...], 'phrase'=>[...], 'wildcard'=>[...], 'fuzzy'=>[...], 'or'=>true?]
     */
    public function parseQuery(string $input): array
    {
        $result = ['must' => [], 'must_not' => [], 'phrase' => [], 'wildcard' => [], 'fuzzy' => []];
        $input  = trim($input);

        // Phrases first: "gelber senf"
        preg_match_all('/"([^"]+)"/', $input, $phrase_matches);
        foreach($phrase_matches[1] as $phrase) {
            if(mb_strlen(trim($phrase)) >= 2) $result['phrase'][] = trim($phrase);
        }
        $input = preg_replace('/"[^"]*"/', '', $input);

        // "senf | ketchup" or "senf OR ketchup": OR mode for the whole query
        // (same as the "OR search" checkbox) — the no-results tips have always
        // suggested "|", but it was searched as a plain AND before 0.5.7.
        $input = str_replace('|', ' | ', $input);

        // Then token by token
        $tokens = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);
        foreach($tokens as $token) {
            if ($token === '|' || $token === 'OR') { $result['or'] = true; continue; }
            $exclude = str_starts_with($token, '-') && mb_strlen($token) > 1;
            $word    = $exclude ? mb_substr($token, 1) : $token;
            $wild    = str_ends_with($word, '*');
            $word    = $wild ? mb_substr($word, 0, -1) : $word;
            // senf~ — also spelling variants (WbceSearchFuzzy); "-senf~" just excludes "senf".
            $fuzzy   = !$wild && str_ends_with($word, '~');
            $word    = $fuzzy ? mb_substr($word, 0, -1) : $word;

            if(mb_strlen($word) < 1) continue;

            if($fuzzy && !$exclude) {
                $result['fuzzy'][] = $word;
            } elseif($wild && !$exclude) {
                $result['wildcard'][] = $word;
            } elseif($exclude) {
                $result['must_not'][] = $word;
            } else {
                $result['must'][]     = $word;
            }
        }
        return $result;
    }

    /** One hit as layout data (a row of R.SECTIONS / the result's own fields). */
    public function prepareResult(array $hit, array $page_info, string $sstring): array
    {
        // page_link() = WB_URL . PAGES_DIRECTORY . $link . PAGE_EXTENSION (class.wb.php)
        // Build directly — $wb/$admin not yet available at dispatcher call time
        $raw_link = $page_info['link'] ?? '';
        if (str_contains($raw_link, '://') || str_starts_with($raw_link, 'mailto:')) {
            $link = $raw_link; // external URL unchanged
        } else {
            $link = WB_URL . PAGES_DIRECTORY . $raw_link . PAGE_EXTENSION;
        }
        $link = self::withHighlight($link, $sstring);
        // Detail URL: the module's own item page, if it has one
        $detail_url = self::urlFromToken($hit['detail_url'] ?? '');
        $thumb_url  = self::urlFromToken($hit['thumb_url']  ?? '');
        $final_link = !empty($detail_url) ? self::withHighlight($detail_url, $sstring) : $link;

        // Title: the module item's title (news, catalogue …), else the page title
        $display_title = !empty($hit['item_title'])
            ? $hit['item_title']
            : ($page_info['page_title'] ?? $hit['title']);
        // Decode HTML entities (&quot; → ") — the layout escapes
        $display_title = html_entity_decode($display_title, ENT_QUOTES, 'UTF-8');

        // Excerpt: from content
        $excerpt = $this->excerpt($hit['content'], $hit['words'] ?? []);

        return [
            'LINK'        => $final_link,
            'PAGE_LINK'   => $link,
            'DETAIL_URL'  => $detail_url,
            'THUMB_URL'      => $thumb_url,
            'TITLE'       => $display_title,
            // Plain text: the LayoutParser escapes every [KEY]. Only EXCERPT
            // is HTML (escaped text + highlight tags) → [R.EXCERPT|raw].
            'PAGE_TITLE'  => html_entity_decode((string) ($page_info['page_title'] ?? $hit['title']), ENT_QUOTES, 'UTF-8'),
            'ITEM_TITLE'  => html_entity_decode($hit['item_title'] ?? '', ENT_QUOTES, 'UTF-8'),
            'EXCERPT'        => $excerpt,
            'SCORE'       => $hit['score'],
            'MODULE'      => $hit['module']      ?? '',
            'PAGE_ID'     => $hit['page_id']     ?? '',
            'SECTION_ID'  => $hit['section_id']  ?? '',
            'ITEM_ID'     => $hit['item_id']     ?? 0,
            // Debug data (DEBUG_MODE)
            'DEBUG_MODULE'   => $hit['module']       ?? '',
            'DEBUG_PAGE_ID'  => $hit['page_id']      ?? '',
            'DEBUG_SEC_ID'   => $hit['section_id']   ?? '',
            'DEBUG_ITEM_ID'  => $hit['item_id']      ?? 0,
            'DEBUG_SCORE'    => $hit['score']         ?? 0,
            'DEBUG_DETAIL'   => $detail_url,
            'DEBUG_DETAIL_OK'=> $detail_url ? '✔' : '✘ empty',
            'DEBUG_THUMB'    => $thumb_url,
            'DEBUG_THUMB_OK' => $thumb_url !== '' ? '✔' : '✘ empty',
            'DEBUG_CONTENT'  => mb_substr($hit['content'] ?? '', 0, 300),
            'DEBUG_PAGE_URL' => $link,
        ];
    }

    // ── Search ─────────────────────────────────────────────────────────────

    /**
     * Search with parsed query — supports must/must_not/phrase/wildcard.
     */
    public function searchParsed(array $parsed): array
    {
        $must     = $this->filterWords($parsed['must']     ?? []);
        $must_any = $this->filterWords($parsed['must_any'] ?? []); // OR-Modus
        $must_not = $parsed['must_not'] ?? [];
        $phrases  = $parsed['phrase']   ?? [];
        $wildcards= $parsed['wildcard'] ?? [];
        // Scope comes straight from the URL (ws_scope[]); a plain string
        // (?ws_scope=title) used to crash in_array() with a TypeError.
        $scope    = array_values(array_intersect((array) ($parsed['scope'] ?? []), ['title', 'content']));
        if (empty($scope)) $scope = ['title', 'content'];

        // Fields the search looks in (scope)
        $scope_fields = [];
        if(in_array('title',   $scope)) $scope_fields = array_merge($scope_fields, ['title', 'item_title', 'keywords', 'description']);
        if(in_array('content', $scope)) $scope_fields[] = 'content';
        if(empty($scope_fields)) $scope_fields = ['title', 'item_title', 'keywords', 'description', 'content'];

        // senf~ → group of spelling variants; at least one must occur.
        // In OR mode the variants simply join the alternatives.
        $groups = [];
        foreach ($this->filterWords($parsed['fuzzy'] ?? []) as $f) {
            $groups[] = ['term' => WbceSearchWords::fold($f), 'variants' => array_keys(WbceSearchFuzzy::variants($this->db, $f))];
        }
        if ($must_any && $groups) {
            foreach ($groups as $g) $must_any = array_merge($must_any, $g['variants']);
            $must_any = array_values(array_unique($must_any));
            $groups   = [];
        }

        // At least one search term needed
        if(empty($must) && empty($must_any) && empty($phrases) && empty($wildcards) && empty($groups)) return [];

        $lang_filter = $this->cfg['language_filter']
            ? (defined('LANGUAGE') ? LANGUAGE : '') : '';

        $terms = compact('must', 'must_any', 'must_not', 'phrases', 'wildcards', 'groups');

        // Large site with a complete word index → index lookup; otherwise
        // the row scan, narrowed down by the database first.
        $results = WbceSearchWords::usable($this->db)
            ? $this->matchViaWords($terms, $scope_fields, $lang_filter)
            : $this->matchViaRows($terms, $scope_fields, $lang_filter);

        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);

        // Deduplication:
        // module item (item_id > 0): per module + item_id
        // keywords/description hit: per page_id
        // plain full-text hit: per section_id
        $best = [];
        foreach($results as $r) {
            $item_id = (int)($r['item_id'] ?? 0);
            if($item_id > 0) {
                $key = ($r['module'] ?? '') . '_item_' . $item_id;
            } else {
                $has_meta = !empty($r['keywords']) || !empty($r['description']);
                $key = $has_meta ? 'page_' . $r['page_id'] : 'sec_' . $r['section_id'];
            }
            if(!isset($best[$key]) || $r['score'] > $best[$key]['score']) {
                $best[$key] = $r;
            }
        }
        $deduped = array_values($best);
        usort($deduped, fn($a, $b) => $b['score'] <=> $a['score']);
        return $deduped;
    }

    /**
     * "Did you mean …?" — the query with every unknown word replaced by its
     * closest known word (public vocabulary, see WbceSearchFuzzy), or null
     * when nothing could be corrected. Operators, phrases and ~ terms are
     * left alone. The caller should only show it if the corrected query
     * actually finds something.
     */
    public function didYouMean(array $parsed, string $query): ?string
    {
        if (!empty($parsed['fuzzy'])) return null;
        $changed = false;
        foreach ($this->filterWords(array_merge($parsed['must'] ?? [], $parsed['must_any'] ?? [])) as $w) {
            $fix = WbceSearchFuzzy::correct($this->db, $w);
            if ($fix === null) continue;
            // Keep the visitor's capitalisation of the first letter ("Sevem" → "Seven").
            $query = preg_replace_callback(
                '/(?<![\p{L}\p{N}_])' . WbceSearchWords::regex($w) . '(?![\p{L}\p{N}_])/iu',
                function ($m) use ($fix) {
                    $first = mb_substr($m[0], 0, 1);
                    return $first !== mb_strtolower($first)
                        ? mb_strtoupper(mb_substr($fix, 0, 1)) . mb_substr($fix, 1)
                        : $fix;
                },
                $query
            );
            $changed = true;
        }
        return $changed ? $query : null;
    }

    /**
     * Row scan (small sites, or word index not complete yet). Before 0.5 every
     * row of the index — full text included — was loaded into PHP for every
     * query. Now the database first drops rows that cannot match (LIKE per
     * required term), so only candidates travel to PHP; the exact checks
     * (whole words, prefix, exclusions) stay in PHP as before.
     */
    private function matchViaRows(array $t, array $scope_fields, string $lang_filter): array
    {
        [$where, $params] = $this->likePrefilter($t, $scope_fields);
        $rows = $this->fetchIndexRows($lang_filter, $where, $params);
        $label_words = $this->labelWords($t);

        $results = [];
        foreach($rows as $row) {
            // Haystack from the scope fields
            $haystack = implode(' ', array_filter(array_map(fn($f) => $row[$f] ?? '', $scope_fields)));

            // must_not: exclusion (always against all fields)
            $full_hay = implode(' ', array_filter([
                $row['title'] ?? '', $row['item_title'] ?? '',
                $row['keywords'] ?? '', $row['description'] ?? '', $row['content'] ?? '',
            ]));
            $skip = false;
            foreach($t['must_not'] as $not) {
                if($this->containsWord($full_hay, $not)) { $skip = true; break; }
            }
            if($skip) continue;

            // must: every required term must occur in the scope
            foreach($t['must'] as $word) {
                if(!$this->containsWord($haystack, $word)) { $skip = true; break; }
            }
            if($skip) continue;

            // must_any: OR mode — at least one term must occur
            if(!empty($t['must_any'])) {
                $found_any = false;
                foreach($t['must_any'] as $word) {
                    if($this->containsWord($haystack, $word)) { $found_any = true; break; }
                }
                if(!$found_any) continue;
            }

            // phrases: the exact word sequence
            foreach($t['phrases'] as $phrase) {
                if(WbceSearchWords::ipos($haystack, $phrase) === false) { $skip = true; break; }
            }
            if($skip) continue;

            // wildcards: prefix search — the term must start a word ("senf*"
            // finds "Senfglas", not "Tafelsenf").
            foreach($t['wildcards'] as $wc) {
                if(!$this->startsWord($haystack, $wc)) { $skip = true; break; }
            }
            if($skip) continue;

            // senf~: at least one spelling variant as a whole word
            foreach($t['groups'] as $g) {
                $any = false;
                foreach($g['variants'] as $v) {
                    if($this->containsWord($haystack, $v)) { $any = true; break; }
                }
                if(!$any) { $skip = true; break; }
            }
            if($skip) continue;

            // Score
            $score = 0;
            $tw = (int) $this->cfg['title_weight'];
            $fields = ['title' => $tw, 'item_title' => $tw, 'keywords' => 2, 'description' => 1, 'content' => 1];
            $all_words = array_merge($t['must'], $t['must_any'], $t['wildcards']);
            foreach($all_words as $word) {
                foreach($fields as $field => $weight) {
                    $val = $row[$field] ?? '';
                    if(!empty($val) && WbceSearchWords::ipos($val, $word) !== false) $score += $weight;
                }
            }
            foreach($t['phrases'] as $phrase) {
                foreach($fields as $field => $weight) {
                    if(WbceSearchWords::ipos($row[$field] ?? '', $phrase) !== false) $score += $weight * 2;
                }
            }
            // ~ groups: the word as typed scores fully, a spelling variant half
            // (exact hits rank above typo hits).
            foreach($t['groups'] as $g) {
                foreach($fields as $field => $weight) {
                    $val = $row[$field] ?? '';
                    if($val === '') continue;
                    if($this->containsWord($val, $g['term'])) { $score += $weight; continue; }
                    foreach($g['variants'] as $v) {
                        if($this->containsWord($val, $v)) { $score += max(1, intdiv($weight, 2)); break; }
                    }
                }
            }
            if($score === 0) continue;

            // Visibility
            if(!self::userCanView($row)) continue;

            // Where the terms were found — drives the result label
            // (Content / Keyword / Description / Title).
            $in = ['content' => false, 'keywords' => false, 'description' => false];
            foreach($label_words as [$w, $prefix]) {
                foreach($in as $f => $found) {
                    if(!$found && ($prefix ? $this->startsWord($row[$f] ?? '', $w) : $this->containsWord($row[$f] ?? '', $w))) {
                        $in[$f] = true;
                    }
                }
            }

            $results[] = $this->resultRow($row, $score, $in, $this->highlightWords($t));
        }
        return $results;
    }

    /** Words to highlight in the excerpt — incl. every spelling variant of a ~ term. */
    private function highlightWords(array $t): array
    {
        $out = array_merge($t['must'], $t['wildcards'], array_merge(...array_map(fn($p) => explode(' ', $p), $t['phrases'])));
        foreach ($t['groups'] as $g) $out = array_merge($out, $g['variants']);
        return array_values(array_unique($out));
    }

    /**
     * Word-index lookup (large sites). The database selects the matching
     * entries via the word table; PHP gets the entries WITHOUT their text and
     * scores them from the word rows. The text of the displayed hits is
     * loaded afterwards by hydrate().
     */
    private function matchViaWords(array $t, array $scope_fields, string $lang_filter): array
    {
        $F = WbceSearchWords::FIELDS;
        $scope_codes = array_values(array_intersect_key($F, array_flip($scope_fields)));
        $where = []; $params = [];

        $add = function (?array $cond) use (&$where, &$params): bool {
            if ($cond === null) return false;
            $where[] = $cond[0];
            array_push($params, ...$cond[1]);
            return true;
        };

        // Required terms; a term the word index cannot express (no word
        // characters, e.g. "!!!") can never match a word → no results, as
        // the row scan would also find none.
        foreach ($t['must'] as $w) {
            if (!$add(WbceSearchWords::termCondition($w, $scope_codes))) return [];
        }
        foreach ($t['wildcards'] as $w) {
            if (!$add(WbceSearchWords::termCondition($w, $scope_codes, true))) return [];
        }
        foreach ($t['phrases'] as $p) {
            // All words of the phrase via the index, the exact sequence via LIKE.
            if (!$add(WbceSearchWords::termCondition($p, $scope_codes))) return [];
            [$lw, $lp] = $this->likeAny($p, $scope_fields, true);
            if ($lw) { $where[] = $lw; array_push($params, ...$lp); }
        }
        if ($t['must_any']) {
            $or = []; $orParams = [];
            foreach ($t['must_any'] as $w) {
                $c = WbceSearchWords::termCondition($w, $scope_codes);
                if ($c) { $or[] = $c[0]; array_push($orParams, ...$c[1]); }
            }
            if (!$or) return [];
            $where[] = '(' . implode(' OR ', $or) . ')';
            array_push($params, ...$orParams);
        }
        foreach ($t['groups'] as $g) {
            // senf~: any one of the spelling variants
            $or = []; $orParams = [];
            foreach ($g['variants'] as $v) {
                $c = WbceSearchWords::termCondition($v, $scope_codes);
                if ($c) { $or[] = $c[0]; array_push($orParams, ...$c[1]); }
            }
            if (!$or) return [];
            $where[] = '(' . implode(' OR ', $or) . ')';
            array_push($params, ...$orParams);
        }
        foreach ($t['must_not'] as $w) {
            // Stop words are not in the word index — exclude them by text.
            $words = WbceSearchWords::split($w);
            if (count($words) === 1 && !in_array($words[0], $this->stopwords, true)) {
                $c = WbceSearchWords::termCondition($w, array_values($F));
                $where[] = 'NOT ' . $c[0];
                array_push($params, ...$c[1]);
            } else {
                [$lw, $lp] = $this->likeAny($w, array_keys($F), false);
                if ($lw) { $where[] = 'NOT ' . $lw; array_push($params, ...$lp); }
            }
        }

        $rows = $this->fetchIndexRows($lang_filter, $where, $params, false);
        if (!$rows) return [];

        // Score + label from the word rows of exactly these entries.
        $termList = [];
        foreach ($t['must'] as $w)      $termList[] = [$w, false];
        foreach ($t['must_any'] as $w)  $termList[] = [$w, false];
        foreach ($t['wildcards'] as $w) $termList[] = [$w, true];
        $phraseFrom = count($termList);
        foreach ($t['phrases'] as $p)   $termList[] = [$p, false];
        // ~ variants: term# → [group#, is the word as typed]
        $groupOf = [];
        foreach ($t['groups'] as $gi => $g) {
            foreach ($g['variants'] as $v) {
                $groupOf[count($termList)] = [$gi, $v === $g['term']];
                $termList[] = [$v, false];
            }
        }

        [$entrySql, $entryParams] = $this->entryIdSql($lang_filter, $where, $params);
        $hits = WbceSearchWords::hitsFor($this->db, $termList, $entrySql, $entryParams);

        $tw = (int) $this->cfg['title_weight'];
        $weight = [$F['title'] => $tw, $F['item_title'] => $tw, $F['keywords'] => 2, $F['description'] => 1, $F['content'] => 1];
        $label_words = $this->highlightWords($t);

        $results = [];
        foreach ($rows as $row) {
            if (!self::userCanView($row)) continue;
            $score = 0;
            $in = ['content' => false, 'keywords' => false, 'description' => false];
            $groupBest = [];   // group# → field code → exact?
            foreach ($hits[(int) $row['id']] ?? [] as $n => $fields) {
                foreach ($fields as $code => $_) {
                    if ($code === $F['content'])     $in['content'] = true;
                    if ($code === $F['keywords'])    $in['keywords'] = true;
                    if ($code === $F['description']) $in['description'] = true;
                    if (isset($groupOf[$n])) {
                        [$gi, $exact] = $groupOf[$n];
                        $groupBest[$gi][$code] = ($groupBest[$gi][$code] ?? false) || $exact;
                        continue;
                    }
                    // Same weights as the row scan; phrases count double there too.
                    $score += ($weight[$code] ?? 1) * ($n >= $phraseFrom ? 2 : 1);
                }
            }
            // ~ groups: typed word full weight, a spelling variant half — as in the row scan
            foreach ($groupBest as $byField) {
                foreach ($byField as $code => $exact) {
                    $w = $weight[$code] ?? 1;
                    $score += $exact ? $w : max(1, intdiv($w, 2));
                }
            }
            if ($score === 0) continue;
            $results[] = $this->resultRow($row, $score, $in, $label_words);
        }
        return $results;
    }

    /** One search result; 'content' is null until hydrate() when it came from the word index. */
    private function resultRow(array $row, int $score, array $in, array $words): array
    {
        return [
            'id'          => (int)$row['id'],
            'score'       => $score,
            'page_id'     => (int)$row['page_id'],
            'section_id'  => (int)$row['section_id'],
            'item_id'     => (int)($row['item_id'] ?? 0),
            'module'      => $row['module']      ?? '',
            'title'       => $row['title']       ?? '',
            'item_title'  => $row['item_title']  ?? '',
            'description' => $row['description'] ?? '',
            'keywords'    => $row['keywords']    ?? '',
            'content'     => $row['content']     ?? null,
            'detail_url'  => $row['detail_url']  ?? '',
            'thumb_url'   => $row['thumb_url']   ?? '',
            'link'        => $row['link']        ?? '',
            'visibility'  => $row['visibility']  ?? 'public',
            'in_content'  => $in['content'],
            'in_keywords' => $in['keywords'],
            'in_desc'     => $in['description'],
            'words'       => $words,
        ];
    }

    /**
     * Loads the text of results that came from the word index — called for
     * the hits of the current results page only, right before the excerpts
     * are built.
     */
    public function hydrate(array $hits): array
    {
        $ids = [];
        foreach ($hits as $h) {
            if (($h['content'] ?? null) === null && !empty($h['id'])) $ids[] = (int) $h['id'];
        }
        if (!$ids) return $hits;
        $rows = $this->db->fetchAll(
            "SELECT `id`, `content` FROM `{TP_SEARCH}index` WHERE `id` IN ("
            . implode(',', array_fill(0, count($ids), '?')) . ")",
            $ids
        );
        $text = array_column($rows, 'content', 'id');
        foreach ($hits as &$h) {
            if (($h['content'] ?? null) === null) $h['content'] = (string) ($text[$h['id']] ?? '');
        }
        unset($h);
        return $hits;
    }

    /** [word, isPrefix] pairs used for the Content/Keyword/Description label. */
    private function labelWords(array $t): array
    {
        $out = [];
        foreach (array_merge($t['must'], $t['must_any']) as $w) $out[] = [$w, false];
        foreach ($t['wildcards'] as $w) $out[] = [$w, true];
        foreach ($t['phrases'] as $p) foreach (explode(' ', $p) as $w) if ($w !== '') $out[] = [$w, false];
        foreach ($t['groups'] as $g) foreach ($g['variants'] as $w) $out[] = [$w, false];
        return $out;
    }

    /** True if a word in $haystack starts with $prefix (the senf* operator). */
    private function startsWord(string $haystack, string $prefix): bool
    {
        return (bool) preg_match('/(?<![\p{L}\p{N}_])' . WbceSearchWords::regex($prefix) . '/iu', $haystack);
    }

    /**
     * Database-side narrowing for the row scan: per required term "appears
     * somewhere in the scope fields" (substring, case-insensitive). This only
     * ever lets MORE rows through than the PHP checks keep, never fewer:
     *   - must_not is not prefiltered (substring "mail" ≠ whole word "mail");
     *   - on SQLite LIKE ignores case for ASCII letters only, so a term with
     *     other letters (ü, é …) gets no condition there ("Über" vs "über").
     */
    private function likePrefilter(array $t, array $scope_fields): array
    {
        $where = []; $params = [];
        foreach (array_merge($t['must'], $t['wildcards'], $t['phrases']) as $term) {
            [$w, $p] = $this->likeAny($term, $scope_fields, false);
            if ($w) { $where[] = $w; array_push($params, ...$p); }
        }
        // OR lists: the must_any alternatives, and each ~ group's spelling variants
        $orLists = $t['must_any'] ? [$t['must_any']] : [];
        foreach ($t['groups'] as $g) $orLists[] = $g['variants'];
        foreach ($orLists as $list) {
            $or = []; $orParams = [];
            foreach ($list as $term) {
                [$w, $p] = $this->likeAny($term, $scope_fields, false);
                if (!$w) { $or = []; break; }   // one term without condition → no narrowing possible
                $or[] = $w; array_push($orParams, ...$p);
            }
            if ($or) { $where[] = '(' . implode(' OR ', $or) . ')'; array_push($params, ...$orParams); }
        }
        return [$where, $params];
    }

    /**
     * "(f1 LIKE ? OR f2 LIKE ? …)" for one term. $force: also on SQLite with
     * non-ASCII text (used where a missing condition would be wrong, not just
     * slower — the caller then accepts SQLite's case-sensitivity there).
     */
    private function likeAny(string $term, array $fields, bool $force): array
    {
        $term = trim($term);
        if ($term === '') return ['', []];
        if (!$force && $this->db->getDriver() === 'sqlite' && preg_match('/[^\x00-\x7F]/', $term)) {
            return ['', []];
        }
        $like = '%' . WbceSearchWords::likeBody($term) . '%';
        $or = [];
        foreach ($fields as $f) $or[] = "i.`$f` LIKE ? ESCAPE '!'";
        return ['(' . implode(' OR ', $or) . ')', array_fill(0, count($fields), $like)];
    }

    /**
     * Index rows joined with the page's CURRENT state. Visibility and
     * searchability come from {TP}pages, not from the copy stored in the
     * index at indexing time: before 0.4 a page moved to the trash, set to
     * "none" or excluded from search stayed findable until a full rebuild,
     * because the stale index copy still said 'public'.
     * Marker rows (searching = 0, see WbceSearchIndexer) are never returned.
     *
     * $where/$params: extra conditions (prefilter or word-index lookups).
     * $withContent = false leaves the big text column out — the word-index
     * path loads it later for the displayed hits only (hydrate()).
     */
    private function fetchIndexRows(string $lang_filter, array $where = [], array $params = [], bool $withContent = true): array
    {
        [$from, $baseParams] = $this->indexFromWhere($lang_filter, $where, $params);
        return $this->db->fetchAll(
            "SELECT i.`id`, i.`page_id`, i.`section_id`, i.`item_id`, i.`module`,
                    i.`title`, i.`item_title`, i.`description`, i.`keywords`,
                    " . ($withContent ? "i.`content`" : "NULL AS `content`") . ", i.`detail_url`, i.`thumb_url`,
                    p.`visibility`, i.`searching`,
                    p.`viewing_groups`, p.`viewing_users`, p.`link`, p.`language`
             $from",
            $baseParams
        );
    }

    /** Ids of the same rows fetchIndexRows() would return — as a subquery. */
    private function entryIdSql(string $lang_filter, array $where, array $params): array
    {
        [$from, $baseParams] = $this->indexFromWhere($lang_filter, $where, $params);
        return ["SELECT i.`id` $from", $baseParams];
    }

    private function indexFromWhere(string $lang_filter, array $where, array $params): array
    {
        $sql = "FROM `{TP_SEARCH}index` i
             INNER JOIN `{TP}pages` p ON i.page_id = p.page_id
             INNER JOIN `{TP}sections` s ON s.section_id = i.section_id
             WHERE p.`visibility` NOT IN ('none','deleted')
               AND p.`searching` = '1'
               AND i.`searching` = 1
               AND (? = '' OR p.`language` = ? OR p.`language` IS NULL OR p.`language` = '')";
        foreach ($where as $w) $sql .= "\n               AND " . $w;
        return [$sql, array_merge([$lang_filter, $lang_filter], $params)];
    }

    // ── Permission check ───────────────────────────────────────────────────────

    /** Checks whether the current visitor is allowed to view the page (also used by WbceSearchSuggest). */
    public static function userCanView(array $row): bool
    {
        $visibility = $row['visibility'] ?? 'public';

        // Public pages always allowed
        if ($visibility === 'public') return true;

        // Not logged in → no access to private/registered
        if (!isset($_SESSION['USER_ID']) || empty($_SESSION['USER_ID'])) return false;

        // Group check — members of the admin group (1) see everything.
        // ($_SESSION['IS_ADMIN'], checked here before, is never set by WBCE.)
        $user_groups  = array_map('trim', explode(',', (string) ($_SESSION['GROUPS_ID'] ?? '')));
        if (in_array('1', $user_groups, true)) return true;
        $view_groups  = array_filter(explode(',', $row['viewing_groups'] ?? ''));
        $view_users   = array_filter(explode(',', $row['viewing_users'] ?? ''));
        $user_id      = (string)($_SESSION['USER_ID'] ?? '');

        if (!empty($view_users) && in_array($user_id, $view_users)) return true;
        if (!empty($view_groups)) {
            foreach ($user_groups as $gid) {
                if (in_array(trim($gid), $view_groups)) return true;
            }
        }

        // registered = all logged-in users may view
        if ($visibility === 'registered') return true;

        return false;
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function filterWords(array $words): array
    {
        $min = (int)$this->cfg['min_length'];
        return array_values(array_filter($words, function($w) use ($min) {
            return mb_strlen($w) >= $min
                && !in_array(WbceSearchWords::fold($w), $this->stopwords, true);
        }));
    }

    /**
     * Checks if $word appears as a whole word in $haystack. A regex instead of
     * lower-casing both sides: mb_strtolower('İ') is two characters, so
     * positions in the lowered text no longer fit the original; the pattern
     * also pairs the four Turkish i-letters (WbceSearchWords::regex()).
     */
    public function containsWord(string $haystack, string $word): bool
    {
        if ($word === '') return false;
        return (bool) preg_match(
            '/(?<![\p{L}\p{M}\p{N}_])' . WbceSearchWords::regex($word) . '(?![\p{L}\p{M}\p{N}_])/iu',
            $haystack
        );
    }

    private function excerpt(string $text, array $words): string
    {
        $max  = (int)$this->cfg['max_excerpt'];
        $hl   = (bool)$this->cfg['highlight'];
        $tag  = htmlspecialchars($this->cfg['highlight_tag'], ENT_QUOTES, 'UTF-8');

        $plain = preg_replace('/\s+/', ' ', trim(strip_tags(html_entity_decode($text, ENT_QUOTES, 'UTF-8'))));
        if (empty($words) || $max === 0) return '';

        $pos = false;
        foreach ($words as $word) {
            $p = WbceSearchWords::ipos($plain, $word);
            if ($p !== false) { $pos = $p; break; }
        }

        if ($pos !== false) {
            $start   = max(0, $pos - 40);
            $excerpt = mb_substr($plain, $start, $max);
            if ($start > 0) $excerpt = '…' . $excerpt;
            if (mb_strlen($plain) > $start + $max) $excerpt .= '…';
        } else {
            $excerpt = mb_substr($plain, 0, $max) . (mb_strlen($plain) > $max ? '…' : '');
        }

        // The layout prints the excerpt with |raw (it carries the <mark>s), so
        // the text itself must be escaped here — strip_tags() above is no
        // escape: "a < b" or a decoded "&lt;…" fragment would reach the page
        // as markup.
        $excerpt = htmlspecialchars($excerpt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        if (!$hl) return $excerpt;

        $alts = [];
        foreach ($words as $word) {
            $w = htmlspecialchars((string) $word, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            if ($w !== '') $alts[] = WbceSearchWords::regex($w);
        }
        if (!$alts) return $excerpt;
        usort($alts, fn(string $a, string $b): int => strlen($b) <=> strlen($a));

        // One pass, entities skipped: per-word passes used to mark inside
        // "&amp;" or inside the tag name of an earlier <mark> (term "mark").
        return preg_replace_callback(
            '/(&#?[a-z0-9]+;)|(' . implode('|', $alts) . ')/ui',
            static fn(array $m): string => $m[1] !== '' ? $m[1] : '<' . $tag . '>' . $m[2] . '</' . $tag . '>',
            $excerpt
        ) ?? $excerpt;
    }
}
