/**
 * WBCE CMS — "My data" (templates/…/preferences.twig)
 *
 *  - Save via fetch, no reload: toast for the result, errors at the fields;
 *    a language change reloads the page, the backend is drawn in it anew.
 *  - "New password?" shows the password fields (as in Access → Users);
 *    unticked, they are emptied and save.php ignores them.
 *  - The current password confirms every save; it is emptied after each
 *    save, successful or not.
 *  - Leaving the page with unsaved changes asks first.
 *  - An expired session or token is reported by the backend-wide notice
 *    (include/SessionTimeout/SessionTimeout.js), not by a second message.
 *
 * Same conventions as admin/settings/settings.js.
 *
 * @since 1.7.0
 */
(() => {
    'use strict';

    const form = document.getElementById('preferences-form');
    if (!form) return;

    const changePw  = form.querySelector('[name=change_pswd]');
    const pwBlock   = document.getElementById('pref_renew_password');
    const newPw     = form.querySelector('[name=new_password_1]');
    const newPw2    = form.querySelector('[name=new_password_2]');
    const currentPw = form.querySelector('[name=current_password]');
    const rowOf     = (name) => form.querySelector(`.cp-setting-row[data-field="${CSS.escape(name)}"]`);
    let dirty = false;
    let busy  = false;

    const toast = (message, type) => {
        if (typeof window.showToast === 'function') {
            window.showToast(message, type, type === 'error' ? 0 : 4000);
        } else {
            alert(message);
        }
    };

    // ── New password: only with the box ticked ──────────────────────────
    const clearNewPassword = () => {
        newPw.value = newPw2.value = '';
        newPw.dispatchEvent(new Event('input', { bubbles: true }));   // resets the strength meter
    };
    const showNewPassword = (on) => {
        pwBlock.hidden = !on;
        if (on) return;
        clearNewPassword();
        pwBlock.querySelectorAll('.cp-setting-row.has-error').forEach((row) => {
            row.classList.remove('has-error');
            const box = row.querySelector('.cp-setting-error');
            if (box) { box.textContent = ''; box.hidden = true; }
        });
    };
    changePw.addEventListener('change', () => {
        showNewPassword(changePw.checked);
        if (changePw.checked) newPw.focus();
    });

    // typing into the confirmation alone changes nothing worth a warning
    form.addEventListener('input', (e) => { if (e.target !== currentPw) dirty = true; });
    form.addEventListener('change', (e) => { if (e.target !== currentPw) dirty = true; });

    window.addEventListener('beforeunload', (event) => {
        if (!dirty) return;
        event.preventDefault();
        event.returnValue = '';
    });

    // ── Selects → wbeSelect (options from data-ws) ──────────────────────
    const initSelects = () => {
        if (typeof window.WbeSelect === 'undefined') return;
        form.querySelectorAll('select.ws-select').forEach((sel) => {
            let opts = {};
            try { opts = JSON.parse(sel.dataset.ws || '{}') || {}; } catch (e) { /* keep defaults */ }
            if (Array.isArray(opts)) opts = {};
            window.WbeSelect.init(sel, opts);
        });
    };
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSelects);
    } else {
        initSelects();
    }

    // ── Errors ──────────────────────────────────────────────────────────
    const clearErrors = () => {
        form.querySelectorAll('.cp-setting-row.has-error').forEach((row) => {
            row.classList.remove('has-error');
            const box = row.querySelector('.cp-setting-error');
            if (box) { box.textContent = ''; box.hidden = true; }
        });
    };

    const showErrors = (errors) => {
        let first = null;
        Object.entries(errors || {}).forEach(([name, message]) => {
            const row = rowOf(name);
            if (!row) return;
            row.hidden = false;
            row.classList.add('has-error');
            const box = row.querySelector('.cp-setting-error');
            if (box) { box.textContent = message; box.hidden = false; }
            first ??= row;
        });
        first?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        first?.querySelector('input:not([type=hidden]), select')?.focus({ preventScroll: true });
    };

    // ── Save ────────────────────────────────────────────────────────────
    const coveredByNotice = (x) => typeof window.WbeSession?.isDenied === 'function' && window.WbeSession.isDenied(x);

    const post = async () => {
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                credentials: 'same-origin',
                headers: { 'X-Requested-With': 'fetch', 'Accept': 'application/json' },
            });
            if (coveredByNotice(response)) return { ok: false, denied: true };
            const data = await response.json();
            return coveredByNotice(data) ? { ok: false, denied: true } : data;
        } catch (e) {
            return { ok: false, message: form.dataset.msgError, errors: {} };
        }
    };

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (busy) return;
        busy = true;
        const buttons = form.querySelectorAll('button[type=submit]');
        buttons.forEach((b) => { b.disabled = true; });
        clearErrors();

        const result = await post();
        // the confirmation is good for one save only — empty it whatever came back
        currentPw.value = '';
        if (!result.denied) {
            if (!result.ok) {
                const labels = Object.keys(result.errors || {})
                    .map((name) => rowOf(name)?.querySelector('.cp-setting-name')?.textContent.trim())
                    .filter(Boolean);
                toast(labels.length ? `${result.message}: ${labels.join(', ')}` : result.message, 'error');
                showErrors(result.errors);
            } else {
                document.querySelectorAll('#toast-container .toast-error').forEach((t) => t.remove());
                // a new password is stored now — back to "no new password"
                changePw.checked = false;
                showNewPassword(false);
                dirty = false;
                toast(result.message, 'success');
                if (result.reload) {
                    // without a ?lang= the page may carry from an earlier
                    // language redirect — the new language comes from the account
                    const url = new URL(window.location.href);
                    url.searchParams.delete('lang');
                    setTimeout(() => { window.location.href = url.toString(); }, 1200);
                    return;   // buttons stay disabled until the reload
                }
            }
        }
        busy = false;
        buttons.forEach((b) => { b.disabled = false; });
    });
})();
