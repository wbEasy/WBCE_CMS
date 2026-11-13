/**
 * wbce_search - assets/fe_search.js
 * AJAX live search with Fetch API
 *
 * @module    wbce_search
 * @author    Peter Kitzinger (Slugger)
 * @author    Christian M. Stefan (https://www.wbEasy.de)
 * @copyright WBCE Project (2026-)
 * @license   GNU General Public License
 * @platform  WBCE 1.7.0+
 *
 * Developed with AI assistance (Claude).
 */
(function() {
    'use strict';

    var CFG     = window.WS_SEARCH_CFG || {};
    var ajaxUrl = CFG.ajax_url  || '';
    var minChars= CFG.min_chars || 2;
    var delay   = CFG.delay     || 300;

    // No config object: derive the URL from the script tag
    if(!ajaxUrl) {
        var scripts = document.querySelectorAll('script[src*="wbce_search/assets/fe_search.js"]');
        if(scripts.length) {
            var base = scripts[0].src.replace(/modules\/wbce_search\/assets\/fe_search\.js.*/, '');
            ajaxUrl  = base + 'search/index.php?ws_ajax=1';
            minChars = 3;
        }
    }
    if(!ajaxUrl) return;

    function init() {
        var inputs = document.querySelectorAll([
            'input[name="string"]',
            'input[name="search_string"]',
            'input[type="search"]',
            '.ws-input',
            'form[action*="search"] input[type="text"]'
        ].join(', '));

        var seen = [];
        inputs.forEach(function(input) {
            if(seen.indexOf(input) === -1) {
                seen.push(input);
                input.setAttribute('autocomplete', 'off');
                initSuggest(input);
            }
        });
    }

    function initSuggest(input) {
        var timer    = null;
        var dropdown = null;
        var current  = -1;

        function getOrCreateDropdown() {
            if(dropdown) return dropdown;
            dropdown = document.createElement('ul');
            dropdown.className = 'ws-suggest';
            dropdown.setAttribute('role', 'listbox');
            // Append to body — avoids overflow:hidden + z-index issues in template
            document.body.appendChild(dropdown);
            return dropdown;
        }

        // Only the geometry is set here — the look is fe_search_suggest.css.
        function positionDropdown() {
            if(!dropdown) return;
            var rect = input.getBoundingClientRect();
            var scrollY = window.scrollY || window.pageYOffset;
            var scrollX = window.scrollX || window.pageXOffset;
            dropdown.style.top   = (rect.bottom + scrollY) + 'px';
            dropdown.style.left  = (rect.left   + scrollX) + 'px';
            dropdown.style.width = Math.max(rect.width, 260) + 'px';
            dropdown.setAttribute('data-ws-theme', pageTheme(input));
        }

        function show(items, q) {
            var dl = getOrCreateDropdown();
            dl.innerHTML = '';
            current = -1;
            if(!items || !items.length) { hide(); return; }
            // Theme + position first: rows created afterwards start in the
            // right colours (no transition from the previous theme).
            positionDropdown();

            // Thumbnails (catalogue entries, news posts …): as soon as one
            // suggestion has a picture, every row gets the same image column —
            // an empty tile where there is none — so the titles stay aligned.
            var withThumbs = items.some(function(item) { return !!item.thumb; });
            dl.classList.toggle('ws-suggest--thumbs', withThumbs);

            items.forEach(function(item, i) {
                var li = document.createElement('li');
                li.setAttribute('role', 'option');
                // snippet = the passage that matched (set when the title did not
                // match); otherwise the page description (or, for a module item,
                // the page it sits on) as context.
                var sub = item.snippet || item.description;
                var text =
                    '<span class="ws-suggest-title">' + mark(item.title, q) + '</span>' +
                    (sub ? '<span class="ws-suggest-desc">' + mark(sub, q) + '</span>' : '');
                if(withThumbs) {
                    if(item.thumb) {
                        // src/alt via the DOM, never concatenated into HTML.
                        var img = document.createElement('img');
                        img.className = 'ws-suggest-thumb';
                        img.src = item.thumb;
                        img.alt = '';
                        img.loading = 'lazy';
                        li.appendChild(img);
                    } else {
                        var ph = document.createElement('span');
                        ph.className = 'ws-suggest-thumb ws-suggest-thumb-empty';
                        ph.setAttribute('aria-hidden', 'true');
                        li.appendChild(ph);
                    }
                    var box = document.createElement('span');
                    box.className = 'ws-suggest-text';
                    box.innerHTML = text;
                    li.appendChild(box);
                } else {
                    li.innerHTML = text;
                }
                li.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                    window.location.href = item.url;
                });
                li.addEventListener('mouseover', function() { setActive(i); });
                dl.appendChild(li);
            });
            positionDropdown();
            dl.classList.add('is-open');
        }

        function hide() {
            if(dropdown) dropdown.classList.remove('is-open');
            current = -1;
        }

        function setActive(i) {
            if(!dropdown) return;
            dropdown.querySelectorAll('li').forEach(function(li, idx) {
                li.classList.toggle('ws-suggest-active', idx === i);
            });
            current = i;
        }

        function fetchSuggestions(q) {
            fetch(ajaxUrl + '&q=' + encodeURIComponent(q))
                .then(function(r) {
                    if(!r.ok) throw new Error('HTTP ' + r.status);
                    return r.json();
                })
                .then(function(data) { show(data, q); })
                .catch(function(err) {
                    console.warn('wbce_search suggest:', err);
                    hide();
                });
        }

        // Events
        input.addEventListener('input', function() {
            clearTimeout(timer);
            var q = input.value.trim();
            if(q.length < minChars) { hide(); return; }
            timer = setTimeout(function() { fetchSuggestions(q); }, delay);
        });

        input.addEventListener('keydown', function(e) {
            if(!dropdown || !dropdown.classList.contains('is-open')) return;
            var items = dropdown.querySelectorAll('li');
            if(e.key === 'ArrowDown')  { e.preventDefault(); setActive(Math.min(current+1, items.length-1)); }
            else if(e.key === 'ArrowUp')   { e.preventDefault(); setActive(Math.max(current-1, 0)); }
            else if(e.key === 'Enter' && current >= 0) { e.preventDefault(); items[current].dispatchEvent(new MouseEvent('mousedown')); }
            else if(e.key === 'Escape')    { hide(); }
        });

        // No focus listener on purpose — it fired unwanted requests on
        // screenshots, tab switches and clicks on other elements

        document.addEventListener('click', function(e) {
            if(e.target !== input) hide();
        });
    }

    /**
     * Escape text and emphasise every typed word in it (case-insensitive).
     * Splitting the raw text first and escaping each part keeps the markup
     * safe — matching inside already escaped text would break on "&" or "<".
     */
    function mark(text, q) {
        text = String(text || '');
        var words = String(q || '').trim().split(/\s+/).filter(function(w) { return w.length >= 2; });
        if (!words.length || !text) return esc(text);
        words.sort(function(a, b) { return b.length - a.length; }); // longest first
        var re = new RegExp('(' + words.map(function(w) {
            return w.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }).join('|') + ')', 'gi');
        return text.split(re).map(function(part, i) {
            // split() with a capture group puts the matches at odd indices
            return i % 2
                ? '<mark class="ws-suggest-hit">' + esc(part) + '</mark>'
                : esc(part);
        }).join('');
    }

    /**
     * "dark" or "light" for the dropdown — after the PAGE, not the operating
     * system: most templates are light, and a dark list on a white page
     * would look broken for every visitor with a dark OS theme.
     *  1. what the template declares: data-theme / data-bs-theme / data-color-scheme
     *     on <html> or <body>, or a class "dark" / "dark-mode" there;
     *  2. else the colour behind the search field: the first ancestor with a
     *     non-transparent background — dark if its luminance is low.
     */
    function pageTheme(input) {
        var roots = [document.documentElement, document.body];
        for (var r = 0; r < roots.length; r++) {
            var el = roots[r];
            if (!el) continue;
            var declared = (el.getAttribute('data-theme') || el.getAttribute('data-bs-theme')
                || el.getAttribute('data-color-scheme') || '').toLowerCase();
            if (declared === 'dark' || declared === 'light') return declared;
            if (el.classList.contains('dark') || el.classList.contains('dark-mode')) return 'dark';
        }
        for (var node = input; node && node.nodeType === 1; node = node.parentElement) {
            var rgb = (getComputedStyle(node).backgroundColor.match(/[\d.]+/g) || []).map(Number);
            if (rgb.length < 3 || (rgb.length > 3 && rgb[3] === 0)) continue; // transparent
            var lum = (0.2126 * rgb[0] + 0.7152 * rgb[1] + 0.0722 * rgb[2]) / 255;
            return lum < 0.4 ? 'dark' : 'light';
        }
        return 'light';
    }

    function esc(str) {
        return String(str || '')
            .replace(/&/g,'&amp;').replace(/</g,'&lt;')
            .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    if(document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
