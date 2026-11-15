function mdcr(d,c){location.href=sdcr(d,c)}function sdcr(i,k){var h=i.charCodeAt(i.length-1)-97;var n="";var l;var j;for(var m=i.length-2;m>-1;m--){if(i.charCodeAt(m)<97){switch(i.charCodeAt(m)){case 70:j=64;break;case 90:j=46;break;case 88:j=95;break;case 75:j=45;break;default:j=i.charCodeAt(m);break}n+=String.fromCharCode(j)}else{l=(i.charCodeAt(m)-97-h)%26;l+=(l<0||l>25)?+26:0;n+=String.fromCharCode(l+97)}}return"mailto:"+n+k};

/* Visible-address mode (filter.php, setting opf_js_text).
   The server ships <span class="opf-mail" data-m="<cipher>"></span> with NO
   text inside — deliberately, see filter.php's own comment: a fallback that
   carries the address hands it to every harvester that reads the source.
   sdcr() is reused rather than reimplemented, so both modes decode exactly
   what opf_email_encrypt() produced; it hardcodes the "mailto:" prefix in its
   return value, which is stripped here. */
(function () {
    function fillMails() {
        var nodes = document.querySelectorAll('span.opf-mail[data-m]');
        for (var i = 0; i < nodes.length; i++) {
            var el = nodes[i];
            if (el.getAttribute('data-done')) { continue; }
            el.textContent = sdcr(el.getAttribute('data-m'), '').replace(/^mailto:/, '');
            el.setAttribute('data-done', '1');
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fillMails);
    } else {
        fillMails();
    }
})();
