# WYSIWYG — wbce_search Integration

**Module:** `wysiwyg` (also: `ckeditor`)
**Table:** `mod_wysiwyg`

---

## Special feature

WYSIWYG is the standard page module in WBCE. Each section corresponds to
exactly one index entry — no own item key needed.

---

## Variant — Configured (standard)

The file `module_defs/wysiwyg.php` is already included in the package.
No setup needed — WYSIWYG content is indexed automatically.

### What gets indexed

| Field | Content |
|---|---|
| `content` | HTML content of the section (tags are removed) |
| Page title | Comes from `{TP}pages.page_title` |
| Description | Comes from page metadata |
| Keywords | Comes from page metadata |

### Mode

**Single** — 1 index entry per section.

### No direct link

WYSIWYG has no own item URL — the search result links
directly to the WBCE page.

---

## Notes

- No preview image (WYSIWYG does not store images in its own table)
- Multiple WYSIWYG sections on one page are indexed individually
- HTML tags are removed before indexing
- Pages with `Search: Disabled` are not indexed
