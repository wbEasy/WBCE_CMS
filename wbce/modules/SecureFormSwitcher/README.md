# Secure Form Switcher

Actually the name is misleading: the tool provides a few settings for sessions and for the CSRF protection of forms (the FTAN). The name only has historical reasons.

Settings: token name, secret, session timeout and the maximum age of a form token. Fingerprinting was removed in 1.4.0 — it never took effect and cannot protect a CSRF token (see the header of `framework/SecureForm.php`).

Have Fun  
Norbert

## License
[GPLv2 or any later](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
