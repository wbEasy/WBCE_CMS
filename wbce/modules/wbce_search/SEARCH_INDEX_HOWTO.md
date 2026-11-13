# How to make your module searchable

**For:** authors of page modules · **WBCE:** 1.7+ · **Search:** WBCE Search
(core module `wbce_search`)

Since WBCE 1.7 the site search is WBCE Search. It does not search your tables
while a visitor waits: it keeps an index (`{TP}mod_search_index`, one row per
findable thing) and searches that. Your module tells it what to put into the
index by shipping one file, `modules/<your_module>/search_index.php`.

The worked example throughout this guide is
[`modules/news_img/search_index.php`](../news_img/search_index.php) — a real,
shipped module. Open it next to this page.

---

## 1. Do you need the file?

Without it your module is not invisible: every section still gets one index row
with the page's title, description and keywords. What is missing is your
content — the text of your entries, their own links and pictures.

An administrator can also describe your table in the WBCE Search admin tool
(Modules → semi-config) without any code. That works for simple tables, but the
admin has to know your schema, and it cannot express every rule (an entry
hidden because its *group* is inactive, say). If your module has content,
ship the file — you know your data best.

| Your data                                          | Use                          |
| -------------------------------------------------- | ---------------------------- |
| One table, entries filtered by fixed column values | Table definition (section 3) |
| Visibility depends on another table or on logic    | Callback (section 4)         |
| Text in files, JSON, a tree, or built by code      | Callback                     |
| URLs or images that need computing                 | Callback                     |

**Old `search.php`:** WBCE 1.7 no longer reads it. If your module also
supports WBCE < 1.7, keep it — the two files do not interfere. **Do not write
into `{TP}search`** (the `module`/`query_start`/`query_body` rows of old
installers): it belongs to the search of WebsiteBaker ≤ 2.6, nothing reads it,
and the table goes in WBCE 2.0.

---

## 2. The file

```
modules/<your_module>/search_index.php
```

- It `return`s an array — nothing else. No output, no global functions (use a
  closure), no `require` of your module's frontend code at file level.
- Only WBCE Search reads it. Your module never includes it, so it costs
  nothing on sites or versions without WBCE Search.
- Start it with `defined('WB_PATH') or die();`.

WBCE Search looks for a definition in this order: your `search_index.php` →
an admin semi-config → a definition shipped with WBCE Search (`module_defs/`)
→ page metadata only. Once your module ships the file, the admin tool no
longer offers a semi-config for it.

---

## 3. Way A: table definition

For a module whose entries sit in one table with a `section_id` column:

```php
<?php
defined('WB_PATH') or die();

return [
    'table'      => 'mod_recipes',            // without {TP}
    'id_field'   => 'section_id',             // column holding the section ID
    'item_key'   => 'recipe_id',              // one index row per recipe
    'mode'       => 'multi',
    'title'      => 'name',                   // → item_title
    'fields'     => ['intro', 'body'],        // → content (HTML is stripped)
    'link'       => 'link',                   // → detail_url
    'image'      => 'image',                  // → thumb_url
    'image_path' => 'recipes/thumbs/',        // below MEDIA_DIRECTORY
    'filter'     => [
        'active'          => 1,               // column = value
        'published_when'  => '<= NOW',        // 0 = no limit
        'published_until' => '>= NOW',
    ],
];
```

| Key           | Meaning                                                                                                          |
| ------------- | ---------------------------------------------------------------------------------------------------------------- |
| `table`       | Main table, without `{TP}`                                                                                       |
| `id_field`    | Column with the section ID (default `section_id`)                                                                |
| `item_key`    | Unique entry ID; stored as `item_id`. Leave out for one row per section                                          |
| `mode`        | `multi`: one row per entry · `single` (default): only the first row of the section                               |
| `index_base`  | `page` (default): rows of this section · `all`: every row of the table, in every section of the module (`multi`) |
| `title`       | Column with the entry's title                                                                                    |
| `fields`      | Columns that make up the searchable text                                                                         |
| `link`        | Column with the entry's own page: a path below `PAGES_DIRECTORY` (`/posts/my-post`) or an absolute `http…` URL   |
| `link_prefix` | Put in front of a relative `link`; placeholders `{page_link}`, `{item_id}`, `{section_id}`, `{page_id}`          |
| `image`       | Column with the picture's file name                                                                              |
| `image_path`  | Folder below `MEDIA_DIRECTORY`; `{column}` placeholders from the entry row (`gallery/item{item_id}/`)            |
| `filter`      | Columns of the main table: `value` (equal), `'<= NOW'` / `'>= NOW'` (Unix timestamp, `0` = no limit)             |
| `joins`       | Up to 3 further tables (text, link or picture from there) — see DEVELOPER.md, "Join definition"                  |

Filters are evaluated **when the index is written**, not when someone searches
— see section 6 for what that means for scheduled entries.

---

## 4. Way B: callback

When a table definition cannot say which entries a visitor may see, return a
callback. WBCE Search calls it once per section of your module and expects it
to insert that section's rows. For a callback, `callback` is the only key read.

```php
<?php
defined('WB_PATH') or die();

return [
    'callback' => static function (
        Database $database, array $def, array $section,
        int $pid, int $sid, string $module,
        string $page_title, string $description, string $keywords,
        string $visibility, int $searching, int $now
    ): int {
        $count = 0;
        foreach (/* the entries of section $sid a visitor may see */ [] as $entry) {
            $database->insertRow('{TP_SEARCH}index', [
                'page_id'     => $pid,
                'section_id'  => $sid,
                'item_id'     => (int) $entry['id'],
                'module'      => $module,
                'title'       => $page_title,
                'item_title'  => $entry['title'],
                'description' => $description,
                'keywords'    => $keywords,
                'content'     => WbceSearchIndexer::plainText($entry['html']),
                'detail_url'  => WbceSearch::urlToToken($entry['url']),
                'thumb_url'   => WbceSearch::urlToToken($entry['thumb']),
                'visibility'  => $visibility,
                'searching'   => $searching,
                'indexed_at'  => $now,
            ]);
            if (!$database->hasError()) {
                $count++;
            }
        }
        return $count;
    },
];
```

What WBCE Search does around the call:

- **Before:** it has deleted every index row of section `$sid`. Do not delete
  anything yourself.
- **Return value:** the number of rows you wrote. `0` makes WBCE Search store a
  marker row ("processed, nothing to find") — the section then cannot be found
  at all, not even by the page title. If the page should stay findable without
  entries, write one row with `item_id` 0 and empty `item_title`/`content`
  (news_img does this).
- **Exceptions** are caught: the section gets a marker, the PHP error log a
  line `[wbce_search] indexing section N (module) failed: …`, and the run goes
  on with the next section.
- `$def` is your own array, `$section` the section row (`section_id`,
  `page_id`, `module`, page `link`, `language`, …).

A callback may also hand work to the table-definition indexer:
`(new WbceSearchIndexer($database))->indexByDef($tableDef, $section, $pid, $sid, $module, $page_title, $description, $keywords, $visibility, $searching, $now)`.

---

## 5. The index row

| Column        | What to put in                                                                |
| ------------- | ----------------------------------------------------------------------------- |
| `page_id`     | `$pid`                                                                        |
| `section_id`  | `$sid`                                                                        |
| `item_id`     | Your entry's ID; `0` for a row that stands for the section/page itself        |
| `module`      | `$module`                                                                     |
| `title`       | `$page_title` — always the **page** title, also on entry rows                 |
| `item_title`  | The entry's own title (empty for a page row)                                  |
| `description` | `$description` (page meta, passed through)                                    |
| `keywords`    | `$keywords` (page meta, passed through)                                       |
| `content`     | The entry's visible text as plain text: `WbceSearchIndexer::plainText($html)` |
| `detail_url`  | Absolute URL of the entry's own page; empty = the page                        |
| `thumb_url`   | Absolute URL of a small picture; empty = none                                 |
| `visibility`  | `$visibility`                                                                 |
| `searching`   | `$searching`                                                                  |
| `indexed_at`  | `$now`                                                                        |

Leave out `id` and `tokenized` — WBCE Search fills them (the word index of
large sites is built from your rows afterwards).

**Ranking:** a term in `title` or `item_title` counts most (admin setting "Title
weight"), then `keywords` (2), then `description` and `content` (1 each).

**What the visitor gets from your row:**

- A row with `item_id > 0` and an `item_title` is an *entry*: the results list
  shows it under its page with its own link, and the live search offers it as
  a suggestion of its own — title, page title as context line, picture.
- The excerpt comes from `content`, with the terms marked.
- Opening a hit adds `?searchresult=1&sstring=…` to `detail_url`; the core then
  highlights the terms on that page. So the page behind `detail_url` should
  show the text you indexed.

---

## 6. Rules

**Rights and drafts — the important one.** WBCE Search checks only the rights
of the *page* (visibility, viewing groups/users). Everything you index can be
found by everyone who may see the page. Index only what the page shows to every
one of them: no inactive entries, no drafts, nothing outside its publishing
window, nothing in a hidden group/category, nothing restricted to members.
Do not filter by the *current* user — indexing runs for whoever happens to
trigger it (see below).

**Scheduled entries.** Your filter sees the time of indexing. An entry that
becomes public tomorrow is not in today's index, and nothing re-indexes the
section when that moment comes; an entry that expires stays findable until the
section is indexed again. If that matters for your module, say in its
documentation that a "Full rebuild" picks such changes up.

**Plain text.** `content` is searched word by word and shown as excerpt. Pass
HTML through `WbceSearchIndexer::plainText()`: it removes tags, entities,
droplet calls `[[…]]` and `{PLACEHOLDERS}`, and keeps words of adjacent
paragraphs apart.

**URLs.** Store them through `WbceSearch::urlToToken()` (it replaces the site
URL by `{SYSVAR:WB_URL}`, so the index survives a move to another domain).
Build them yourself — `WB_URL . PAGES_DIRECTORY . $link . PAGE_EXTENSION` —
not with `page_link()` or `$wb`: the callback may run where neither exists.

**Pictures.** The live search loads `thumb_url` on every keystroke (44 px
tile). Point it to a thumbnail or preview image, not the original upload.

**No context.** Your callback runs in the backend (admin rebuild), during a
visitor's search (WBCE Search re-indexes a few changed sections then) and from
the command line. Do not rely on `PAGE_ID`, `$wb`, `$admin`, the session,
`$_GET`/`$_POST` or output buffering. Use the arguments and `$database`.

---

## 7. Keeping the index current

WBCE Search re-indexes a section when its **page's** `modified_when` is newer
than the section's index rows (lazily during searches, and with "Update changed" in
the admin tool). So every change to searchable data must bump it.

- **Scripts that go through `modules/admin.php`** — set the flag before the
  include; the core then touches the section and its page:

  ```php
  $update_when_modified = true;
  require WB_PATH . '/modules/admin.php';
  ```

- **Data that lands in another section** (move or copy to another section or
  page) and scripts without `modules/admin.php` (AJAX, frontend forms, import
  tools): call `$admin->touchSection($section_id)` (or `$wb->…`, WBCE 1.7+)
  for every section whose entries changed. news_img does this in
  `manage_posts.php` (mass copy/move/regroup) and `save_post.php` (a post
  moved to another section).

- Deleting an entry is a change too.
- Settings that change *what* is indexed (which fields count, say) touch no
  page: tell the administrator to run "Full rebuild".

---

## 8. Test it

1. **Admin-Tools → WBCE Search → Modules:** your module shows the source
   "From module".
2. **Overview → Full rebuild.**
3. Look at what was written:

   ```sql
   SELECT item_id, item_title, detail_url, thumb_url, LEFT(content, 80)
     FROM {TP}mod_search_index WHERE module = 'your_module';
   ```

4. Search on the frontend for a word of an entry — and for a word of an
   inactive or unpublished one, which must find nothing.
5. Type in the search field: entries appear as suggestions with their picture
   (setting "Images in suggestions").
6. Change an entry in the backend, search for the new word: found without a
   rebuild (section 7 works).
7. Nothing found at all? Check the PHP error log for `[wbce_search]`.

---

## 9. Checklist

- [ ] `modules/<your_module>/search_index.php` returns an array, starts with
      `defined('WB_PATH') or die();`, defines no global functions
- [ ] Only entries every visitor of the page may see (active, published,
      visible group, no members-only content)
- [ ] `title` = page title, `item_title` = entry title, `item_id` = entry ID
- [ ] `content` through `WbceSearchIndexer::plainText()`
- [ ] `detail_url`/`thumb_url` absolute, through `WbceSearch::urlToToken()`,
      built without `page_link()`; thumbnail, not original
- [ ] Callback returns the number of rows; page row with `item_id` 0 if the
      page should be findable without entries
- [ ] Every script that changes searchable data touches the section (and the
      target section of moves/copies)
- [ ] No writes to `{TP}search`; old `search.php` kept only for WBCE < 1.7
