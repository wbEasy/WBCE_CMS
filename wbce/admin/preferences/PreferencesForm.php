<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

declare(strict_types=1);

/**
 * "My data" (admin/preferences): what the logged-in user may change about
 * his own account, how it is checked and how it is stored.
 *
 * Every save is confirmed with the current password (as the old page did):
 * an unattended, logged-in browser must not be enough to take the account
 * over. A new password is set only with the "new password?" box ticked
 * (change_pswd), as in Access → Users.
 *
 * Writes straight to {TP}users: UserManager::updateUser() refuses user 1,
 * who has preferences like everyone else.
 *
 * @since 1.7.0
 */
final class PreferencesForm
{
    /** Columns this page writes — nothing else of the user row. */
    private const COLUMNS = ['display_name', 'email', 'language', 'timezone', 'date_format', 'time_format', 'password'];

    /** @var array<string, array<string, string>> */
    private array $optionCache = [];

    /** @var array<string, mixed>|null the user's row */
    private ?array $user = null;

    public function __construct(private readonly Admin $admin)
    {
    }

    public function userId(): int
    {
        return (int) $this->admin->get_user_id();
    }

    /** @return array<string, mixed> the user's row ([] when it is gone) */
    public function user(): array
    {
        if ($this->user === null) {
            $row        = $GLOBALS['database']->fetchRow('SELECT * FROM `{TP}users` WHERE `user_id` = ?', [$this->userId()]);
            $this->user = is_array($row) ? $row : [];
        }
        return $this->user;
    }

    // ── Rendering ───────────────────────────────────────────────────────────

    /**
     * The form's values: the stored ones, with "system default" as ''.
     *
     * @return array<string, string>
     */
    public function values(): array
    {
        $u = $this->user();
        return [
            'username'     => (string) ($u['username'] ?? ''),
            'display_name' => (string) ($u['display_name'] ?? ''),
            'email'        => (string) ($u['email'] ?? ''),
            'language'     => (string) ($u['language'] ?? ''),
            'timezone'     => DateTimeFormat::storedZone((string) ($u['timezone'] ?? '')),
            'date_format'  => (string) ($u['date_format'] ?? ''),
            'time_format'  => (string) ($u['time_format'] ?? ''),
        ];
    }

    /**
     * [value => label] for language, timezone, date_format, time_format;
     * '' = the system default, labelled with what that default is now.
     *
     * @return array<string, string>
     */
    public function options(string $field): array
    {
        if (isset($this->optionCache[$field])) {
            return $this->optionCache[$field];
        }
        global $TEXT;
        $default = ' (' . ($TEXT['SYSTEM_DEFAULT'] ?? 'System default') . ')';

        switch ($field) {
            case 'language':
                $rows    = $GLOBALS['database']->fetchAll(
                    "SELECT `directory`, `name` FROM `{TP}addons` WHERE `type` = 'language' ORDER BY `name`"
                );
                $options = array_column($rows ?: [], 'name', 'directory');
                break;

            case 'timezone':
                // the user's stored zone stays selectable even as an Etc zone
                $zones   = DateTimeFormat::timezoneChoices([DEFAULT_TIMEZONE_NAME, $this->values()['timezone']]);
                $options = ['' => $zones[DEFAULT_TIMEZONE_NAME] . $default] + $zones;
                break;

            case 'date_format':
            case 'time_format':
                $isDate  = $field === 'date_format';
                if ($isDate) {
                    include ADMIN_PATH . '/interface/date_formats.php';
                    $formats = $DATE_FORMATS;
                } else {
                    include ADMIN_PATH . '/interface/time_formats.php';
                    $formats = $TIME_FORMATS;
                }
                $now     = new DateTimeImmutable('now', new DateTimeZone(DEFAULT_TIMEZONE_NAME));
                $options = ['' => DateTimeFormat::format($now, $isDate ? DEFAULT_DATE_FORMAT : DEFAULT_TIME_FORMAT) . $default];
                foreach ($formats as $key => $label) {
                    if ($key !== 'system_default') {
                        $options[str_replace('|', ' ', (string) $key)] = $label;
                    }
                }
                break;

            default:
                throw new LogicException("PreferencesForm: no options for '{$field}'");
        }
        return $this->optionCache[$field] = $options;
    }

    // ── Saving ──────────────────────────────────────────────────────────────

    /**
     * Check a POST.
     *
     * @return array{values: array<string, string>, errors: array<string, string>, password_changed: bool}
     */
    public function validate(array $post): array
    {
        $values = [];
        $errors = [];
        $uid    = $this->userId();
        $str    = static fn (string $k): string => is_string($post[$k] ?? null) ? $post[$k] : '';

        // display name: shown to others, so unique (no one passes for someone else)
        $name = trim(strip_tags($str('display_name')));
        $name = preg_replace('/[\x00-\x1F\x7F]/u', '', $name) ?? '';
        if ($name === '') {
            $errors['display_name'] = L_('MESSAGE:SETTINGS_REQUIRED_FIELD');
        } elseif (mb_strlen($name) > 255) {
            $errors['display_name'] = L_('MESSAGE:SETTINGS_INVALID_VALUE');
        } elseif ($this->taken('display_name', $name, $uid)) {
            $errors['display_name'] = L_('MESSAGE:USERS_DISPLAY_NAME_TAKEN');
        } else {
            $values['display_name'] = $name;
        }

        // email: same rules as Access → Users
        $email        = trim($str('email'));
        $emailChanged = $email !== (string) ($this->user()['email'] ?? '');
        if ($emailChanged) {
            $emailErrors = (new UserManager())->validateEmail($this->admin, $email, $uid);
            if ($emailErrors !== []) {
                $errors['email'] = $emailErrors[0];
            } else {
                $values['email'] = $email;
            }
        }

        foreach (['language', 'timezone', 'date_format', 'time_format'] as $field) {
            $value = $str($field);
            if (!array_key_exists($value, $this->options($field))) {
                $errors[$field] = L_('MESSAGE:SETTINGS_INVALID_VALUE');
                continue;
            }
            $values[$field] = $value;
        }
        if (($values['language'] ?? '') === '') {
            unset($values['language']);   // never stored empty: the backend needs a language
            $errors['language'] ??= L_('MESSAGE:SETTINGS_REQUIRED_FIELD');
        }

        // new password: only with the box ticked; not trimmed, spaces may be
        // part of it
        if (($post['change_pswd'] ?? '') === '1') {
            $hash = $this->admin->checkPasswordPattern($str('new_password_1'), $str('new_password_2'));
            if (is_array($hash)) {
                $errors['new_password_1'] = (string) reset($hash);
            } else {
                $values['password'] = $hash;
            }
        }

        // every save is confirmed with the current password
        $current = $str('current_password');
        if ($current === '') {
            $errors['current_password'] = L_('MESSAGE:SETTINGS_REQUIRED_FIELD');
        } elseif (!$this->admin->doCheckPassword($uid, $current)) {
            // the string carries <br /><b>…</b> for the old message box;
            // errors are shown as text at the field
            $errors['current_password'] = self::plainText(L_('MESSAGE:PREFERENCES_CURRENT_PASSWORD_INCORRECT'));
        }

        return [
            'values'           => $errors === [] ? $values : [],
            'errors'           => $errors,
            'password_changed' => isset($values['password']),
        ];
    }

    /** "a <br /><b>b</b>" → "a b" */
    private static function plainText(string $html): string
    {
        return trim(preg_replace('/\s+/u', ' ', strip_tags(str_ireplace(['<br>', '<br/>', '<br />'], ' ', $html))) ?? '');
    }

    /** Whether another account already uses $value in $column. */
    private function taken(string $column, string $value, int $uid): bool
    {
        return (int) $GLOBALS['database']->fetchValue(
            "SELECT COUNT(*) FROM `{TP}users` WHERE `{$column}` = ? AND `user_id` <> ?",
            [$value, $uid]
        ) > 0;
    }

    /**
     * Write the values and carry them into the session, so the backend
     * uses them from the next request on (Login does the same at sign-in).
     *
     * @param  array<string, string> $values  From validate()
     * @return string|null  error message, null on success
     */
    public function save(array $values): ?string
    {
        global $database;

        $data = array_intersect_key($values, array_flip(self::COLUMNS));
        if ($data === []) {
            return null;
        }
        $data['user_id'] = $this->userId();
        $database->upsertRow('{TP}users', 'user_id', $data);
        if ($database->hasError()) {
            return $database->getError();
        }
        $this->user = null;

        if (isset($values['display_name'])) $_SESSION['DISPLAY_NAME'] = $values['display_name'];
        if (isset($values['email']))        $_SESSION['EMAIL']        = $values['email'];
        if (isset($values['language']))     $_SESSION['LANGUAGE']     = $values['language'];

        self::sessionDefault('TIMEZONE_NAME', $values['timezone'] ?? null, 'USE_DEFAULT_TIMEZONE');
        // the seconds beside the name, for modules that read them (Login does the same)
        if (isset($values['timezone'])) {
            if ($values['timezone'] === '') {
                unset($_SESSION['TIMEZONE']);
            } else {
                $_SESSION['TIMEZONE'] = DateTimeFormat::offsetSeconds($values['timezone']);
            }
        }
        self::sessionDefault('DATE_FORMAT', $values['date_format'] ?? null, 'USE_DEFAULT_DATE_FORMAT');
        self::sessionDefault('TIME_FORMAT', $values['time_format'] ?? null, 'USE_DEFAULT_TIME_FORMAT');

        return null;
    }

    /** A value or "use the system default" in the session, as Login sets it. */
    private static function sessionDefault(string $key, ?string $value, string $defaultKey): void
    {
        if ($value === null) {
            return;   // not part of this save
        }
        if ($value === '') {
            unset($_SESSION[$key]);
            $_SESSION[$defaultKey] = true;
        } else {
            $_SESSION[$key] = $value;
            unset($_SESSION[$defaultKey]);
        }
    }
}
