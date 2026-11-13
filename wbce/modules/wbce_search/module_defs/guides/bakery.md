# Bakery — wbce_search Integration

**Module:** `bakery` | **Table:** `mod_bakery_items`

---

## Special feature

Bakery is a shop module with products and product images in separate tables.
Each product is stored as its own index entry — **multi mode with join**.

---

## Variant — Configured (standard)

The file `module_defs/bakery.php` is already included in the package.
No setup needed — after rebuild Bakery products will be indexed.

### What gets indexed

| Field | Content |
|---|---|
| `title` | Product title (highest priority) |
| `description` | Short description |
| `full_desc` | Full description |
| `link` | Direct link to product |
| `filename` | Preview image from `media/bakery/thumbs/item{item_id}/` |

### Filter

| Filter | Value |
|---|---|
| Active products only | `active = 1` |

### Mode

**Multi** — each product is stored as its own index entry.

### Join — Product images

| Field | Value |
|---|---|
| Table | `mod_bakery_images` |
| ON main table | `item_id` |
| ON join table | `item_id` |
| Image column | `filename` |
| Image path template | `bakery/thumbs/item{item_id}/` |

First image of the product is used as preview image.

---

## Variant — Semi-config

If a customized configuration is needed.

### Main table

| Field | Value | Note |
|---|---|---|
| Table | `mod_bakery_items` | Main table with products |
| ID column | `section_id` | WBCE page anchor |
| Item key | `item_id` | Unique PK per product |
| Title column | `title` | Product name |
| Text columns | `description`, `full_desc` | Short and long description |
| Link column | `link` | Direct link to product |
| Mode | Multi | 1 entry per product |
| Index base | All sections | |
| Filter | Active entries only | `active = 1` |

### Join — Images

| Field | Value |
|---|---|
| Table | `mod_bakery_images` |
| ON main table | `item_id` |
| ON join table | `item_id` |
| Image column | `filename` |
| Image path template | `bakery/thumbs/item{item_id}/` |

---

## Notes

- Images are stored in `media/bakery/thumbs/item{item_id}/`
- The direct link leads to the product detail page
- Run rebuild after adding new products
- `sku` and other fields can be added as additional text columns
