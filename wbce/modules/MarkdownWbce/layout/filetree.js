/* layout/filetree.js — visual FileTree renderer
 * Vendored from modules/tiptap_editor/assets/filetree.js (same author) so
 * MarkdownWbce's reader renders ```file-tree blocks identically to the
 * TipTap editor, without a hard runtime dependency on tiptap_editor being
 * installed. Keep in sync manually if the original changes — EXCEPT the
 * toolbar (badge + copy button), which deliberately diverges from the
 * original's plain "Copy" text button: it reuses the same
 * .mdr-code-toolbar/.mdr-code-lang/.mdr-code-copy classes and SVG icon as
 * the reader's regular code-block toolbar (see layout/reader.htt), badged
 * "FileTree" instead of a real language, so both toolbars look/behave
 * identically in the rendered output.
 *
 * Transforms <pre class="file-tree"><code>…</code></pre> into a visual tree
 * with icons and connecting lines. That markup comes from
 * ParsedownWbce::blockFencedCode() special-casing the ```file-tree language
 * tag — see modules/MarkdownWbce/Parsedown/ParsedownWbce.php.
 */
(function () {
    'use strict';

    document.querySelectorAll('pre.file-tree').forEach(function (treeContainer) {
        var codeElement = treeContainer.querySelector('code');
        if (!codeElement) return;

        var showCopyButton = true;

        var originalText = codeElement.textContent;
        var lines = originalText.split('\n');

        var wrapper = document.createElement('div');
        wrapper.className = 'file-tree-container';

        var rootUl = document.createElement('ul');
        rootUl.className = 'treeview-root';

        lines.forEach(function (line) {
            var isContentless = !line.replace(/[│├└─\s ]/g, '').trim();

            var prefixMatch = line.match(/^([│├└─\s ]+)/);
            var prefix = prefixMatch ? prefixMatch[1] : '';
            var contentPart = line.substring(prefix.length);

            var li = document.createElement('li');
            li.className = 'treeview-item';

            if (prefix) {
                var indentWrapper = document.createElement('div');
                indentWrapper.className = 'tree-indent-wrapper';
                var chunks = prefix.match(/.{1,4}/g) || [];

                chunks.forEach(function (chunk) {
                    var cell = document.createElement('div');
                    cell.className = 'tree-line-cell';

                    if      (chunk.indexOf('├') !== -1) cell.classList.add('line-t');
                    else if (chunk.indexOf('└') !== -1) cell.classList.add('line-corner');
                    else if (chunk.indexOf('│') !== -1) cell.classList.add('line-vertical');

                    indentWrapper.appendChild(cell);
                });
                li.appendChild(indentWrapper);
            }

            if (isContentless) {
                if (prefix) rootUl.appendChild(li);
                return;
            }

            // Standalone comment line — starts with // or # (with or
            // without a tree prefix before it). Rendered as plain text in
            // the same style as the trailing "→ …" comment on file/folder
            // lines, no icon, no file/folder name parsing.
            if (/^(\/\/|#)/.test(contentPart)) {
                var lineCommentSpan = document.createElement('span');
                lineCommentSpan.className = 'tree-comment';
                lineCommentSpan.textContent = contentPart;
                li.appendChild(lineCommentSpan);
                rootUl.appendChild(li);
                return;
            }

            // File: name.ext  — comment requires at least 1 space
            var fileMatch = contentPart.match(/^([a-zA-Z0-9_\-\.]+\.(js|css|php|txt|json|html|md|sql))(\s.*|$)/i);
            // Folder: any/path/with/slashes/  — multi-segment paths treated as one name,
            //         comment requires at least 1 space
            var folderMatch = contentPart.match(/^([a-zA-Z0-9_\-\.][a-zA-Z0-9_\-\.\/]*\/)(\s.*|$)/);

            var nodeName    = '';
            var commentPart = '';
            var iconClass   = 'icon-file';
            var isFolder    = false;

            if (fileMatch) {
                nodeName    = fileMatch[1];
                iconClass   = 'icon-' + fileMatch[2].toLowerCase();
                commentPart = fileMatch[3] || '';
            } else if (folderMatch) {
                nodeName    = folderMatch[1];
                iconClass   = 'icon-folder';
                commentPart = folderMatch[2] || '';
                isFolder    = true;
            } else {
                // Fallback: bare name without extension or slash (treat as folder)
                var fallbackMatch = contentPart.match(/^([a-zA-Z0-9_\-\.]+)(\s.*|$)/);
                if (fallbackMatch) {
                    nodeName    = fallbackMatch[1];
                    iconClass   = 'icon-folder';
                    commentPart = fallbackMatch[2] || '';
                    isFolder    = true;
                } else {
                    nodeName = contentPart;
                    isFolder = true;
                }
            }

            var iconSpan = document.createElement('span');
            iconSpan.className = 'tree-icon ' + iconClass;
            li.appendChild(iconSpan);

            var nameSpan = document.createElement('span');
            nameSpan.className = isFolder ? 'tree-name tree-name--folder' : 'tree-name';
            nameSpan.textContent = nodeName;
            li.appendChild(nameSpan);

            if (commentPart) {
                var commentSpan = document.createElement('span');
                commentSpan.className = 'tree-comment';
                commentSpan.textContent = commentPart;
                li.appendChild(commentSpan);
            }

            rootUl.appendChild(li);
        });

        wrapper.appendChild(rootUl);

        if (showCopyButton) {
            var toolbar = document.createElement('div');
            toolbar.className = 'mdr-code-toolbar';

            var badge = document.createElement('span');
            badge.className = 'mdr-code-lang';
            badge.textContent = 'FileTree';
            toolbar.appendChild(badge);

            var copyBtn = document.createElement('button');
            copyBtn.type = 'button';
            copyBtn.className = 'mdr-code-copy';
            copyBtn.title = 'Copy code';
            copyBtn.setAttribute('aria-label', 'Copy code');
            copyBtn.innerHTML = '<svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">'
                + '<path fill-rule="evenodd" d="M14 12V2H4V0h12v12h-2zM0 4h12v12H0V4zm2 2v8h8V6H2z"/></svg>';
            copyBtn.addEventListener('click', function () {
                function done() {
                    copyBtn.classList.add('mdr-code-copy--done');
                    setTimeout(function () { copyBtn.classList.remove('mdr-code-copy--done'); }, 1200);
                }
                function fallbackCopy() {
                    var ta = document.createElement('textarea');
                    ta.value = originalText;
                    ta.style.position = 'fixed';
                    ta.style.opacity = '0';
                    document.body.appendChild(ta);
                    ta.select();
                    try { document.execCommand('copy'); done(); } catch (e) {}
                    document.body.removeChild(ta);
                }

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(originalText).then(done, fallbackCopy);
                } else {
                    fallbackCopy();
                }
            });
            toolbar.appendChild(copyBtn);

            wrapper.appendChild(toolbar);
        }

        treeContainer.parentNode.replaceChild(wrapper, treeContainer);
    });
}());
