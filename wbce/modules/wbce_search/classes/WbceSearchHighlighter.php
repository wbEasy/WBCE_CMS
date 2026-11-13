<?php
/**
 * wbce_search — WbceSearchHighlighter
 *
 * Marks the search terms on a page opened from a search hit
 * (?searchresult=1&sstring=…, the links WbceSearch::withHighlight() builds):
 * every term in the section content gets <span class="highlight">…</span>.
 *
 *   WbceSearchHighlighter::fromRequest()?->apply($html)   (framework/TemplateBlocks.php)
 *   search_highlight($html, $terms)                        (legacy core function, delegates here)
 *
 * Moved here from framework/frontend.functions.php (search_highlight()) and
 * search/search_convert.php. Case is folded by PCRE itself (/iu); only real
 * spelling equivalents are added per page language — German ä/ae, ö/oe,
 * ü/ue, ß/ss and Turkish i/İ, ı/I. The old search_convert_ul.php table
 * (1 450 lines of upper/lower pairs) was only used by the removed legacy
 * search engine, and search_convert_local.php existed nowhere.
 *
 * Only registered while the visitor may search (initialize.php,
 * SHOW_SEARCH) — with the search off nothing is highlighted.
 *
 * @module wbce_search  @license GNU General Public License
 */

defined('WB_PATH') or die('No direct access');

final class WbceSearchHighlighter
{
    /** Spelling equivalents per language: a term containing a key also matches each listed form. */
    private const EQUIVALENTS = [
        'DE' => [
            'ß' => ['ß', 'ss'], 'ss' => ['ß', 'ss'],
            'ä' => ['ä', 'ae'], 'ae' => ['ä', 'ae'],
            'ö' => ['ö', 'oe'], 'oe' => ['ö', 'oe'],
            'ü' => ['ü', 'ue'], 'ue' => ['ü', 'ue'],
            'Ä' => ['Ä', 'Ae'], 'Ae' => ['Ä', 'Ae'],
            'Ö' => ['Ö', 'Oe'], 'Oe' => ['Ö', 'Oe'],
            'Ü' => ['Ü', 'Ue'], 'Ue' => ['Ü', 'Ue'],
        ],
        // All four i-letters as one — like the search itself (WbceSearchWords::fold()).
        'TR' => [
            'i' => ['i', 'ı', 'İ'], 'ı' => ['ı', 'i', 'I'],
            'I' => ['I', 'ı', 'İ'], 'İ' => ['İ', 'i', 'I'],
        ],
    ];

    /** @param list<string> $terms non-empty search terms */
    private function __construct(private array $terms)
    {
    }

    /**
     * From the request of a page opened from a search hit; null when the
     * page was not opened that way, ?nohighlight is set, or no term is left.
     * Terms are split at whitespace and need 2+ characters; searchresult=2
     * (exact phrase) joins the first term's underscores back to spaces.
     */
    public static function fromRequest(?array $get = null): ?self
    {
        $get ??= $_GET;
        if (!isset($get['searchresult']) || !is_numeric($get['searchresult'])
            || isset($get['nohighlight']) || empty($get['sstring']) || !is_string($get['sstring'])) {
            return null;
        }
        $terms = array_values(array_filter(
            preg_split('/\s+/u', trim($get['sstring'])) ?: [],
            fn ($t) => mb_strlen($t) >= 2
        ));
        if ($terms !== [] && (int) $get['searchresult'] === 2) {
            $terms[0] = str_replace('_', ' ', $terms[0]);
        }
        return self::forTerms($terms);
    }

    /** For given terms (empty ones are dropped); null when none is left. */
    public static function forTerms(array $terms): ?self
    {
        $terms = array_values(array_filter(array_map('strval', $terms), fn ($t) => $t !== ''));
        return $terms === [] ? null : new self($terms);
    }

    /**
     * Wraps every occurrence of the terms in text — never inside tags,
     * <style>, <script>, <svg>, <pre>, <code>, comments, droplet calls or
     * e-mail addresses.
     */
    public function apply(string $html): string
    {
        require_once WB_PATH . '/framework/functions.php';   // entities_to_umlauts() & co.
        $html    = entities_to_umlauts($html, 'UTF-8');
        $pattern = $this->pattern();

        // An HTML tag is "<", then unquoted characters or whole quoted
        // attribute values, then ">" — so <input value="<b>x</b>"> stays one
        // tag. Atomic/possessive on purpose: a nested (?:[^<]|<.*>)* gave up
        // with "backtrack limit exhausted" on rich markup and the page was
        // shown without any highlight. <svg> is cut away whole: a <span>
        // inside an SVG <text> is no SVG element.
        $parts = preg_split(
            "~(\[\[.*\]\]|<style.*</style>|<script.*</script>|<svg.*</svg>|<pre.*</pre>|<code.*</code>|<!--.*-->"
            . "|<(?>[^<>\"']++|\"[^\"]*+\"|'[^']*+')*+>|\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,8}\b)~iUs",
            $html,
            -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );
        if (is_array($parts) && $parts !== []) {
            $html = '';
            foreach ($parts as $part) {
                if ($part[0] !== '<'
                    && !preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,8}$/i', $part)
                    && !preg_match('~\[\[.*\]\]~', $part)) {
                    $part = str_replace(['&lt;', '&gt;', '&amp;', '&quot;', '&#039;', '&nbsp;'], ['<', '>', '&', '"', "'", "\xC2\xA0"], $part);
                    $part = preg_replace('~(' . $pattern . ')~ui', "\x01$1\x02", $part) ?? $part;
                    // Re-escape the decoded text: text shown escaped on the page
                    // (&lt;img onerror=…&gt; in a post) must not become live HTML
                    // for anyone opening it with ?sstring=… (XSS). double_encode
                    // off keeps entities the decode did not touch (&copy; …).
                    $part = htmlspecialchars($part, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', false);
                    $part = str_replace(["\x01", "\x02"], ['<span class="highlight">', '</span>'], $part);
                }
                $html .= $part;
            }
        }
        if (defined('DEFAULT_CHARSET') && strtolower((string) DEFAULT_CHARSET) !== 'utf-8') {
            $html = umlauts_to_entities($html, 'UTF-8');
        }
        return $html;
    }

    /** Alternation of the quoted terms, with the page language's spelling equivalents. */
    private function pattern(): string
    {
        $map = [];
        foreach (self::EQUIVALENTS[defined('LANGUAGE') ? LANGUAGE : ''] ?? [] as $key => $forms) {
            $map[preg_quote($key, '~')] = '(?:' . implode('|', array_map(fn ($f) => preg_quote($f, '~'), $forms)) . ')';
        }
        // strtr(): one pass, longest key first — "ss" is not rewritten again
        // inside the group "ß" already produced.
        return implode('|', array_map(fn ($t) => strtr(preg_quote($t, '~'), $map), $this->terms));
    }
}
