<?php
/**
 * @category        modules
 * @package         More Security Settings (SecureFormSwitcher)
 * @author          WBCE Project
 * @copyright       Luisehahne, Norbert Heimsath
 * @license         GPLv2 or any later.
 */

//Module description
$module_description = 'Einige Zusatzeinstellungen für die Sicherheit';

$SFS['HEADER']      = 'Sessions und Formular-Token';
$SFS['DESCRIPTION'] = 'Jedes Backend-Formular trägt ein Formular-Token (FTAN), das es gegen CSRF schützt. Hier wird eingestellt, wie lange Sessions und Formular-Token gültig sind und womit die Token signiert werden.';

$SFS['TIMEOUT']      = 'Session-Timeout (Sekunden)';
$SFS['TIMEOUT_HINT'] = 'Inaktivität, nach der die Session endet und man sich neu anmelden muss (60-86400, Standard 7200). Gilt auch als Lebensdauer der Einmal-Schlüssel für Aktionen (IDKEYs). Begrenzt nicht, wie lange ein Formular offen bleiben darf — siehe unten.';
$SFS['TIMEOUT_ERR']  = 'Session-Timeout nicht gespeichert: nur eine Zahl zwischen 60 und 86400.';

$SFS['FTAN_MAXAGE']      = 'Formular-Token Höchstalter (Sekunden)';
$SFS['FTAN_MAXAGE_HINT'] = 'Wie lange ein Formular offen bleiben darf, bevor das Speichern abgelehnt wird, gerechnet ab dem Öffnen (0-604800, Standard 28800 = 8 Stunden). 0 = keine Grenze, das Token gilt dann so lange wie die Session.';
$SFS['FTAN_MAXAGE_ERR']  = 'Formular-Token Höchstalter nicht gespeichert: nur eine Zahl zwischen 0 und 604800.';

$SFS['TOKENNAME']      = 'Tokenname';
$SFS['TOKENNAME_HINT'] = 'Name des versteckten Formularfelds, das das Formular-Token trägt. Buchstaben a-z und A-Z, 5-20 Zeichen (Standard formtoken).';
$SFS['TOKENNAME_ERR']  = 'Tokenname nicht gespeichert: nur a-z und A-Z, 5 bis 20 Zeichen.';

$SFS['SECRET']      = 'Secret';
$SFS['SECRET_HINT'] = 'Zufälliger Schlüssel, mit dem die Formular-Token signiert werden. Buchstaben und Ziffern, 20-60 Zeichen. Eine Änderung macht alle gerade geöffneten Formulare ungültig.';
$SFS['SECRET_ERR']  = 'Secret nicht gespeichert: nur a-z, A-Z und 0-9, 20 bis 60 Zeichen.';

$SFS['RESET_CONFIRM'] = 'Alle Werte auf Standard zurücksetzen? Dabei wird auch ein neues Secret erzeugt, gerade geöffnete Formulare lassen sich danach nicht mehr speichern.';
