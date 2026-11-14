/**
 * DateTimeFormat — relative times in the browser
 *
 * Turns <time datetime="…Z" data-relative data-max-days="7">01.08.2026, 18:00</time>
 * (written by DateTimeFormat::relative()) into "vor 5 Minuten", "gestern",
 * "in 3 Tagen" and keeps it current. The server text is the absolute date; it
 * stays without JavaScript, without Intl.RelativeTimeFormat, beyond
 * data-max-days, and as the element's title.
 *
 * Grammar (plurals, cases, "gestern"/"vorgestern") comes from the browser's
 * Intl.RelativeTimeFormat in the page language — window.WBCE_RELATIVE_TIME
 * = {locale, justNow}, set once per page by DateTimeFormat. Under one minute
 * in the past reads justNow ("gerade eben"). Calendar days count in the
 * browser's zone, i.e. the viewer's real local time.
 *
 * One timer for all elements (30 s), paused while the tab is hidden; elements
 * added later (AJAX) are picked up on the next tick.
 *
 * @copyright WBCE Project (2015-)
 * @license   GNU GPL2 (or any later version)
 */
(() => {
    'use strict';
    if (!window.Intl || !Intl.RelativeTimeFormat) return;

    const cfg = window.WBCE_RELATIVE_TIME || {};
    let rtf;
    try {
        rtf = new Intl.RelativeTimeFormat(cfg.locale || document.documentElement.lang || undefined, {numeric: 'auto'});
    } catch (e) {
        return;
    }
    const MINUTE = 60e3, HOUR = 36e5, DAY = 864e5;

    const midnight = (d) => new Date(d.getFullYear(), d.getMonth(), d.getDate());

    /** Relative text, or null to show the absolute date. */
    const describe = (then, now, maxDays) => {
        const diff = then - now;
        const abs  = Math.abs(diff);
        if (abs < MINUTE) {
            return diff <= 0 && cfg.justNow ? cfg.justNow : rtf.format(0, 'second');
        }
        if (abs < HOUR) return rtf.format(Math.trunc(diff / MINUTE), 'minute');
        if (abs < DAY)  return rtf.format(Math.trunc(diff / HOUR), 'hour');

        // From 24 hours on by calendar days, not 24-hour blocks: at 01:00,
        // 26 hours ago (23:00 two days back) is "vorgestern", not "gestern".
        const days = Math.round((midnight(then) - midnight(now)) / DAY);
        if (Math.abs(days) > maxDays) return null;
        if (Math.abs(days) < 30) return rtf.format(days, 'day');
        const months = (then.getFullYear() - now.getFullYear()) * 12 + then.getMonth() - now.getMonth();
        return Math.abs(months) < 12
            ? rtf.format(months, 'month')
            : rtf.format(then.getFullYear() - now.getFullYear(), 'year');
    };

    const update = () => {
        const now = new Date();
        document.querySelectorAll('time[data-relative]').forEach((el) => {
            if (el.dataset.absolute === undefined) {
                el.dataset.absolute = el.textContent;
                if (!el.title) el.title = el.textContent.trim();
            }
            const then = new Date(el.getAttribute('datetime'));
            if (isNaN(then)) return;
            const max  = parseInt(el.dataset.maxDays || '7', 10);
            const text = describe(then, now, isNaN(max) ? 7 : max);
            el.textContent = text === null ? el.dataset.absolute : text;
        });
    };

    let timer = null;
    const start = () => {
        update();
        if (timer === null) timer = setInterval(update, 30e3);
    };
    const stop = () => {
        clearInterval(timer);
        timer = null;
    };
    document.addEventListener('visibilitychange', () => (document.hidden ? stop() : start()));

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start);
    } else {
        start();
    }
})();
