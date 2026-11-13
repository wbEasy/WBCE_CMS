# OneForAll (OFA) — wbce_search Integration

**Modul:** `oneforall` | **Tabellen:** `mod_oneforall_items`, `mod_oneforall_item_fields`, `mod_oneforall_images`

---

## Variante A — Semi-Konfig (für Admins)

Konfiguration über Admin-Tools → WBCE Search → Semi-Konfig.
Danach **module_defs/oneforall.php generieren** und **Rebuild** durchführen.

### Haupttabelle

| Feld | Wert | Hinweis |
|---|---|---|
| Tabelle | `mod_oneforall_items` | Haupttabelle mit allen Einträgen |
| ID-Spalte | `section_id` | WBCE Seiten-Anker |
| Item-Schlüssel | `item_id` | Eindeutiger PK pro Eintrag → Multi-Modus |
| Titel-Spalte | `title` | Titel des Eintrags |
| Text-Spalten | `title`, `description` | Werden im Volltext durchsucht |
| Link-Spalte | `link` | Eintrag-eigener Pfad (z.B. `/mein-eintrag`) |
| Link-Prefix | Seitenname der OFA-Seite | z.B. `produkte` ergibt `/pages/produkte/mein-eintrag.php` |
| Bild-Spalte | — kein Bild — | Bild kommt aus Join 2 |
| Modus | Multi | 1 Index-Eintrag pro Item |
| Index-Basis | Nur suchbare Seiten | |
| Filter | Nur aktive Einträge | `active = 1` |

### Join 1 — Zusatzfelder

| Feld | Wert |
|---|---|
| Tabelle | `mod_oneforall_item_fields` |
| ON Haupttabelle | `item_id` |
| ON Join-Tabelle | `item_id` |
| Text-Felder | `value` |

Indexiert alle benutzerdefinierten Textfelder (Typ: Text, Langer Text, WYSIWYG).

### Join 2 — Bilder

| Feld | Wert |
|---|---|
| Tabelle | `mod_oneforall_images` |
| ON Haupttabelle | `item_id` |
| ON Join-Tabelle | `item_id` |
| Bild-Spalte | `filename` |
| Bild-Pfad Template | `oneforall/thumbs/item{item_id}/` |

Erstes aktives Bild des Eintrags wird als Vorschaubild verwendet.

---

## Variante B — Callback (für Entwickler)

Für Anforderungen die Semi-Konfig nicht abdeckt.

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

Die Methode `WbceSearchIndexer::indexOneforall()` ist bereits implementiert.
Sie liest Items, Zusatzfelder und Bilder und baut die Detail-URL zusammen:

```
Seiten-Link + Item-Link + PAGE_EXTENSION
→ https://example.com/pages/meine-seite/mein-eintrag.php
```

### Wann Callback statt Semi-Konfig?

| Situation | Empfehlung |
|---|---|
| Standard OFA Konfiguration | Semi-Konfig |
| OFA mit Link-Prefix | Semi-Konfig |
| Mehr als 3 Joins nötig | Callback |
| Individuelle URL-Logik | Callback |

---

## Hinweise

- Die `link`-Spalte enthält den eintragseigenen Pfad (z.B. `/mein-eintrag`)
- Der Link-Prefix entspricht dem Dateinamen der OFA-Seite im WBCE-Backend
- Vorschaubilder liegen in `media/oneforall/thumbs/item{item_id}/`
- PNG-Dateien werden automatisch als JPG gesucht
