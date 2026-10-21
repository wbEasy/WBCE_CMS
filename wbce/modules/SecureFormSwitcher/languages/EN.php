<?php
/**
 * @category        modules
 * @package         More Security Settings (SecureFormSwitcher)
 * @author          WBCE Project
 * @copyright       Luisehahne, Norbert Heimsath
 * @license         GPLv2 or any later.
 */

//Module description
$module_description = 'This module offers a few additional security settings.';

$SFS['HEADER']      = 'Sessions and form tokens';
$SFS['DESCRIPTION'] = 'Every backend form carries a form token (FTAN) that protects it against CSRF. These settings control how long sessions and form tokens stay valid and how the tokens are signed.';

$SFS['TIMEOUT']      = 'Session timeout (seconds)';
$SFS['TIMEOUT_HINT'] = 'Inactivity after which the session ends and the user has to log in again (60-86400, default 7200). Also the lifetime of one-time action keys (IDKEYs). It does not limit how long a form may stay open — see below.';
$SFS['TIMEOUT_ERR']  = 'Session timeout not saved: only a number between 60 and 86400.';

$SFS['FTAN_MAXAGE']      = 'Form token max. age (seconds)';
$SFS['FTAN_MAXAGE_HINT'] = 'How long a form may stay open before saving is refused, counted from the moment it was opened (0-604800, default 28800 = 8 hours). 0 = no limit, the token then stays valid as long as the session.';
$SFS['FTAN_MAXAGE_ERR']  = 'Form token max. age not saved: only a number between 0 and 604800.';

$SFS['TOKENNAME']      = 'Token name';
$SFS['TOKENNAME_HINT'] = 'Name of the hidden form field that carries the form token. Letters a-z and A-Z, 5-20 characters (default formtoken).';
$SFS['TOKENNAME_ERR']  = 'Token name not saved: only a-z and A-Z, 5 to 20 characters.';

$SFS['SECRET']      = 'Secret';
$SFS['SECRET_HINT'] = 'Random key used to sign the form tokens. Letters and digits, 20-60 characters. Changing it invalidates all forms that are currently open.';
$SFS['SECRET_ERR']  = 'Secret not saved: only a-z, A-Z and 0-9, 20 to 60 characters.';

$SFS['RESET_CONFIRM'] = 'Reset all values to their defaults? This also generates a new secret, so forms that are open right now can no longer be saved.';
