# Semi-Config — Help

With the semi-config you can configure any WBCE module for search without writing PHP code.

## Step by step

### 1. Select table
Select the **main table** of the module — the table that contains a `section_id` column. Tip: In phpMyAdmin you can see which tables the module uses (table names start with `mod_{modulename}`).

### 2. ID column
Almost always `section_id` — this column links the module table to the WBCE page.

### 3. Item key
Only for modules with multiple entries per page (e.g. shop products, blog posts). Select the unique primary key of the entry, e.g. `item_id` or `post_id`. Leave empty if only one entry per page exists.

### 4. Title column
The field displayed as the title of the search result, e.g. `title` or `name`.

### 5. Text columns
Fields whose content should be searched. Select only fields with real text content — no IDs, timestamps or technical fields.

### 6. Link column
Field with the relative URL path to the entry. wbce_search automatically builds the full URL from this.

### 7. Image column and path
If the module has preview images: select the field with the filename and enter the path to the image folder.

**Placeholders in path:**
- `{item_id}` — replaced by the item ID
- `{section_id}` — replaced by the section ID
- `{page_id}` — replaced by the page ID

Example: `products/images/item{item_id}/`

### 8. Mode
- **Single** — one entry per page section (e.g. simple content modules)
- **Multi** — multiple entries per section (e.g. shop, news, gallery)

### 9. Index base
- **Searchable pages only** — only pages marked as searchable in WBCE page settings
- **All sections** — all sections regardless of page setting

### 10. Filter
- **Active entries only** — only index entries with `active = 1`
- **Time control** — consider entries with `published_when` and `published_until`

### 11. Joins
If images or texts are in a **separate table** (e.g. image table for a shop), you can link up to 3 additional tables.

**When is a join needed?**
When the image or text is not in the main table but in its own table linked via a common ID.

---

## Tip
After saving click **Rebuild** so the new settings are applied to the search index.
