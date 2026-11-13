# CHANGELOG — wbce_search

## 0.6.1 (2026-11-09) — Christian M. Stefan

Results page rebuilt on the extended LayoutParser (nested loops); the
indexer is a class.

### Added
- WBCE Search is the only search and a core module (`$core = true`, cannot
  be uninstalled; `uninstall.php` is empty with a note). `search/index.php`
  (core) always hands /search/ to it — the setting `use_search_tool` and the
  overview's "WBCE Search" switch are gone (`upgrade.php` deletes the
  setting), and so is the legacy engine (`search/search.php`,
  `search_modext.php`, `search_convert.php`, `search_convert_ul.php`;
  listed in the core's `update_remove_list.txt`). Whether the search runs is
  decided by the core's "Search" setting alone.
- `WbceSearchHighlighter`: the hit highlighting on target pages
  (`?searchresult=1&sstring=…`), moved here from the core
  (`search_highlight()` + `search/search_convert*.php`). Called from
  `framework/TemplateBlocks.php`; only active while the visitor may search.
  Output identical to the old function (compared for EN and DE, incl. the
  German spelling variants and the XSS re-escape); the 1 450-line case table
  is replaced by PCRE's `/iu`. `search_highlight()` stays as a deprecated
  delegate.
- Settings → Result display: "Search page template" — the frontend template
  /search/ is shown in ('' = the website's default), stored in
  `search_cfg` (`page_template`, type `template`: only an installed
  frontend template is accepted). The dispatcher defines `TEMPLATE` with it;
  `search/index.php` no longer defines it a second time. (The core's own
  "search template" setting has never taken effect in 1.7.0: it is saved
  to `{TP}search` but read from `{TP}settings`.)
- `SEARCH_INDEX_HOWTO.md`: how a module makes itself searchable with its
  own `search_index.php` — table definition or callback, what goes into an
  index row, rights and drafts, keeping the index current, testing. Worked
  example: News with Images, which now ships its `search_index.php`.
  `WbceSearchIndexer::plainText()` is public for such callbacks.

### Changed
- A module's own `search_index.php` takes precedence over a saved
  semi-config (semi-config still beats `module_defs/`). The admin tool shows
  such a module as "From module" and offers no semi-config editor — a
  semi-config saved earlier used to keep winning, invisible and
  undeletable.
- `module_defs/news_img.php` and its guides are gone: News with Images
  (5.0.37) ships its own `search_index.php`, which also leaves out posts of
  inactive groups (as the page does) and indexes `content_block2`. The
  `nwi_anywhere` alias had no effect — its sections have no posts.
- Tables renamed `{TP}mod_wbce_search_*` → `{TP}mod_search_*` (`index`,
  `words`, `stats`). In code they are written `{TP_SEARCH}index` etc.; the
  placeholder is registered in `initialize.php` and `install.php`
  (`$database->addPrefix()`). The `search_index.php` of CatalogueHub and VES
  write to `{TP_SEARCH}index`. No upgrade step renames old tables — the
  module was never released under the old names.
- Layout tab rebuilt (new class `WbceSearchLayouts`). Three cards:
  search results page, tag cloud, stylesheet. Per layout the files are
  listed as radios — own copy (`layouts/<x>_custom.htt`), the search
  template's `templates/<tpl>/search/<x>.htt` (read only), the shipped
  `layouts/<x>_default.htt` (read only); a pick saves at once, nothing
  picked → the first existing one. The editor opens only on "Edit": on the
  own copy directly; on the template's or the shipped file after a confirm
  that copies it to `<x>_custom.htt` (overwriting an existing own copy is
  confirmed separately). Editor buttons: Back (left), Save, Save & back
  (right; "Save & back" also works with AjaxSave ticked). The own copy can
  be deleted (was: renamed to `.bak` by "Reset"). Stylesheet: an own copy
  `layouts/fe_search_custom.css`, any `.css` in the search template's
  `search/` folder, the shipped `fe_search.css`, or none — loaded for the
  results page and the tag cloud. Stylesheets are edited the same way as
  layouts: "Edit" on the shipped or a template stylesheet copies it to
  `fe_search_custom.css` (after a confirm) and opens the editor; the live
  search's `fe_search_suggest.css` stays. The tag cloud's default layout
  moved to `layouts/tagcloud_default.htt`. Settings keys `layout_search`,
  `layout_tagcloud`, `stylesheet` replace `layout_file`.
- Droplet `[[wbce_search_tagcloud]]`: the HTML is a LayoutParser layout
  file, `templates/systemplates/search/tagcloud.htt`; a template overrides
  it with its own `search/tagcloud.htt` (the search page template from
  Settings → Result display, else the website's default template). The
  droplet code only prepares the data and calls the core's new
  `LayoutParser::parseFile()` (reads .htt files inside the installation
  only — droplets may not read files themselves). The layout loads its CSS
  itself (`{insertCssFile "{MODULES}/wbce_search/assets/fe_search.css"}`,
  new in the core's LayoutParser), so an override can bring its own or
  none. Output unchanged (compared for six parameter sets). The parser
  escapes every placeholder, so the hand-written `htmlspecialchars()` calls
  with differing flags are gone. Texts come through `Lang::loadLanguage()`
  instead of an `include` of the language file — CodeVet blocks `include`
  in droplets, so the droplet showed as blocked in the Droplets admin.
- Overview reworked to show only what the admin can act on. The search
  index panel has the last index time in its head, the three actions one
  below the other with a description each (icons; a spinner while one
  runs, all three locked meanwhile; "Clear index" outlined in red), and an
  "Up to date" bar with one sentence ("The index is up to date — all 34
  sections …" / "5 of 34 sections were changed or are missing"). The KPI
  cards (entries, indexed pages, stale sections, last index) are gone —
  entries and pages were noise, the rest moved into the panel. The word
  index panel is gone too: its state is a line in Settings → Index
  maintenance; the overview shows a "Continue building" action only while
  its build has a backlog. The frontend search card holds two settings
  that save after a confirm ("Cancel" puts the control back): the core
  setting "Search" (public / registered / private / off — written by this
  tool with the tool permission alone, that key and those four values
  only) and the switch "Use the new WBCE Search admin tool" (locked while
  the search is off).
- Modules view rebuilt as one sortable table (every column header sorts;
  equal values fall back to the module name). Columns: Module (name from
  `{TP}addons` plus the directory), Indexing, Pages, Entries. Only page
  modules are listed: snippets, filters and tools have no sections, so
  nothing to index (`WbceSearchBackend::SHOW_ALL_KINDS` brings them back
  with a Type column and type checkboxes). "Status" and the definition
  tags described the same thing and are merged into Indexing: from module,
  callback, built-in, semi-config, semi-config not generated, search.php
  found, page title only. Toolbar checkboxes filter by indexing group
  (with definition / incomplete / page title only), plus a name filter;
  filters and sort order survive a save. The expanded page list shows
  visibility icon (wbeSelect icons, translated tooltip), page id, menu
  title and section ids, linked to the page and section in the backend; a
  red magnifier marks pages whose search is switched off. "Configure" inserts the editor as a
  table row of its own directly below the module (a second click closes
  it); it travels with its module when the table is re-sorted. Editor
  fragments are sent without the AdminTools runner's wrapper div.
- The indexer is a class, `WbceSearchIndexer` (`rebuild()`,
  `smartRebuild()`, `lazyReindex()`, `prune()`, `indexSections()`,
  `tokenizeUrls()`, `moduleDef()`, `indexByDef()`; the built-in callbacks
  `indexMdViewer()` / `indexOneforall()`). It replaces the `ws_*` functions
  of `lib/indexer.php`, which is gone (`upgrade.php` deletes it);
  `module_defs/` name the callbacks as `[WbceSearchIndexer::class, '…']`.
  Smart and lazy reindex shared a copied query, now one. The index it
  writes is identical (full rebuild, smart rebuild and lazy reindex
  compared row by row). The callback signature is unchanged.
- A definition whose `callback` cannot be called is logged ("callback is
  not callable: …") and the section gets no entries. It used to be indexed
  silently by its `table` definition instead, so a typo went unnoticed.
- All classes live in `classes/` and come from the core autoloader:
  `initialize.php` registers the folder (`WbAuto::AddDir()`), no file
  requires a class any more (about 25 `require_once` gone, the core's
  LayoutParser included). `install.php` registers it itself — it runs
  before the module's initialize.php ever has. `lib/setup.php` is gone:
  `install.php` holds every (repeatable) install step and `upgrade.php`
  includes it, then adds the upgrade-only steps; an upgrade keeps the
  admin's `use_search_tool`. The frontend
  part of `initialize.php` (live search, jump to the first hit) is
  `initialize_fe.php`, which the core loads on frontend requests only.
  `upgrade.php` removes the old copies from the module root.
- Stop words come from the language files (`$SEARCH['STOPWORDS']`; EN, DE
  and — new — PL ship one) instead of the fixed DE + EN list in
  `lib/stopwords.php`, which is gone. The site uses the lists of the
  languages its pages are written in (`WbceSearchStopwords`), stored by the
  indexer as state `stopword_languages`; when they change, the word index is
  re-tokenised. A German-only site therefore no longer drops English filler
  words from a query ("the Klavier" now looks for "the" too).
- Module settings moved from the table `{TP}mod_wbce_search_cfg` into the
  core's `{TP}settings` as JSON (`search_cfg` for what the admin sets,
  `search_state` for what the indexer writes), like tinymce_wbce. The
  core loads that table once per request, so every frontend page and every
  search lost a query. Only `WbceSearchSettings` reads and writes them.
  Old values are not carried over — the module was never released with the
  table.
- MD Viewer callback: a Markdown pattern that fails (backtrack limit on a
  huge file) leaves the text as it is instead of emptying it.
- The results page is a class, `WbceSearchPage` (input, grouping, "did
  you mean", tracking, layout data, live-search endpoint);
  `search_admin_tool.php` is a thin dispatcher. The hit label ("Content &
  Keyword") was computed twice, now once.
- The layout gets data only: a result's sections are a list, `R.SECTIONS`,
  that `search_default.htt` loops over — thumbnail, item link and excerpt
  are now in the layout and can be changed there (they were HTML built in
  PHP, `R.SECTIONS_HTML`). Keys for layouts: DEVELOPER.md → "Results page
  and layouts".
- Layouts test the lists directly (`{if RESULTS}`, `{if TAGCLOUD}`,
  `{if SUGGESTION_AREAS}`, `{if DID_YOU_MEAN}`); the `HAS_*` flags,
  `R.SECTIONS_HTML` and the `*_DISPLAY` helper keys (`PL.CURRENT_DISPLAY`,
  `THUMB_DISPLAY` …) are gone. The debug table uses the `.ws-debug-table`
  styles of fe_search.css instead of inline styles.
- The administrator check for the debug boxes only queries the database
  while the debug setting is on (was on every search by a logged-in user).
- Frontend assets renamed and moved into `assets/`: `frontend.css` →
  `assets/fe_search.css`, `frontend.js` → `assets/fe_search.js`, `jump.js` →
  `assets/fe_search_jump.js`. `upgrade.php` removes the old files; the tag
  cloud droplet's stored code is refreshed by the upgrade as usual.
- Live-search dropdown: its look is CSS now (`assets/fe_search_suggest.css`,
  loaded with the live search on every page) instead of inline styles set
  by fe_search.js, which no template could change. The rules are scoped to
  `ul.ws-suggest.ws-suggest` and reset what templates like to change (list
  bullets, fonts, margins, img borders) — tested against hostile template
  rules. Colours are custom properties (`--ws-suggest-*`) a template may
  override. New dark variant: used when the template declares a dark theme
  (`data-theme`/`data-bs-theme`/`data-color-scheme`="dark", class `dark` or
  `dark-mode` on html/body) or when the search field sits on a dark
  background — the page decides, not the visitor's OS setting (most
  templates are light). fe_search.js only sets position and width.
- Admin tool: no script or inline handler in the templates any more. The
  layout view's `wssLayoutSaved()` (CodeEditor `on_save`) moved to
  `assets/backend.js`; help link, guide button, "close" and the reset
  confirmation use `data-wss` / `data-confirm` and delegated listeners
  there (CSP without 'unsafe-inline' possible).
- Semi-config help (Modules view → "Help") opens in the MarkdownWbce reader
  (`MdReaderLink`), rendered and in the backend language
  (`help_semi_konfig_<LANG>.md`, else `help_semi_konfig.md`). It used to be
  the raw Markdown text in a dialog. The dialog, its CSS and `ajax.php`
  (which only served that text) are gone; `upgrade.php` removes the file.
- Code streamlined, output unchanged (search page and live search compared
  before/after for 11 queries in 4 layout variants):
  - `WbceSearch` (1 360 → 800 lines) is the engine only. Live suggestions
    moved to `WbceSearchSuggest`, statistics and tag-cloud data
    (`trackSearch()`, `trackMiss()`, `getTagCloud()`) to `WbceSearchStats`;
    pagination and layout parsing to `WbceSearchPage`. Dead code removed
    (`search()`, `mode()`, `score()`, `matchCheck()` — unused since the
    parsed search).
  - One settings path: everything reads `WbceSearchSettings` (typed, with
    defaults) — `WbceSearch::getCfg()` with its second set of defaults and
    `WbceSearchSettings::flat()` are gone.
  - The search page's wording comes from the core's Lang registry
    (`L_('SEARCH:…')`, EN as fallback for missing keys) instead of an
    included language file passed around as an array.
  - One tag cloud: the search page renders it with the same `tagcloud`
    layout as the droplet (`WbceSearchLayouts::renderTagCloud()`), so a
    custom or template tag-cloud layout now applies on /search/ too. Layout
    key `TAGCLOUD` is that HTML (`[TAGCLOUD|raw]`); `SEARCH_BASE_URL` and
    the `TAG.*` loop of the search layout are gone.
  - Escaping: the layout gets plain values and the LayoutParser escapes
    them; `|raw` only for HTML (`EXCERPT`, `TAGCLOUD`). `S.ITEM_TITLE`, the
    `R.DEBUG_*` values and `SEARCH_URL` are no longer escaped in PHP —
    `[S.ITEM_TITLE]` instead of `[S.ITEM_TITLE|raw]` in own layouts.
  - The dispatcher is `search_page.php` (was `search_admin_tool.php`,
    `upgrade.php` removes the old file).
  - Comments in English throughout.

### Fixed
- Semi-config: the filters "Active entries only" and "Time control" could
  be saved for a table without the `active` / `published_when` +
  `published_until` columns; every index run then failed for that module
  (SQL error, only a marker row). The editor now offers a filter only when
  the table has its columns, saving drops an impossible one, and the
  indexer skips a stored one whose columns are gone.
- A search term with a backslash lost it (`C:\temp` searched as `C:temp`):
  a `stripslashes()` left over from PHP's magic quotes.
- Tag cloud on the search page: the term was not URL-encoded in the link
  (`a&b`, `c#` or `x+y` broke it).
- The search page switched `display_errors` off and hid deprecations for
  the whole request, overriding the site's own error setting. Only the
  live search's JSON response keeps it off now (a displayed notice would
  break the JSON; errors still reach the log). A broken layout is logged
  instead of silently leaving the page empty.
- The core's "Search" setting (Settings → search: public / private /
  registered / none) was ignored: `search_admin_tool.php` defined
  SHOW_SEARCH as a fixed true, so with "None" or "Registered" guests still
  searched, got live suggestions and the live search on every page — and
  the template's search box showed on /search/. Now SHOW_SEARCH decides
  first — the core sets it in `framework/initialize.php` since 1.7.0,
  before any module initialize file runs (it used to be set only later, in
  `Frontend::get_website_settings()`): the search page
  shows "Search disabled" like the core's own, live search answers `[]`,
  `initialize_fe.php` adds nothing, the tag cloud droplet stays empty, and
  with "None" frontend pages do not register the classes at all. The admin
  overview warns for "None" and notes "logged-in users only" (its old hint
  read SHOW_SEARCH, which the backend never has, and never showed).
- Pagination (default layout): the current page was not highlighted — the
  CSS expects `li.ws-current span`, the layout had `span.ws-current` — and
  the gap between page numbers was never shown (both of its elements were
  hidden). The current page and "…" now show.
- Search switched off (`SHOW_SEARCH`): `display_errors` stayed off for the
  rest of the request.
- Live search: `?q[]=…` was a TypeError.
- Turkish i-letters: `mb_strtolower()` turns "İ" into "i" + a combining dot
  and "I" into "i" (Turkish: ı), so a capitalised word ("İstanbul" in a
  heading, "IRMAK" in a query) never matched its lower-case form — not in
  the word index, the row checks, the excerpt, the highlighting, the stop
  words or the live search. `WbceSearchWords::fold()` now treats i, ı, İ, I
  as one letter for every compare (a few extra hits such as kır/kir instead
  of missing capitalised words); `lower()` only drops the dot and keeps ı
  for what visitors see (tag cloud, statistics). Matching in the original
  text uses `regex()` / `ipos()` (positions stay right — a lowered "İ" is
  two characters), and the SQL prefilter `likeBody()` puts `_` for each
  i-letter, because `utf8mb4_unicode_ci` treats ı ≠ i and SQLite does not
  pair İ with i. Sites with Turkish content: rebuild the index once.

### Requirements
- The LayoutParser of WBCE 1.7.0 with nested loops, `{if LIST}` true for a
  non-empty list, and `and` in conditions.

## 0.6.0 (2026-11-09) — Christian M. Stefan

Review against the WBCE 1.7.0 standards.

### Fixed
- Uninstall now also drops `{TP}mod_wbce_search_words` (word index, 0.5.0) —
  it stayed behind as an orphan table. The droplet row is only deleted when
  the Droplets table still exists.
- Result page: the excerpt is HTML-escaped before the `<mark>`s are added
  (the layout prints it `|raw`; `strip_tags()` alone is no escape). Terms
  are marked in one pass that skips entities — per-term passes used to mark
  inside `&amp;` or inside the tag of an earlier `<mark>`.
- Result page: links and thumbnail URLs in the result sections are escaped
  for their attribute — a `"` in a module's detail URL broke out of it.
- `initialize.php` checks `FRONTEND_CONTEXT` instead of the deprecated
  `WB_FRONTEND`.

### Changed
- Full rebuild runs in one transaction (`Database::transaction()`): a run
  that dies halfway keeps the old index; on SQLite the inserts are one
  commit instead of one each. A broken section (missing module table,
  failing callback) is logged and skipped instead of ending the run.
- Every write is checked (`hasError()`): index inserts only count when
  they succeeded, word-index batches throw on the first failed statement
  (only the last one used to be checked), setup/upgrade steps throw (the
  installer reports them), statistics log failures without disturbing the
  visitor. A failing lazy reindex no longer breaks the result page.
- Module tables in definitions are addressed as `{TP}` + a sanitised name
  (was `TABLE_PREFIX` concatenation, main table unsanitised).
- `WbceSearch.php` declares `strict_types=1` like the other classes.

### Removed
- `search.php` — the 0.3 hook into the legacy core search, dead since the
  module serves /search/ itself.
- `ajax.php`: the unused second suggest endpoint (the frontend uses
  `search/index.php?ws_ajax=1`) and the unused `get_guide` action; the file
  is admin-only now (help text).
- `.htaccess` and the code in `install.php` that wrote it — nothing in the
  core blocks module PHP files.
- Stale `@version` tags in file headers (`info.php` is the only source).
- `upgrade.php` deletes `search.php` and `.htaccess` on existing installs,
  each only if it is recognisably the module's own.

## 0.5.9 (2026-11-08) — Christian M. Stefan

### Fixed (core, framework/frontend.functions.php)
- `search_highlight()` silently highlighted nothing on pages with rich markup
  (inline SVG, `<picture>`, long card lists — e.g. a CatalogueHub list): its
  tag pattern nested two repetitions, PCRE hit the backtrack limit and the
  page was shown unmarked, so `jump.js` had nothing to scroll to. The tag
  pattern now skips quoted attribute values atomically; `<svg>…</svg>` is
  left untouched (a `<span>` inside SVG `<text>` would hide the word).

### Documented
- Known limitation: modules without detail pages have no jump target per
  item (DEVELOPER.md, "Known limitations") — deferred, needs a universal
  anchor convention.

### Changed — live suggestions show module items with picture
- Suggestions used to be one entry per page: a catalogue page offered
  itself ("CHUB") with the page link, never the entry that matched. Index rows
  of module items (`item_id > 0` with an item title) now become their own
  suggestions — item title, the page title as context line, the item's
  detail link (or the page) and its thumbnail.
- An item matches by its own title, not by the page title stored on every
  row — typing the page name does not list every entry of that catalogue.
- New setting "Images in suggestions" (default on). As soon as one suggestion
  has a picture, every row gets the same 44 px image column (an empty tile
  where there is none), so titles stay aligned.
- Pictures come from what a module indexes as `thumb_url` — CatalogueHub now
  ships its own `search_index.php` (with DynamicFields' per-field
  "searchable" switch), so its entries are the first to show one.

## 0.5.8 (2026-11-07) — Christian M. Stefan

### Fixed — the layout editor had no way to save
- Layout tab: there was no Save button, and the hint promised one "in the
  editor toolbar" that never existed. With "AjaxSave" unticked nothing could
  be saved at all; with it ticked only Ctrl+S worked, and only while the
  cursor was inside the editor. Now there is a Save button below the editor:
  - AjaxSave ticked → saves via AJAX, no reload (Ctrl+S works too).
  - AjaxSave unticked → normal form POST, then back to the Layout tab.
- Both ways run the same code (`WbceSearchBackend::saveCustomLayout()`). It
  refuses an empty layout (which would leave the search page blank) and
  shows a real error message when search_custom.htt cannot be written (the
  AJAX save used to show "saved successfully" in red for this).
- "Reset to default" appears right after the first save, not only after a
  reload.
- ajax_save_layout.php checks the tool permission (`hasToolPermission`)
  instead of only the general admin-tools right.

## 0.5.7 (2026-11-07) — Christian M. Stefan

### Changed — no hard-coded wording in the search page
- layouts/search_default.htt: the search-tips table, the hit legend and the
  pagination arrows used fixed English text ("Wildcard", "mustard*",
  "Term found in page content" …). All of it now comes from the language
  files (29 new keys in EN/DE/PL, incl. language-specific example words:
  mustard / senf / musztarda) — the tips table also gained a row for `|`.
- The layout receives every plain text of the language file as
  `[TEXT.KEY]` (before: a hand-picked list of 22), so a custom layout can use
  any of them. The admin-only debug box keeps its technical labels.
- Pagination arrows got `aria-label`/`title` ("Previous page" / "Next page").

### Fixed
- `|` and `OR` (upper case) in a query now really mean OR (as the
  no-results tips have always suggested): "mustard | ketchup" finds pages
  with either word. Before, it was searched as AND.
- DE: example word "anderesBegriff" → "andererBegriff".

## 0.5.6 (2026-11-07) — Christian M. Stefan

### Fixed — the tag cloud could not be switched off
- New setting **Show tag cloud** (`tagcloud_show`) for the search page. The
  droplet has its own parameter instead: `active=1` (default) / `active=false`
  — it is placed deliberately, so it is switched where it is placed.
  The only switch so far, "record" (`tagcloud_track`), just stopped collecting new terms — the cloud
  kept showing the ones already collected. Recording stays a separate switch
  (it also feeds the statistics, incl. "searched, nothing found"); its hint
  now says it does not hide the cloud.
- upgrade.php: installs that had recording switched off get "show" off too —
  that was what switching it off was meant to do.

## 0.5.5 (2026-11-07) — Christian M. Stefan

### Fixed — live search stopped at the first space
- Without the word index (small sites) the suggestions matched the whole
  input as one phrase: "roger bos" found nothing although the text says
  "Roger E. Boswarva". Now every typed word must occur, in any order and at
  any distance (title/description and index text alike). Sites with the word
  index already worked this way.
- The passage shown under a suggestion is looked up word by word when the
  whole input does not occur as a phrase.

## 0.5.4 (2026-11-07) — Christian M. Stefan

### New — land on the passage, not the page top
- jump.js: on a page opened from a search hit (`?searchresult=1&sstring=…`)
  it scrolls the first term the core highlighted (`span.highlight`) into the
  middle of the screen and lets it flash briefly. Skips hidden hits, opens a
  surrounding `<details>`, corrects once after images have loaded, leaves the
  page alone when the URL has an #anchor or the visitor already scrolled.
  Respects "reduce motion" (no smooth scroll, short flash). Loaded by
  initialize.php only on such requests.
- Live-search suggestions and module detail links (news_img posts …) now
  carry `searchresult`/`sstring` too, so they highlight and jump as well.

### Fixed
- `sstring` in result links was URL-encoded twice: "Roger Boswarva" arrived
  as "Roger+Boswarva" on the target page. It now holds only the plain search
  words (no `-exclusions`, quotes or `*`), encoded once.

## 0.5.3 (2026-11-07) — Christian M. Stefan

### Changed — suggestions show where the word was found
- When the typed text is not in the page title, a suggestion now shows the
  matching passage (~90 characters around the hit, from the description or
  the indexed page text) instead of the unrelated page description.
  New field `snippet` in the suggest JSON; `description` stays.
- frontend.js emphasises the typed words in title and passage
  (`<mark class="ws-suggest-hit">`, case-insensitive, each word separately).
  The text is split first and every part escaped, so input like `<b>` or
  regex characters cannot inject markup or break the dropdown.

## 0.5.2 (2026-11-07) — Christian M. Stefan

### Changed — live search finds words from the page text
- New suggestion source **hybrid** (default): title and description matches
  first, topped up from the search index while fewer than "Max. suggestions"
  were found. With the old default "title", a word that occurs only in the
  page text (e.g. a name used throughout the content) suggested nothing,
  although the search itself found the pages. "Title only" and "Full text"
  remain selectable.
- The full-text part only runs when the titles do not fill the list; on
  large sites it uses the word index. Duplicates are dropped, the visitor
  check applies to both parts.
- upgrade.php switches an existing "title" setting to "hybrid" once (marker
  `migrated_suggest_hybrid`); choosing "title" again afterwards is kept.
- Languages: new option label and hint in EN/DE/PL.

## 0.5.1 (2026-11-07) — Christian M. Stefan

### Changed — index survives a move
- `detail_url` and `thumb_url` in the search index store `{SYSVAR:WB_URL}`
  instead of the absolute site URL (same token as wysiwyg and the output
  filter dashboard). Before, item links and preview images (news_img posts,
  semi-config images, OneForAll) pointed to the old domain after a move until
  someone ran a full rebuild — the lazy reindex only picks up changed pages.
- The output resolves the token; absolute URLs (foreign links, rows from
  older versions) pass through unchanged.
- Rows written by a module's own `search_index.php` callback are converted
  after each indexer run, so callbacks that still store absolute URLs work.
- upgrade.php converts the existing index rows (MySQL and SQLite).

## 0.5.0 (2026-11-07) — Christian M. Stefan

### New — search scales to large sites
- Word index (`WbceSearchWords`, table `{TP}mod_wbce_search_words`): one row
  per word, entry and field. The database finds the matching entries through
  an index lookup; PHP no longer loads the whole index, and the text is
  loaded only for the hits of the displayed results page (`hydrate()`).
- Built only where it pays off: setting `word_index` = automatic (default,
  from `word_index_threshold` = 2 000 indexed entries), always on, or off.
  Small sites keep the row search and get no extra table rows.
- Never incomplete: entries carry `tokenized`; the search uses the word index
  only when no searchable entry is pending. Rebuild/Update tokenise within a
  20 s budget ("Continue building" on the overview for the rest), the lazy
  reindex keeps it current (re-indexed sections + 25 pending per search).
- Live search in full-text mode uses the word index (prefix lookup instead of
  `LIKE '%…%'` over all text on every keystroke).
- Measured with 128 MB memory_limit, synthetic sections of ~3 KB:
  before, the search ran out of memory at ~13 000 entries (≈10 MB per 1 000).
  With the word index at 20 000 entries (MySQL): rare term 21 ms, medium
  243 ms, two terms 479 ms, prefix 133 ms, all at ≤ 3.4 MB; a term found in
  every entry 1.8 s / 64 MB — slow, but no longer a crash. Building the word
  index for 20 000 entries took 450 s on MySQL (≈ 23 rounds of the 20 s budget).
  Result sets are identical in both modes (37 curated cases incl. umlauts,
  hyphens, prefix, phrase, exclusion, OR, scope — MySQL and SQLite).

### Changed
- Row search (small sites): the database pre-filters candidates with one
  `LIKE` per required term before PHP checks whole words — memory for a rare
  term at 20 000 entries 197 MB → 0.2 MB. Very common terms still load most
  of the index, which is what the word index is for.
- Result labels (Content/Keyword/Description) are computed by the engine
  (`in_content`, `in_keywords`, `in_desc`), no second pass over the text.

### New — "searched, nothing found"
- Searches without results are recorded as the whole query (`misses` column,
  `count` = 0) and listed on the statistics page. They never reach the public
  tag cloud.

### Fixed
- Live search LIKE escaping had no effect on SQLite (no default escape
  character) — explicit `ESCAPE '!'`.
- SQLite: lookups by `section_id` had no index (importSql() drops inline KEYs).

### Upgrade
- New table + columns `tokenized` (index) and `misses` (stats) via upgrade.php.
  On MySQL the word index runs `ANALYZE TABLE` after bulk builds — without it
  InnoDB's stale statistics made a two-term query 10× slower.

## 0.4.0 (2026-11-06) — Christian M. Stefan

### Changed — admin tool rebuilt
- tool.php is now a thin controller: `WbceSearchBackend` (views + operations),
  `WbceSearchSettings` (schema: defaults, casting, range clamping),
  `WbceSearchModules` (module list + semi-config), `WbceSearchIcons` (Tabler)
- Twig templates (`twig/`) + HTMX, layout taken from WbceAnalytics: five
  pages (Overview, Modules, Layout, Settings, Statistics), tabs on top or an
  icon sidebar (setting `nav_style`)
- Page size 6.3 MB → ~25 KB: the semi-config editor is loaded per module on
  demand instead of being pre-rendered 45 times (with its script block)
- Column pickers are rendered server-side on table change (fixes stale text
  columns after switching the table); join ON-columns follow the main table
- Single-term removal in the statistics; layout reset keeps
  `search_custom.htt.bak`; real confirm dialogs (the old ones never fired)

### Fixed — security
- Live search suggested private/registered pages (title, description, URL)
  to guests; full-text mode allowed probing their content
- Pages moved to the trash, set to "none" or excluded from search stayed
  findable until a full rebuild — the search now checks the live page state
  and smart/lazy reindex prune such rows
- ajax.php `get_cols` (removed) / `get_help` / `get_guide` and guide_popup.php
  were open to any logged-in frontend member — now admin tool access only
- Semi-config accepted any table/column (e.g. `users`) — validated against
  `mod_*` tables with `section_id` and their real columns now
- Settings were stored unvalidated (`tagcloud_max=-1` broke the tag cloud,
  `highlight_tag=script` reached the frontend) — now clamped per schema
- Tag cloud only records terms of searches with results; stop words and
  terms over 50 characters are skipped

### Fixed
- Frontend switch toggled a sentinel file nothing read — it now sets
  `use_search_tool`, the setting `search/index.php` uses; sentinel removed
- `initialize.php` never ran (`module_function` lacked `initialize`): live
  search now works on all pages while WBCE Search serves /search/
- `?ws_scope=title` (string instead of array) caused a fatal error
- `match=any` / `match=exact` of the standard search form are honoured
- Wildcards are prefix matches as documented
- news_img definition compared `post_id` with `section_id` — posts are indexed
- Sections without indexable content stayed "stale" forever and were
  re-indexed on every search — a marker row now records them as processed
- Default layout: tag-cloud label and area headline were empty
- Page titles were escaped twice; `&nbsp;` survived in indexed text;
  `?string[]=x` searched for "Array"
- upgrade.php inserted the droplet into a non-existent column; install.php
  added a duplicate droplet on every run — both share `lib/setup.php` now
- Hit labels (Content/Keyword/Description/Title) translated; `userCanView()`
  recognises the admin group

### Changed — SQLite support
- Runs on MySQL/MariaDB and SQLite: schema access via the new core helpers
  `Database::listTables()` / `listColumns()` / `groupConcat()` (instead of
  INFORMATION_SCHEMA and GROUP_CONCAT … SEPARATOR), tables from
  `install_struct.sql` via `importSql()`, tag-cloud counter without
  `ON DUPLICATE KEY`. Tested on both drivers (install, upgrade, uninstall,
  all admin views, indexing incl. joins, search, live search).

### Changed — module-provided search definitions
- A module can ship its own `modules/<module>/search_index.php` (same array as a
  module_defs file; `callback` may be a closure). Lookup order: admin semi-config >
  the module's own file > `module_defs/` (before, a module_defs file silently beat a
  saved semi-config). Shown as "from module" in the module list. VES is the first
  module using it — VES pages are now indexed with their full visible text.

### Changed — language files, plural forms
- Counts use `Ln_()` plural forms incl. a separate wording for 0: pages and
  sections per module, index rebuild/update messages ("Nothing to update."
  is now the zero form), statistics footer, result total on the search page,
  tag-cloud tooltips (layout and droplet) — no more "page(s)" or "1 results"
- New `languages/PL.php` (Polish, incl. one/few/many forms)
- EN/DE/PL restructured: frontend texts first, backend grouped; 53 keys of the
  old single-page UI removed
- **Custom layouts:** `[TOTAL] [TEXT.RESULTS]` → `[TOTAL_TEXT]` and
  `[TAG.COUNT]x searched` → `[TAG.SEARCHED]` (`TEXT.RESULTS` no longer exists)
- Droplet loads the module language file (label/tooltips were always English)

### Removed
- `index_corepatch/` (the 1.7 core already integrates via `use_search_tool`),
  the sentinel file `wbce_search.active`, the old single-page tool UI

---
## 0.3.8 (2026-08-04) — Peter Kitzinger (Slugger)

### Changed — Internationalisation
- languages/EN.php: complete rewrite — all UI strings covered (card titles,
  status labels, button labels, settings hints, AJAX info, statistics)
- languages/DE.php: synchronised with EN.php — identical key set
- tool.php: all hardcoded German strings replaced with $SEARCH[] language keys
- layouts/search_default.htt: fully translated to English
- WbceSearch.php, lib/indexer.php, search_admin_tool.php, droplet.php,
  install.php, search.php, index_corepatch/search/index.php:
  German comments translated to English

### Fixed (update)
- ajax.php: get_help and get_guide now load language-specific .md files
  ({file}_{LANGUAGE}.md) with fallback to EN — fixes guide popup always
  showing English regardless of user language setting

### Fixed
- guide_popup.php: stray debug_dump() calls removed

---

## 0.3.7 (2026-08-02) — Peter Kitzinger (Slugger)

### New
- tool.php: Layout-Editor now uses CodeMirror with syntax highlighting (htt mode),
  toolbar and AJAX-Save — contributed by Christian M. Stefan
- ajax_save_layout.php: new AJAX endpoint for CodeMirror live save
- tool.php: Layout-Editor card forces open on arrival via #ws-card-layout hash
  (e.g. after reset, user lands back directly on the editor)
- tool.php: live label update after AJAX-Save without page reload (wsLayoutSaved callback)
- tool.php: lazy-init fix for CodeMirror inside collapsed cards (cm.refresh on open)

### Changed
- tool.php: Reset button moved into status line next to custom-active hint
- tool.php: redundant Save button in status line removed

---

## 0.3.6 (2026-08-02) — Peter Kitzinger (Slugger)

### Fixed
- tool.php: version number now read from info.php instead of hardcoded string
- tool.php: removed stray debug_dump() call visible in admin UI
- tool.php: renamed "Core-Patch" button to "Frontend-Suche" (clearer labeling)
- tool.php: removed redundant "Use Search AdminTool" button

---

## 0.3.5 (2026-07-24) — Peter Kitzinger (Slugger)

### Fixed
- indexer.php: block-level HTML tags (p, div, h1-h6, li, br etc.) are now replaced
  with spaces before strip_tags() — prevents words from merging across tag boundaries
  (e.g. `<p>foo</p><p>bar</p>` was indexed as `foobar` instead of `foo bar`)
- indexer.php: Semi-Konfig mode=single now always filters by section_id regardless
  of index_base setting — fixes empty index when index_base=pool was selected
- tool.php: after generating module_defs file, custom_modules DB entry is removed —
  fixes persistent "Save" button and "Generate" button in module list

---

## 0.3.4 (2026-05-22) — Peter Kitzinger (Slugger)

### Fixed
- upgrade.php: existing droplet `code` updated in DB on upgrade — no reinstall needed

---

## 0.3.3 (2026-05-21) — Peter Kitzinger (Slugger)

### Fixed
- install.php: `<?php` opening tag stripped from droplet code — Droplets module expects pure code without opening tag
- install.php: `modified_by` and `modified_when` set on insert — fixes missing Save buttons in Droplets admin
- droplet.php: Parameters now read as direct variables (Droplets standard) — `$params[]` array access removed
- droplet.php: `title` attribute HTML bug fixed (`3x</span>` → `3x`)

### New
- droplet.php: `desc` parameter for tag cloud label text
  - `[[wbce_search_tagcloud]]` → uses language variable
  - `[[wbce_search_tagcloud?desc=Often searched]]` → custom label
  - `[[wbce_search_tagcloud?desc=]]` → no label

---

## 0.3.2 (2026-05-15) — Peter Kitzinger (Slugger)

### New
- Hit labels legend: collapsible legend showing all label combinations (Content, Keyword, Description etc.)
- install.php: robust droplet insert — handles missing `file` column in older WBCE versions

### Fixed
- Duplicate result bug: page appeared 2x when term was only in keywords or description
- Indexer: keywords/description no longer copied into content field — stored as separate fields
- Indexer: item_id = 0 when no item_key defined (wysiwyg single mode) — prevents false multi-mode handling
- Deduplication: smart page_id/section_id logic based on keywords/description presence

### New
- Grouped output: fulltext hits show all matching sections under one page title
- Meta hits (keywords/description): page shown once with label
- Hit labels for all combinations: Content, Keyword, Description and combinations
- item_title as clickable direct link for multi-mode modules (NWI, Bakery, OFA, Members)
- Correct match-type logic: content hit → fulltext; no content hit → meta

### Changed
- search_admin_tool.php: grouping logic after searchParsed()
- WbceSearch.php: deduplication considers keywords/description fields
- frontend.css: CSS for grouped output, meta labels, item_title links
- search_default.htt: new template with grouped output and labels

---

## 0.3.0 (2026-05-08) — Peter Kitzinger (Slugger)

### New
- Operator parser: phrases "...", wildcard word*, NOT -word in search queries
- No-results box: search tips + suggest areas when 0 results
- Collapsible search tips legend in frontend (always visible)
- Advanced search: scope checkboxes title only / content only / OR search (on/off per setting)
- Admin tool: tab register All / Configured / Preset / Not configured
- Admin tool: module type badges callback / generated / snippet / tool / filter
- Admin tool: tools + snippets + output filters hidden by default
- Admin tool: system info utilization display (index fill level, lazy queue, last reindex)
- Layout editor: save button top, reset bottom, custom hint
- Guides: members.md, bakery.md guide files

### Changed
- Radio buttons All/Single/Exact phrase removed — operator parser takes over
- html_entity_decode for phrase input (no &quot; in search field)
- Pagination: design revised, lighter background, better readability

### Fixed
- &quot; display in phrase search due to double HTML encoding

---

## 0.2.13 (2026-05-03) — Peter Kitzinger (Slugger)

### New
- OneForAll (OFA): callback indexer ws_index_oneforall()
- Semi-config: link prefix field
- Admin tool: guide button in semi-config inlay
- Guides: oneforall.md + md_viewer.md

### Fixed
- page_map array_unique() without array_values() returned wrong keys for PDO IN clause
- Semi-config: link_prefix missing in module_defs generator

---

## 0.2.0 (2026-05-01) — Peter Kitzinger (Slugger)

### New
- MD Viewer: full-text indexing via callback indexer
- Word boundary search: mb-safe, PHP 8.5 compatible
- Documentation: README.md, CHANGELOG.md, DEVELOPER.md

### Fixed
- Deduplication bug: item_id without module context filtered wrong entries
- Blank page when searching for words with 0 results

---

## 0.1.x (2025-2026) — Peter Kitzinger (Slugger)

- Basic full-text search with own index, core patch, tag cloud, AJAX live search
