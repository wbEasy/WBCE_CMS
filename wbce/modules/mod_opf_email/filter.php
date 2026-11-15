<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright    Ryan Djurovich (2004-2009)
 * @copyright    WebsiteBaker Org. e.V. (2009-2015)
 * @copyright    WBCE Project (2015-)
 * @category     tool
 * @package      OPF E-Mail
 * @version      1.1.8
 * @authors      Martin Hecht (mrbaseman)
 * @link         https://forum.wbce.org/viewtopic.php?id=176
 * @license      GNU GPL2 (or any later version)
 * @platform     WBCE 1.x
 * @requirements OutputFilter Dashboard 1.5.x and PHP 5.4 or higher
 *
 **/

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if (!defined('WB_PATH')) {
    // Stop this file being access directly
    if (!headers_sent()) {
        header("Location: ../index.php", true, 301);
    }
    die('<head><title>Access denied</title></head><body><h2 style="color:red;margin:3em auto;text-align:center;">Cannot access this file directly</h2></body></html>');
}
/* -------------------------------------------------------- */

/**
 * protect email addresses (replace '@' and '.' and obfuscate address
 * @param string $content
 * @return string
 */
function doFilterEmail($content)
{

    // check if required arguments are defined otherwise define
    if (!defined('OPF_AT_REPLACEMENT') or !defined('OPF_DOT_REPLACEMENT')) {
        Settings::Set('OPF_AT_REPLACEMENT', "(at)");
        Settings::Set('OPF_DOT_REPLACEMENT', "(dot)");
    }

    // Search for Maillinks

    // first search part to find all mailto email addresses
    $pattern = '#(<a[^<]*href\s*?=\s*?"\s*?mailto\s*?:\s*?)([A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,25})([^"]*?)"([^>]*>)(.*?)</a>';

    // second part to find all non mailto email addresses
    $pattern .= '|(value\s*=\s*"|\')??\b([A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,25})\b#i';
    /**
     *  Patterns explained
     *  Sub 1:\b(<a.[^<]*href\s*?=\s*?"\s*?mailto\s*?:\s*?)         --> "<a id="yyy" class="xxx" href = " mailto :" ignoring white spaces
     *  Sub 2:([A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,25})         --> the email address in the mailto: part of the mail link
     *  Sub 3:([^"]*?)"                                             --> possible ?Subject&cc... stuff attached to the mail address
     *  Sub 4:([^>]*>)                                              --> all class or id statements after the mailto but before closing ..>
     *  Sub 5:(.*?)</a>\b                                           --> the mailto text; all characters between >xxxxx</a>
     *  Sub 6:|\b([A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,25})\b    --> email addresses which may appear in the text (require word boundaries)
     */
    // Do the actual work
    // find all email addresses embedded in the content and filter them using a callback function

    $new_content = preg_replace_callback($pattern, '_cbDoExecuteFilter', $content);

    // Include mdcr.js when either JS mode is in play and the filter actually
    // changed something. The text mode needs it just as much as the mailto
    // one — without the script its <span class="opf-mail"> stays empty, which
    // is the one failure mode that is silent on the page.
    $needsJs = (Settings::Get('OPF_MAILTO_FILTER') and Settings::Get('OPF_JS_MAILTO'))
            or (Settings::Get('OPF_EMAIL_FILTER') and Settings::Get('OPF_JS_TEXT'));
    if ($needsJs and ($content != $new_content)) {
        // use insert class to include the needed js file
        I::insertJsFile(get_url_from_path(__DIR__ .'/js/mdcr.js', 'BODY BTM-'));
    }
    return $new_content;
}

/**
 * @brief  Obfuscate email address while keeping it in a human readable format.
 *         This solution is based on: http://www.wbwip.com/wbw/emailencoder.html
 * 
 *         This function will be only applied when email address contains @ + .  
 * 
 * @param  string  $str
 * @return string
 */
function readable_obfuscation($str){    
    $pattern = '/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i'; // find email 
    $retVal  = preg_replace_callback($pattern, 'readable_obfuscation_callback', $str);    
    
    return $retVal;
}

/**
 * Callback function for readable_obfuscation regEx replacement
 * 
 * 
 * @param  array $matches
 * @return string
 */
function readable_obfuscation_callback($matches) {
    $arr = array(
        'a' => '&#97;',
        'b' => '&#98;',
        'c' => '&#99;',
        'd' => '&#100;',
        'e' => '&#101;',
        'f' => '&#102;',
        'g' => '&#103;',
        'h' => '&#104;',
        'i' => '&#105;',
        'j' => '&#106;',
        'k' => '&#107;',
        'l' => '&#108;',
        'm' => '&#109;',
        'n' => '&#110;',
        'o' => '&#111;',
        'p' => '&#112;',
        'q' => '&#113;',
        'r' => '&#114;',
        's' => '&#115;',
        't' => '&#116;',
        'u' => '&#117;',
        'v' => '&#118;',
        'w' => '&#119;',
        'x' => '&#120;',
        'y' => '&#121;',
        'z' => '&#122;',

        // further obfuscate `@` and `.` for email harvesting bots 
        '@' => '<span>&#64;</span>', 
        '.' => '<span>&#46;</span>',
    );
    return strtr($matches[0], $arr);
}
/**
 * The configured @/. replacements, reduced to the pairs that are actually set.
 *
 * Two reasons this is not just array('@','.') => array(setting, setting):
 *
 * 1. An EMPTY setting used to delete the character outright —
 *    max.mustermann@example.com became maxmustermannexamplecom, and the
 *    mailto: href along with it. A blank field read as "remove it", which is
 *    nobody's intention.
 * 2. Leaving both blank is now the way to get the GOOD obfuscation. The text
 *    substitution runs before readable_obfuscation(), whose pattern needs a
 *    literal '@' to find an address at all — so as long as '@' had already
 *    been turned into "(at)", the entity encoder below silently did nothing
 *    and the page shipped plain "(at)" text. With no replacement configured,
 *    the address survives intact up to readable_obfuscation(), which encodes
 *    every character as a numeric entity and wraps @/. in <span>. The visitor
 *    reads a normal address, the harvester finds no address in the source.
 *
 * @return array{0: array<int,string>, 1: array<int,string>} [$search, $replace]
 */
function opf_email_replacements()
{
    $search  = array();
    $replace = array();
    $at  = (string) Settings::Get('opf_at_replacement');
    $dot = (string) Settings::Get('opf_dot_replacement');
    if ($at !== '')  { $search[] = '@'; $replace[] = $at; }
    if ($dot !== '') { $search[] = '.'; $replace[] = $dot; }
    return array($search, $replace);
}

/**
 * Encrypt an address with the adapted Caesar cipher that js/mdcr.js reverses.
 *
 * Lifted verbatim out of the mailto branch below, where it had been inline —
 * the visible-text mode needs exactly the same ciphertext, and two copies of
 * a cipher is how the two halves drift apart.
 *
 * Lower-cased on purpose, not sloppiness: F/Z/X/K are the cipher's markers for
 * @ . _ and -, so a literal capital F in an address would come back out of the
 * decoder as an '@'. The price is that a visible address renders lower-case.
 *
 * NOT a security boundary. The shift is the last character of the result and
 * js/mdcr.js is served alongside it — the protection is that a harvester has
 * to RUN JavaScript, not that the cipher is hard.
 *
 * @param  string $address Plain e-mail address.
 * @return string Ciphertext for mdcr()/sdcr().
 */
function opf_email_encrypt($address)
{
    $prepared = str_replace(array('@', '.', '_', '-'), array('F', 'Z', 'X', 'K'), strtolower($address));
    $shift    = mt_rand(1, 25);
    $out      = '';
    for ($i = strlen($prepared) - 1; $i > -1; $i--) {
        if (preg_match('#[FZXK0-9]#', $prepared[$i])) {
            $out .= $prepared[$i];
        } else {
            $out .= chr((ord($prepared[$i]) - 97 + $shift) % 26 + 97);
        }
    }
    return $out . chr($shift + 97);
}

/**
 * callback-function for function _doFilterEmail() to proceed search results
 * @param array results from preg_replace
 * @return string proceeded replacement string
 */
function _cbDoExecuteFilter($match)
{
    list($search, $replace) = opf_email_replacements();

    // check if the match contains the expected number of subpatterns (6|8)
    switch (count($match)) {

        case 8:
        /** OUTPUT FILTER FOR EMAIL ADDRESSES EMBEDDED IN TEXT **/
        // 1.. text mails only, 3.. text mails + mailto (no JS), 7 text mails + mailto (JS)
            if (!Settings::Get('opf_email_filter')) {
                return $match[0];
            }
            // do not filter mail addresses included in input tags (<input ... value = "test@mail)
            if (strpos($match[6], 'value') !== false) {
                return $match[0];
            }
            // JS mode for the VISIBLE address: emit nothing but a ciphertext
            // and let js/mdcr.js write the address in at runtime. The served
            // HTML then contains no address at all — not even entity-encoded,
            // which a harvester decodes for free.
            //
            // The element is deliberately EMPTY: a no-JS fallback that carries
            // the address (entities, or a "turn on JavaScript" line with the
            // address in it) hands it straight back to anything that reads the
            // source, and the whole detour buys nothing. Visitors without
            // JavaScript see nothing here — a conscious trade, chosen by
            // switching this on.
            if (Settings::Get('opf_js_text')) {
                // $match[6] is the optional value="/' prefix the pattern
                // captures; normally empty (the value= case bailed out above),
                // kept so nothing is swallowed in the edge case.
                return $match[6] . '<span class="opf-mail" data-m="'
                     . htmlspecialchars(opf_email_encrypt($match[7]), ENT_QUOTES, 'UTF-8') . '"></span>';
            }

            // filtering of non mailto email addresses enabled
            // $search empty => nothing configured => leave the address for
            // readable_obfuscation() to encode (see opf_email_replacements()).
            $replacement = $search ? str_replace($search, $replace, $match[0]) : $match[0];
            return readable_obfuscation($replacement);
        break;

        case 6:
        /** OUTPUT FILTER FOR EMAIL ADDRESSES EMBEDDED IN MAILTO LINKS **/
        // 2.. mailto only (no JS), 3.. text mails + mailto (no JS), 6.. mailto only (JS), 7.. all filters active
            if (!Settings::Get('opf_mailto_filter')) {
                return $match[0];
            }
            // check if last part of the a href link: >xxxx</a> contains a email address we need to filter
            $pattern = '#[A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,25}#i';
            if (preg_match_all($pattern, $match[5], $matches)) {
                foreach ($matches as $submatch) {
                    foreach ($submatch as $value) {
                        // replace all . and all @ in email address parts by the
                        // configured strings — or leave them be, so the entity
                        // encoder on the next line can do the better job.
                        if ($search) {
                            $match[5] = str_replace($value, str_replace($search, $replace, $value), $match[5]);
                        }
                        $match[5] = readable_obfuscation($match[5]);
                    }
                }
            }
            // check if Javascript encryption routine is enabled
            if (Settings::Get('OPF_JS_MAILTO')) {
                /** USE JAVASCRIPT ENCRYPTION FOR MAILTO LINKS **/
                // extract possible class and id attribute from ahref link
                preg_match('/class\s*?=\s*?("|\')(.*?)\1/ix', $match[0], $class_attr);
                $class_attr = empty($class_attr) ? '' : 'class="' . $class_attr[2] . '" ';
                preg_match('/title\s*?=\s*?("|\')(.*?)\1/ix', $match[0], $title_attr);
                $title_attr = empty($title_attr) ? '' : 'title="' . $title_attr[2] . '" ';

                preg_match('/id\s*?=\s*?("|\')(.*?)\1/ix', $match[0], $id_attr);
                $id_attr = empty($id_attr) ? '' : 'id="' . $id_attr[2] . '" ';
                preg_match('/style\s*?=\s*?("|\')(.*?)\1/ix', $match[0], $style_attr);
                $style_attr = empty($style_attr) ? '' : 'style="' . $style_attr[2] . '" ';
                // preprocess mailto link parts for further usage.
                // NB: $search/$replace are NOT reassigned to the cipher markers
                // here any more — they still hold the configured @/. strings,
                // and overwriting them used to leave a trap for anything added
                // below this point.
                $email_subject = rawurlencode(html_entity_decode($match[3]));
                // Cipher now lives in opf_email_encrypt() — the visible-text
                // mode above needs the identical encoding.
                $encrypted_email = opf_email_encrypt($match[2]);
                // build the encrypted Javascript mailto link
                if (strpos($class_attr, 'fa-') == false) {
                    $mailto_link  = "<a {$class_attr}{$title_attr}{$id_attr}{$style_attr}href=\"javascript:mdcr('$encrypted_email','$email_subject')\">" .$match[5] ."</a>";
                } else {
                    $mailto_link  = "<a {$title_attr}{$id_attr}{$style_attr}href=\"javascript:mdcr('$encrypted_email','$email_subject')\">" .$match[5] ."</a>";
                }
                return $mailto_link;
            } else {
                /** DO NOT USE JAVASCRIPT ENCRYPTION FOR MAILTO LINKS **/
                // as minimum protection, replace @ in the mailto part by (at)
                // dots are not transformed as this would transform my.name@domain.com into: my(dot)name(at)domain(dot)com
                // rebuild the mailto link from the subpatterns (at the missing characters " and </a>")
                //
                // An EMPTY at-replacement must leave the href alone: substituting
                // '' here produced "mailto:max.mustermannexample.com", a dead
                // link. Without a replacement the mailto stays intact and the
                // protection comes from the link TEXT, which readable_obfuscation()
                // has already encoded above.
                $atRep  = (string) Settings::Get('opf_at_replacement');
                $mailTo = $atRep !== '' ? str_replace('@', $atRep, $match[2]) : $match[2];
                return $match[1] .$mailTo .$match[3] .'"' .$match[4] .$match[5] .'</a>';
                // if you want to protect both, @ and dots, comment out the line above and remove the comment from the line below
            // return $match[1] .str_replace($search, $replace, $match[2]) .$match[3] .'"' .$match[4] .$match[5] .'</a>';
            }
        break;

        default:
        // number of subpatterns do not match the requirements ... do nothing
            return $match[0];
        break;
    }
}

function opff_mod_opf_email(&$content, $page_id, $section_id, $module, $wb)
{
    if (Settings::Get('opf_email', true)) {    
        $content = doFilterEmail($content);
    }
    return(true);
}
