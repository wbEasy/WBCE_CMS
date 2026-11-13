# WBCE Search

**Version:** 0.6.1 | **Plattform:** WBCE CMS 1.7.0+ | **PHP:** 8.1+ | **Datenbank:** MySQL/MariaDB oder SQLite
**Lizenz:** GNU General Public License | **Autoren:** Peter Kitzinger (Slugger), Christian M. Stefan ([wbEasy.de](https://www.wbEasy.de)) | © WBCE Project

---

## Was ist WBCE Search?

WBCE Search ist die Suche von WBCE CMS. Seit 1.7.0 ist es ein
**Core-Modul**: Es wird mit dem CMS installiert, bedient die Suchseite
`/search/` und lässt sich nicht deinstallieren. Eine andere Suche gibt es
nicht mehr.

Es indiziert Seiteninhalte, Modul-Einträge und verlinkte Mediendateien in
eigenen Tabellen (`{TP}mod_search_index`, `…_words`, `…_stats`) und bietet:

- Volltextsuche mit Operatoren (Phrasen, Wildcard, Ausschluss, ODER,
  Tippfehler-Toleranz)
- Ranking mit Titelgewichtung
- Hervorgehobene Textausschnitte, Seitenblätterung
- „Meinten Sie …?“, wenn eine Suche nichts findet
- Hervorhebung der Treffer auf der Zielseite — der Besucher landet an der
  Fundstelle
- Live-Suche mit Vorschlägen beim Tippen (Titel und Seitentext, mit
  Vorschaubildern bei Modul-Einträgen)
- Tag-Cloud der gesuchten Begriffe, als Droplet
- Erweiterte Suche (Bereich: nur Titel / nur Inhalt)
- Ergebnisseite und Tag-Cloud als Layout-Dateien, im Admin-Tool bearbeitbar
  und per Template überschreibbar

Gefunden werden nur Seiten, die der Besucher sehen darf — Sichtbarkeit,
Gruppen und Papierkorb werden bei jeder Suche geprüft, nicht nur beim
Indizieren.

---

## Erste Schritte

1. *Einstellungen* → „Suche“: wer suchen darf (öffentlich / registriert /
   privat / aus). Derselbe Schalter steht unter Admin-Tools → WBCE Search →
   Übersicht.
2. Admin-Tools → WBCE Search → Übersicht: einmal **Vollständig neu
   aufbauen**.

Danach hält sich der Index selbst aktuell: Jede Suche aktualisiert
nebenbei einige geänderte Abschnitte (Einstellung „Auto-Reindex bei
Suche“).

---

## Suchoperatoren

| Eingabe                       | Bedeutung                                                 |
| ----------------------------- | --------------------------------------------------------- |
| `senf bio`                    | Alle Wörter müssen vorkommen                              |
| `senf -scharf`                | senf ja, scharf nein                                      |
| `senf \| ketchup`             | Eines der Wörter genügt (auch `OR`, großgeschrieben)      |
| `"gelber senf"`               | Exakte Phrase                                             |
| `senf*`                       | Beginnt mit senf (Wildcard)                               |
| `sneff~`                      | Toleriert Tippfehler — findet auch senf (ab 5 Buchstaben) |
| `senf bio -scharf "aus mais"` | Kombination aller Operatoren                              |

Findet eine Suche nichts, bietet die Ergebnisseite **„Meinten Sie …?“** mit
der nächstliegenden bekannten Schreibweise an — nur wenn diese Suche auch
etwas findet. Vorschläge stammen nur aus Wörtern öffentlicher Seiten.

---

## Admin-Tool

Admin-Tools → WBCE Search, fünf Seiten: **Übersicht**, **Module**,
**Layout**, **Einstellungen**, **Statistik**.

### Suchindex (Übersicht)

| Aktion                   | Wann                                                                        |
| ------------------------ | --------------------------------------------------------------------------- |
| Vollständig neu aufbauen | Beim ersten Mal, nach dem Installieren oder Konfigurieren von Modulen       |
| Geänderte aktualisieren  | Nach vielen Inhaltsänderungen; liest nur geänderte oder fehlende Abschnitte |
| Index löschen            | Kompletter Neustart                                                         |

Der vollständige Neuaufbau läuft in einer Transaktion: Bricht er ab, bleibt
der alte Index erhalten. Ein Abschnitt, der sich nicht indizieren lässt,
wird protokolliert und übersprungen.

Große Seiten (standardmäßig ab 2 000 Index-Einträgen) bekommen zusätzlich
einen Wort-Index, der die Suche schnell hält. Er wird automatisch aufgebaut
und lässt sich in den Einstellungen ein- oder ausschalten.

### Module

Jedes installierte Modul wird mit der Herkunft seiner Suchdefinition
aufgeführt:

| Herkunft                      | Bedeutung                                                                |
| ----------------------------- | ------------------------------------------------------------------------ |
| Vom Modul                     | Das Modul liefert `search_index.php` selbst mit — hier nicht bearbeitbar |
| Callback                      | Indiziert über einen PHP-Callback — hier nicht bearbeitbar               |
| Mitgeliefert                  | Definition liegt WBCE Search bei (`module_defs/`)                        |
| Semi-Konfig                   | Definition aus der Semi-Konfig generiert                                 |
| Semi-Konfig – nicht generiert | Semi-Konfig gespeichert, Definition noch nicht generiert                 |
| search.php erkannt            | Noch keine Definition — die Semi-Konfig lässt sich daraus vorbelegen     |
| Nur Seitentitel               | Keine Definition — nur der Seitentitel wird indiziert                    |

Gibt es mehrere, gilt diese Reihenfolge: das eigene `search_index.php` des
Moduls > Semi-Konfig > `module_defs/`.

Badges zeigen den Modultyp: **Page**, **Snippet**, **Filter**, **Tool**.

### Semi-Konfig

Für Module ohne Definition, eingerichtet im Admin-Tool:

1. Tabelle wählen (Haupttabelle mit `section_id`)
2. ID-Spalte (fast immer `section_id`)
3. Item-Schlüssel (z. B. `item_id`)
4. Titel-Spalte
5. Text-Spalten (mehrere möglich)
6. Link-Spalte + Link-Präfix (optional)
7. Bild-Spalte + Pfad-Vorlage (`{item_id}`, `{section_id}`, `{page_id}`)
8. Modus: einfach oder mehrfach
9. Index-Basis: nur durchsuchbare Seiten oder alle Abschnitte
10. Filter: nur aktive / Zeitsteuerung
11. Joins: bis zu 3 weitere Tabellen
12. `module_defs/MODULE.php` generieren → neu aufbauen

Akzeptiert werden nur `mod_*`-Tabellen mit `section_id` und deren
tatsächliche Spalten.

### Layout

Drei Karten: **Suchergebnisseite**, **Tag-Cloud**, **Stylesheet**. Für
jede wählen Sie, welche Datei verwendet wird:

- Ihre eigene Kopie (`layouts/<name>_custom.htt`, `layouts/fe_search_custom.css`)
- die Datei des Such-Templates (`templates/<template>/search/…`, nur lesbar)
- die mitgelieferte Vorgabe (nur lesbar)

„Bearbeiten“ auf einer nur lesbaren Datei kopiert sie zuerst in Ihre eigene
Kopie. Die Layouts verwenden die LayoutParser-Syntax (`[KEY]`, `{foreach}`,
`{if}` …).

### Einstellungen

| Einstellung                       | Standard           | Beschreibung                                          |
| --------------------------------- | ------------------ | ----------------------------------------------------- |
| Minimale Wortlänge                | 3                  | Kürzere Begriffe werden ignoriert                     |
| Titelgewichtung                   | 3                  | Treffer im Titel zählen stärker                       |
| Ergebnisse pro Seite              | 10                 | Seitenblätterung                                      |
| Sprachfilter                      | Aus                | Nur Seiten in der Sprache des Besuchers               |
| Erweiterte Suche                  | Aus                | Bereichs-Checkboxen auf der Suchseite                 |
| Max. Excerpt-Länge                | 200                | Zeichen im Vorschautext                               |
| Highlight / Highlight-Tag         | An / `mark`        | Suchbegriffe hervorheben (`mark`, `strong` oder `em`) |
| Template der Suchseite            | (Website-Standard) | Frontend-Template, in dem die Suchseite erscheint     |
| Auto-Reindex bei Suche            | An                 | Veraltete Abschnitte beim Suchen aktualisieren        |
| Max. Abschnitte pro Suche         | 5                  | Grenze für den Auto-Reindex                           |
| Wort-Index / Wort-Index ab        | Auto / 2 000       | Auto, an oder aus; Schwelle für „Auto“                |
| AJAX Live-Suche                   | An                 | Vorschläge beim Tippen                                |
| Quelle der Vorschläge             | Hybrid             | Erst Titel, aufgefüllt aus dem Seitentext             |
| Max. Vorschläge                   | 5                  |                                                       |
| Bilder in Vorschlägen             | An                 | Bild von Modul-Einträgen                              |
| Tag-Cloud anzeigen                | An                 | Schaltet die Ausgabe des Droplets an/aus              |
| Tag-Cloud aufzeichnen             | An                 | Gesuchte Begriffe für die Tag-Cloud erfassen          |
| Max. Begriffe / Min. Suchanfragen | 20 / 1             | Vorgaben für das Droplet                              |
| Debug-Modus                       | Aus                | Zusatzinfos auf der Ergebnisseite (nur Admins)        |
| Navigation                        | Tabs oben          | Admin-Tool: Tabs oben oder Leiste links               |

### Statistik

Gesuchte Begriffe mit ihrer Anzahl; einzelne Begriffe lassen sich
entfernen. Suchen ohne Ergebnis stehen gesondert unter „Gesucht, nichts
gefunden“ — nützlich, um zu sehen, was Besucher vermissen.

---

## Eigenes Modul indizieren

Ein Modul kann seine Indizierung selbst mitliefern:
`modules/<modul>/search_index.php`. News with Images (news_img) macht das
zum Beispiel so.

Wie man eine schreibt:
[SEARCH_INDEX_HOWTO.md](SEARCH_INDEX_HOWTO.md).

Definitionen, die WBCE Search mitliefert (`module_defs/`):

| Modul     | Art          | Beschreibung                                         |
| --------- | ------------ | ---------------------------------------------------- |
| wysiwyg   | Mitgeliefert | WYSIWYG-Abschnitte                                   |
| bakery    | Mitgeliefert | Bakery-Shop mit Produktbildern                       |
| md_viewer | Callback     | MD Viewer (vollständige Markdown-Dateien)            |
| oneforall | Callback     | OneForAll — Einträge mit Link, Bild, eigenen Feldern |

Für jedes andere Modul die Semi-Konfig im Admin-Tool verwenden.

---

## Tag-Cloud-Droplet

```
[[wbce_search_tagcloud]]
[[wbce_search_tagcloud?max=15&min_count=2]]
[[wbce_search_tagcloud?active=false]]
```

| Parameter   | Standard         | Bedeutung                                                      |
| ----------- | ---------------- | -------------------------------------------------------------- |
| `max`       | Einstellung (20) | Höchstzahl der Begriffe                                        |
| `min_count` | Einstellung (1)  | Mindestzahl Suchen pro Begriff                                 |
| `desc`      | Sprachtext       | Eigene Beschriftung; leer = keine Beschriftung                 |
| `active`    | `true`           | `false` blendet das Droplet aus (unabhängig von der Suchseite) |

Das HTML stammt aus einer Layout-Datei; ein Template kann sie mit einer
eigenen `search/tagcloud.htt` überschreiben.

---

## Weiterlesen

- [CHANGELOG.md](CHANGELOG.md) — Änderungen je Version
- [SEARCH_INDEX_HOWTO.md](SEARCH_INDEX_HOWTO.md) — Suchdefinition für ein Modul
- [DEVELOPER.md](DEVELOPER.md) — Architektur und Klassen
