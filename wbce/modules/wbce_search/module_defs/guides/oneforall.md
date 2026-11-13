# OneForAll (OFA) — wbce_search Integration

**Module:** `oneforall` | **Tables:** `mod_oneforall_items`, `mod_oneforall_item_fields`, `mod_oneforall_images`

---

## Variant A — Semi-config (for admins)

Configuration via Admin Tools → WBCE Search → Semi-Config.
Then **generate module_defs/oneforall.php** and run **rebuild**.

### Main table

| Field | Value | Note |
|---|---|---|
| Table | `mod_oneforall_items` | Main table with all entries |
| ID column | `section_id` | WBCE page anchor |
| Item key | `item_id` | Unique PK per entry → multi mode |
| Title column | `title` | Entry title |
| Text columns | `title`, `description` | Searched in full text |
| Link column | `link` | Entry path (e.g. `/my-entry`) |
| Link prefix | Page name of OFA page | e.g. `products` gives `/pages/products/my-entry.php` |
| Image column | — no image — | Image comes from join 2 |
| Mode | Multi | 1 index entry per item |
| Index base | Searchable pages only | |
| Filter | Active entries only | `active = 1` |

### Join 1 — Custom fields

| Field | Value |
|---|---|
| Table | `mod_oneforall_item_fields` |
| ON main table | `item_id` |
| ON join table | `item_id` |
| Text fields | `value` |

Indexes all custom text fields (type: text, long text, WYSIWYG).

### Join 2 — Images

| Field | Value |
|---|---|
| Table | `mod_oneforall_images` |
| ON main table | `item_id` |
| ON join table | `item_id` |
| Image column | `filename` |
| Image path template | `oneforall/thumbs/item{item_id}/` |

First active image of the entry is used as preview image.

---

## Variant B — Callback (for developers)

For requirements that semi-config cannot cover.

### 1. module_defs/oneforall.php

```php
return [
    'table'      => 'mod_oneforall_items',
    'id_field'   => 'section_id',
    'callback'   => [WbceSearchIndexer::class, 'indexOneforall'],
    'mode'       => 'multi',
    'index_base' => 'page',
    'suggest'    => true,
];
```

### 2. Callback in WbceSearchIndexer.php

The method `WbceSearchIndexer::indexOneforall()` is already implemented.
It reads items, custom fields and images and builds the detail URL:

```
Page link + item link + PAGE_EXTENSION
→ https://example.com/pages/my-page/my-entry.php
```

### When callback instead of semi-config?

| Situation | Recommendation |
|---|---|
| Standard OFA configuration | Semi-config |
| OFA with link prefix | Semi-config |
| More than 3 joins needed | Callback |
| Custom URL logic | Callback |

---

## Notes

- The `link` column contains the entry path (e.g. `/my-entry`)
- The link prefix corresponds to the filename of the OFA page in the WBCE backend
- Preview images are stored in `media/oneforall/thumbs/item{item_id}/`
- PNG files are automatically searched as JPG
