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
 * The settings page's logic: what a user sees, what a POST may change,
 * and writing it. The registry (settings_registry.php) says WHAT exists;
 * this class says how it is shown, checked and stored.
 *
 * Every rule that used to be a special case in save.php is a property of
 * a field here, so the form and the save cannot drift apart: a field the
 * user is not shown is a field the user cannot save.
 *
 * @since 1.7.0
 */
final class SettingsForm
{
    public const LEVEL_BASIC      = 0;
    public const LEVEL_ADVANCED   = 1;
    public const LEVEL_SUPERADMIN = 2;

    private const LEVELS = [
        'basic'      => self::LEVEL_BASIC,
        'advanced'   => self::LEVEL_ADVANCED,
        'superadmin' => self::LEVEL_SUPERADMIN,
    ];

    private const BOOL_VALUES = ['true', 'false'];

    /** Characters that would break out of the HTML attributes these
     *  values are echoed into unescaped (WEBSITE_DESCRIPTION in <meta>). */
    private const PLAIN_STRIP = ['"', '<', '>', '\\'];

    /** @var array<string, array<string, string>> options() cache */
    private array $optionCache = [];

    /** wbSeoTool's config (seo_cfg); false = not looked up yet,
     *  null = module not installed */
    private array|null|false $seo = false;

    /**
     * @param array  $registry  The array settings_registry.php returns
     * @param object $admin     The Admin instance (tests pass a stand-in
     *                          with the same methods)
     */
    public function __construct(
        private readonly array $registry,
        private readonly object $admin,
    ) {
    }

    // ── Who may see what ────────────────────────────────────────────────────

    /** The user's level: basic, advanced (settings_advanced) or superadmin
     *  (settings_advanced and user_id 1). */
    public function userLevel(): int
    {
        if (!$this->admin->get_permission('settings_advanced')) {
            return self::LEVEL_BASIC;
        }
        return ((int) $this->admin->get_user_id() === 1) ? self::LEVEL_SUPERADMIN : self::LEVEL_ADVANCED;
    }

    /** Whether this user may see — and therefore save — a field. */
    public function isVisible(array $def): bool
    {
        $level = self::LEVELS[$def['level'] ?? ''] ?? null;
        if ($level === null) {
            throw new LogicException("Settings registry: unknown level '" . ($def['level'] ?? '') . "'");
        }
        if ($level > $this->userLevel()) {
            return false;
        }
        return !isset($def['guard']) || $this->guard($def['guard']);
    }

    /** Named extra conditions the registry can attach to a field. */
    public function guard(string $name): bool
    {
        return match ($name) {
            // the visibility is offered only to whoever may open the tool
            // that holds the rest of the search configuration
            'search_tool' => is_file(WB_PATH . '/modules/wbce_search/tool.php')
                             && $this->admin->hasToolPermission('wbce_search'),
            // wbSeoTool can switch the keywords meta field off; without
            // the module the field is always there
            'seo_keywords' => ($seo = $this->seoConfig()) === null || !empty($seo['keywordsConfig']['use']),
            default       => throw new LogicException("Settings registry: unknown guard '{$name}'"),
        };
    }

    /**
     * wbSeoTool's settings (stored as JSON in {TP}settings 'seo_cfg'), or
     * null when the module is not installed. The settings page follows
     * them, so both screens judge titles and descriptions alike.
     */
    public function seoConfig(): ?array
    {
        if ($this->seo === false) {
            $installed = (int) $GLOBALS['database']->fetchValue(
                "SELECT COUNT(*) FROM `{TP}addons` WHERE `type` = 'module' AND `directory` = ?",
                ['wbSeoTool']
            ) > 0;
            $cfg       = $installed ? json_decode((string) Settings::get('seo_cfg', ''), true) : null;
            $this->seo = is_array($cfg) ? $cfg : null;
        }
        return $this->seo;
    }

    /** Use this seo_cfg instead of looking it up (null = module absent). */
    public function useSeoConfig(?array $cfg): self
    {
        $this->seo = $cfg;
        return $this;
    }

    /**
     * The character counter for a field with 'counter' => <seo_cfg key>:
     * min/optimum/max and whether to show the remaining characters; null
     * when the module is absent or the counter is switched off there.
     *
     * @return array{min: int, optimum: int, max: int, remaining: bool}|null
     */
    private function counterFor(string $key): ?array
    {
        $seo = $this->seoConfig();
        $cfg = $seo[$key] ?? null;
        if (!is_array($cfg) || empty($cfg['use'])) {
            return null;
        }
        return [
            'min'       => (int) ($cfg['minimum'] ?? 0),
            'optimum'   => (int) ($cfg['optimum'] ?? 0),
            'max'       => (int) ($cfg['maximum'] ?? 0),
            'remaining' => !empty($seo['bUseRemainingChars']),
        ];
    }

    /** The keywords field's label: wbSeoTool's own name for it, when it
     *  gives one other than "keywords". Labels are printed raw (core
     *  language strings carry entities like &#8217;), so this one — typed
     *  into the tool, stored in the database — is escaped here. */
    private function keywordsLabel(string $default): string
    {
        $word = trim((string) ($this->seoConfig()['keywordsConfig']['wordReplace'] ?? ''));
        return ($word !== '' && strcasecmp($word, 'keywords') !== 0)
            ? htmlspecialchars($word, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
            : $default;
    }

    // ── Rendering ───────────────────────────────────────────────────────────

    /**
     * The registry reduced to what this user may see, every field enriched
     * with its current 'value', 'options' (select/radio/timezone) and the
     * level flag 'advanced' (true for anything above basic). Sections left
     * without fields are dropped.
     *
     * @return array<string, array>
     */
    public function view(): array
    {
        $view = [];
        foreach ($this->registry as $sectionKey => $section) {
            $fields = [];
            foreach ($section['fields'] as $name => $def) {
                if (!$this->isVisible($def)) {
                    continue;
                }
                $def['value']    = $this->currentValue($name, $def);
                $def['advanced'] = self::LEVELS[$def['level']] > self::LEVEL_BASIC;
                if (isset($def['counter'])) {
                    $def['counter'] = $this->counterFor($def['counter']);
                    if ($def['counter'] === null) {
                        unset($def['counter']);
                    }
                }
                if (!empty($def['seo_label'])) {
                    $def['label'] = $this->keywordsLabel(L_($def['label']));
                }
                // the hint under the field: $HINT['SETTINGS_<NAME>'] in the
                // language files. Lang::has() first — L_() would make a text
                // up from the key name where there is none.
                $hintKey = 'SETTINGS_' . strtoupper($name);
                if (Lang::has('HINT', $hintKey)) {
                    $def['hint'] = Lang::get('HINT', $hintKey);
                }
                if (isset($def['options'])) {
                    $def['options'] = $this->options($name);
                    $def['choices'] = $this->choices($def);
                    // wbeSelect's base style hides the badge of the selected
                    // item; cfg-lang is the variant that shows it (Access
                    // uses it for the group id the same way)
                    if (!empty($def['badge'])) {
                        $def['widget'] ??= ['customSelector' => 'cfg-lang'];
                    }
                }
                if ($def['type'] === 'bool') {
                    $def['values'] ??= self::BOOL_VALUES;
                }
                if ($def['type'] === 'filemode') {
                    // the checked boxes of the r/w/e × u/g/o grid
                    $def['bits'] = [];
                    foreach (['u', 'g', 'o'] as $who) {
                        foreach (['r', 'w', 'e'] as $perm) {
                            if (self::modeHas($def['value'], $who, $perm)) {
                                $def['bits'][] = "{$who}_{$perm}";
                            }
                        }
                    }
                }
                if ($def['type'] === 'password') {
                    // never echoed into the page; the form only learns
                    // whether one is stored
                    $def['is_set'] = $def['value'] !== '';
                    $def['value']  = '';
                }
                $fields[$name] = $def;
            }
            if ($fields !== []) {
                $view[$sectionKey] = ['fields' => $fields] + $section;
            }
        }
        return $view;
    }

    /**
     * The options as wbeSelect renders them: value, label, and — per the
     * registry's 'badge' / 'icon' — a right-hand badge (data-right) and a
     * left-hand image (data-left). "Off" values ('', 'false', 'none') get
     * no badge: a badge saying "false" explains nothing.
     *
     * @param  array $def  Field definition with 'options' already resolved
     * @return list<array{value: string, label: string, right?: string, left?: string}>
     */
    private function choices(array $def): array
    {
        $choices = [];
        foreach ($def['options'] as $value => $label) {
            $value  = (string) $value;
            $choice = ['value' => $value, 'label' => $label];
            if (!empty($def['badge']) && !in_array($value, ['', 'false', 'none'], true)) {
                $choice['right'] = $value;
            }
            $icon = match ($def['icon'] ?? null) {
                'visibility' => WB_URL . '/include/wbeSelect/icons/' . rawurlencode($value) . '.svg',
                'flag'       => WB_URL . '/languages/' . rawurlencode($value) . '.svg',
                default      => null,
            };
            if ($icon !== null) {
                $choice['left'] = $icon;
            }
            $choices[] = $choice;
        }
        return $choices;
    }

    /** The stored value as the form uses it (string; timezone in hours). */
    public function currentValue(string $name, array $def): string
    {
        $value = Settings::get($name, '');
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }
        $value = (string) $value;

        if ($def['type'] === 'timezone') {
            return (string) intdiv((int) $value, 3600);
        }
        return $value;
    }

    /**
     * [value => label] for a field, labels translated. A stored value the
     * source no longer lists (an uninstalled template, …) is kept as an
     * entry, so opening and saving the page never changes it silently.
     *
     * @return array<string, string>
     */
    public function options(string $field): array
    {
        if (isset($this->optionCache[$field])) {
            return $this->optionCache[$field];
        }
        $def    = $this->field($field);
        $source = $def['options'] ?? null;

        if (is_array($source)) {
            $options = array_map(static fn ($label): string => L_((string) $label), $source);
        } elseif (is_string($source)) {
            $options = $this->optionSource($source);
        } else {
            throw new LogicException("Settings registry: field '{$field}' has no options");
        }
        $options = array_combine(array_map('strval', array_keys($options)), array_values($options));

        $current = $this->currentValue($field, $def);
        if ($current !== '' && !array_key_exists($current, $options)) {
            $options[$current] = $current;
        }
        return $this->optionCache[$field] = $options;
    }

    /** @return array<string|int, string> */
    private function optionSource(string $source): array
    {
        global $TEXT;   // er_levels.php reads it in this scope

        switch ($source) {
            case 'languages':
                return $this->addons("`type` = 'language'");
            case 'templates':
                return $this->addons("`type` = 'template' AND `function` != 'theme'");
            case 'themes':
                return $this->addons("`type` = 'template' AND `function` = 'theme'");
            case 'editors':
                return ['none' => L_('TEXT:NONE')]
                     + $this->addons("`type` = 'module' AND `function` LIKE '%wysiwyg%'");
            case 'page_levels':
                $levels = range(1, 10);
                return array_combine($levels, array_map('strval', $levels));
            case 'signup_groups':
                $groups = ['false' => L_('TEXT:DISABLED')];
                foreach ((new GroupManager())->getGroupsSimpleList() as $group) {
                    $groups[(string) $group['id']] = $group['name'];
                }
                return $groups;
        }

        // admin/interface/* fill a variable in the including scope; the
        // $user_time they look at stays unset here — this is the system
        // default, not a user preference
        switch ($source) {
            case 'timezones':
                include ADMIN_PATH . '/interface/timezones.php';
                return $TIMEZONES;
            case 'charsets':
                include ADMIN_PATH . '/interface/charsets.php';
                return $CHARSETS;
            case 'er_levels':
                include ADMIN_PATH . '/interface/er_levels.php';
                return $ER_LEVELS;
            case 'date_formats':
                include ADMIN_PATH . '/interface/date_formats.php';
                return $this->formatList($DATE_FORMATS);
            case 'time_formats':
                include ADMIN_PATH . '/interface/time_formats.php';
                return $this->formatList($TIME_FORMATS);
        }
        throw new LogicException("Settings registry: unknown option source '{$source}'");
    }

    /** @return array<string, string> directory => name */
    private function addons(string $where): array
    {
        $rows = $GLOBALS['database']->fetchAll(
            "SELECT `directory`, `name` FROM `{TP}addons` WHERE {$where} ORDER BY `name`"
        );
        return array_column($rows ?: [], 'name', 'directory');
    }

    /** Date/time format keys use '|' for spaces (array keys). */
    private function formatList(array $formats): array
    {
        $list = [];
        foreach ($formats as $key => $label) {
            if ($key !== 'system_default') {
                $list[str_replace('|', ' ', (string) $key)] = $label;
            }
        }
        return $list;
    }

    private function field(string $name): array
    {
        foreach ($this->registry as $section) {
            if (isset($section['fields'][$name])) {
                return $section['fields'][$name];
            }
        }
        throw new LogicException("Settings registry: unknown field '{$name}'");
    }

    // ── Saving ──────────────────────────────────────────────────────────────

    /**
     * Check and normalise a POST. Only fields this user may see are looked
     * at; a field missing from the POST is left as it is (the form posts a
     * hidden "off" value before every switch and checkbox group, so
     * "unchecked" still arrives).
     *
     * @return array{values: array<string, string>, errors: array<string, string>}
     */
    public function validate(array $post): array
    {
        $values = [];
        $errors = [];

        foreach ($this->registry as $section) {
            foreach ($section['fields'] as $name => $def) {
                if (!$this->isVisible($def) || !array_key_exists($name, $post)) {
                    continue;
                }
                $result = $this->normalize($name, $def, $post[$name]);
                if ($result === null) {
                    continue;   // e.g. an empty password: keep the stored one
                }
                [$value, $error] = $result;
                if ($error !== null) {
                    $errors[$name] = $error;
                } else {
                    $values[$name] = $value;
                }
            }
        }

        $this->validateSmtp($values, $errors);

        return ['values' => $values, 'errors' => $errors];
    }

    /**
     * One field: [value, null] or [null, error message]; null = skip.
     *
     * @return array{0: ?string, 1: ?string}|null
     */
    public function normalize(string $name, array $def, mixed $raw): ?array
    {
        if ($def['type'] === 'filemode') {
            return [self::buildOctalMode(is_array($raw) ? $raw : []), null];
        }
        if (!is_string($raw)) {
            return [null, L_('MESSAGE:SETTINGS_INVALID_VALUE')];
        }

        switch ($def['type']) {
            case 'bool':
                $values = $def['values'] ?? self::BOOL_VALUES;
                return in_array($raw, $values, true)
                    ? [$raw, null]
                    : [null, L_('MESSAGE:SETTINGS_INVALID_VALUE')];

            case 'password':
                // not trimmed: whitespace may be part of a password
                return ($raw === '') ? null : [$raw, null];

            case 'number':
                $raw = trim($raw);
                if ($raw === '') {
                    // e.g. no SMTP port: PHPMailer's default applies
                    return empty($def['required'])
                        ? ['', null]
                        : [null, L_('MESSAGE:SETTINGS_REQUIRED_FIELD')];
                }
                if (!preg_match('/^-?\d+$/', $raw)) {
                    return [null, L_('MESSAGE:SETTINGS_INVALID_VALUE')];
                }
                $int = (int) $raw;
                $int = max($def['min'] ?? PHP_INT_MIN, min($def['max'] ?? PHP_INT_MAX, $int));
                return [(string) $int, null];

            case 'select':
            case 'radio':
            case 'timezone':
                if (!array_key_exists($raw, $this->options($name))) {
                    return [null, L_('MESSAGE:SETTINGS_INVALID_VALUE')];
                }
                if ($name === 'frontend_signup' && !$this->isValidSignupGroup($raw)) {
                    return [null, L_('MESSAGE:GENERIC_SECURITY_ACCESS')];
                }
                return ($def['type'] === 'timezone')
                    ? [(string) ((int) $raw * 3600), null]
                    : [$raw, null];

            case 'html':
                return [trim($raw), null];

            case 'text':
            case 'textarea':
                $value = self::cleanPlain($raw);
                if ($value === '') {
                    return empty($def['required'])
                        ? ['', null]
                        : [null, L_('MESSAGE:SETTINGS_REQUIRED_FIELD')];
                }
                if (isset($def['pattern']) && !preg_match($def['pattern'], $value)) {
                    return [null, L_($def['error'] ?? 'MESSAGE:SETTINGS_INVALID_VALUE')];
                }
                if ($name === 'server_email' && !$this->admin->validate_email($value)) {
                    return [null, L_('MESSAGE:USERS_INVALID_EMAIL')];
                }
                return [$value, null];
        }
        throw new LogicException("Settings registry: unknown type '{$def['type']}' for '{$name}'");
    }

    /**
     * SMTP needs a host, and with authentication a user name and password.
     * Checked against what the POST changes, falling back to what is stored.
     */
    private function validateSmtp(array $values, array &$errors): void
    {
        $effective = function (string $name) use ($values): string {
            return $values[$name] ?? (string) Settings::get($name, '');
        };
        if ($effective('wbmailer_routine') !== 'smtp') {
            return;
        }
        $required = ['wbmailer_smtp_host'];
        if ($effective('wbmailer_smtp_auth') === '1') {
            $required[] = 'wbmailer_smtp_username';
            $required[] = 'wbmailer_smtp_password';
        }
        foreach ($required as $name) {
            if (!isset($errors[$name]) && $effective($name) === '') {
                $errors[$name] = L_('MESSAGE:SETTINGS_REQUIRED_FIELD');
            }
        }
    }

    /** Never the administrators group; a non-admin only a group within his
     *  own rights (GroupManager::isValidSignupGroup()). Without a real Admin
     *  to check against, nothing but "off" is accepted. */
    private function isValidSignupGroup(string $value): bool
    {
        if (!$this->admin instanceof Admin) {
            return $value === 'false';
        }
        return (new GroupManager())->isValidSignupGroup($value, $this->admin);
    }

    /**
     * Write the values in one transaction; afterwards move pages/intro.php
     * out of reach when the intro page was switched off (and back in when
     * it was switched on), and refresh the developer snapshot.
     *
     * @param  array<string, string> $values  From validate()
     * @return string|null  error message, null on success
     */
    public function save(array $values): ?string
    {
        global $database;

        try {
            $database->transaction(function () use ($values): void {
                foreach ($values as $name => $value) {
                    $error = Settings::set($name, $value);
                    if ($error !== false) {
                        throw new RuntimeException((string) $error);
                    }
                }
            });
        } catch (Throwable $e) {
            return $e->getMessage();
        }

        if (isset($values['intro_page'])) {
            self::moveIntroPage($values['intro_page'] === 'true');
        }
        Settings::refreshSnapshot();

        return null;
    }

    // ── Helpers (static: no state, directly testable) ───────────────────────

    /** strip_tags, the attribute-breaking characters, surrounding space. */
    public static function cleanPlain(string $value): string
    {
        return trim(str_replace(self::PLAIN_STRIP, '', strip_tags($value)));
    }

    /**
     * Octal mode string ('0644') from checkbox values 'u_r', 'g_w', 'o_e' …
     *
     * @param array<mixed> $bits
     */
    public static function buildOctalMode(array $bits): string
    {
        $weight = ['r' => 4, 'w' => 2, 'e' => 1];
        $mode   = '0';
        foreach (['u', 'g', 'o'] as $who) {
            $digit = 0;
            foreach ($weight as $perm => $value) {
                if (in_array("{$who}_{$perm}", $bits, true)) {
                    $digit += $value;
                }
            }
            $mode .= $digit;
        }
        return $mode;
    }

    /** Whether the checkbox for $who/$perm is set in an octal mode string. */
    public static function modeHas(string $mode, string $who, string $perm): bool
    {
        $digit = (int) (str_pad($mode, 4, '0', STR_PAD_LEFT)[['u' => 1, 'g' => 2, 'o' => 3][$who]] ?? 0);
        return (bool) ($digit & ['r' => 4, 'w' => 2, 'e' => 1][$perm]);
    }

    /** intro.php ↔ intro.backup.php, so a disabled intro page is not
     *  reachable from search engine results anymore. */
    private static function moveIntroPage(bool $enabled): void
    {
        $dir     = WB_PATH . PAGES_DIRECTORY;
        $active  = $dir . '/intro' . PAGE_EXTENSION;
        $backup  = $dir . '/intro.backup' . PAGE_EXTENSION;
        [$from, $to] = $enabled ? [$backup, $active] : [$active, $backup];
        if (file_exists($from) && !file_exists($to)) {
            rename($from, $to);
        }
    }
}
