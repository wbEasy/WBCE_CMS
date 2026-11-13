/**
 * WBCE CMS — settings page behaviour (templates/…/settings.twig)
 *
 *  - Save via fetch, no reload: toast for the result, errors at the fields.
 *  - "Show advanced" toggles [data-advanced] rows; the choice is remembered.
 *  - [data-depends] rows follow the value of the field they name
 *    (dependencies chain: a row is shown only if its parent row is, too).
 *  - The test mail uses the stored settings, so pending changes are saved
 *    before it is sent.
 *  - A save that changes the open page itself (save.php: reload) reloads it;
 *    leaving the page with unsaved changes asks first.
 *  - An expired session or token is reported by the backend-wide notice
 *    (include/SessionTimeout/SessionTimeout.js) — this page adds no second
 *    message for it.
 *
 * @since 1.7.0
 */
(() => {
    'use strict';

    const form = document.getElementById('settings-form');
    if (!form) return;

    const ADV_KEY    = 'wbce.settings.showAdvanced';
    const advToggles = form.querySelectorAll('.settings-advanced-toggle');
    const mailBtn    = document.getElementById('settings-testmail');
    let dirty       = false;
    let busy        = false;

    const toast = (message, type) => {
        if (typeof window.showToast === 'function') {
            window.showToast(message, type, type === 'error' ? 0 : 4000);
        } else {
            alert(message);
        }
    };

    const storage = {
        get(key) { try { return localStorage.getItem(key); } catch (e) { return null; } },
        set(key, value) { try { localStorage.setItem(key, value); } catch (e) { /* private mode */ } },
    };

    // ── Visibility ──────────────────────────────────────────────────────

    const rowOf = (name) => form.querySelector(`.cp-setting-row[data-field="${CSS.escape(name)}"]`);

    /** The value a field would post: last checked/filled control wins,
     *  as in PHP (the hidden "off" input comes before the switch). */
    const valueOf = (name) => {
        let value = null;
        form.querySelectorAll(`[name="${CSS.escape(name)}"]`).forEach((el) => {
            if ((el.type === 'checkbox' || el.type === 'radio') && !el.checked) return;
            value = el.value;
        });
        return value;
    };

    const showAdvanced = () => form.classList.contains('show-advanced');

    const isShown = (row, seen = new Set()) => {
        if (!row || seen.has(row)) return true;
        seen.add(row);
        if (row.hasAttribute('data-advanced') && !showAdvanced()) return false;
        const dep = row.dataset.depends;
        if (!dep) return true;
        // a dependency the user cannot see (level) does not hide the row
        if (valueOf(dep) === null) return true;
        return valueOf(dep) === row.dataset.dependsValue && isShown(rowOf(dep), seen);
    };

    const refresh = () => {
        form.querySelectorAll('.cp-setting-row[data-field]').forEach((row) => {
            row.hidden = !isShown(row);
        });
        // a card with nothing to show (all advanced) goes, too
        form.querySelectorAll('.cp-settings').forEach((card) => {
            card.hidden = !card.querySelector('.cp-setting-row[data-field]:not([hidden])');
        });
    };

    const setAdvanced = (on) => {
        form.classList.toggle('show-advanced', on);
        // « points back (hide), » points on (show)
        const label = on ? `« ${form.dataset.labelHide}` : `${form.dataset.labelShow} »`;
        advToggles.forEach((btn) => {
            btn.querySelector('span').textContent = label;
            btn.setAttribute('aria-pressed', on ? 'true' : 'false');
        });
        storage.set(ADV_KEY, on ? '1' : '0');
        refresh();
    };

    /** The element that scrolls the page (the backend theme may scroll an
     *  inner container rather than the window). */
    const scroller = (el) => {
        for (let p = el.parentElement; p && p !== document.body; p = p.parentElement) {
            const style = getComputedStyle(p);
            if (/(auto|scroll)/.test(style.overflowY) && p.scrollHeight > p.clientHeight) return p;
        }
        return document.scrollingElement || document.documentElement;
    };

    // Rows above the clicked card appear or vanish too — shift the scroll
    // position by exactly that much, so the clicked card stays where it was.
    advToggles.forEach((btn) => btn.addEventListener('click', () => {
        const card   = btn.closest('.cp-settings');
        const before = card.getBoundingClientRect().top;
        setAdvanced(!showAdvanced());
        scroller(card).scrollTop += card.getBoundingClientRect().top - before;
    }));
    setAdvanced(advToggles.length > 0 && storage.get(ADV_KEY) === '1');

    // ── Code fields (CodeMirror_Config, website header/footer) ──────────
    // CodeMirror keeps its text to itself until the form's native submit;
    // a fetch save must copy it back first, and typing in it is a change.
    const codeEditors = () => [...form.querySelectorAll('.CodeMirror')]
        .map((el) => el.CodeMirror)
        .filter(Boolean);
    const syncCodeEditors = () => codeEditors().forEach((cm) => cm.save());
    const watchCodeEditors = () => codeEditors().forEach((cm) => cm.on('change', () => { dirty = true; }));

    // ── Selects → wbeSelect ─────────────────────────────────────────────
    // include/wbeSelect is loaded by index.php; without it the plain
    // <select>s keep working. Its options come from the registry (data-ws).
    const initSelects = () => {
        if (typeof window.WbeSelect === 'undefined') return;
        form.querySelectorAll('select.ws-select').forEach((sel) => {
            let opts = {};
            try { opts = JSON.parse(sel.dataset.ws || '{}') || {}; } catch (e) { /* keep defaults */ }
            if (Array.isArray(opts)) opts = {};   // json_encode([]) of an empty map
            window.WbeSelect.init(sel, opts);
        });
    };

    // Both widgets are set up by scripts further down the page
    // (CodeEditor::init(), wbeSelect.js) — wait until they have run.
    const initWidgets = () => {
        watchCodeEditors();
        initSelects();
    };
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initWidgets);
    } else {
        initWidgets();
    }

    // ── Character counters (limits from wbSeoTool, see the registry) ────
    // Same rule as the tool's page tree: below the minimum or above the
    // optimum is red, in between green.
    const updateCounter = (box) => {
        const field = document.getElementById(box.dataset.for);
        if (!field) return;
        const len       = [...field.value].length;   // characters, not UTF-16 units
        const min       = Number(box.dataset.min);
        const optimum   = Number(box.dataset.optimum);
        const remaining = optimum - len;
        let text = String(len);
        if (box.dataset.remaining === '1') {
            const tpl = remaining >= 0 ? form.dataset.counterLeft : form.dataset.counterOver;
            text += ` (${tpl.replace('%d', Math.abs(remaining))})`;
        }
        box.textContent = text;
        const good = len >= min && len <= optimum;
        box.classList.toggle('is-good', good);
        box.classList.toggle('is-bad', !good);
    };
    form.querySelectorAll('.cp-counter[data-for]').forEach((box) => {
        updateCounter(box);
        document.getElementById(box.dataset.for)?.addEventListener('input', () => updateCounter(box));
    });

    form.addEventListener('change', () => { dirty = true; refresh(); });
    form.addEventListener('input', () => { dirty = true; });

    // Leaving with unsaved changes asks first (the browser shows its own
    // wording; a custom text is ignored by all current browsers).
    window.addEventListener('beforeunload', (event) => {
        if (!dirty) return;
        event.preventDefault();
        event.returnValue = '';
    });

    // ── Errors ──────────────────────────────────────────────────────────

    const clearErrors = () => {
        form.querySelectorAll('.cp-setting-row.has-error').forEach((row) => {
            row.classList.remove('has-error');
            const box = row.querySelector('.cp-setting-error');
            box.textContent = '';
            box.hidden = true;
        });
    };

    const showErrors = (errors) => {
        let first = null;
        Object.entries(errors || {}).forEach(([name, message]) => {
            const row = rowOf(name);
            if (!row) return;
            // an error in a hidden advanced row must be visible
            if (row.hasAttribute('data-advanced') && !showAdvanced()) setAdvanced(true);
            row.classList.add('has-error');
            const box = row.querySelector('.cp-setting-error');
            box.textContent = message;
            box.hidden = false;
            first ??= row;
        });
        refresh();
        first?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        first?.querySelector('input:not([type=hidden]), select, textarea')?.focus({ preventScroll: true });
    };

    // ── Requests ────────────────────────────────────────────────────────

    /** POST the form to url; resolves to {ok, message, errors}. */
    const post = async (url) => {
        syncCodeEditors();
        try {
            const response = await fetch(url, {
                method: 'POST',
                body: new FormData(form),
                credentials: 'same-origin',
                headers: { 'X-Requested-With': 'fetch', 'Accept': 'application/json' },
            });
            // session/token expired: SessionTimeout.js already shows the
            // sticky notice with the reload button — no second, vaguer toast
            if (window.WbceSession?.isDenied(response)) {
                return { ok: false, denied: true, errors: {} };
            }
            const data = await response.json();
            return window.WbceSession?.isDenied(data) ? { ...data, denied: true, errors: {} } : data;
        } catch (e) {
            // a PHP error instead of JSON
            return { ok: false, message: form.dataset.msgError, errors: {} };
        }
    };

    const setBusy = (on) => {
        busy = on;
        form.querySelectorAll('button[type=submit]').forEach((b) => { b.disabled = on; });
        if (mailBtn) mailBtn.disabled = on;
    };

    /** Save; true on success, 'reload' when the page reloads, false
     *  otherwise. Toasts only what the caller should see. */
    const save = async ({ quietSuccess = false } = {}) => {
        clearErrors();
        const result = await post(form.action);
        if (result.denied) return false;
        if (!result.ok) {
            // name the fields: one may sit in a row that is hidden right now
            const labels = Object.keys(result.errors || {})
                .map((name) => rowOf(name)?.querySelector('.cp-setting-name')?.textContent.trim())
                .filter(Boolean);
            toast(labels.length ? `${result.message}: ${labels.join(', ')}` : result.message, 'error');
            showErrors(result.errors);
            return false;
        }
        dirty = false;
        // errors are sticky toasts; once saved they no longer apply
        document.querySelectorAll('#toast-container .toast-error').forEach((t) => t.remove());
        // the stored password stays stored; the field never shows it
        form.querySelectorAll('input[type=password]').forEach((el) => {
            if (el.value !== '') { el.placeholder = '••••••••'; el.value = ''; }
        });
        if (result.reload) {
            // the open page no longer fits (new session cookie, new theme):
            // show the result, then reload — the buttons stay disabled
            toast(result.message, 'success');
            setTimeout(() => window.location.reload(), 1200);
            return 'reload';
        }
        if (!quietSuccess) toast(result.message, 'success');
        return true;
    };

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (busy) return;
        setBusy(true);
        if (await save() !== 'reload') setBusy(false);
    });

    mailBtn?.addEventListener('click', async () => {
        if (busy) return;
        setBusy(true);
        const saved = dirty ? await save({ quietSuccess: true }) : true;
        if (saved === 'reload') return;   // the mail would use the old page's token
        if (saved) {
            const result = await post(form.dataset.testmailUrl);
            if (!result.denied) toast(result.message, result.ok ? 'success' : 'error');
        }
        setBusy(false);
    });
})();
