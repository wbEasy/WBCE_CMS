# Changelog

All notable changes to the `MarkdownWbce` module.

## 0.2.0 - 2026-08-19 Christian M. Stefan

### Added
- **Editing.** `reader.php` gained a full edit mode (PlainMDE, loaded via
  `I::loadPlugin('include/PlainMDE')`) alongside the existing read-only view,
  backed by a new `ajax_save_doc.php` save endpoint.
- **Permission model.** Reading requires only a valid backend `Admin`
  session; writing requires `$admin->isAdmin()` or the `MarkdownWbce_tool`
  AdminTool permission specifically (same per-tool check as
  `admin/admintools/tool.php`) — not the generic
  `modules_install`/`modules_uninstall` system permission, and not tied to
  page ACL, since these are documentation files, not page content.
- **Hardening.** `MdReaderHelper::safePath()` now enforces a `.md` extension
  whitelist. `ajax_save_doc.php` is overwrite-only (never creates a new
  file), requires a valid FTAN token, and writes a JSON-lines audit log to
  `var/markdown_wbce/save.log`.
- **Frontend reach.** `MdReaderLink` is registered FE+BE (via the new
  `initialize.php`, not just `initialize_be.php`), so a link embedded on a
  live page works for any editor already logged into the backend in the
  same browser — the same cookie-based session `reader.php` already
  required, just no longer gated behind a `/admin/`-only registration.
- **Missing-base-file fallback.** `MdReaderHelper::findExistingDoc()` — if
  the requested `README.md` doesn't exist but a `README_<LANG>.md` variant
  does (or vice versa), that variant is served instead of a hard error.
- **Language switcher.** A segmented-control flag bar (styled after
  DynamicFields' `df-segmented` widget) lists every available
  `README_<CODE>.md` variant, including the base file itself as an implicit
  `EN` entry when at least one localized sibling also exists. Each flag
  carries an `exact` flag so an explicit language choice is never silently
  overridden by the visitor's own active `LANGUAGE`.
- **`` ```file-tree `` fenced blocks.** `ParsedownWbce::blockFencedCode()`
  special-cases this language tag to emit `<pre class="file-tree">` instead
  of a normal code block; `layout/filetree.js`/`filetree.css` (vendored from
  `modules/tiptap_editor`, restyled to match this module's own code-block
  toolbar) render it as a visual, icon-annotated tree. Lines starting with
  `//` or `#` render as plain comments instead of being mis-parsed as
  folders.
- **Syntax highlighting.** Rendered code blocks in the viewer use
  highlight.js (trial, loaded via cdnjs) instead of read-only CodeMirror
  instances, with a language badge and copy-to-clipboard button per block.
- **Light/dark theme.** The whole reader — chrome, sidebar, article content,
  code blocks, the FileTree renderer, and scrollbars — is CSS-variable
  driven with a light default, automatic `prefers-color-scheme: dark`
  support, and a manual toggle (persisted via `localStorage`) that always
  wins over the OS setting. highlight.js's theme stylesheet is swapped to
  match. The PlainMDE editor itself also gets a dark mode, scoped under a
  `.mdr-pmde-theme` wrapper class so the shared PlainMDE component's other
  four consumers are completely unaffected.
- Internal markdown links (`[x](./CHANGELOG.md)`, `[x](../docs/y.md)`) now
  resolve against the *document's own* directory instead of `reader.php`'s
  URL, using the same resolution the rendered viewer already applied to
  relative image paths.
- Relative image paths in the PlainMDE edit-mode preview now resolve the
  same way the rendered viewer already did.
- mtime-based cache-busting (`?v=…`) on all of this module's own
  `layout/*.css`/`*.js` assets.

### Changed
- Renamed from `MarkdownReader` to `MarkdownWbce` (directory, `info.php`,
  all internal path references).
- `MdrLink` → `MdReaderLink`, `MdrHelper` → `MdReaderHelper` (classes and
  filenames) — the shorter names read as too easily confused with each
  other and with unrelated `Mdr*`-prefixed symbols elsewhere.
- `ParsedownWbce` is now registered core-wide via `initialize.php`
  (`function = 'initialize, tool'`), not gated behind the backend-only
  `initialize_be.php` — WBCE needs a Markdown parser regardless of whether
  this module's own viewer/editor UI is ever opened.
- The reader's client-side filter/search box was removed — the browser's
  own find-in-page already covers it, and the extra UI wasn't earning its
  keep.
- Edit mode: Save moved to the right of the action row (Cancel stays left),
  the panel widened and centered, the sidebar hides while editing, and
  Cancel now triggers a full reload instead of a local DOM toggle — so a
  completed Save is reflected on screen without an extra manual refresh.
- Sidebar resize handle got a permanently visible grip ("handlebar") — the
  original was invisible until hovered, which turned out to be too subtle
  to find.

### Fixed
- `tool.php` didn't pass `returnToTools` to its Twig template, leaving the
  AdminTool's own "Back" button with an empty `href`.
- `modules/outputfilter_dashboard`'s help links (`opf_md_link()`) still
  pointed at the removed `include/MarkdownReader/reader.php?url=…`
  mechanism; also fixed a pre-existing missing-argument bug in the same
  function's `(md)`-marked DB-configured helppath branch.
- Windows-style backslashes could leak into generated doc URLs
  (`/modules\Foo\docs\README_DE.md`) on this Windows dev install — fine by
  browser leniency locally, broken on a real Linux/Apache deployment.

## 0.1.0 2026-08-09 Christian M. Stefan

- Initial release (as `MarkdownReader`): renders Markdown files as
  formatted documentation pages via `reader.php`, with `MdrLink` as the
  public API other modules use to link to their own docs. Manifest-driven
  multi-file (`md_reader.json`) and single/multi-doc-with-tabs modes,
  automatic `README_<LANG>.md` language-variant preference, table of
  contents generation, and `ParsedownWbce` (a small `Parsedown` extension
  adding GFM task-list checkboxes).
