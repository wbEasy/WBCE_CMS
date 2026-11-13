# Members — wbce_search Integration

**Modul:** `members` | **Tabellen:** `mod_members_groups`, `mod_members`

---

## Struktur

Members arbeitet mit zwei Tabellen:

- `mod_members_groups` — Gruppen (Anker an WBCE-Sektion)
- `mod_members` — Mitglieder (verknüpft über group_id)

Pro Gruppe können mehrere Mitglieder vorhanden sein → **Multi-Modus mit Join**.

---

## Variante — Semi-Konfig

Konfiguration über Admin-Tools → WBCE Search → Semi-Konfig.
Danach **module_defs/members.php generieren** und **Rebuild** durchführen.

### Haupttabelle

| Feld | Wert | Hinweis |
|---|---|---|
| Tabelle | `mod_members_groups` | Haupttabelle mit Gruppen |
| ID-Spalte | `section_id` | WBCE Seiten-Anker |
| Item-Schlüssel | `group_id` | PK pro Gruppe → Multi-Modus |
| Titel-Spalte | `group_name` | Name der Gruppe |
| Text-Spalten | — | Texte kommen aus Join |
| Link-Spalte | — kein Link — | |
| Modus | Multi | 1 Eintrag pro Gruppe |
| Index-Basis | Nur suchbare Seiten | |
| Filter | Nur aktive Einträge | `active = 1` |

### Join 1 — Mitglieder

| Feld | Wert |
|---|---|
| Tabelle | `mod_members` |
| ON Haupttabelle | `group_id` |
| ON Join-Tabelle | `group_id` |
| Text-Felder | `m_name` |
| Bild-Spalte | `m_picture` |
| Bild-Pfad Template | `members/` |

> Indexiert alle Mitgliedernamen der Gruppe. Vorschaubild = Bild des ersten Mitglieds.

---

## Hinweise

- `m_short1`, `m_short2` können zusätzlich als Text-Felder im Join ergänzt werden
- `m_link` kann als Link-Spalte im Join gesetzt werden wenn Mitglieder Direktlinks haben
- Kein eigener Direktlink auf Gruppenebene — Suchergebnis verlinkt auf die WBCE-Seite
- Bilder liegen in `media/members/`
