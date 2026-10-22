<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright Ryan Djurovich (2004-2009)
 * @copyright WebsiteBaker Org. e.V. (2009-2015)
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

//  Heavy patched version, idea for patches based on :
//  http://stackoverflow.com/questions/2695153/php-csrf-how-to-make-it-works-in-all-tabs/2695291#2695291
//  Whith this patch the token System now allows for multiple browser tabs.
//  You can configure this class by adding several constants to your config.php
//  All Patches are Copyright Norbert Heimsath released under GPLv3
//  http://www.gnu.org/licenses/gpl.html
//  Take a look at  __construct  for configuration options(constants).
//  Patch version 0.3.5

/*
 * === CONFIGURATION ===========================================================
 *
 * The following constants can be configured with the SecureForm Switcher 
 * Admin Tool (authored by Luisehahne) that is part of the WBCE CMS Package. 
 *
 * ─── WB_SECFORM_SECRET ───────────────────────────────────────────────────────
 * Secret can contain anything. It's the base for the secret part for the hash:
 * define ('WB_SECFORM_SECRET','whatever you like');
 * 
 * ─── WB_SECFORM_SECRETTIME ───────────────────────────────────────────────────
 * No longer used. Up to 1.7.0 the FTAN secret was rotated every 86400
 * seconds (this constant was never actually read); FTAN lifetime is now
 * controlled by WB_SECFORM_FTAN_MAXAGE.
 * 
 * ─── WB_SECFORM_TIMEOUT ──────────────────────────────────────────────────────
 * Lifetime of IDKEYs (getIDKEY()/checkIDKEY()), counted from their creation.
 * Does NOT apply to the FTAN, see WB_SECFORM_FTAN_MAXAGE.
 * Integer value between 0-86400 seconds:
 * define ('WB_SECFORM_TIMEOUT', 3600);
 *
 * ─── WB_SECFORM_FTAN_MAXAGE ──────────────────────────────────────────────────
 * Maximum age of a form token (FTAN), counted from the moment the form was
 * rendered. Default 28800 (8 hours, a working day): nobody loses a form
 * they spent hours on, and a token that leaked through a URL (Referer,
 * logs, history) is bounded even within an all-day session. 0 = no age
 * limit, the token then lives as long as the session (it is bound to
 * SessionTokenIdentifier, which logout and session timeout clear).
 * Kept apart from WB_SECFORM_TIMEOUT on purpose: the session timeout slides
 * with every request, a token's age does not, so the 2-hour IDKEY/session
 * default would reject forms that were simply open for a long time.
 * Integer value between 0-604800 seconds (one week):
 * define ('WB_SECFORM_FTAN_MAXAGE', 28800);
 * 
 * ─── WB_SECFORM_TOKENNAME ────────────────────────────────────────────────────
 * Name for the token form element only alphanumerical string 
 * allowed that starts whith a charakter:
 * define ('WB_SECFORM_TOKENNAME','my3form3');
 * 
 * ─── Removed: WB_SECFORM_USEFP, FINGERPRINT_WITH_IP_OCTETS ───────────────────
 * Browser/IP fingerprinting of the FTAN was removed in 1.7.0. The switch never
 * took effect (the constructor only ever set it to false), and it cannot work
 * in principle: a CSRF request is sent by the victim's own browser, so its
 * fingerprint matches; a hijacker with the session cookie simply renders the
 * form in their own browser and gets a token signed with their own fingerprint.
 * What remained were false rejections (browser update, mobile IP change).
 * Both constants are ignored; the updater removes their settings rows.
 *
 * =============================================================================
 */

// Prevent  this  file  from  being  accessed  directly
defined('WB_PATH') or die('No direct access allowed');

/**
 * Class Wbce extends this class, providing these methods to Admin and Frontend as well.
 */

class SecureForm
{

    const FRONTEND = 0;
    const BACKEND = 1;

    // additional private data
    private $_secret = '5609bnefg93jmgi99igjefg';
    private $_tokenname = 'formtoken';
    private $_timeout = 7200;
    private $_ftanMaxAge = 28800;
    private $_page_uid = "";
    private $_page_id = "";

    // additional private data
    private $_FTAN = '';
    private $_IDKEYs = array('0' => '0');
    private $_idkey_name = '';
    private $_salt = '';
    private $_serverdata = '';

    // Session key under which the IDKEYs are stored. Fixed on purpose: it used
    // to be derived from a browser fingerprint (user agent + IP), so a browser
    // update in the middle of a session silently dropped every open IDKEY.
    private const IDKEY_STORE = 'wbce_idkeys';
            
    // Establish class Database object
    protected Database $db; 

    /* Construtor */

    protected function __construct($mode = self::FRONTEND)
    {
        // Establish class Database object for
        // use in this class and its subclasses Admin, Wbce & Frontend.
        // Introduced with WBCE 1.4.0 to save redundancy.
        $this->db = $GLOBALS['database'];

        // GLOBAL CONFIGURATION, additional constants and stuff

        // Secret can contain anything its the base for the secret part of the hash
        if (defined('WB_SECFORM_SECRET')) {
            $this->_secret = WB_SECFORM_SECRET;
        }

        // Timeout till the form token times out. Integer value between 0-86400 seconds (one day)
        if (defined('WB_SECFORM_TIMEOUT') and is_numeric(WB_SECFORM_TIMEOUT) and intval(WB_SECFORM_TIMEOUT) >= 0 and intval(WB_SECFORM_TIMEOUT) <= 86400) {
            $this->_timeout = intval(WB_SECFORM_TIMEOUT);
        }

        // Maximum FTAN age. Integer value between 0-604800 seconds (one week), 0 = session-bound only
        if (defined('WB_SECFORM_FTAN_MAXAGE') and is_numeric(WB_SECFORM_FTAN_MAXAGE) and intval(WB_SECFORM_FTAN_MAXAGE) >= 0 and intval(WB_SECFORM_FTAN_MAXAGE) <= 604800) {
            $this->_ftanMaxAge = intval(WB_SECFORM_FTAN_MAXAGE);
        }

        // Name for the token form element only alphanumerical string allowed that starts whith a charakter
        if (defined('WB_SECFORM_TOKENNAME') and !$this->_validate_alalnum(WB_SECFORM_TOKENNAME)) {
            $this->_tokenname = WB_SECFORM_TOKENNAME;
        }

        // create a unique pageid for per page management of idkeys , especially
        // to identify and delete unused ones from same page call.
        $this->_page_uid = uniqid(rand(), true);

        // GLOBAL CONFIGURATION END

        // CONFIGURE VARS
        $this->_serverdata = $this->_generate_serverdata();
        $this->_secret = $this->_generate_secret();
        $this->_salt = $this->_generate_salt();
        $this->_idkey_name = self::IDKEY_STORE;

        // takeover id_keys from session if available
        if (isset($_SESSION[$this->_idkey_name]) && is_array($_SESSION[$this->_idkey_name])) {
            $this->_IDKEYs = $_SESSION[$this->_idkey_name];
        } else {
            $this->_IDKEYs = array('0' => '0');
            $_SESSION[$this->_idkey_name] = $this->_IDKEYs;
        }
    }

    /**
     * Validate that $input is an alphanumeric string starting with a letter.
     *
     * Returns false on success (valid input). This inverted pattern matches the
     * guard style in the constructor: if (!$this->_validate_alalnum(X)) means
     * "proceed only if X is valid".
     *
     * @param  mixed        $input
     * @return false|string false if valid; error message string if invalid
     */
    private function _validate_alalnum(mixed $input): false|string
    {
        # Alphanumeric string that starts with a letter character
        if (preg_match('/^[a-zA-Z][0-9a-zA-Z]+$/u', $input)) {
            return false;
        }

        return "The given input is not an alphanumeric string.";
    }

    /**
     * Collect stable server-side values for use in token signing.
     *
     * Includes server software, name, port, admin address, and PHP version.
     * These values stay constant across requests and ensure that tokens generated
     * on one server cannot be replayed on a different server.
     *
     * The server IP is deliberately not included (it was, cut to
     * FINGERPRINT_WITH_IP_OCTETS blocks, up to 1.7.0): behind a load balancer
     * or with several addresses per host it differs between requests and
     * would reject valid tokens.
     */
    private function _generate_serverdata(): string
    {

        $serverdata = '';
        $serverdata .= (isset($_SERVER['SERVER_SIGNATURE'])) ? $_SERVER['SERVER_SIGNATURE'] : '2';
        $serverdata .= (isset($_SERVER['SERVER_SOFTWARE'])) ? $_SERVER['SERVER_SOFTWARE'] : '3';
        $serverdata .= (isset($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : '5';
        $serverdata .= (isset($_SERVER['SERVER_PORT'])) ? $_SERVER['SERVER_PORT'] : '11';
        $serverdata .= (isset($_SERVER['SERVER_ADMIN'])) ? $_SERVER['SERVER_ADMIN'] : '13';
        $serverdata .= PHP_VERSION;

        return $serverdata;
    }

    /**
     * Build the site-wide part of the HMAC key used to sign and verify CSRF tokens.
     *
     * Combines:
     *   - The configured base secret (WB_SECFORM_SECRET)
     *   - The server name (ties tokens to this domain)
     *   - Stable server environment data
     *
     * Deliberately NOT included (both were part of this secret up to 1.7.0):
     *   - A daily time seed: token lifetime is now enforced by the signed
     *     timestamp inside each token (see getFTAN()), so there is no longer
     *     a moment at midnight (UTC) when every open form becomes invalid.
     *   - session_id(): the session binding comes from SessionTokenIdentifier
     *     (see _signFtan()), which survives session_regenerate_id().
     */
    private function _generate_secret(): string
    {

        $secret = $this->_secret;
        $secret .= md5($_SERVER['SERVER_NAME'] ?? '');
        $secret .= $this->_serverdata;

        return $secret;
    }

    /**
     * Compute the HMAC-SHA256 signature for an FTAN.
     *
     * The key combines the site-wide secret with the per-session random
     * SessionTokenIdentifier (256 bit, see WbceSession), so a token is only
     * valid in the session it was issued for.
     *
     * @param  string $issued  Unix timestamp (decimal digits) at which the token was issued
     * @param  string $nonce   Random hex string that makes each token unique
     * @return string          64 character lowercase hex signature
     */
    private function _signFtan(string $issued, string $nonce): string
    {
        $key = $this->_secret . '|' . WbceSession::get('SessionTokenIdentifier');

        return hash_hmac('sha256', 'ftan|' . $issued . '|' . $nonce, $key);
    }
    
    /**
     * Generates a cryptographically secure random IDKEY token 
     *
     * @return string  64 character hexadecimal token (256 Bit entropy)
     */
    private function _generate_salt(): string
    {
        try {
            // random_bytes() is cryptographically secure and available since PHP 7.0
            return bin2hex(random_bytes(32));

        } catch (\Exception $e) {
            // Fallback only in very rare cases (e.g. system has no entropy)
            // This should practically never happen on a normal server
            trigger_error('random_bytes() failed: ' . $e->getMessage(), E_USER_WARNING);
            return hash('sha256', uniqid((string)mt_rand(), true) . microtime(true));
        }
    }
    
    /**
     * Generate a signed CSRF form token (Form Transaction Number).
     *
     * Token format: "<issued>-<nonce>-<signature>"
     *   issued     Unix timestamp of creation (decimal)
     *   nonce      32 hex chars from random_bytes()
     *   signature  HMAC-SHA256 over issued + nonce, see _signFtan()
     *
     * Each call produces a unique, signed token bound to the current session via
     * SessionTokenIdentifier. The token survives session_regenerate_id() calls
     * because it is tied to the identifier rather than the raw session ID.
     *
     * Multiple browser tabs are supported.
     *
     * Tokens expire after $this->_ftanMaxAge seconds (WB_SECFORM_FTAN_MAXAGE,
     * default 8 hours), counted from the moment the token was issued, and in
     * any case with the session (logout, session timeout).
     *
     * For action links prefer getIDKEY(): an FTAN is reusable within its
     * lifetime, so one that sits in a URL is a leaked token for every form.
     *
     * @param  bool   $as_tag  true (default) returns a hidden <input> tag ready to embed in a form
     *                         false returns a key=value string for use in URLs (GET requests)
     * @return string
     */
    final public function getFTAN(bool $as_tag = true): string
    {

        $issued = (string) time();
        $nonce = bin2hex(random_bytes(16));
        $signed = $issued . '-' . $nonce . '-' . $this->_signFtan($issued, $nonce);

        if ($as_tag == true) {
            // by default return a complete, hidden <input>-tag
            return '<input type="hidden" name="' . $this->_tokenname . '" value="' . htmlspecialchars($signed) . '" />';
        }

        return $this->_tokenname . '=' . $signed;
    }

    /**
     * Validate the CSRF token submitted with a form or URL.
     *
     * Checks that the token found in POST or GET matches the HMAC signature
     * expected for the current session, and that it is not older than
     * $this->_ftanMaxAge seconds (a maximum age of 0 disables the age check).
     * Any mismatch returns false — the calling code must abort the request
     * in that case.
     *
     * A valid token can be submitted more than once within its lifetime
     * (multiple tabs, re-submitting after a validation error).
     *
     * @param  string $mode  'POST' (default) or 'GET'
     * @return bool          true if the token is valid and the request may proceed
     */
    final public function checkFTAN(string $mode = 'POST'): bool
    {

        $received = (strtoupper($mode) != 'POST' ? $_GET : $_POST)[$this->_tokenname] ?? null;

        // an array (formtoken[]=...) or a missing token is never valid
        if (!is_string($received) || !WbceSession::get('SessionTokenIdentifier')) {
            return false;
        }

        $parts = explode('-', $received);
        if (count($parts) !== 3) {
            return false;
        }
        [$issued, $nonce, $hash] = $parts;

        if (!ctype_digit($issued) || strlen($nonce) !== 32 || !ctype_xdigit($nonce)) {
            return false;
        }

        if ($this->_ftanMaxAge > 0 && time() - (int) $issued > $this->_ftanMaxAge) {
            return false;
        }

        return hash_equals($this->_signFtan($issued, $nonce), $hash);
    }

    /**
     * Store a value in the session under a one-time opaque key.
     *
     * Lets you pass sensitive data (IDs, arrays) through form hidden fields without
     * exposing the actual values in HTML. The returned key is safe to embed in a
     * form or URL. Each key can be redeemed exactly once via checkIDKEY() — after
     * redemption all keys from the same page call are invalidated to prevent replay.
     *
     * Purpose: all IDKEYs of a session share one store, and checkIDKEY() alone
     * returns whatever value a key holds. A section ID handed out by one screen
     * would therefore be accepted as a page ID by another endpoint. Give keys a
     * purpose (e.g. 'page') and redeem them with the same purpose, and a key
     * issued for anything else is refused. Keys without a purpose behave as
     * before.
     *
     * @param  mixed  $value    Scalar or array to store (arrays are serialized automatically)
     * @param  string $purpose  What the value is, e.g. 'page'; '' = unspecified (legacy)
     * @return string           Opaque one-time key to embed in the form
     */
    public function getIDKEY(mixed $value, string $purpose = ''): string
    {

        // serialize value, if it's an array
        if (is_array($value) == true) {
            $value = serialize($value);
        }

        // cryptsome random stuff with salt into md5-hash
        $key = md5($this->_salt . rand() . uniqid('', true));

        //shorten hash a bit
        $key = str_replace(array("=", "$", "+"), array("-", "_", ""), base64_encode(pack('H*', $key)));

        // the key is unique, so store it in list
        if (!array_key_exists($key, $_SESSION[$this->_idkey_name])) {
            $_SESSION[$this->_idkey_name][$key]['value'] = $value;
            $_SESSION[$this->_idkey_name][$key]['time'] = time();
            $_SESSION[$this->_idkey_name][$key]['page'] = $this->_page_uid;
            $_SESSION[$this->_idkey_name][$key]['purpose'] = $purpose;
        } // if key already exist, try again, dont store as it already been stored
        else {
            $key = $this->getIDKEY($value, $purpose);
        }

        return $key;
    }

    /**
     * Redeem an IDKEY created by getIDKEY() and return the value it stands for.
     *
     * @param  string      $fieldname  Request field holding the key (or the key itself)
     * @param  mixed       $default    Returned when the key is unknown, expired or has the wrong purpose
     * @param  string      $request    'POST', 'GET' or anything else = $fieldname is the key
     * @param  bool        $ajax       true = peek: keep the key and its siblings valid
     * @param  string|null $purpose    Accept only keys issued with this purpose (see
     *                                 getIDKEY()); null = any key (legacy behaviour)
     * @return mixed
     */
    public function checkIDKEY($fieldname, $default = 0, $request = 'POST', $ajax = false, ?string $purpose = null)
    {

        //Remove timed out idkeys
        //debug_dump($_SESSION[$this->_idkey_name]);
        $_SESSION[$this->_idkey_name] = array_filter($_SESSION[$this->_idkey_name], array($this, "_timedout"));

        // set returnvalue to default
        $return_value = $default;
        switch (strtoupper($request)) {
            case 'POST':
                $key = isset($_POST[$fieldname]) ? $_POST[$fieldname] : $fieldname;
                break;
            case 'GET':
                $key = isset($_GET[$fieldname]) ? $_GET[$fieldname] : $fieldname;
                break;
            default:
                $key = $fieldname;
        }

        // key always must match the generated ones
        if (preg_match('/[0-9a-zA-Z\-\_]{1,32}$/', $key)) {
            // check if key is stored in IDKEYs-list
            if (array_key_exists($key, $_SESSION[$this->_idkey_name])) {
                // a key issued for something else is no key for this purpose;
                // refuse it without consuming anything
                if ($purpose !== null && ($_SESSION[$this->_idkey_name][$key]['purpose'] ?? '') !== $purpose) {
                    return $default;
                }
                // fetch stored value
                $return_value = $_SESSION[$this->_idkey_name][$key]['value'];
                // fetch page identifier used to remove all keys generated on the former pagecall
                $this->_page_id = $_SESSION[$this->_idkey_name][$key]['page'];

                if ($ajax === false) {
                    //Remove all keys from this page to prevent multiuse and session mem usage
                    $_SESSION[$this->_idkey_name] = array_filter($_SESSION[$this->_idkey_name], array($this, "_fpages"));
                    //unset($_SESSION[$this->_idkey_name][$key]);   // remove from list to prevent multiuse
                }

                if (preg_match('/.*(?<!\{).*(\d:\{.*;\}).*(?!\}).*/', $return_value)) {
                    // if value is a serialized array, then deserialize it
                    // Hardening: block PHP Object Injection via unserialize()
                    $return_value = unserialize($return_value, ['allowed_classes' => false]);
                }
            }
        }

        return $return_value;
    }

    // ── Additional functions by Norbert Heimsath, heimsath.org ───────────────
    // 
    // Released under GPLv3: http://www.gnu.org/licenses/gpl.html

    /**
     * Invalidate all stored IDKEY entries for this session.
     *
     * Resets the IDKEYs list to its initial sentinel state {0: 0}.
     * Call after logout or any operation that should prevent previously
     * issued keys from being redeemed.
     */
    public function clearIDKEY(): void
    {

        $this->_IDKEYs = array('0' => '0');
    }


    /**
     * Array filter callback: remove expired IDKEY entries.
     *
     * Called by array_filter() in checkIDKEY() to prune stale keys before
     * looking up a submitted key.
     *
     * The sentinel value '0' inserted by clearIDKEY() is always removed —
     * it keeps the session array non-empty after a reset, not a real key.
     *
     * @param  mixed $var  IDKEY entry (array with 'time' key) or sentinel '0'
     * @return bool        true = keep; false = remove
     */
    private function _timedout(mixed $var): bool
    {
        // Sentinel from clearIDKEY() — always discard
        if ($var === 0 || $var === '0') {
            return false;
        }

        // Discard if older than the configured timeout
        if ($var['time'] < time() - $this->_timeout) {
            return false;
        }

        return true;
    }

    /**
     * Array filter callback: remove IDKEY entries that belong to the current page call.
     *
     * After a key is successfully redeemed, all other keys generated during the
     * same page request are removed. This prevents replay while still allowing
     * multiple forms on the same page to each have their own valid key.
     *
     * @param  mixed $var  IDKEY entry array with a 'page' identifier
     * @return bool        true = keep; false = remove (same page as current request)
     */
    private function _fpages(mixed $var): bool
    {
        if ($var['page'] == $this->_page_id) {
            return false;
        }

        return true;
    }

    //
    // ADDITIONAL FUNCTIONS END
    //
}
