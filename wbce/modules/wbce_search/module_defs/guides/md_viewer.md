# MD Viewer — wbce_search Integration

**Module:** `md_viewer` | **Table:** `mod_md_viewer`

---

## Special feature

MD Viewer stores content as Markdown files in the media directory — not as text in the database. Therefore only a **callback indexer** is possible. Semi-config is not practical.

---

## Variant — Callback (standard)

The callback `WbceSearchIndexer::indexMdViewer()` is already implemented in `WbceSearchIndexer.php` and is used automatically.

### module_defs/md_viewer.php

```php
return [
    'table'      => 'mod_md_viewer',
    'id_field'   => 'section_id',
    'callback'   => [WbceSearchIndexer::class, 'indexMdViewer'],
    'mode'       => 'single',
    'index_base' => 'page',
    'suggest'    => true,
];
```

### What the callback indexes

| Source | Content |
|---|---|
| `mod_md_viewer.md_source` | Path to MD file in media directory |
| `mod_md_viewer.md_source_type` | Must be `internal` — external sources are not indexed |
| MD file (full text) | Markdown syntax is removed, plain text is indexed |
| Page metadata | Title, description, keywords of the WBCE page |

### What is not indexed

| Situation | Reason |
|---|---|
| `md_source_type = external` | External files are not read |
| Empty MD file | No content available |
| File outside `media/` | Security check fails |

---

## Limitations

- No preview image (MD Viewer has no image assignment)
- No item link — search result links to the WBCE page
- Droplet syntax `[[...]]` is removed before indexing

---

## Notes

- Always run **rebuild** after uploading a new MD file
- MD Viewer must be included as a section on a searchable page
- The page type must be set to `Enabled` (search setting of the page)
