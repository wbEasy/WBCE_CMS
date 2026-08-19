$(function () {

    // ── Theme toggle (light/dark) ─────────────────────────────────────────────
    //
    // reader.htt already applies a saved choice before first paint (its own
    // small inline <script>, same 'mdr_theme' key) — this only wires up the
    // click handler and keeps highlight.js's theme stylesheet in sync, since
    // hljs has no CSS-variable hook of its own (its theme IS the stylesheet).
    var THEME_KEY   = 'mdr_theme';
    var $themeBtn   = $('#mdr-theme-toggle');
    var $hljsTheme  = $('#mdr-hljs-theme');
    var HLJS_LIGHT  = 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css';
    var HLJS_DARK   = 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css';

    function currentIsDark() {
        var explicit = document.documentElement.getAttribute('data-theme');
        if (explicit === 'dark') return true;
        if (explicit === 'light') return false;
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    }

    function syncHljsTheme() {
        if (!$hljsTheme.length) return;
        $hljsTheme.attr('href', currentIsDark() ? HLJS_DARK : HLJS_LIGHT);
    }

    syncHljsTheme();

    $themeBtn.on('click', function () {
        var next = currentIsDark() ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem(THEME_KEY, next);
        syncHljsTheme();
    });

    // ── Sidebar collapse toggle ───────────────────────────────────────────────
    var $wrap        = $('#mdr-sidebar-wrap');
    var $toggleBtn   = $('#mdr-sidebar-toggle');
    var STORAGE_KEY  = 'mdr_sidebar_collapsed';
    var WIDTH_KEY    = 'mdr_sidebar_width';
    var DEFAULT_W    = 260;
    var MIN_W        = 140;
    var MAX_W        = 520;

    // Restore persisted state
    if (localStorage.getItem(STORAGE_KEY) === '1') {
        $wrap.addClass('mdr-sidebar-wrap--collapsed');
        $toggleBtn.attr('title', 'Sidebar aufklappen');
    }
    var savedW = parseInt(localStorage.getItem(WIDTH_KEY), 10);
    if (!isNaN(savedW) && savedW >= MIN_W && savedW <= MAX_W) {
        $wrap.css('width', savedW + 'px');
    }

    $toggleBtn.on('click', function () {
        var collapsed = $wrap.toggleClass('mdr-sidebar-wrap--collapsed')
                             .hasClass('mdr-sidebar-wrap--collapsed');
        $toggleBtn.attr('title', collapsed ? 'Sidebar aufklappen' : 'Sidebar zuklappen');
        localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
    });

    // ── Resize drag ───────────────────────────────────────────────────────────
    var $handle   = $('#mdr-resize-handle');
    var dragging  = false;
    var startX, startW;

    $handle.on('mousedown', function (e) {
        e.preventDefault();
        dragging = true;
        startX   = e.clientX;
        startW   = $wrap.outerWidth();
        $handle.addClass('mdr-resizing');
        $('body').css('cursor', 'col-resize').css('user-select', 'none');
    });

    $(document).on('mousemove', function (e) {
        if (!dragging) return;
        var newW = Math.min(MAX_W, Math.max(MIN_W, startW + (e.clientX - startX)));
        $wrap.css('width', newW + 'px');
    });

    $(document).on('mouseup', function () {
        if (!dragging) return;
        dragging = false;
        $handle.removeClass('mdr-resizing');
        $('body').css('cursor', '').css('user-select', '');
        localStorage.setItem(WIDTH_KEY, $wrap.outerWidth());
    });

    // ── Scroll spy — highlight active TOC link ────────────────────────────────
    var OFFSET = 60;
    var $links = $('#mdr-sidebar a[href^="#"]');

    function getActive () {
        var scrollTop = $(window).scrollTop();
        var active    = $links.first();
        $links.each(function () {
            var $anchor = $($(this).attr('href'));
            if ($anchor.length && $anchor.offset().top - OFFSET <= scrollTop) {
                active = $(this);
            }
        });
        return active;
    }

    $(window).on('scroll.mdrspy', function () {
        var $current = getActive();
        if (!$current.hasClass('mdr-nav--active')) {
            $links.removeClass('mdr-nav--active');
            $current.addClass('mdr-nav--active');
        }
    });

    var $article = $('#mdr-article');

    // ── Internal MD links — rewrite to reader.php ─────────────────────────────
    //
    // href is relative to the DOC's own location, not to reader.php's own
    // URL (window.location.pathname is always .../MarkdownWbce/reader.php
    // regardless of which doc is open) — so "./CHANGELOG.md" or
    // "../docs/x.md" must resolve against document.body.dataset.docDir
    // (set server-side from the active doc's relPath), not the page URL.
    // Delegating ./ and ../ resolution to the URL API instead of hand-
    // rolling it handles every case (nested ../.., bare filenames, etc.)
    // the same way a browser would.
    var docDir = document.body.dataset.docDir || '';

    $article.on('click', 'a[href$=".md"]', function (e) {
        var href = $(this).attr('href');

        // Skip absolute external links
        if (/^https?:\/\//i.test(href)) return;

        e.preventDefault();

        var absHref = href.startsWith('/')
            ? href
            : new URL(href, window.location.origin + docDir + '/').pathname;

        var url = window.location.pathname
                + '?doc=' + encodeURIComponent(absHref)
                + '&title=' + encodeURIComponent($(this).text());

        window.location.href = url;
    });

    // ── Mobile header toggle ──────────────────────────────────────────────────
    $('.mdr-toggle').on('click', function () {
        $wrap.toggle();
    });

    if ($(window).width() < 900) {
        $wrap.hide();
    }

    $(window).on('resize', function () {
        if ($(window).width() >= 900) {
            $wrap.show();
        }
    });

});
