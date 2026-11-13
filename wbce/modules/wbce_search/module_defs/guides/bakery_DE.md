# Bakery — wbce_search Integration

**Modul:** `bakery` | **Tabelle:** `mod_bakery_items`

---

## Besonderheit

Bakery ist ein Shop-Modul mit Produkten und Produktbildern in separaten Tabellen.
Jedes Produkt wird als eigener Index-Eintrag gespeichert — **Multi-Modus mit Join**.

---

## Variante — Konfiguriert (Standard)

Die Datei `module_defs/bakery.php` ist bereits im Paket enthalten.
Kein Setup nötig — nach dem Rebuild werden Bakery-Produkte indexiert.

### Was indexiert wird

| Feld | Inhalt |
|---|---|
| `title` | Produkttitel (höchste Priorität) |
| `description` | Kurzbeschreibung |
| `full_desc` | Vollständige Beschreibung |
| `link` | Direktlink zum Produkt |
| `filename` | Vorschaubild aus `media/bakery/thumbs/item{item_id}/` |

### Filter

| Filter | Wert |
|---|---|
| Nur aktive Produkte | `active = 1` |

### Modus

**Multi** — jedes Produkt wird als eigener Index-Eintrag gespeichert.

### Join — Produktbilder

| Feld | Wert |
|---|---|
| Tabelle | `mod_bakery_images` |
| ON Haupttabelle | `item_id` |
| ON Join-Tabelle | `item_id` |
| Bild-Spalte | `filename` |
| Bild-Pfad Template | `bakery/thumbs/item{item_id}/` |

Erstes Bild des Produkts wird als Vorschaubild verwendet.

---

## Variante — Semi-Konfig

Falls eine angepasste Konfiguration benötigt wird.

### Haupttabelle

| Feld | Wert | Hinweis |
|---|---|---|
| Tabelle | `mod_bakery_items` | Haupttabelle mit Produkten |
| ID-Spalte | `section_id` | WBCE Seiten-Anker |
| Item-Schlüssel | `item_id` | Eindeutiger PK pro Produkt |
| Titel-Spalte | `title` | Produktname |
| Text-Spalten | `description`, `full_desc` | Kurz- und Langbeschreibung |
| Link-Spalte | `link` | Direktlink zum Produkt |
| Modus | Multi | 1 Eintrag pro Produkt |
| Index-Basis | Alle Abschnitte | |
| Filter | Nur aktive Einträge | `active = 1` |

### Join — Bilder

| Feld | Wert |
|---|---|
| Tabelle | `mod_bakery_images` |
| ON Haupttabelle | `item_id` |
| ON Join-Tabelle | `item_id` |
| Bild-Spalte | `filename` |
| Bild-Pfad Template | `bakery/thumbs/item{item_id}/` |

---

## Hinweise

- Bilder liegen in `media/bakery/thumbs/item{item_id}/`
- Der Direktlink führt auf die Produktdetailseite
- Nach dem Hinzufügen neuer Produkte Rebuild durchführen
- `sku` und weitere Felder können zusätzlich als Text-Spalten ergänzt werden
