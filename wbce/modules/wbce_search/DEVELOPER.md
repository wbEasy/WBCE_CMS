# DEVELOPER — wbce_search technical documentation

**Version:** 0.6.1 | **PHP:** 8.1+ | **DB:** MariaDB/MySQL or SQLite (PDO)

---

## Architecture

```
wbce_search/
├── classes/                  — every class, loaded by the core autoloader
│   ├── WbceSearchBackend.php     — controller: views, operations, HTMX fragments
│   ├── WbceSearchSettings.php    — settings schema (defaults, types, ranges)
│   ├── WbceSearchModules.php     — module list + semi-config (read/validate/store)
│   ├── WbceSearchIcons.php       — Twig function icon() (Tabler SVGs)
│   ├── WbceSearch.php            — search engine (parser, scoring, excerpts, permissions)
│   ├── WbceSearchSuggest.php     — live-search suggestions
│   ├── WbceSearchStats.php       — search statistics + tag-cloud data
│   ├── WbceSearchHighlighter.php — marks the terms on a page opened from a hit
│   ├── WbceSearchLayouts.php     — layout/stylesheet picks, tag-cloud rendering
│   ├── WbceSearchWords.php       — word index (large sites)
│   ├── WbceSearchFuzzy.php       — typo tolerance (~ operator)
│   ├── WbceSearchStopwords.php   — stop words of the site's page languages
│   ├── WbceSearchIndexer.php     — indexer: rebuild / smart / lazy, definitions, callbacks
│   └── WbceSearchPage.php        — results page + live-search endpoint (layout data)
├── tool.php                  — AdminTool entry (thin: assets, Twig, Backend::run())
├── search_page.php           — frontend dispatcher for /search/ (thin)
├── search_output.php         — PAGE_CONTENT output
├── initialize.php            — every request: registers classes/ with the autoloader
├── initialize_fe.php         — frontend only: live search, jump to the first hit
├── ajax_save_layout.php      — layout editor AJAX save (IDKEY)
├── guide_popup.php           — module guide in its own window
├── droplet.php               — tag cloud droplet
├── install.php / upgrade.php / uninstall.php
├── install_struct.sql        — table DDL (MySQL syntax, importSql() adapts it for SQLite)
├── assets/
│   ├── backend.css           — admin tool styles (auto-loaded by the core)
│   ├── backend.js            — filters, help dialog, guide window
│   ├── fe_search.css         — search page, live search, tag cloud (frontend)
│   ├── fe_search.js          — live search (suggestions while typing)
│   ├── fe_search_suggest.css — live-search dropdown, light + dark, template-proof
│   └── fe_search_jump.js     — scroll to the first highlight on a hit's page
├── twig/
│   ├── _shell.twig           — #wss-view swap target
│   ├── _nav.twig             — tabs on top (cp-tabs)
│   ├── _nav_vertical.twig    — icon sidebar
│   ├── content/              — overview, modules, layout, settings, stats
│   └── partials/             — page_header, semi_panel, semi_columns, semi_join
├── module_defs/              — per-module index definitions (+ guides/)
├── SEARCH_INDEX_HOWTO.md     — for module authors: shipping a search_index.php
└── layouts/
    ├── search_default.htt    — default layout (do not modify)
    └── search_custom.htt     — custom layout (optional)
```

No file of the module requires a class: `initialize.php` registers
`classes/` with the core autoloader (`WbAuto::AddDir()`), on every request.
Exception: `install.php` runs before the module is registered in
`{TP}addons`, so the core has not run its `initialize.php` yet —
`install.php` registers the folder itself (`upgrade.php` includes it).

`install.php` holds every install step, each repeatable (tables `IF NOT
EXISTS`, settings: missing keys only, droplet: code refreshed);
`upgrade.php` removes leftovers of older versions, includes `install.php`
and adds the upgrade-only steps. `uninstall.php` is empty: a core module is
never uninstalled.

---

## Database

Three tables: `{TP}mod_search_index`, `{TP}mod_search_words`,
`{TP}mod_search_stats`. The module's code writes them as `{TP_SEARCH}index`,
`{TP_SEARCH}words`, `{TP_SEARCH}stats` — `initialize.php` (every request) and
`install.php` register the placeholder with
`$database->addPrefix('{TP_SEARCH}', TABLE_PREFIX . 'mod_search_')`.

### {TP}mod_search_index

| Column      | Type               | Description                                    |
| ----------- | ------------------ | ---------------------------------------------- |
| id          | INT AUTO_INCREMENT | Primary key                                    |
| page_id     | INT                | WBCE page ID                                   |
| section_id  | INT                | WBCE section ID                                |
| item_id     | INT                | Item ID (multi mode)                           |
| module      | VARCHAR(100)       | Module name                                    |
| title       | TEXT               | Page title                                     |
| item_title  | TEXT               | Module-specific title                          |
| description | TEXT               | Page description                               |
| keywords    | TEXT               | Page keywords                                  |
| content     | MEDIUMTEXT         | Indexed full text                              |
| detail_url  | VARCHAR(500)       | Direct link                                    |
| thumb_url   | VARCHAR(500)       | Preview image URL                              |
| visibility  | VARCHAR(50)        | Copy at indexing time (informational)          |
| searching   | TINYINT(1)         | 1 = hit, 0 = marker "processed, nothing found" |
| indexed_at  | INT                | Unix timestamp                                 |
| tokenized   | TINYINT(1)         | 1 = words are in the word index                |

**Visibility:** the search always checks the *current* state in
`{TP}pages` (`visibility`, `searching`, groups), not the copy in the index.

**Marker rows:** a section without indexable content gets a row with
`searching = 0`. It is never found but counts as indexed — otherwise the
section would stay stale forever.

**URLs (0.5.1):** `detail_url` and `thumb_url` store `{SYSVAR:WB_URL}` in
place of the site URL (`WbceSearch::URL_TOKEN`, the same token wysiwyg and
the output filter dashboard use), so the index keeps working after a move to
another domain or folder without a rebuild. `WbceSearch::urlToToken()` /
`urlFromToken()` convert; the output resolves the token, absolute URLs pass
through unchanged.

---

## WbceSearch class

```php
$engine = new WbceSearch($database);

$parsed  = $engine->parseQuery('mustard organic -hot "from corn"');
$results = $engine->searchParsed($parsed);

$parsed['scope']    = ['title'];       // title only
$parsed['must_any'] = $parsed['must']; // OR mode
$parsed['must']     = [];

$hit         = $engine->prepareResult($result, $page_info, $search_string);

// Live search: only pages the visitor may see; pages + module items,
// each with title/description/snippet/url/thumb
$suggest     = new WbceSearchSuggest($database);
$suggestions = $suggest->suggest('sea', 5, 'hybrid'); // 'hybrid' | 'title' | 'fulltext'

// Statistics + tag cloud
$stats = new WbceSearchStats($database);
$stats->trackSearch(['mustard', 'organic']);
$tags  = $stats->getTagCloud();             // term, count, size (1–5)
echo WbceSearchLayouts::renderTagCloud($tags); // in the picked tagcloud layout
```

### parseQuery()

| Input      | Array key           |
| ---------- | ------------------- |
| `word`     | must[]              |
| `-word`    | must_not[]          |
| `"phrase"` | phrase[]            |
| `word*`    | wildcard[] (prefix) |
| `word~`    | fuzzy[] (typos)     |

`WbceSearchPage` also maps `match=any` (standard search form) to OR
mode and `match=exact` to a phrase.

### Typo tolerance (`WbceSearchFuzzy`)

- `word~` becomes a group of spelling variants within a Levenshtein
  distance of 0 (≤ 4 letters), 1 (5–7) or 2 (≥ 8); at least one variant must
  occur. The typed word scores full weight, a variant half. In OR mode the
  variants join the alternatives. Excluded from the public tag cloud.
- `didYouMean($parsed, $query)` replaces unknown words (from 4 letters, one
  typo allowed even for short words) by the closest, most frequent known
  word; the dispatcher only shows it when the corrected query finds hits.
- Vocabulary = words of **public** searchable pages only (no word of a
  private/members page may leak through a suggestion), cached in
  `var/wbce_search/vocab.ser`. Small sites rebuild it on demand (max. hourly),
  large sites (word index in use) only in the admin Rebuild/Update — a visitor
  request never scans the word table. Admin index operations invalidate it.
- Distance per character: non-ASCII characters are mapped to spare bytes so
  PHP's byte-based `levenshtein()` can be used ("müller"/"muller" = 1).
- Measured at 5 000 entries: vocabulary 20 000 words / 1.4 MB, build 0.9 s
  (from text) / 7 s (word index); `~` query 5–150 ms; "did you mean" 3–5 ms.

---

## module_defs API

### Standard definition

```php
return [
    'table'       => 'mod_bakery_items',
    'id_field'    => 'section_id',   // WBCE anchor: must hold the section ID
    'item_key'    => 'item_id',      // one entry per item (multi mode)
    'title'       => 'title',
    'fields'      => ['description', 'full_desc'],
    'link'        => 'link',
    'link_prefix' => 'bakery',
    'image'       => null,
    'image_path'  => null,
    'mode'        => 'multi',
    'index_base'  => 'page',
    'filter'      => ['active' => 1],
    'joins'       => [...],
];
```

### Callback definition

```php
return [
    'table'      => 'mod_oneforall_items',
    'id_field'   => 'section_id',
    'callback'   => [WbceSearchIndexer::class, 'indexOneforall'],
    'mode'       => 'multi',
    'index_base' => 'page',
];
```

`callback` is anything callable: a closure (what a module's own
`search_index.php` usually returns), `[Class::class, 'method']` or a function
name. Signature:

```php
function (
    $database, array $def, array $section,
    int $pid, int $sid, string $module,
    string $page_title, string $description, string $keywords,
    string $visibility, int $searching, int $now
): int
```

Return value: number of indexed entries. A callback may hand (part of) its
work to the table-definition indexer:
`(new WbceSearchIndexer($database))->indexByDef($def, $section, $pid, …)` —
the same arguments without `$database`.

A `callback` that is set but cannot be called is an error, not a fallback:
the section gets no entries (only a marker) and the log a line "callback is
not callable: …". Indexing it by `table` instead would hide a typo.

### Join definition

```php
'joins' => [
    [
        'table'      => 'mod_bakery_images',
        'type'       => 'LEFT',
        'on_main'    => 'item_id',
        'on_join'    => 'item_id',
        'fields'     => [],
        'image'      => 'filename',
        'image_path' => 'bakery/thumbs/item{item_id}/',
    ],
],
```

Semi-configs from the admin tool are validated server-side: main table
only `mod_*` with `section_id`, join tables only `mod_*`, every column must
exist in its table.

---

## Module-provided definitions

A module can describe its own indexing by shipping
`modules/<module>/search_index.php`. It returns the same array as a module_defs
file (table definition or `callback`, a closure there). **How to write one, for
module authors: [SEARCH_INDEX_HOWTO.md](SEARCH_INDEX_HOWTO.md)** — worked
example `modules/news_img/search_index.php`.

Lookup order per module (`indexSection()`): the module's own `search_index.php`
> admin semi-config > `module_defs/MODULE.php` > alias. The module's file wins
because the module knows its data rules (drafts, groups, rights), and the admin
tool shows such a module as "From module" without a semi-config editor
(`WbceSearchIndexer::hasOwnDef()`). The file is only read by wbce_search.

Internals a callback relies on:

- `indexSection()` deletes the section's rows (and their word-index rows)
  before calling it; a callback that throws is logged and the section skipped.
- A callback that inserts nothing returns 0 — the indexer then stores a
  marker row for the section.
- The placeholder `{TP_SEARCH}` is registered whenever the indexer runs.
- Stale sections are found by the **page's** `modified_when` (newer than the
  section's `indexed_at`); `Wbce::touchSection()` bumps section and page.
- Absolute `detail_url`/`thumb_url` are converted to the URL token after each
  run (`WbceSearchIndexer::tokenizeUrls()`), so `urlToToken()` in a callback
  is good practice, not a requirement.
- `WbceSearchIndexer::plainText()` is public for callbacks.

A row with `item_id > 0` and an `item_title` is a module item (catalogue entry,
news post …). Live suggestions list such items on their own: item title, the
page title as context line, `detail_url` (or the page) as link and `thumb_url`
as picture (setting "Images in suggestions").

---

## Search page and the "Search" setting

WBCE Search is a **core module** (`$core = true` in `info.php`, cannot be
uninstalled, `uninstall.php` is empty) and the only search: `search/index.php`
(core) always includes `search_page.php`. The legacy search engine
(`search/search.php` & co.) and the former switch `use_search_tool` are gone;
`upgrade.php` deletes the setting.

The core's **"Search" setting** (Settings → `search`, constant `SEARCH`)
decides who may search — checked first, before any class or module setting
is loaded:

| `SEARCH`               | Search page, live search, tag cloud droplet, jump |
| ---------------------- | ------------------------------------------------- |
| `public`               | everyone                                          |
| `private`/`registered` | logged-in users only (guests: "Search disabled")  |
| `none`                 | nobody; frontend pages do not even load classes   |

The core turns it into the constant SHOW_SEARCH in `framework/initialize.php`
— before the module initialize files run — so the module only reads that
constant: wherever it is false, a frontend page registers no class and
loads no asset of the module.
Order of the checks everywhere: `SEARCH` (i.e. SHOW_SEARCH) → module
settings.

**Hit highlighting:** when a visitor opens a hit (`?searchresult=1&sstring=…`,
built by `WbceSearch::withHighlight()`), `framework/TemplateBlocks.php` marks
the terms in every section via
`WbceSearchHighlighter::fromRequest()?->apply($html)` — only while the visitor
may search (the class is not registered otherwise). Case is folded by PCRE
(`/iu`); real spelling variants are added per page language (DE ä/ae, ö/oe,
ü/ue, ß/ss; TR i/İ, ı/I). The old core function `search_highlight()` only
delegates to this class now (deprecated).

---

## Results page and layouts

`search_page.php` only loads the language file, answers the live
search (`?ws_ajax=1`) and hands the request to `WbceSearchPage::render()`:
read input → lazy reindex → search → group the hits (one result per page and
kind of match, one per module item) → "did you mean" / tracking → paginate →
layout data → the layout picked in the Layout tab (`WbceSearchLayouts`) is
parsed with the LayoutParser.

The layout gets data only — no HTML built in PHP. A result's matching
sections are a list the layout loops over (nested loop, LayoutParser 2.1):

```
{foreach RESULTS as R}
  <a href="[R.PAGE_LINK]">[R.PAGE_TITLE]</a>
  {foreach R.SECTIONS as S}
    {if S.THUMB_URL}<img src="[S.THUMB_URL]" alt="[S.TITLE]">{/if}
    {if S.ITEM_TITLE and S.LINK}<a href="[S.LINK]">[S.ITEM_TITLE]</a>{/if}
    {if S.EXCERPT}<p>[S.EXCERPT|raw]</p>{/if}
  {/foreach}
{else}
  <p>[TEXT.NO_RESULTS]</p>
{/foreach}
```

| Key                                                 | Content                                                                |
| --------------------------------------------------- | ---------------------------------------------------------------------- |
| `SEARCH_STRING`                                     | the query as entered                                                   |
| `RESULTS`                                           | results of the current page (empty: nothing found)                     |
| `R.PAGE_TITLE`, `R.PAGE_LINK`                       | the page of the result (link with highlight parameters)                |
| `R.LINK`, `R.TITLE`, `R.EXCERPT`                    | first section: its target (module detail URL if any), title, excerpt   |
| `R.META_LABEL`                                      | where the terms were found ("Content & Keyword" …)                     |
| `R.MATCH_TYPE`                                      | `fulltext`, `meta` (title/keywords/description only) or `multi` (item) |
| `R.IS_META`, `R.IS_FULLTEXT`, `R.IS_MULTI`          | `"1"` / `""` for `{if}`                                                |
| `R.SECTIONS`                                        | matching sections; empty for a `meta` result (show `R.EXCERPT`)        |
| `S.LINK`, `S.TITLE`, `S.THUMB_URL`                  | per section: target, title, thumbnail (may be empty)                   |
| `S.ITEM_TITLE`                                      | module item title (plain text, like every key)                         |
| `S.EXCERPT` / `R.EXCERPT`                           | excerpt with `<mark>`, already escaped → `\|raw`                       |
| `TOTAL`, `TOTAL_TEXT`                               | number of results / "5 results" in the right plural form               |
| `PAGES`, `PREV_URL`, `NEXT_URL`                     | pagination                                                             |
| `PAGE_LINKS` → `PL.NUM`, `PL.URL`, `PL.CURRENT`     | page numbers; `URL` empty = gap ("…"), `CURRENT` true = this page      |
| `TAGCLOUD`                                          | tag cloud as HTML (`tagcloud` layout) → `\|raw`; empty when off        |
| `DID_YOU_MEAN`, `DID_YOU_MEAN_URL`                  | spelling suggestion when nothing was found                             |
| `SUGGESTION_AREAS` → `AREA.TITLE`, `AREA.URL`       | top-level pages offered when nothing was found                         |
| `DEBUG_MODE`, `R.DEBUG_*`                           | debug boxes (setting on + administrator)                               |
| `TEXT.*`                                            | every text of the language file                                        |

Lists are tested directly — `{if RESULTS}`, `{if TAGCLOUD}`,
`{if DID_YOU_MEAN}` — there are no `HAS_*` flags.

---

## Admin tool

Same structure as `modules/WbceAnalytics`: `_shell.twig` with the swap
target `#wss-view`, nav links via `hx-get` + `hx-push-url`. `info.php` puts
the runner into `no_page` mode for HTMX requests so only the fragment is
returned.

| Request                               | Response                                    |
| ------------------------------------- | ------------------------------------------- |
| `GET ?action=<view>`                  | full page (shell + view)                    |
| `GET ?action=<view>` + HX-Request     | view only                                   |
| `GET ?action=modules&partial=semi`    | semi-config editor for one module           |
| `GET …&partial=semi_cols / join_cols` | column blocks after a table change          |
| `POST ?action=<view>` with `op=…`     | operation (FTAN-checked), then view + toast |

Views: `overview`, `modules`, `layout`, `settings`, `stats`. `layout` is
always a full page load (not HTMX) because `CodeEditor::init()` queues its
assets via `I::`.

Settings: add new values to `WbceSearchSettings::SCHEMA` (group, type,
default, range) plus the language keys `SET_<NAME>`, `SET_<NAME>_HINT`
(for enums also `OPT_<NAME>_<VALUE>`) — the form is generated from it.

Storage (since 0.6.1): two JSON values in the core's `{TP}settings`, which
the core loads once per request — reading a setting costs no query (the
table `{TP}mod_wbce_search_cfg` was read on every search and every frontend
page). Only `WbceSearchSettings` knows where they are:

| Settings key   | Content                                                                                           | Written by                     |
| -------------- | ------------------------------------------------------------------------------------------------- | ------------------------------ |
| `search_cfg`   | SCHEMA values, `custom_modules` (semi-configs), `layout_search`, `layout_tagcloud`, `stylesheet`  | admin tool (`set()`, `save()`) |
| `search_state` | `stopword_languages`                                                                              | indexer (`setState()`)         |

Two keys because each write stores the whole JSON: the lazy reindex writes
the state inside a visitor's request and must not overwrite an admin's
save at the same moment (or the other way round). `seed()` (install,
upgrade) adds missing keys with their defaults and drops unknown ones.

`getTwig()` runs with `autoescape = false`: every data value in a template
needs `|e` or `|e('html_attr')`.

---

## Search modes (0.5)

`WbceSearch::searchParsed()` picks one of two paths per query:

- **Row search** (`matchViaRows`) — small sites. The database pre-filters with
  one `LIKE` per required term (only ever lets *more* rows through than the
  PHP checks keep: no prefilter for exclusions; on SQLite none for non-ASCII
  terms, its `LIKE` ignores case for ASCII only). PHP then checks whole
  words, prefixes, phrases and exclusions as before.
- **Word index** (`matchViaWords`) — large sites. `{TP}mod_search_words`
  holds one row per (word, entry, field); field codes in
  `WbceSearchWords::FIELDS`. Required terms become `id IN (SELECT entry_id …
  WHERE word = ?)`, `senf*` a range `word >= 'senf' AND word < 'senf'+U+10FFFF`
  (uses the primary key on both drivers). Rows come without `content`;
  `hydrate()` loads the text for the displayed page only.

The word index is used only when `WbceSearchWords::usable()`: setting
`word_index` (auto/on/off, auto = from `word_index_threshold` entries) **and**
no searchable entry with `tokenized = 0`. Tokenising happens outside the
indexer on purpose: admin Rebuild/Update (`backfill()` with a 20 s budget,
then `ANALYZE TABLE` on MySQL), the lazy reindex (sections it just re-indexed
+ 25 pending), and "Continue building" on the overview. Index rows of a
re-indexed section get new ids, their word rows are removed first
(`deleteSection()`); leftovers are harmless (the lookup joins the index) and
pruned on Rebuild/Update.

Tokens = runs of letters, marks, digits and `_`, lower-cased, stop words
skipped, cut at 64 characters — the same word boundaries as
`containsWord()`. The `word` column is `utf8mb4_bin`: with the `_ci` default
"o" and "ö" collide in the primary key.

**Stop words** come from the language files: `$SEARCH['STOPWORDS']`, a list
of the language's most frequent filler words, lower case (EN, DE, PL ship
one; a new translation adds its own). The site uses the lists of the
languages its searchable pages are written in — not the visitor's or the
admin's language — because index and search must agree: a word left out of
the word index but kept in a query would find nothing. Every indexer run
stores those languages as state `stopword_languages` ("DE", "DE,EN");
`WbceSearch` reads it with the rest of its settings (no extra query). When the
set changes, the indexer re-tokenises the word index (`clear()`); until the
backlog is done the search reads the text, so results stay correct. A page
language without a module language file simply has no stop words.

**Searches without results** are stored by `trackMiss()` as the whole query
in `{TP}mod_search_stats` with `count = 0, misses = n`; the tag cloud
only shows `count >= 1`.

---

## Database portability

All SQL runs on MySQL/MariaDB and SQLite. Schema access goes through the
core helpers `Database::tableExists()`, `listTables()`, `listColumns()`
(normalised base types) and `groupConcat()`; tables are created from
`install_struct.sql` via `Database::importSql()`. Avoid `INFORMATION_SCHEMA`,
`SHOW …`, `ON DUPLICATE KEY`, `INSERT IGNORE`, `TRUNCATE` and
`GROUP_CONCAT … SEPARATOR` in this module.

---

## Guides

Module-specific guides in `module_defs/guides/MODULE.md` (per language
`MODULE_DE.md`). The button appears in the semi-config editor when the file
exists and opens `guide_popup.php` (admin tool access required).

---

## Known limitations

- MD Viewer: only md_source_type = 'internal' is indexed
- Joins: max. 3 per module
- EventCalendar, Blog and others have no definition yet — they only
  contribute their page title (CatalogueHub ships its own `search_index.php`)
- **No jump target per item when a module has no detail pages** (e.g.
  CatalogueHub with `use_detail` off — a list without sub-pages). Every item
  of such a page links to the page itself; the highlight + `fe_search_jump.js` then
  scroll to the FIRST occurrence of the typed word, which is not necessarily
  the item that was clicked. If the item's matching text is not rendered in
  the list at all (only in a lightbox, or a field the layout leaves out),
  there is nothing to highlight and the page opens at the top. A fix needs a
  universal anchor convention every list-rendering module/layout follows
  (`#item-<id>`-style, written into `detail_url`; `fe_search_jump.js` already leaves a
  URL with `#…` to the browser) — deliberately deferred to a later version.
- No picture for plain pages in suggestions/results: only module items carry
  a `thumb_url`. A per-page image (page settings, doubling as `og:image`) is
  planned for 2.x.
- Row search (below the word-index threshold, or while the word index is
  still being built): a very common term loads most of the index into PHP
  — at ~20 000 entries that exceeds 128 MB. The word index removes this.
- SQLite: the inline indexes of `install_struct.sql` are dropped by
  `importSql()`; `install.php` creates the ones lookups depend on
  (`section_id`, `tokenized`, words `entry_id`)

---

## When semi-config, when callback?

| Situation                     | Recommendation     |
| ----------------------------- | ------------------ |
| Data in DB, simple structure  | Semi-config        |
| Data in DB, joins needed      | Semi-config + join |
| More than 3 joins             | Callback           |
| Data in files (Markdown, XML) | Callback           |
| Custom URL logic              | Callback           |

**Rule of thumb:** Try semi-config first. Callback only when necessary.
