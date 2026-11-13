# Semi-Konfig — Hilfe

Mit der Semi-Konfig kannst du beliebige WBCE-Module für die Suche konfigurieren, ohne PHP-Code schreiben zu müssen.

## Schritt für Schritt

### 1. Tabelle wählen
Wähle die **Haupttabelle** des Moduls — das ist die Tabelle die eine `section_id` Spalte enthält. Tipp: In phpMyAdmin kannst du sehen welche Tabellen das Modul verwendet (Tabellennamen beginnen mit `mod_{modulname}`).

### 2. ID-Spalte
Fast immer `section_id` — diese Spalte verknüpft die Modultabelle mit der WBCE-Seite.

### 3. Item-Schlüssel
Nur bei Modulen mit mehreren Einträgen pro Seite (z.B. Shop-Produkte, Blog-Beiträge). Wähle den eindeutigen Primärschlüssel des Eintrags, z.B. `item_id` oder `post_id`. Leer lassen wenn nur ein Eintrag pro Seite vorhanden ist.

### 4. Titel-Spalte
Das Feld das als Titel des Suchergebnisses angezeigt wird, z.B. `title` oder `name`.

### 5. Text-Spalten
Felder deren Inhalt durchsucht werden soll. Wähle nur Felder mit echtem Textinhalt — keine IDs, Zeitstempel oder technischen Felder.

### 6. Link-Spalte
Feld mit dem relativen URL-Pfad zum Eintrag. wbce_search baut daraus automatisch die vollständige URL.

### 7. Bild-Spalte und Pfad
Wenn das Modul Vorschaubilder hat: Wähle das Feld mit dem Dateinamen und gib den Pfad zum Bildordner an.

**Platzhalter im Pfad:**
- `{item_id}` — wird durch die Item-ID ersetzt
- `{section_id}` — wird durch die Abschnitts-ID ersetzt
- `{page_id}` — wird durch die Seiten-ID ersetzt

Beispiel: `produkte/bilder/item{item_id}/`

### 8. Modus
- **Single** — ein Eintrag pro Seitenabschnitt (z.B. einfache Inhaltsmodule)
- **Multi** — mehrere Einträge pro Abschnitt (z.B. Shop, News, Galerie)

### 9. Index-Basis
- **Nur suchbare Seiten** — nur Seiten die in den WBCE-Seiteneinstellungen als durchsuchbar markiert sind
- **Alle Abschnitte** — alle Abschnitte unabhängig von der Seiteneinstellung

### 10. Filter
- **Nur aktive Einträge** — nur Einträge mit `active = 1` indexieren
- **Zeitsteuerung** — Einträge mit `published_when` und `published_until` berücksichtigen

### 11. Joins
Wenn Bilder oder Texte in einer **separaten Tabelle** liegen (z.B. Bildertabelle für einen Shop), kannst du bis zu 3 zusätzliche Tabellen verknüpfen.

**Wann ist ein Join nötig?**
Wenn das Bild oder ein Text nicht in der Haupttabelle steht sondern in einer eigenen Tabelle die über eine gemeinsame ID verknüpft ist.

---

## Tipp
Nach dem Speichern auf **Rebuild** klicken damit die neuen Einstellungen in den Suchindex übernommen werden.
