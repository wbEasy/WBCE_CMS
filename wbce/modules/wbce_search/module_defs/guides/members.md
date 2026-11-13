# Members — wbce_search Integration

**Module:** `members` | **Tables:** `mod_members_groups`, `mod_members`

---

## Structure

Members works with two tables:

- `mod_members_groups` — groups (anchor to WBCE section)
- `mod_members` — members (linked via group_id)

Multiple members can exist per group → **multi mode with join**.

---

## Variant — Semi-config

Configuration via Admin Tools → WBCE Search → Semi-Config.
Then **generate module_defs/members.php** and run **rebuild**.

### Main table

| Field | Value | Note |
|---|---|---|
| Table | `mod_members_groups` | Main table with groups |
| ID column | `section_id` | WBCE page anchor |
| Item key | `group_id` | PK per group → multi mode |
| Title column | `group_name` | Group name |
| Text columns | — | Texts come from join |
| Link column | — no link — | |
| Mode | Multi | 1 entry per group |
| Index base | Searchable pages only | |
| Filter | Active entries only | `active = 1` |

### Join 1 — Members

| Field | Value |
|---|---|
| Table | `mod_members` |
| ON main table | `group_id` |
| ON join table | `group_id` |
| Text fields | `m_name` |
| Image column | `m_picture` |
| Image path template | `members/` |

> Indexes all member names of the group. Preview image = image of first member.

---

## Notes

- `m_short1`, `m_short2` can be added as additional text fields in the join
- `m_link` can be set as link column in the join if members have direct links
- No direct link at group level — search result links to the WBCE page
- Images are stored in `media/members/`
