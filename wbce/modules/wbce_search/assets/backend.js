/**
 * wbce_search — assets/backend.js (auto-loaded for ?tool=wbce_search)
 * Small glue for the HTMX views. Everything is delegated on document, so it
 * keeps working after #wss-view swaps without re-binding.
 */
(function () {
    'use strict';

    // Module URL from the shell (_shell.twig data-base) — this file itself is
    // served from cache/assets/, so its own src can't be used for that.
    function base() {
        var app = document.getElementById('wss-app');
        return app ? app.dataset.base : '';
    }

    // A server answer can ask for a full reload via `HX-Trigger: reloadPage`
    // (switching nav_style changes the shell itself).
    document.addEventListener('reloadPage', function () { location.reload(); });

    // After a nav swap, start the new view at the top of the tool.
    document.addEventListener('htmx:afterSwap', function (e) {
        if (e.target && e.target.id === 'wss-view') {
            var app = document.getElementById('wss-app');
            if (app && app.getBoundingClientRect().top < 0) app.scrollIntoView({ block: 'start' });
            initModules();
        }
    });

    // ── Modules view: filters, sorting, editor rows ───────────────────────
    // State lives here, not in the DOM: a save re-renders the whole view
    // (#wss-view), and filters/sort order should survive that.
    var modState = null;   // {kinds: [], groups: [], name: '', sortCol: n, asc: bool}

    function modTable() { return document.getElementById('wss-mod-table'); }
    function modRows(table) { return Array.prototype.slice.call(table.querySelectorAll('tr.wss-mod-row')); }
    function detailOf(tr) {
        var next = tr.nextElementSibling;
        return next && next.classList.contains('wss-detail') ? next : null;
    }
    function checkedValues(attr) {
        return Array.prototype.map.call(
            document.querySelectorAll('input[' + attr + ']:checked'),
            function (c) { return c.getAttribute(attr); }
        );
    }

    function readState() {
        var th = modTable().querySelector('th[aria-sort]');
        var name = document.querySelector('[data-wss-name]');
        modState = {
            hasKinds: !!document.querySelector('input[data-wss-kind]'),
            kinds:   checkedValues('data-wss-kind'),
            groups:  checkedValues('data-wss-group'),
            name:    name ? name.value.trim().toLowerCase() : '',
            sortCol: th ? th.cellIndex : 1,
            asc:     th ? th.getAttribute('aria-sort') !== 'descending' : true
        };
    }

    function applyModuleFilter() {
        var table = modTable();
        if (!table) return;
        var shown = 0;
        modRows(table).forEach(function (tr) {
            var d = tr.dataset;
            // No type checkboxes (only page modules listed) → no type filter.
            var ok = (!modState.hasKinds || modState.kinds.indexOf(d.kind) !== -1)
                && modState.groups.indexOf(d.group) !== -1
                && (!modState.name || (d.mod + ' ' + d.name).toLowerCase().indexOf(modState.name) !== -1);
            var detail = detailOf(tr);
            if (detail) ok = true;           // a row with an open editor stays visible
            tr.hidden = !ok;
            if (detail) detail.hidden = !ok;
            if (ok) shown++;
        });
        var foot = table.querySelector('[data-wss-count]');
        if (foot) foot.textContent = foot.dataset.wssCount.replace('%1$d', shown).replace('%2$d', foot.dataset.total);
    }

    function sortModules() {
        var table = modTable();
        if (!table) return;
        var col = modState.sortCol, dir = modState.asc ? 1 : -1;
        table.querySelectorAll('th[data-wss-sort]').forEach(function (th) {
            if (th.cellIndex === col) th.setAttribute('aria-sort', modState.asc ? 'ascending' : 'descending');
            else th.removeAttribute('aria-sort');
        });
        function key(tr) {
            var td = tr.cells[col];
            return td ? (td.dataset.sort !== undefined ? td.dataset.sort : td.textContent.trim()) : '';
        }
        var tbody = table.tBodies[0];
        modRows(table).sort(function (a, b) {
            var x = key(a), y = key(b), nx = parseFloat(x), ny = parseFloat(y);
            var r = (!isNaN(nx) && !isNaN(ny)) ? nx - ny : x.localeCompare(y);
            // equal → by name, always ascending
            return (dir * r) || a.dataset.name.localeCompare(b.dataset.name);
        }).forEach(function (tr) {
            var detail = detailOf(tr);   // look it up before the row moves
            tbody.appendChild(tr);
            if (detail) tbody.appendChild(detail);
        });
    }

    // Called on page load and after every #wss-view swap.
    function initModules() {
        var table = modTable();
        if (!table) return;
        if (modState) {
            // Restore the controls of the re-rendered view.
            document.querySelectorAll('input[data-wss-kind]').forEach(function (c) {
                c.checked = modState.kinds.indexOf(c.getAttribute('data-wss-kind')) !== -1;
            });
            document.querySelectorAll('input[data-wss-group]').forEach(function (c) {
                c.checked = modState.groups.indexOf(c.getAttribute('data-wss-group')) !== -1;
            });
            var name = document.querySelector('[data-wss-name]');
            if (name) name.value = modState.name;
            sortModules();
        } else {
            readState();
        }
        applyModuleFilter();
    }

    document.addEventListener('change', function (e) {
        if (e.target.matches('input[data-wss-kind], input[data-wss-group]')) { readState(); applyModuleFilter(); }
    });
    document.addEventListener('input', function (e) {
        if (e.target.matches('[data-wss-name]')) { readState(); applyModuleFilter(); }
    });
    document.addEventListener('click', function (e) {
        var th = e.target.closest('#wss-mod-table th[data-wss-sort]');
        if (!th) return;
        readState();
        modState.asc = modState.sortCol === th.cellIndex ? !modState.asc : true;
        modState.sortCol = th.cellIndex;
        sortModules();
    });

    // "Configure": a second click closes the editor row instead of loading
    // another one below it.
    document.addEventListener('htmx:beforeRequest', function (e) {
        var btn = e.detail.elt;
        if (!btn || !btn.matches || !btn.matches('[data-wss-configure]')) return;
        var tr = btn.closest('tr');
        var detail = detailOf(tr);
        if (detail) {
            e.preventDefault();
            closeDetail(detail);
        }
    });
    document.addEventListener('htmx:afterSwap', function (e) {
        var btn = e.detail.requestConfig && e.detail.requestConfig.elt;   // the element that made the request
        if (!btn || !btn.matches || !btn.matches('[data-wss-configure]')) return;
        var tr = btn.closest('tr');
        tr.classList.add('is-open');
        btn.setAttribute('aria-expanded', 'true');
    });
    function closeDetail(detail) {
        var tr = detail.previousElementSibling;
        detail.remove();
        if (tr) {
            tr.classList.remove('is-open');
            var btn = tr.querySelector('[data-wss-configure]');
            if (btn) btn.setAttribute('aria-expanded', 'false');
        }
        applyModuleFilter();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initModules);
    } else {
        initModules();
    }

    // ── Markdown help: MarkdownWbce reader window (same size and window
    // name as MdReaderLink's own popups, without its inline onclick) ──────
    function openMdReader(url) {
        var w = window.open(url, 'mdr_popup',
            'width=1100,height=820,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=yes');
        if (w) w.focus();
        return !!w;
    }

    // ── Module guide: separate window, stays open while editing ───────────
    window.wssShowGuide = function (mod) {
        var w = window.open(base() + '/guide_popup.php?module=' + encodeURIComponent(mod),
            'wss_guide_' + mod, 'width=780,height=680,scrollbars=yes,resizable=yes');
        if (w) w.focus();
    };

    // ── Layout view: a picked radio saves at once (plain POST of its form) ──
    document.addEventListener('change', function (e) {
        var input = e.target;
        if (!input.matches || !input.matches('input[data-wss-autosubmit]') || !input.form) return;
        input.form.requestSubmit ? input.form.requestSubmit() : input.form.submit();
    });

    // ── No inline handlers in the templates: data-wss="…" + delegation ────
    document.addEventListener('click', function (e) {
        var el = e.target.closest('[data-wss]');
        if (!el) return;
        switch (el.dataset.wss) {
            // A blocked popup leaves the plain link (target=_blank) working.
            case 'md-popup':   if (openMdReader(el.href)) e.preventDefault(); break;
            case 'guide':      e.preventDefault(); window.wssShowGuide(el.dataset.module || ''); break;
            case 'close-detail': {
                e.preventDefault();
                var detail = el.closest('tr.wss-detail');
                if (detail) closeDetail(detail);
                break;
            }
        }
    });

    // Settings that save on change (overview: site search, tool switch):
    // ask first; "Cancel" puts the control back to its rendered state,
    // "OK" fires the form's hx-trigger="wss-confirmed".
    document.addEventListener('change', function (e) {
        var input = e.target;
        if (!input.matches || !input.matches('input[data-wss-confirm]')) return;
        var form = input.form;
        if (window.confirm(input.dataset.wssConfirm)) {
            if (window.htmx && form) window.htmx.trigger(form, 'wss-confirmed');
            return;
        }
        if (input.type === 'radio' && form) {
            form.querySelectorAll('input[type=radio][name="' + input.name + '"]').forEach(function (r) {
                r.checked = r.defaultChecked;
            });
        } else {
            input.checked = input.defaultChecked;
        }
    });

    // Plain (non-HTMX) forms ask first when the form or the button that sent
    // it carries data-confirm (layout view: delete, edit → copy).
    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (form.matches('[hx-confirm]')) return;
        var by  = e.submitter && e.submitter.dataset ? e.submitter.dataset.confirm : '';
        var msg = by || form.dataset.confirm;
        if (msg && !window.confirm(msg)) {
            e.preventDefault();
        }
    });
})();
