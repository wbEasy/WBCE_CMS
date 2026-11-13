/**
 * Backend session handling — loaded on every backend page by Admin::print_header().
 *
 * 1. Counts the remaining session time down in #countdown (theme header).
 * 2. Warns 5 minutes before the session ends: a yellow box with a live
 *    countdown and an "Extend session" button (POST to
 *    admin/start/keepalive.php — any backend request extends the session).
 *    Only when the session lasts at least 10 minutes; closing the box
 *    silences it until the session is extended.
 * 3. Shows ONE sticky notice with a reload button when the session or the
 *    page's security token has expired:
 *      - when the countdown reaches 0 (unless another tab has kept the
 *        session alive meanwhile),
 *      - when a script request comes back refused. fetch() and
 *        XMLHttpRequest are both watched, so htmx and jQuery are covered
 *        without per-page code.
 *    Server side, framework/BackendAjax.php answers script requests with
 *    401/403 and {ok:false, reason, message, login_url}. Requests that do not
 *    identify as script requests still get the login redirect; a fetch/XHR
 *    that silently ended up on the login page counts as expired as well.
 *
 * For page scripts (all optional):
 *   WbceSession.isDenied(dataOrResponse)  true when the global notice covers
 *                                         it — skip your own error message
 *   WbceSession.notify(reason, message)   show the notice yourself
 *
 * Texts come from window.WBCE_SESSION_TEXT (Admin::print_header()).
 */
(function () {
    'use strict';

    document.cookie = 'WBCELastConnectJS=' + Math.round(Date.now() / 1000) + '; expires=0; SameSite=Lax; path=/';

    var REASONS      = ['session_expired', 'token_expired', 'forbidden'];
    var RANK         = { forbidden: 1, token_expired: 2, session_expired: 3 };
    var TTL          = (typeof SESSION_TIMEOUT === 'number') ? SESSION_TIMEOUT : 0;
    var WARN_AT      = 300;    // seconds left when the warning appears
    var WARN_MIN_TTL = 600;    // shorter sessions get no warning — it would show almost at once

    var shown    = '';     // reason of the notice on screen, '' = none
    var deadline = TTL > 0 ? Date.now() + TTL * 1000 : 0;

    function text(key) {
        return (window.WBCE_SESSION_TEXT || {})[key] || '';
    }

    // ── Shared box pieces ────────────────────────────────────────────────

    var STYLE = ''
        + '.wbce-session-notice{position:fixed;top:16px;left:50%;transform:translateX(-50%);z-index:100000;'
        + 'display:flex;flex-wrap:wrap;align-items:center;gap:12px;max-width:min(640px,calc(100vw - 32px));'
        + 'padding:14px 44px 14px 18px;border-radius:6px;border-left:4px solid #dc3545;background:#f8d7da;'
        + 'color:#721c24;box-shadow:0 6px 24px rgba(0,0,0,.25);font-size:15px;line-height:1.45;}'
        + '.wbce-session-notice.is-forbidden,.wbce-session-notice.is-warning{border-left-color:#ffc107;background:#fff3cd;color:#664d03;}'
        + '.wbce-session-notice p{margin:0;flex:1 1 260px;}'
        + '.wbce-session-notice strong{font-variant-numeric:tabular-nums;}'
        + '.wbce-session-notice .wsn-action{flex:0 0 auto;padding:7px 14px;border:0;border-radius:4px;'
        + 'background:#dc3545;color:#fff;font:inherit;font-weight:600;cursor:pointer;}'
        + '.wbce-session-notice .wsn-action:hover,.wbce-session-notice .wsn-action:focus-visible{background:#b02a37;}'
        + '.wbce-session-notice.is-warning .wsn-action{background:#664d03;}'
        + '.wbce-session-notice.is-warning .wsn-action:hover,.wbce-session-notice.is-warning .wsn-action:focus-visible{background:#4d3a02;}'
        + '.wbce-session-notice .wsn-action:disabled{opacity:.6;cursor:wait;}'
        + '.wbce-session-notice .wsn-close{position:absolute;top:6px;right:8px;border:0;background:none;'
        + 'color:inherit;font-size:22px;line-height:1;cursor:pointer;opacity:.6;padding:2px 6px;}'
        + '.wbce-session-notice .wsn-close:hover{opacity:1;}';

    function ensureStyle() {
        if (document.getElementById('wbce-session-notice-css')) return;
        var css = document.createElement('style');
        css.id = 'wbce-session-notice-css';
        css.textContent = STYLE;
        document.head.appendChild(css);
    }

    function actionButton(label, onClick) {
        var b = document.createElement('button');
        b.type        = 'button';
        b.className   = 'wsn-action';
        b.textContent = label;
        b.addEventListener('click', onClick);
        return b;
    }

    function closeButton(onClick) {
        var b = document.createElement('button');
        b.type      = 'button';
        b.className = 'wsn-close';
        b.setAttribute('aria-label', text('close') || 'Close');
        b.textContent = '×';
        b.addEventListener('click', onClick);
        return b;
    }

    // ── Expired / refused notice ─────────────────────────────────────────

    /**
     * Show the notice for reason. A weaker reason never replaces a stronger
     * one (session gone > token expired > no rights); closing it allows the
     * next refusal to show it again — closing is how the user gets to copy
     * unsaved text out of the page before reloading.
     */
    function notify(reason, message) {
        if (REASONS.indexOf(reason) === -1) return;
        if (shown && RANK[shown] >= RANK[reason]) return;

        if (!document.body) {
            document.addEventListener('DOMContentLoaded', function () { notify(reason, message); });
            return;
        }

        ensureStyle();
        hideWarning();

        var old = document.getElementById('wbce-session-notice');
        if (old) old.remove();

        if (!message) {
            message = text({ session_expired: 'request', token_expired: 'token', forbidden: 'forbidden' }[reason]);
        }

        var box = document.createElement('div');
        box.id        = 'wbce-session-notice';
        box.className = 'wbce-session-notice' + (reason === 'forbidden' ? ' is-forbidden' : '');
        box.setAttribute('role', 'alert');

        var p = document.createElement('p');
        p.textContent = message;          // server text, never markup
        box.appendChild(p);

        var reload = null;
        if (reason !== 'forbidden') {
            reload = actionButton(text('reload') || 'Reload page', function () { window.location.reload(); });
            box.appendChild(reload);
        }

        box.appendChild(closeButton(function () {
            box.remove();
            shown = '';
        }));

        document.body.appendChild(box);
        shown = reason;
        if (reload) reload.focus();
    }

    // ── Expiry warning ───────────────────────────────────────────────────

    var warnBox       = null;
    var warnTime      = null;
    var warnDismissed = false;   // closed by the user — quiet until extended

    function hideWarning() {
        if (warnBox) warnBox.remove();
        warnBox = warnTime = null;
    }

    function minutes(secs) {
        var s = secs % 60;
        return Math.floor(secs / 60) + ':' + (s < 10 ? '0' : '') + s;
    }

    /** Show the warning or update its time. Never takes the focus — the user may be typing. */
    function showWarning(left) {
        if (warnDismissed || shown || !document.body) return;

        if (!warnBox) {
            ensureStyle();
            warnBox = document.createElement('div');
            warnBox.id        = 'wbce-session-warning';
            warnBox.className = 'wbce-session-notice is-warning';
            warnBox.setAttribute('role', 'status');

            // "… in %s …" with the time as its own element, so it can tick
            var parts = (text('warn') || 'Your session will expire in %s.').split('%s');
            var p = document.createElement('p');
            p.appendChild(document.createTextNode(parts[0]));
            warnTime = document.createElement('strong');
            warnTime.setAttribute('aria-live', 'off');   // announced once, not every second
            p.appendChild(warnTime);
            p.appendChild(document.createTextNode(parts.slice(1).join('%s')));
            warnBox.appendChild(p);

            var extendBtn = actionButton(text('extend') || 'Extend session', function () { extend(extendBtn); });
            warnBox.appendChild(extendBtn);
            warnBox.appendChild(closeButton(function () {
                hideWarning();
                warnDismissed = true;
            }));

            document.body.appendChild(warnBox);
        }

        warnTime.textContent = minutes(left);
    }

    /**
     * Any backend request extends the session. On success the fetch hook
     * below (touched()) restarts the countdown, which then hides the warning;
     * a 401 makes the hook show the "expired" notice instead.
     */
    function extend(btn) {
        var url = text('keepalive');
        if (!url) return;
        btn.disabled = true;
        window.fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'fetch', 'Accept': 'application/json' },
        }).then(function (res) {
            if (res.ok) hideWarning();
        }, function () { /* offline: the warning stays, the user may retry */ })
          .then(function () { btn.disabled = false; });
    }

    // ── Recognising refusals ─────────────────────────────────────────────

    function urlOf(u) {
        try { return new URL(u, window.location.href); } catch (e) { return null; }
    }

    function sameOrigin(u) {
        var url = urlOf(u);
        return !!url && url.origin === window.location.origin;
    }

    function isLoginUrl(u) {
        var url   = urlOf(u);
        var login = urlOf(text('loginUrl') || ((window.ADMIN_URL || '') + '/login/'));
        return !!url && !!login && url.pathname.indexOf(login.pathname) === 0;
    }

    function fromBody(data) {
        if (data && typeof data === 'object' && REASONS.indexOf(data.reason) !== -1) {
            notify(data.reason, data.message);
            return true;
        }
        return false;
    }

    /**
     * A successful request to a PHP endpoint extended the session (it slides);
     * restart the countdown and tell the other tabs.
     */
    function touched(u) {
        var url = urlOf(u);
        if (!url || !/(\.php|\/)$/.test(url.pathname) || isLoginUrl(u)) return;
        if (TTL > 0) deadline = Date.now() + TTL * 1000;
        document.cookie = 'WBCELastConnectJS=' + Math.round(Date.now() / 1000) + '; expires=0; SameSite=Lax; path=/';
    }

    // fetch() — wrapped once; the caller gets the same Response back
    if (typeof window.fetch === 'function' && !window.fetch.wbceSession) {
        var nativeFetch = window.fetch;
        var wrapped = function () {
            return nativeFetch.apply(this, arguments).then(function (res) {
                try { checkFetch(res); } catch (e) { /* never break the caller */ }
                return res;
            });
        };
        wrapped.wbceSession = true;
        window.fetch = wrapped;
    }

    function checkFetch(res) {
        if (!sameOrigin(res.url)) return;
        if (res.redirected && isLoginUrl(res.url)) {
            notify('session_expired');
            return;
        }
        if (res.status === 401 || res.status === 403) {
            res.clone().json().then(fromBody, function () {
                if (res.status === 401) notify('session_expired');
            });
            return;
        }
        if (res.ok) touched(res.url);
    }

    // XMLHttpRequest — htmx, jQuery and older scripts
    if (window.XMLHttpRequest && !XMLHttpRequest.prototype.wbceSession) {
        var proto = XMLHttpRequest.prototype;
        var open  = proto.open;
        var send  = proto.send;
        proto.open = function (method, url) {
            this.wbceUrl = url;
            return open.apply(this, arguments);
        };
        proto.send = function () {
            var xhr = this;
            xhr.addEventListener('loadend', function () {
                try { checkXhr(xhr); } catch (e) { /* never break the caller */ }
            });
            return send.apply(this, arguments);
        };
        proto.wbceSession = true;
    }

    function checkXhr(xhr) {
        var url = xhr.responseURL;
        if (!url || !sameOrigin(url)) return;
        if (isLoginUrl(url) && !isLoginUrl(xhr.wbceUrl || '')) {
            notify('session_expired');
            return;
        }
        if (xhr.status === 401 || xhr.status === 403) {
            var data = null;
            try {
                data = (xhr.responseType === 'json') ? xhr.response
                     : (xhr.responseType === '' || xhr.responseType === 'text') ? JSON.parse(xhr.responseText)
                     : null;
            } catch (e) { /* not JSON */ }
            if (!fromBody(data) && xhr.status === 401) notify('session_expired');
            return;
        }
        if (xhr.status >= 200 && xhr.status < 300) touched(url);
    }

    // htmx: BackendAjax sends HX-Trigger {wbceAjaxDenied: {...}} as well;
    // the XHR hook usually got there first, notify() ignores the repeat
    document.addEventListener('wbceAjaxDenied', function (e) { fromBody(e.detail); });

    // ── Countdown ────────────────────────────────────────────────────────

    function lastConnect() {
        var m = document.cookie.match(/(?:^|;\s*)WBCELastConnectJS=(\d+)/);
        return m ? parseInt(m[1], 10) * 1000 : 0;
    }

    function format(secs) {
        var h = Math.floor(secs / 3600),
            m = Math.floor((secs % 3600) / 60),
            s = secs % 60;
        return h + ':' + (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (TTL <= 0) return;
        var el = document.getElementById('countdown');

        var timer = setInterval(function () {
            // another tab (or a request from this one) may have extended it
            var other = lastConnect() + TTL * 1000;
            if (other > deadline) deadline = other;

            var left = Math.max(0, Math.round((deadline - Date.now()) / 1000));
            if (el) el.textContent = format(left);

            if (left === 0) {
                clearInterval(timer);
                notify('session_expired', text('expired'));
                return;
            }

            if (TTL >= WARN_MIN_TTL && left <= WARN_AT) {
                showWarning(left);
            } else {
                // extended (here or in another tab): the next run-out warns again
                hideWarning();
                warnDismissed = false;
            }
        }, 1000);
    });

    window.WbceSession = {
        notify: notify,

        /**
         * Is this refusal one the global notice already shows? Takes parsed
         * JSON ({reason: …}) or a fetch Response.
         */
        isDenied: function (x) {
            if (!x || typeof x !== 'object') return false;
            if (typeof x.status === 'number' && typeof x.headers === 'object') {
                return x.status === 401 || (x.redirected === true && isLoginUrl(x.url));
            }
            return REASONS.indexOf(x.reason) !== -1;
        }
    };
})();
