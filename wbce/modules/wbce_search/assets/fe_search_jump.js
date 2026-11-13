/**
 * wbce_search - assets/fe_search_jump.js
 * Loaded only on pages opened from a search hit (?searchresult=1&sstring=…,
 * see initialize_fe.php). The core has wrapped the search terms in
 * <span class="highlight">; this scrolls the first one into view and makes
 * it flash briefly, so the visitor lands on the passage, not the page top.
 * @module wbce_search  @version 0.5.4
 */
(function () {
    'use strict';

    // An explicit #anchor in the URL wins — the visitor (or the link) asked for it.
    if (location.hash && location.hash.length > 1) return;

    var userScrolled = false;
    window.addEventListener('wheel', function () { userScrolled = true; }, { passive: true, once: true });
    window.addEventListener('touchmove', function () { userScrolled = true; }, { passive: true, once: true });
    window.addEventListener('keydown', function () { userScrolled = true; }, { once: true });

    function target() {
        var hits = document.querySelectorAll('span.highlight');
        for (var i = 0; i < hits.length; i++) {
            // skip hits in hidden elements (closed menus, hidden tabs …)
            if (hits[i].getClientRects().length) return hits[i];
        }
        // all hits hidden: open a surrounding <details>, then use the first one
        if (hits.length) {
            for (var p = hits[0].parentElement; p; p = p.parentElement) {
                if (p.tagName === 'DETAILS') p.open = true;
            }
            return hits[0].getClientRects().length ? hits[0] : null;
        }
        return null;
    }

    function jump(behavior) {
        if (userScrolled) return;
        var el = target();
        if (!el) return;
        el.scrollIntoView({ block: 'center', behavior: behavior });
        return el;
    }

    function flash(el) {
        if (!el) return;
        el.classList.add('ws-jump-target');
        var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        el.style.transition = reduce ? 'box-shadow .15s linear' : 'box-shadow .5s ease';
        el.style.boxShadow = '0 0 0 4px rgba(255, 196, 0, .65)';
        setTimeout(function () { el.style.boxShadow = ''; }, reduce ? 900 : 1800);
    }

    function run() {
        var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        flash(jump(reduce ? 'auto' : 'smooth'));
        // Images loading later can push the passage down — correct once, silently.
        if (document.readyState !== 'complete') {
            window.addEventListener('load', function () { jump('auto'); }, { once: true });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }
})();
