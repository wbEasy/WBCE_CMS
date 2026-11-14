<?php
/**
 * DateTimeFormat — localized date and time output, ranges, time zones, pickers
 * ────────────────────────────────────────────────────────────────────────────
 *
 * One place for everything WBCE shows or reads as a date:
 *
 *   DateTimeFormat::format($ts);                     // DATE_FORMAT, names localized
 *   DateTimeFormat::format($ts, 'long+time');        // 1. August 2026 um 18:00
 *   DateTimeFormat::range($start, $end, 'long');     // 1.–3. August 2026
 *   DateTimeFormat::toUser($ts)?->format('Y-m-d');   // replaces date(…, $ts + TIMEZONE)
 *   DateTimeFormat::fromInput($_POST['start']);      // ISO from a picker → timestamp
 *
 * Names, patterns and interval patterns come from the CLDR tables in
 * languages/DateTimeFormat/XX.php (written by dev-tools/cldr-export.php), so
 * the output is the same on every server, with or without the intl extension.
 * A language without a table uses the English one.
 *
 * Format spec — a string that works the same in PHP, Twig and LayoutParser:
 *
 *   null, '', 'date'               DATE_FORMAT
 *   'time'                         TIME_FORMAT
 *   'datetime'                     DATE_FORMAT + joiner + TIME_FORMAT
 *   'short' … 'full'               CLDR date style of the language
 *   'short+time' … 'full+time'     style + CLDR joiner + TIME_FORMAT
 *   'iso', 'iso-local', 'w3c',     machine formats, independent of language
 *   'rfc2822', 'http'
 *   'relative', 'relative:<spec>'  <time> element, made relative in the browser
 *   '@name'                        named format (define() / override())
 *   anything else                  PHP date() pattern, names localized
 *
 * Input values:
 *   int or digit string    Unix timestamp (UTC) → shown in the user's zone
 *   8 digits forming a date  YYYYMMDD, wall date ("20261109")
 *   string without zone    wall time (DB DATETIME) → shown as it is
 *   string with zone       that instant → shown in the user's zone
 *   DateTimeInterface      keeps its own zone
 *   null, 0, '', '0000-…'  empty → ''
 *
 * @copyright WBCE Project (2015-)
 * @license   GNU GPL2 (or any later version)
 */

declare(strict_types=1);

final class DateTimeFormat
{
    /** WBCE code => [ICU locale, flatpickr l10n key]. */
    private const LANGUAGES = [
        'BG' => ['bg', 'bg'], 'CA' => ['ca', 'cat'],     'CS' => ['cs', 'cs'], 'DA' => ['da', 'da'],
        'DE' => ['de', 'de'], 'EN' => ['en', 'default'], 'ES' => ['es', 'es'], 'ET' => ['et', 'et'],
        'FI' => ['fi', 'fi'], 'FR' => ['fr', 'fr'],      'GR' => ['el', 'gr'], 'HR' => ['hr', 'hr'],
        'HU' => ['hu', 'hu'], 'IT' => ['it', 'it'],      'LV' => ['lv', 'lv'], 'NL' => ['nl', 'nl'],
        'NO' => ['nb', 'no'], 'PL' => ['pl', 'pl'],      'PT' => ['pt', 'pt'], 'RU' => ['ru', 'ru'],
        'SK' => ['sk', 'sk'], 'SV' => ['sv', 'sv'],      'TR' => ['tr', 'tr'],
    ];

    /** The choices of the settings pages (admin/interface/date_formats.php, time_formats.php). */
    public const DATE_FORMATS = [
        'l, jS F, Y', 'jS F, Y', 'd M Y', 'M d Y', 'D M d, Y',
        'd-m-Y', 'm-d-Y', 'd.m.Y', 'm.d.Y', 'd/m/Y', 'm/d/Y', 'j.n.Y',
    ];
    public const TIME_FORMATS = ['g:i A', 'g:i a', 'H:i:s', 'H:i'];

    private const STYLES = ['short', 'medium', 'long', 'full'];

    /** PHP date() letters that are format characters (everything else is literal). */
    private const PHP_TOKENS = 'dDjlNSwzWFmMntLoXxYyaABgGhHisuveIOPpTZcrU';

    /** PHP → ICU; null = no ICU equivalent (kept as quoted literal). */
    private const PHP_TO_ICU = [
        'd' => 'dd', 'j' => 'd', 'D' => 'EEE', 'l' => 'EEEE', 'N' => 'e', 'w' => 'e',
        'W' => 'w', 'F' => 'MMMM', 'M' => 'MMM', 'm' => 'MM', 'n' => 'M',
        'Y' => 'y', 'y' => 'yy', 'o' => 'Y', 'a' => 'a', 'A' => 'a',
        'g' => 'h', 'h' => 'hh', 'G' => 'H', 'H' => 'HH', 'i' => 'mm', 's' => 'ss',
        'v' => 'SSS', 'e' => 'VV', 'O' => 'xx', 'P' => 'xxx', 'p' => 'XXX', 'T' => 'z',
    ];

    /**
     * PHP → flatpickr. The letters differ where it hurts: PHP h (12 h, two
     * digits) is flatpickr G, PHP s (two digits) is flatpickr S.
     */
    private const PHP_TO_PICKER = [
        'd' => 'd', 'j' => 'j', 'D' => 'D', 'l' => 'l', 'N' => 'w', 'w' => 'w', 'W' => 'W',
        'F' => 'F', 'M' => 'M', 'm' => 'm', 'n' => 'n', 'Y' => 'Y', 'y' => 'y',
        'a' => 'K', 'A' => 'K', 'g' => 'h', 'h' => 'G', 'G' => 'H', 'H' => 'H',
        'i' => 'i', 's' => 'S', 'U' => 'U',
    ];
    private const PICKER_TOKENS = 'dDlljJwWFmnMUyYZHhGiSsK';

    private static ?array $context = null;
    private static ?int   $now     = null;
    private static array  $tables  = [];
    private static array  $defined = [];
    private static array  $overridden = [];

    // ── Output ──────────────────────────────────────────────────────────────

    /**
     * Format a point in time by a format spec (see the class comment).
     * Returns '' for empty values.
     */
    public static function format(int|string|DateTimeInterface|null $when, ?string $spec = null): string
    {
        $dt = self::toDateTime($when);
        if ($dt === null) {
            return '';
        }
        $spec = self::resolve($spec);

        if ($spec === 'relative' || str_starts_with($spec, 'relative:')) {
            return self::relative($dt, substr($spec, 9) ?: 'datetime');
        }
        switch ($spec) {
            case 'date':      return self::formatPhp($dt, self::context('date_format'));
            case 'time':      return self::formatPhp($dt, self::context('time_format'));
            case 'datetime':  return self::formatPhp($dt, self::context('date_format'))
                                   . self::joiner('medium')
                                   . self::formatPhp($dt, self::context('time_format'));
            case 'iso':       return $dt->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d\TH:i:s\Z');
            case 'iso-local': return $dt->format(DATE_ATOM);
            case 'w3c':       return $dt->setTimezone(new DateTimeZone('UTC'))->format(DATE_W3C);
            case 'rfc2822':   return $dt->setTimezone(new DateTimeZone('UTC'))->format(DATE_RFC2822);
            case 'http':      return $dt->setTimezone(new DateTimeZone('UTC'))->format('D, d M Y H:i:s \G\M\T');
        }
        [$style, $withTime] = self::parseStyle($spec);
        if ($style !== null) {
            $out = self::formatIcu($dt, self::table()['date'][$style]);
            return $withTime ? $out . self::joiner($style) . self::formatPhp($dt, self::context('time_format')) : $out;
        }
        return self::formatPhp($dt, $spec);
    }

    /** format($when, 'date') */
    public static function date(int|string|DateTimeInterface|null $when): string
    {
        return self::format($when, 'date');
    }

    /** format($when, 'time') */
    public static function time(int|string|DateTimeInterface|null $when): string
    {
        return self::format($when, 'time');
    }

    /** format($when, 'datetime') */
    public static function dateTime(int|string|DateTimeInterface|null $when): string
    {
        return self::format($when, 'datetime');
    }

    /**
     * A period, written the way the language writes it: "1.–3. August 2026",
     * "July 30 – August 3, 2026", "1. August 2026, 18:00–20:00 Uhr".
     *
     * Only the styles (short … full, +time) have interval patterns. Every
     * other spec, a style the language has no fitting pattern for, and a
     * '+time' period across days are written as two full values joined by
     * the language's fallback ("{0} – {1}"). Equal values are written once.
     * The time part follows CLDR; TIME_FORMAT only decides 12 or 24 hours.
     */
    public static function range(
        int|string|DateTimeInterface|null $start,
        int|string|DateTimeInterface|null $end,
        ?string $spec = null
    ): string {
        $a = self::toDateTime($start);
        $b = self::toDateTime($end);
        if ($a === null || $b === null) {
            return $a === null ? '' : self::format($a, $spec);
        }
        $spec = self::resolve($spec);
        [$style, $withTime] = self::parseStyle($spec);
        $table = self::table();

        if ($style !== null) {
            $diff = self::largestDiff($a, $b, ['Y' => 'y', 'm' => 'M', 'd' => 'd']);
            if (!$withTime) {
                if ($diff === null) {
                    return self::format($a, $style);
                }
                $parts = $table['interval'][$style][$diff] ?? null;
                if ($parts !== null) {
                    return self::formatIcu($a, $parts[0]) . self::formatIcu($b, $parts[1]);
                }
            } elseif ($diff === null) {
                return self::formatIcu($a, $table['date'][$style]) . self::joiner($style) . self::timeRange($a, $b);
            }
        }
        $first  = self::format($a, $spec);
        $second = self::format($b, $spec);
        return $first === $second ? $first : self::joinFallback($first, $second);
    }

    /**
     * A <time> element that relative.js turns into "vor 5 Minuten" in the
     * browser and keeps current. Without JavaScript the absolute date in
     * $fallback stays. Only for HTML — not for attributes, mails or feeds.
     */
    public static function relative(int|string|DateTimeInterface|null $when, string $fallback = 'datetime', int $maxDays = 7): string
    {
        $dt = self::toDateTime($when);
        if ($dt === null) {
            return '';
        }
        self::enqueueRelative();
        return sprintf(
            '<time datetime="%s" data-relative data-max-days="%d">%s</time>',
            self::format($dt, 'iso'),
            $maxDays,
            htmlspecialchars(self::format($dt, $fallback), ENT_QUOTES, 'UTF-8')
        );
    }

    // ── Named formats ───────────────────────────────────────────────────────

    /** A module's default for a named format: define('blog.teaser', 'j. M Y'). */
    public static function define(string $name, string $spec): void
    {
        self::$defined[$name] = $spec;
    }

    /**
     * Replace a named format, typically from a template. Wins over define()
     * whichever runs first — modules often define() only in view.php, after
     * the template has started.
     */
    public static function override(string $name, string $spec): void
    {
        self::$overridden[$name] = $spec;
    }

    /**
     * A spec with its name resolved: '@blog.teaser' → 'j. M Y', null/'' →
     * 'date'. An unknown name, or a name pointing to another name, gives
     * 'date' (and a notice in debug mode).
     */
    public static function resolve(?string $spec): string
    {
        $spec = trim((string) $spec);
        if ($spec === '') {
            return 'date';
        }
        if ($spec[0] !== '@') {
            return $spec;
        }
        $name  = substr($spec, 1);
        $value = trim(self::$overridden[$name] ?? self::$defined[$name] ?? '');
        if ($value === '' || $value[0] === '@') {
            if (defined('WBCE_DEBUG') && WBCE_DEBUG) {
                trigger_error("DateTimeFormat: format '@$name' is " . ($value === '' ? 'not defined' : 'a reference to another name'), E_USER_NOTICE);
            }
            return 'date';
        }
        return $value;
    }

    // ── Clock and calendar days (user's zone) ───────────────────────────────

    /** "Now" in the user's zone — or the moment set by setNow(). */
    public static function now(): DateTimeImmutable
    {
        $tz = self::userTimezone();
        return self::$now === null
            ? new DateTimeImmutable('now', $tz)
            : (new DateTimeImmutable('@' . self::$now))->setTimezone($tz);
    }

    /**
     * Pretend it is $when from now on (tests, "show the page as of 1 Dec");
     * null returns to the real clock. Only affects code using this class.
     */
    public static function setNow(int|string|DateTimeInterface|null $when): void
    {
        self::$now = null;
        self::$now = $when === null ? null : self::toDateTime($when)?->getTimestamp();
    }

    /** True if $when falls on today's date in the user's zone. */
    public static function isToday(int|string|DateTimeInterface $when): bool
    {
        return self::isSameDay($when, self::now());
    }

    /** True if both fall on the same date in the user's zone. */
    public static function isSameDay(int|string|DateTimeInterface $a, int|string|DateTimeInterface $b): bool
    {
        $x = self::toUser($a);
        $y = self::toUser($b);
        return $x !== null && $y !== null && $x->format('Y-m-d') === $y->format('Y-m-d');
    }

    /** Timestamp of 00:00:00 on that day in the user's zone (correct on DST days). */
    public static function startOfDay(int|string|DateTimeInterface $when): ?int
    {
        return self::toUser($when)?->setTime(0, 0, 0)->getTimestamp();
    }

    /** Timestamp of 23:59:59 on that day in the user's zone. */
    public static function endOfDay(int|string|DateTimeInterface $when): ?int
    {
        return self::toUser($when)?->setTime(23, 59, 59)->getTimestamp();
    }

    // ── Time zone ───────────────────────────────────────────────────────────

    /**
     * The user's zone. Reads an IANA name (TIMEZONE_NAME, "Europe/Berlin")
     * and the old offset in seconds (TIMEZONE, 3600) alike, so values that
     * older modules still write as seconds keep working.
     */
    public static function userTimezone(): DateTimeZone
    {
        return self::zone(self::context('timezone'));
    }

    /**
     * The value as a DateTimeImmutable in the user's zone, null if empty.
     * Replaces `$ts + TIMEZONE`: toUser($ts)?->format('Y-m-d H:i').
     */
    public static function toUser(int|string|DateTimeInterface|null $when): ?DateTimeImmutable
    {
        return self::toDateTime($when)?->setTimezone(self::userTimezone());
    }

    /**
     * ISO input from a form ("2026-08-01", "2026-08-01 18:00",
     * "2026-08-01T18:00:30"), read as the user's wall time → Unix timestamp.
     * Replaces `$ts - TIMEZONE`. Anything else gives null.
     */
    public static function fromInput(string $iso): ?int
    {
        $iso = trim($iso);
        if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})(?:[ T](\d{2}):(\d{2})(?::(\d{2}))?)?$/', $iso, $m)
            || !checkdate((int) $m[2], (int) $m[3], (int) $m[1])) {
            return null;
        }
        $dt = (new DateTimeImmutable('now', self::userTimezone()))
            ->setDate((int) $m[1], (int) $m[2], (int) $m[3])
            ->setTime((int) ($m[4] ?? 0), (int) ($m[5] ?? 0), (int) ($m[6] ?? 0));
        return $dt->getTimestamp();
    }

    /**
     * A zone for an old offset in seconds, with exactly that offset: whole
     * hours → Etc/GMT∓h (IANA flips the sign: Etc/GMT-1 is UTC+1), half
     * hours → a city without DST that has it. 0 → UTC. What upgrade and
     * Login use for values stored before zones were names.
     */
    public static function zoneFromOffset(int $seconds): string
    {
        if ($seconds % 3600 !== 0) {
            return match ($seconds) {
                -12600 => 'America/St_Johns',
                12600  => 'Asia/Tehran',
                16200  => 'Asia/Kabul',
                19800  => 'Asia/Kolkata',
                23400  => 'Asia/Yangon',
                34200  => 'Australia/Darwin',
                default => self::zoneFromOffset(intdiv($seconds, 3600) * 3600),
            };
        }
        $hours = intdiv($seconds, 3600);
        if ($hours === 0 || $hours < -12 || $hours > 14) {
            return 'UTC';
        }
        return 'Etc/GMT' . ($hours > 0 ? '-' : '+') . abs($hours);
    }

    /**
     * Every zone once, flat: [name => "Wien, Österreich (UTC+01:00)"] — the
     * suggestions first, then the continents (timezoneGroups()). For
     * validating a posted value and for selects without groups. The offset
     * is the one at $at (default: now), summer or winter time as it is today.
     *
     * PHP's list has no Etc/GMT… zones; a value the upgrade wrote is passed
     * in $keep so it stays selectable — among the suggestions, where the
     * person sees it and can replace it.
     */
    public static function timezoneChoices(array $keep = [], ?int $at = null): array
    {
        $out = [];
        foreach (self::timezoneGroups($keep, null, $at) as $group) {
            foreach ($group['zones'] as $zone => $entry) {
                $out[$zone] ??= $entry['label'];
            }
        }
        return $out;
    }

    /**
     * The zone choice in groups, for a select with <optgroup>:
     *
     *   [['key' => 'suggested', 'label' => 'Vorschläge',
     *     'zones' => ['Europe/Berlin' => ['label' => 'Berlin, Deutschland (UTC+01:00)',
     *                                     'keywords' => 'Deutschland Germany']]],
     *    ['key' => 'europe', 'label' => 'Europa', 'zones' => ['Europe/Amsterdam' => …]], …]
     *
     * - Suggestions first: $keep (the current values — an Etc zone from the
     *   upgrade too), the main zones of the language's countries, UTC.
     * - Then the continents. The ID's prefix decides (Europe/…, Asia/…), so
     *   Istanbul is in Europe and Vladivostok in Asia. IANA has only
     *   America/… for the whole double continent, and Atlantic/…, Indian/…,
     *   Pacific/… are oceans: those go by their country's UN M.49 region —
     *   North America (with Mexico), Central America, Caribbean, South
     *   America; Azores → Europe, Honolulu → North America.
     * - City names and group headings in the language (CLDR: "Wien",
     *   "Südamerika"), sorted by city; the country name (and the English one)
     *   as search keywords.
     * - Suggested zones appear in their continent as well.
     */
    public static function timezoneGroups(array $keep = [], ?string $language = null, ?int $at = null): array
    {
        $at        = $at ?? time();
        $t         = self::table($language);
        $countries = $t['countries'] ?? [];
        $english   = self::table('EN')['countries'] ?? [];
        $offset    = fn(string $zone): string => '(UTC'
            . (new DateTimeImmutable('@' . $at))->setTimezone(new DateTimeZone($zone))->format('P') . ')';
        $entry     = function (string $zone, bool $withCountry) use ($t, $countries, $english, $offset): array {
            if ($zone === 'UTC' || self::isFixedOffsetZone($zone)) {
                return ['label' => $zone === 'UTC' ? 'UTC' : $zone . ' ' . $offset($zone), 'keywords' => ''];
            }
            $city    = $t['zone_names'][$zone] ?? str_replace('_', ' ', substr($zone, strrpos($zone, '/') + 1));
            $cc      = (new DateTimeZone($zone))->getLocation()['country_code'] ?? '??';
            $country = $countries[$cc] ?? '';
            $label   = ($withCountry && $country !== '' && $country !== $city) ? "$city, $country" : $city;
            return [
                'label'    => $label . ' ' . $offset($zone),
                'keywords' => trim($country . ' ' . (($english[$cc] ?? '') !== $country ? ($english[$cc] ?? '') : '')),
            ];
        };

        $suggested = [];
        foreach (array_merge($keep, $t['zone_suggest'] ?? [], ['UTC']) as $zone) {
            if (is_string($zone) && $zone !== '' && !isset($suggested[$zone]) && self::isZone($zone)) {
                $suggested[$zone] = $entry($zone, true);
            }
        }
        $groups = [['key' => 'suggested', 'label' => $t['zone_suggested'] ?? 'Suggestions', 'zones' => $suggested]];

        $byGroup = [];
        foreach (DateTimeZone::listIdentifiers() as $zone) {
            if ($zone !== 'UTC') {
                $byGroup[self::zoneGroup($zone)][$zone] = $entry($zone, false);
            }
        }
        $fold = static fn(string $s): string => strtr(mb_strtolower($s), [
            'ä' => 'a', 'á' => 'a', 'à' => 'a', 'â' => 'a', 'å' => 'a', 'ã' => 'a', 'æ' => 'ae', 'ç' => 'c', 'č' => 'c',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ñ' => 'n', 'ó' => 'o',
            'ò' => 'o', 'ô' => 'o', 'ö' => 'o', 'ø' => 'o', 'õ' => 'o', 'ß' => 'ss', 'š' => 's', 'ú' => 'u', 'ù' => 'u',
            'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ž' => 'z', 'ł' => 'l', 'ő' => 'o', 'ű' => 'u', 'ğ' => 'g', 'ş' => 's', 'ı' => 'i',
        ]);
        $names = $t['zone_groups'] ?? [];
        foreach (array_unique(array_merge(array_keys($names), array_keys($byGroup))) as $key) {
            if (empty($byGroup[$key])) {
                continue;
            }
            uasort($byGroup[$key], fn($a, $b) => strcmp($fold($a['label']), $fold($b['label'])));
            $groups[] = ['key' => $key, 'label' => $names[$key] ?? ucfirst(str_replace('_', ' ', $key)), 'zones' => $byGroup[$key]];
        }
        return $groups;
    }

    /**
     * Groups as rows for a select: value, label, keywords, selected, and
     * group_start (the heading, when a group with a heading starts) /
     * group_end (true on a group's last row) for the <optgroup> tags. A
     * group with an empty label (e.g. a leading "system default" row) gets
     * no <optgroup>. Only the first row of the selected value is marked.
     *
     * @return list<array{value: string, label: string, keywords: string, selected: bool, group_start?: string, group_end?: bool}>
     */
    public static function timezoneRows(array $groups, string $selected): array
    {
        $rows = [];
        $done = false;
        foreach ($groups as $group) {
            $first = true;
            $count = count($group['zones']);
            $i     = 0;
            foreach ($group['zones'] as $zone => $entry) {
                $i++;
                $row = [
                    'value'    => (string) $zone,
                    'label'    => $entry['label'],
                    'keywords' => $entry['keywords'] ?? '',
                    'selected' => !$done && (string) $zone === $selected,
                ];
                $done = $done || $row['selected'];
                if (($group['label'] ?? '') !== '') {
                    if ($first) {
                        $row['group_start'] = $group['label'];
                    }
                    if ($i === $count) {
                        $row['group_end'] = true;
                    }
                }
                $first  = false;
                $rows[] = $row;
            }
        }
        return $rows;
    }

    /** The continent group of a zone (see timezoneGroups()). */
    private static function zoneGroup(string $zone): string
    {
        $byPrefix = ['Europe' => 'europe', 'Asia' => 'asia', 'Africa' => 'africa', 'Australia' => 'oceania',
                     'Antarctica' => 'antarctica', 'Arctic' => 'europe'];
        $prefix = strstr($zone, '/', true) ?: $zone;
        if (isset($byPrefix[$prefix])) {
            return $byPrefix[$prefix];
        }
        static $regions = null;
        $regions ??= self::dataFile('regions') ?? [];
        $cc = (new DateTimeZone($zone))->getLocation()['country_code'] ?? '??';
        return $regions[$cc] ?? 'other';
    }

    /**
     * A user's stored zone (users.timezone) as forms and Login use it:
     * '' = system default (also '0', which meant that before 1.7.0); an old
     * offset in seconds → the zone with that offset; anything unknown → ''.
     */
    public static function storedZone(string $stored): string
    {
        $stored = trim($stored);
        if (preg_match('/^-?\d+$/', $stored)) {
            return (int) $stored === 0 ? '' : self::zoneFromOffset((int) $stored);
        }
        return self::isZone($stored) ? $stored : '';
    }

    /** True for a fixed-offset Etc zone (no DST) — what the upgrade writes for old values. */
    public static function isFixedOffsetZone(string $name): bool
    {
        return str_starts_with($name, 'Etc/');
    }

    /** True for a name PHP knows as a zone ('Europe/Berlin', 'UTC', 'Etc/GMT-1'). */
    public static function isZone(string $name): bool
    {
        static $known = null;
        $known ??= array_flip(DateTimeZone::listIdentifiers(DateTimeZone::ALL_WITH_BC));
        return isset($known[$name]);
    }

    /**
     * Offset of a zone in seconds at a moment (default: now) — what the
     * TIMEZONE constant holds once the setting stores a zone name.
     */
    public static function offsetSeconds(DateTimeZone|string|int $zone, ?int $at = null): int
    {
        $tz = $zone instanceof DateTimeZone ? $zone : self::zone($zone);
        return (new DateTimeImmutable('@' . ($at ?? self::now()->getTimestamp())))->setTimezone($tz)->getOffset();
    }

    // ── Translation and language ────────────────────────────────────────────

    /**
     * PHP date() pattern → ICU pattern, for pickers and libraries that speak
     * ICU: 'l, jS F, Y' → 'EEEE, d. MMMM, y' in German. S becomes the
     * ordinal dot where the language has one and is dropped otherwise (ICU
     * has no ordinal token). A pattern that is a single name gives the
     * stand-alone form (LLLL, cccc). PHP letters without an ICU field
     * (t, L, U …) stay as quoted text.
     */
    public static function toIcu(string $phpFormat, ?string $language = null): string
    {
        $tokens     = self::tokenizePhp($phpFormat);
        $standalone = self::isStandalone($tokens);
        $dot        = self::table($language)['ordinal_dot'] && self::code($language) !== 'EN';
        $out     = '';
        $literal = '';
        $flush   = function () use (&$out, &$literal): void {
            if ($literal !== '') {
                $out     .= preg_replace('/[a-zA-Z]+/', "'$0'", str_replace("'", "''", $literal));
                $literal  = '';
            }
        };
        foreach ($tokens as [$isToken, $c]) {
            if ($isToken && $c === 'S') {
                $literal .= $dot ? '.' : '';
            } elseif ($isToken && isset(self::PHP_TO_ICU[$c])) {
                $flush();
                $icu  = self::PHP_TO_ICU[$c];
                $out .= $standalone ? strtr($icu, ['M' => 'L', 'E' => 'c']) : $icu;
            } else {
                $literal .= $c;
            }
        }
        $flush();
        return $out;
    }

    /** PHP date() pattern → flatpickr tokens ('g:i A' → 'h:i K', 'jS F' → 'J F'). */
    public static function toPicker(string $phpFormat): string
    {
        $tokens = self::tokenizePhp($phpFormat);
        $out    = '';
        foreach ($tokens as $i => [$isToken, $c]) {
            if ($isToken && $c === 'j' && ($tokens[$i + 1] ?? null) === [true, 'S']) {
                $out .= 'J';
            } elseif ($isToken && $c === 'S') {
                continue;
            } elseif ($isToken && isset(self::PHP_TO_PICKER[$c])) {
                $out .= self::PHP_TO_PICKER[$c];
            } else {
                $out .= str_contains(self::PICKER_TOKENS, $c) || $c === '\\' ? '\\' . $c : $c;
            }
        }
        return $out;
    }

    /** WBCE language code → ICU locale ('GR' → 'el', 'NO' → 'nb'). */
    public static function icuLocale(?string $language = null): string
    {
        $code = self::code($language);
        return self::LANGUAGES[$code][0] ?? strtolower($code);
    }

    /** WBCE language code → flatpickr.l10ns key ('CA' → 'cat', 'EN' → 'default'). */
    public static function pickerLocale(?string $language = null): string
    {
        return self::LANGUAGES[self::code($language)][1] ?? 'default';
    }

    /**
     * Month names 1..12. $style 'long' | 'short'. The stand-alone form is the
     * one for a name on its own (calendar heading: RU "сентябрь"); false
     * gives the form used inside a date ("1 сентября").
     */
    public static function monthNames(string $style = 'long', ?string $language = null, bool $standalone = true): array
    {
        $months = self::table($language)['months'][$standalone ? 'standalone' : 'format'];
        return $months[$style] ?? $months['long'];
    }

    /** Weekday names 1..7, ISO order (1 = Monday). $style 'long' | 'short' | 'narrow'. */
    public static function weekdayNames(string $style = 'long', ?string $language = null, bool $standalone = true): array
    {
        $days = self::table($language)['weekdays'][$standalone ? 'standalone' : 'format'];
        return $days[$style] ?? $days['long'];
    }

    /** First day of the week, ISO (1 = Monday … 7 = Sunday). */
    public static function firstWeekday(?string $language = null): int
    {
        return (int) self::table($language)['first_weekday'];
    }

    // ── Picker and choice lists ─────────────────────────────────────────────

    /**
     * flatpickr options for json_encode(): the field submits ISO (dateFormat),
     * the user sees a compact date in the page language (altInput): the
     * language's numeric short date with a four-digit year — DE 17.04.2026,
     * EN 4/17/2026 — plus TIME_FORMAT. A narrow input field cannot show
     * "Donnerstag, 17th April, 2026". $userFormat = true shows DATE_FORMAT
     * instead (names included) where the field is wide enough.
     */
    public static function pickerConfig(bool $withTime = false, array $overrides = [], bool $userFormat = false): array
    {
        $time = self::context('time_format');
        $date = $userFormat ? self::context('date_format') : self::numericDateFormat();
        $alt  = $date . ($withTime ? ' ' . $time : '');
        return array_replace([
            'dateFormat' => $withTime ? 'Y-m-d H:i:S' : 'Y-m-d',
            'altInput'   => true,
            'altFormat'  => self::toPicker($alt),
            'allowInput' => false,
            'enableTime' => $withTime,
            'time_24hr'  => !self::is12Hour($time),
            'locale'     => self::pickerLocale(),
        ], $overrides);
    }

    /**
     * The language's numeric date as a PHP date() pattern, from its CLDR
     * short style with the year always four digits: DE 'd.m.Y' (17.04.2026),
     * EN 'n/j/Y' (4/17/2026), FR 'd/m/Y', HU 'Y. m. d.', SV 'Y-m-d'. Usable
     * with format() and — through toPicker() — in flatpickr.
     */
    public static function numericDateFormat(?string $language = null): string
    {
        $pattern = self::table($language)['date']['short'] ?? 'y-MM-dd';
        preg_match_all("/'((?:[^']|'')*)'|([a-zA-Z])\\2*|[^a-zA-Z']+/u", $pattern, $m, PREG_SET_ORDER);
        $out = '';
        foreach ($m as $tok) {
            if (($tok[2] ?? '') === '') {
                $text = $tok[0][0] === "'" ? ($tok[0] === "''" ? "'" : str_replace("''", "'", $tok[1])) : $tok[0];
                $out .= preg_replace('/[a-zA-Z]/', '\\\\$0', $text);   // literal letters stay literal
                continue;
            }
            $n    = strlen($tok[0]);
            $out .= match ($tok[2]) {
                'd'      => $n === 1 ? 'j' : 'd',
                'M', 'L' => $n === 1 ? 'n' : 'm',
                'y'      => 'Y',
                default  => '',
            };
        }
        return trim($out);
    }

    /** Load flatpickr, its locales and wbeRange once through the AssetQueue. */
    public static function enqueuePicker(): void
    {
        $base = WB_URL . '/include/date_time_picker/';
        I::insertCssFile($base . 'flatpickr.wbeRange.min.css', 'HEAD TOP+');
        I::insertJsFile([
            $base . 'flatpickr.min.js',
            $base . 'flatpickr.locales.js',
            $base . 'flatpickr.wbeRange.js',
        ], 'BODY TOP+');
    }

    /**
     * [format => example] for the date choice, in the user's language. Formats
     * without names get the order as a hint: "01.08.2026 (D.M.Y)".
     */
    public static function dateFormatChoices(): array
    {
        $now = self::now();
        $out = [];
        foreach (self::DATE_FORMATS as $fmt) {
            $example = self::formatPhp($now, $fmt);
            $out[$fmt] = preg_match('/[DlFMS]/', $fmt) ? $example : $example . ' (' . strtr($fmt, ['d' => 'D', 'm' => 'M']) . ')';
        }
        return $out;
    }

    /** [format => example] for the time choice. */
    public static function timeFormatChoices(): array
    {
        $now = self::now();
        $out = [];
        foreach (self::TIME_FORMATS as $fmt) {
            $out[$fmt] = self::formatPhp($now, $fmt);
        }
        return $out;
    }

    // ── For tests ───────────────────────────────────────────────────────────

    /**
     * Replace the request's settings: ['language' => 'DE', 'date_format' =>
     * 'd.m.Y', 'time_format' => 'H:i', 'timezone' => 'Europe/Berlin'].
     * Keys left out keep the constant's value; null returns to the constants.
     */
    public static function setContext(?array $context): void
    {
        self::$context = $context;
    }

    // ── Internals ───────────────────────────────────────────────────────────

    private static function context(string $key): string|int
    {
        if (isset(self::$context[$key])) {
            return self::$context[$key];
        }
        return match ($key) {
            'language'    => defined('LANGUAGE') ? LANGUAGE : 'EN',
            'date_format' => defined('DATE_FORMAT') ? DATE_FORMAT : 'Y-m-d',
            'time_format' => defined('TIME_FORMAT') ? TIME_FORMAT : 'H:i',
            'timezone'    => defined('TIMEZONE_NAME') && TIMEZONE_NAME !== '' ? TIMEZONE_NAME
                             : (defined('TIMEZONE') ? (int) TIMEZONE : 0),
        };
    }

    private static function code(?string $language): string
    {
        return strtoupper($language ?? (string) self::context('language'));
    }

    /** The CLDR table of a language; English for a language without one. */
    private static function table(?string $language = null): array
    {
        $code = self::code($language);
        if (!isset(self::$tables[$code])) {
            $data = preg_match('/^[A-Z]{2}$/', $code) ? self::dataFile($code) : null;
            self::$tables[$code] = $data ?? ($code === 'EN' ? [] : self::table('EN'));
        }
        return self::$tables[$code];
    }

    /**
     * A file of languages/DateTimeFormat/ (they guard themselves with
     * WB_PATH, so without it — the installer before config.php — nothing is
     * read rather than everything ending in exit).
     */
    private static function dataFile(string $name): ?array
    {
        if (!defined('WB_PATH')) {
            return null;
        }
        $file = dirname(__DIR__) . '/languages/DateTimeFormat/' . $name . '.php';
        return is_file($file) ? include $file : null;
    }

    /** IANA name or offset in seconds → zone; anything unusable → UTC. */
    private static function zone(string|int $value): DateTimeZone
    {
        if (is_int($value) || preg_match('/^[+-]?\d+$/', $value)) {
            $sec = (int) $value;
            return new DateTimeZone(sprintf('%s%02d:%02d', $sec < 0 ? '-' : '+', intdiv(abs($sec), 3600), intdiv(abs($sec) % 3600, 60)));
        }
        try {
            return new DateTimeZone($value);
        } catch (Exception) {
            return new DateTimeZone('UTC');
        }
    }

    /** Any accepted input → DateTimeImmutable, null for empty or unreadable values. */
    private static function toDateTime(int|string|DateTimeInterface|null $when): ?DateTimeImmutable
    {
        if ($when instanceof DateTimeInterface) {
            return DateTimeImmutable::createFromInterface($when);
        }
        if ($when === null) {
            return null;
        }
        $isString = is_string($when);
        $when     = trim((string) $when);
        // A string of eight digits that form a date is YYYYMMDD, as
        // LayoutParser's |date reads it; the timestamps it would otherwise be
        // (April 1970 to March 1973) do not occur in WBCE data. An int stays
        // a timestamp.
        if ($isString && preg_match('/^(\d{4})(\d{2})(\d{2})$/', $when, $m) && checkdate((int) $m[2], (int) $m[3], (int) $m[1])) {
            return new DateTimeImmutable("$m[1]-$m[2]-$m[3]", self::userTimezone());
        }
        if (preg_match('/^-?\d+$/', $when)) {
            return (int) $when === 0 ? null : (new DateTimeImmutable('@' . $when))->setTimezone(self::userTimezone());
        }
        if ($when === '' || str_starts_with($when, '0000-00-00')) {
            return null;
        }
        if (strtolower($when) === 'now') {
            return self::now();
        }
        $tz = self::userTimezone();
        try {
            $dt = new DateTimeImmutable($when, $tz);
        } catch (Exception) {
            return null;
        }
        // With a zone in the string it is an instant: show it in the user's zone.
        return !empty(date_parse($when)['is_localtime']) ? $dt->setTimezone($tz) : $dt;
    }

    /** ['long', true] for 'long+time', [null, false] for anything that is no style. */
    private static function parseStyle(string $spec): array
    {
        $withTime = str_ends_with($spec, '+time');
        $style    = $withTime ? substr($spec, 0, -5) : $spec;
        return in_array($style, self::STYLES, true) ? [$style, $withTime] : [null, false];
    }

    private static function joiner(string $style): string
    {
        $joiner = self::table()['joiner'][$style] ?? null;
        return $joiner === null ? ', ' : self::formatIcu(new DateTimeImmutable('@0'), $joiner);
    }

    private static function joinFallback(string $first, string $second): string
    {
        return strtr(self::table()['interval']['fallback'] ?? '{0} – {1}', ['{0}' => $first, '{1}' => $second]);
    }

    /** The largest field (by PHP letter) in which a and b differ, mapped to its key; null if none. */
    private static function largestDiff(DateTimeImmutable $a, DateTimeImmutable $b, array $fields): ?string
    {
        foreach ($fields as $php => $key) {
            if ($a->format($php) !== $b->format($php)) {
                return $key;
            }
        }
        return null;
    }

    /** Time part of a same-day range, CLDR pattern; 12/24 hours from TIME_FORMAT. */
    private static function timeRange(DateTimeImmutable $a, DateTimeImmutable $b): string
    {
        $timeFormat = self::context('time_format');
        if (self::is12Hour($timeFormat)) {
            $set  = 'hm';
            $diff = self::largestDiff($a, $b, ['A' => 'a', 'g' => 'h', 'i' => 'm']);
        } else {
            $set  = 'Hm';
            $diff = self::largestDiff($a, $b, ['G' => 'H', 'i' => 'm']);
        }
        if ($diff === null) {
            return self::formatPhp($a, $timeFormat);
        }
        $parts = self::table()['interval'][$set][$diff] ?? null;
        return $parts === null
            ? self::joinFallback(self::formatPhp($a, $timeFormat), self::formatPhp($b, $timeFormat))
            : self::formatIcu($a, $parts[0]) . self::formatIcu($b, $parts[1]);
    }

    private static function is12Hour(string $phpFormat): bool
    {
        foreach (self::tokenizePhp($phpFormat) as [$isToken, $c]) {
            if ($isToken && ($c === 'g' || $c === 'h')) {
                return true;
            }
        }
        return false;
    }

    /** @return list<array{0: bool, 1: string}> [is format character, character] */
    private static function tokenizePhp(string $format): array
    {
        $tokens = [];
        $chars  = mb_str_split($format);
        for ($i = 0, $n = count($chars); $i < $n; $i++) {
            if ($chars[$i] === '\\' && $i + 1 < $n) {
                $tokens[] = [false, $chars[++$i]];
            } else {
                $tokens[] = [strlen($chars[$i]) === 1 && str_contains(self::PHP_TOKENS, $chars[$i]), $chars[$i]];
            }
        }
        return $tokens;
    }

    /** A pattern that is one month or weekday name alone takes the stand-alone form. */
    private static function isStandalone(array $tokens): bool
    {
        $fields = array_filter($tokens, fn($t) => $t[0]);
        return count($fields) === 1 && str_contains('FMlD', reset($fields)[1]);
    }

    /** PHP date() pattern with names from the CLDR table. */
    private static function formatPhp(DateTimeImmutable $dt, string $format): string
    {
        $t          = self::table();
        $tokens     = self::tokenizePhp($format);
        $ctx        = self::isStandalone($tokens) ? 'standalone' : 'format';
        $english    = self::code(null) === 'EN' || !isset(self::LANGUAGES[self::code(null)]);
        $out = '';
        foreach ($tokens as [$isToken, $c]) {
            if (!$isToken) {
                $out .= $c;
                continue;
            }
            $out .= match ($c) {
                'D'     => $t['weekdays'][$ctx]['short'][(int) $dt->format('N')],
                'l'     => $t['weekdays'][$ctx]['long'][(int) $dt->format('N')],
                'F'     => $t['months'][$ctx]['long'][(int) $dt->format('n')],
                'M'     => $t['months'][$ctx]['short'][(int) $dt->format('n')],
                'A'     => $t['ampm'][(int) ($dt->format('G') >= 12)],
                'a'     => mb_strtolower($t['ampm'][(int) ($dt->format('G') >= 12)]),
                'S'     => $english ? $dt->format('S') : ($t['ordinal_dot'] ? '.' : ''),
                default => $dt->format($c),
            };
        }
        return $out;
    }

    /**
     * ICU pattern from the CLDR table. Only the subset the tables use:
     * y M L d E c e a h H m s and literals ('…', '' and every non-ASCII-letter).
     */
    private static function formatIcu(DateTimeImmutable $dt, string $pattern): string
    {
        $t = self::table();
        preg_match_all("/'((?:[^']|'')*)'|([a-zA-Z])\\2*|[^a-zA-Z']+/u", $pattern, $m, PREG_SET_ORDER);
        $out = '';
        foreach ($m as $tok) {
            if (($tok[2] ?? '') === '') {
                $out .= isset($tok[1]) && $tok[0][0] === "'" ? ($tok[0] === "''" ? "'" : str_replace("''", "'", $tok[1])) : $tok[0];
                continue;
            }
            $n = strlen($tok[0]);
            $out .= match ($tok[2]) {
                'y'      => $n === 2 ? $dt->format('y') : $dt->format('Y'),
                'M', 'L' => match (true) {
                    $n === 1 => $dt->format('n'),
                    $n === 2 => $dt->format('m'),
                    default  => $t['months'][$tok[2] === 'L' ? 'standalone' : 'format'][$n === 3 ? 'short' : 'long'][(int) $dt->format('n')],
                },
                'd'      => $n === 1 ? $dt->format('j') : $dt->format('d'),
                'E', 'c', 'e' => match (true) {
                    $tok[2] !== 'E' && $n <= 2 => $dt->format('N'),
                    default => $t['weekdays'][$tok[2] === 'c' ? 'standalone' : 'format'][$n <= 3 ? 'short' : ($n === 4 ? 'long' : 'narrow')][(int) $dt->format('N')],
                },
                'a'      => $t['ampm'][(int) ($dt->format('G') >= 12)],
                'h'      => $n === 1 ? $dt->format('g') : $dt->format('h'),
                'H'      => $n === 1 ? $dt->format('G') : $dt->format('H'),
                'm'      => $n === 1 ? (string) (int) $dt->format('i') : $dt->format('i'),
                's'      => $n === 1 ? (string) (int) $dt->format('s') : $dt->format('s'),
                default  => $tok[0],
            };
        }
        return $out;
    }

    /** relative.js and its per-page settings, once. Does nothing until the script exists. */
    private static function enqueueRelative(): void
    {
        static $done = false;
        if ($done || !defined('WB_PATH') || !is_file(WB_PATH . '/include/DateTimeFormat/relative.js') || !class_exists('I')) {
            return;
        }
        $done = true;
        I::insertJsCode('window.WBCE_RELATIVE_TIME = ' . json_encode([
            'locale'  => self::icuLocale(),
            'justNow' => self::table()['just_now'] ?? 'just now',
        ], JSON_UNESCAPED_UNICODE) . ';', 'body_late', 'DateTimeFormat-relative-config');
        I::insertJsFile(WB_URL . '/include/DateTimeFormat/relative.js', 'body_late', ['defer' => true], 'DateTimeFormat-relative');
    }
}
