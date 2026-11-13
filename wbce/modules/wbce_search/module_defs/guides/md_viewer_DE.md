# MD Viewer — wbce_search Integration

**Modul:** `md_viewer` | **Tabelle:** `mod_md_viewer`

---

## Besonderheit

MD Viewer speichert Inhalte als Markdown-Dateien im Medienverzeichnis — nicht als Text in der Datenbank. Deshalb ist nur ein **Callback-Indexer** möglich. Semi-Konfig ist nicht sinnvoll.

---

## Variante — Callback (Standard)

Der Callback `WbceSearchIndexer::indexMdViewer()` ist bereits in `WbceSearchIndexer.php` implementiert und wird automatisch verwendet.

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

### Was der Callback indexiert

| Quelle | Inhalt |
|---|---|
| `mod_md_viewer.md_source` | Pfad zur MD-Datei im Medienverzeichnis |
| `mod_md_viewer.md_source_type` | Muss `internal` sein — externe Quellen werden nicht indexiert |
| MD-Datei (Volltext) | Markdown-Syntax wird entfernt, reiner Text wird indexiert |
| Seiten-Metadaten | Titel, Beschreibung, Schlüsselwörter der WBCE-Seite |

### Was nicht indexiert wird

| Situation | Grund |
|---|---|
| `md_source_type = external` | Externe Dateien werden nicht gelesen |
| Leere MD-Datei | Kein Inhalt vorhanden |
| Datei außerhalb von `media/` | Sicherheitsprüfung schlägt an |

---

## Einschränkungen

- Kein Vorschaubild (MD Viewer hat keine Bild-Zuordnung)
- Kein Item-Link — Suchergebnis verlinkt auf die WBCE-Seite
- Droplet-Syntax `[[...]]` wird vor der Indexierung entfernt

---

## Hinweise

- Nach dem Hochladen einer neuen MD-Datei immer **Rebuild** durchführen
- MD Viewer muss als Abschnitt auf einer suchbaren Seite eingebunden sein
- Der Seitentyp muss auf `Aktiviert` stehen (Suchen-Einstellung der Seite)
