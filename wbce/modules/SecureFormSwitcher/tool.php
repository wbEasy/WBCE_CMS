<?php
/**
 * SecureFormSwitcher — tool.php
 *
 * Admin-Tool entry point for the session and form-token (FTAN) settings that
 * framework/SecureForm.php reads as WB_SECFORM_* constants. Handles save /
 * reset (post-redirect-get with toasts) and renders twig/tool.twig.
 *
 * @category        modules
 * @package         More Security Settings (SecureFormSwitcher)
 * @author          WBCE Project
 * @copyright       Norbert Heimsath
 * @license         WTFPL
 */

defined('WB_PATH') or exit('No direct access allowed');
$admin->get_permission('admintools') or die(header('Location: ../../index.php'));

// Defaults — keep in sync with install.php and SecureForm's own fallbacks
const SFS_DEFAULT_TIMEOUT     = '7200';
const SFS_DEFAULT_FTAN_MAXAGE = '28800';
const SFS_DEFAULT_TOKENNAME   = 'formtoken';

// ── Save / reset ──────────────────────────────────────────────────────────────
if (isset($_POST['save_settings']) || isset($_POST['save_default'])) {
    if (!$admin->checkFTAN()) {
        (new Alerts())->sessionToast($MESSAGE['GENERIC_SECURITY_ACCESS'], 'error');
        header('Location: ' . $returnUrl);
        exit;
    }

    $aErrors = [];
    $setError = '';

    if (isset($_POST['save_default'])) {
        $setError .= Settings::set('wb_secform_secret', bin2hex(random_bytes(12)));
        $setError .= Settings::set('wb_secform_timeout', SFS_DEFAULT_TIMEOUT);
        $setError .= Settings::set('wb_session_timeout', SFS_DEFAULT_TIMEOUT);
        $setError .= Settings::set('wb_secform_ftan_maxage', SFS_DEFAULT_FTAN_MAXAGE);
        $setError .= Settings::set('wb_secform_tokenname', SFS_DEFAULT_TOKENNAME);
    } else {
        // Each field is saved on its own: one invalid value must not throw
        // away the valid ones next to it.
        $tokenName = (string) $admin->get_post('tokenName');
        if (preg_match('/^[a-zA-Z]{5,20}$/', $tokenName)) {
            $setError .= Settings::set('wb_secform_tokenname', $tokenName);
        } else {
            $aErrors[] = $SFS['TOKENNAME_ERR'];
        }

        $secret = (string) $admin->get_post('secret');
        if (preg_match('/^[a-zA-Z0-9]{20,60}$/', $secret)) {
            $setError .= Settings::set('wb_secform_secret', $secret);
        } else {
            $aErrors[] = $SFS['SECRET_ERR'];
        }

        // SecureForm only accepts 0-86400 and silently falls back to its
        // default otherwise; below 60 nobody could stay logged in to save
        $timeout = (string) $admin->get_post('timeout');
        if (ctype_digit($timeout) && (int) $timeout >= 60 && (int) $timeout <= 86400) {
            $setError .= Settings::set('wb_secform_timeout', $timeout);
            $setError .= Settings::set('wb_session_timeout', $timeout);
        } else {
            $aErrors[] = $SFS['TIMEOUT_ERR'];
        }

        $ftanMaxAge = (string) $admin->get_post('ftanMaxAge');
        if (ctype_digit($ftanMaxAge) && (int) $ftanMaxAge <= 604800) {
            $setError .= Settings::set('wb_secform_ftan_maxage', $ftanMaxAge);
        } else {
            $aErrors[] = $SFS['FTAN_MAXAGE_ERR'];
        }
    }

    if ($setError) {
        $aErrors[] = $setError;
    }
    if ($aErrors) {
        (new Alerts())->sessionToast(implode('<br>', $aErrors), 'error');
    } else {
        (new Alerts())->sessionToast('MESSAGE:CHANGES_SAVE_SUCCESS', 'success');
    }
    header('Location: ' . $returnUrl);
    exit;
}

// ── Display ───────────────────────────────────────────────────────────────────
// Read from the DB, not the constants: they were defined at the start of the
// request and may predate a save. No row for the max age = SecureForm default.
getTwig(__DIR__ . '/twig/')->load('tool.twig')->display([
    'returnUrl'       => $returnUrl,
    'RETURN_TO_TOOLS' => $returnToTools,
    'SFS'             => $SFS,
    'cfg'             => [
        'tokenName'  => (string) Settings::get('wb_secform_tokenname', SFS_DEFAULT_TOKENNAME),
        'secret'     => (string) Settings::get('wb_secform_secret', ''),
        'timeout'    => (string) Settings::get('wb_secform_timeout', SFS_DEFAULT_TIMEOUT),
        'ftanMaxAge' => (string) Settings::get('wb_secform_ftan_maxage', SFS_DEFAULT_FTAN_MAXAGE),
    ],
]);
