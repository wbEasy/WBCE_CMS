# WYSIWYG — wbce_search Integration

**Modul:** `wysiwyg` (auch: `ckeditor`)
**Tabelle:** `mod_wysiwyg`

---

## Besonderheit

WYSIWYG ist das Standard-Seitenmodul in WBCE. Jeder Abschnitt entspricht
genau einem Index-Eintrag — kein eigener Item-Schluessel noetig.

---

## Variante — Konfiguriert (Standard)

Die Datei `module_defs/wysiwyg.php` ist bereits im Paket enthalten.
Kein Setup noetig — WYSIWYG-Inhalte werden automatisch indexiert.

### Was indexiert wird

| Feld | Inhalt |
|---|---|
| `content` | HTML-Inhalt des Abschnitts (Tags werden entfernt) |
| Seitentitel | Kommt aus `{TP}pages.page_title` |
| Beschreibung | Kommt aus Seiten-Metadaten |
| Schluesselwoerter | Kommt aus Seiten-Metadaten |

### Modus

**Single** — 1 Index-Eintrag pro Abschnitt.

### Kein Direktlink

WYSIWYG hat keine eigene Item-URL — das Suchergebnis verlinkt
direkt auf die WBCE-Seite.

---

## Hinweise

- Kein Vorschaubild (WYSIWYG speichert keine Bilder in eigener Tabelle)
- Mehrere WYSIWYG-Abschnitte auf einer Seite werden einzeln indexiert
- HTML-Tags werden vor der Indexierung entfernt
- Seiten mit `Suchen: Deaktiviert` werden nicht indexiert
