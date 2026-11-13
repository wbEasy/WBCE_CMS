# WBCE Search

**Version:** 0.6.1 | **Platform:** WBCE CMS 1.7.0+ | **PHP:** 8.1+ | **Database:** MySQL/MariaDB or SQLite
**License:** GNU General Public License | **Authors:** Peter Kitzinger (Slugger), Christian M. Stefan ([wbEasy.de](https://www.wbEasy.de)) | © WBCE Project

---

## What is WBCE Search?

WBCE Search is the search of WBCE CMS. Since 1.7.0 it is a **core module**:
it is installed with the CMS, serves the search page `/search/` and cannot be
uninstalled. There is no other search any more.

It indexes page content, module items and linked media files in its own
tables (`{TP}mod_search_index`, `…_words`, `…_stats`) and provides:

- Full-text search with operators (phrases, wildcard, exclusion, OR, typo
  tolerance)
- Ranking with title weighting
- Highlighted excerpts, pagination
- "Did you mean …?" when a search finds nothing
- Hit highlighting on the target page — the visitor lands on the passage
- Live search with suggestions while typing (titles and page text, with
  thumbnails for module items)
- Tag cloud of searched terms, as a droplet
- Advanced search (scope: title only / content only)
- Results page and tag cloud as layout files, editable in the admin tool
  and overridable by a template

Only pages the visitor may see are found — visibility, groups and trash are
checked on every search, not only when indexing.

---

## Getting started

1. *Settings* → "Search": who may search (public / registered / private /
   off). The same switch is in Admin Tools → WBCE Search → Overview.
2. Admin Tools → WBCE Search → Overview: run a first **Full rebuild**.

After that the index keeps itself current: every search updates a few
changed sections on the fly (setting "Auto-reindex on search").

---

## Search operators

| Input                              | Meaning                                             |
| ---------------------------------- | --------------------------------------------------- |
| `mustard organic`                  | All words must appear                               |
| `mustard -hot`                     | mustard yes, hot no                                 |
| `mustard \| ketchup`               | Either word is enough (also `OR`, upper case)       |
| `"yellow mustard"`                 | Exact phrase                                        |
| `mustard*`                         | Starts with mustard (wildcard)                      |
| `mustrad~`                         | Tolerates typos — also finds mustard (from 5 chars) |
| `mustard organic -hot "from corn"` | Combination of all operators                        |

When a search finds nothing, the results page offers **"Did you mean …?"**
with the closest known spelling — only if that query actually finds
something. Suggestions use words of public pages only.

---

## Admin tool

Admin Tools → WBCE Search, five pages: **Overview**, **Modules**,
**Layout**, **Settings**, **Statistics**.

### Search index (Overview)

| Action         | When to use                                                        |
| -------------- | ------------------------------------------------------------------ |
| Full rebuild   | First time, after installing or configuring modules                |
| Update changed | After many content changes; reads only changed or missing sections |
| Delete index   | Complete reset                                                     |

A full rebuild runs in one transaction: if it breaks off, the old index
stays. A section that cannot be indexed is logged and skipped.

Large sites (from 2 000 index entries by default) also get a word index,
which keeps searches fast; it is built automatically and can be switched
on or off in the settings.

### Modules

Every installed module is listed with where its search definition comes
from:

| Source                      | Meaning                                                        |
| --------------------------- | -------------------------------------------------------------- |
| From module                 | The module ships `search_index.php` itself — not editable here |
| Callback                    | Indexed by a PHP callback — not editable here                  |
| Built-in                    | Definition shipped with WBCE Search (`module_defs/`)           |
| Semi-config                 | Definition generated from the semi-config                      |
| Semi-config – not generated | Semi-config saved, definition not generated yet                |
| search.php found            | No definition yet — the semi-config can be preset from it      |
| Page title only             | No definition — only the page title is indexed                 |

If several exist, this order wins: the module's own `search_index.php` >
semi-config > `module_defs/`.

Badges show the module type: **Page**, **Snippet**, **Filter**, **Tool**.

### Semi-config

For modules without a definition, configured in the admin tool:

1. Select table (main table with `section_id`)
2. ID column (almost always `section_id`)
3. Item key (e.g. `item_id`)
4. Title column
5. Text columns (multiple possible)
6. Link column + link prefix (optional)
7. Image column + path template (`{item_id}`, `{section_id}`, `{page_id}`)
8. Mode: single or multi
9. Index base: searchable pages only or all sections
10. Filter: active only / time control
11. Joins: up to 3 additional tables
12. Generate `module_defs/MODULE.php` → rebuild

Only `mod_*` tables with a `section_id` and their real columns are accepted.

### Layout

Three cards: **search results page**, **tag cloud**, **stylesheet**. For
each, pick which file is used:

- your own copy (`layouts/<name>_custom.htt`, `layouts/fe_search_custom.css`)
- the search template's file (`templates/<template>/search/…`, read only)
- the shipped default (read only)

"Edit" on a read-only file first copies it to your own copy. The layouts
use the LayoutParser syntax (`[KEY]`, `{foreach}`, `{if}` …).

### Settings

| Setting                      | Default           | Description                                       |
| ---------------------------- | ----------------- | ------------------------------------------------- |
| Minimum word length          | 3                 | Shorter terms are ignored                         |
| Title weight                 | 3                 | Title matches count stronger                      |
| Results per page             | 10                | Pagination                                        |
| Language filter              | Off               | Pages in the visitor's language only              |
| Advanced search              | Off               | Scope checkboxes on the search page               |
| Max. excerpt length          | 200               | Characters in the preview text                    |
| Highlight / Highlight tag    | On / `mark`       | Highlight search terms (`mark`, `strong` or `em`) |
| Search page template         | (website default) | Frontend template the search page is shown in     |
| Auto-reindex on search       | On                | Update stale sections while searching             |
| Max. sections per search     | 5                 | Limit for auto-reindex                            |
| Word index / Word index from | Auto / 2 000      | Auto, on or off; threshold for "auto"             |
| AJAX live search             | On                | Suggestions while typing                          |
| Suggestion source            | Hybrid            | Titles first, topped up from the page text        |
| Max. suggestions             | 5                 |                                                   |
| Images in suggestions        | On                | Picture of module items                           |
| Show tag cloud               | On                | Switches the droplet output on/off                |
| Track tag cloud searches     | On                | Record searched terms for the tag cloud           |
| Max. tags / Min. searches    | 20 / 1            | Defaults for the droplet                          |
| Debug mode                   | Off               | Extended info on the results page (admins only)   |
| Navigation                   | Horizontal        | Admin tool: tabs on top or icon sidebar           |

### Statistics

Searched terms with their count; single terms can be removed. Searches that
found nothing are listed separately — useful to see what visitors miss.

---

## Indexing your own module

A module can ship its indexing itself: `modules/<module>/search_index.php`.
News with Images (news_img) for example does so.

How to write one:
[SEARCH_INDEX_HOWTO.md](SEARCH_INDEX_HOWTO.md).

Definitions shipped with WBCE Search (`module_defs/`):

| Module    | Kind     | Description                                       |
| --------- | -------- | ------------------------------------------------- |
| wysiwyg   | built-in | WYSIWYG sections                                  |
| bakery    | built-in | Bakery shop with product images                   |
| md_viewer | callback | MD Viewer (full Markdown files)                   |
| oneforall | callback | OneForAll — items with link, image, custom fields |

For any other module use the semi-config in the admin tool.

---

## Tag cloud droplet

```
[[wbce_search_tagcloud]]
[[wbce_search_tagcloud?max=15&min_count=2]]
[[wbce_search_tagcloud?active=false]]
```

| Parameter   | Default       | Meaning                                                    |
| ----------- | ------------- | ---------------------------------------------------------- |
| `max`       | setting (20)  | Maximum number of terms                                    |
| `min_count` | setting (1)   | Minimum searches per term                                  |
| `desc`      | language text | Own label; empty = no label                                |
| `active`    | `true`        | `false` hides the droplet (independent of the search page) |

The HTML comes from a layout file; a template can override it with its own
`search/tagcloud.htt`.

---

## Further reading

- [CHANGELOG.md](CHANGELOG.md) — changes per version
- [SEARCH_INDEX_HOWTO.md](SEARCH_INDEX_HOWTO.md) — search definition for a module
- [DEVELOPER.md](DEVELOPER.md) — architecture and classes
