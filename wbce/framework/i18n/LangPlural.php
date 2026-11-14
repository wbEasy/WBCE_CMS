<?php
/**
 * Internationalization — LangPlural
 *
 * CLDR plural category resolver for Lang::getPlural(), Ln_() and the
 * LayoutParser filter |plural. Determines the plural form (zero, one, two,
 * few, many, other) for a given locale and number, and picks it from a
 * language file's plural array.
 *
 * @file      framework/i18n/LangPlural.php
 * @package   Framework i18n
 * @author    Christian M. Stefan  (https://www.wbEasy.de)
 * @copyright 2025-2026 Christian M. Stefan
 * @copyright 2026 WBCE CMS Project
 * @license   GNU/GPL v2 https://www.gnu.org/licenses/gpl-2.0.html
 *
 * -----------------------------------------------------------------------------
 *
 * Rules: Unicode CLDR 42 (the data of ICU 72), cardinal plurals —
 * https://www.unicode.org/cldr/charts/42/supplemental/language_plural_rules.html
 * tests/Framework/LangPluralTest.php compares every language here with ICU.
 *
 * CLDR rules work on the operands of the number as written:
 *   n  absolute value          i  integer digits
 *   v  number of visible fraction digits
 *   f  visible fraction digits as a number      t  f without trailing zeros
 * A PHP float carries no trailing zeros, so 1.0 counts as 1 (v = 0) — the
 * caller meant one. 1.5 is v = 1, f = 5.
 *
 * Language file plural arrays use the category names as keys:
 *
 *   // EN
 *   $TEXT['GROUP_COUNT'] = [
 *       'zero'  => 'No groups',          // optional, WBCE: used for n = 0
 *       'one'   => '%d group',
 *       'other' => '%d groups',
 *   ];
 *
 *   // PL
 *   $TEXT['GROUP_COUNT'] = [
 *       'one'   => '%d grupa',
 *       'few'   => '%d grupy',           // 2–4, 22–24, …
 *       'many'  => '%d grup',            // 0, 5–21, 25–31, …
 *       'other' => '%d grupy',           // fractions (1,5 grupy)
 *   ];
 *
 * Which keys a language needs: one per category its rule returns. 'many' is
 * an integer form only in PL, RU, UK, BE, AR, GA; in CS, SK and LT it is the
 * form for fractions, in ES, FR, IT, CA, PT for exact millions (1 000 000) —
 * where it is missing, select() falls back to 'other'.
 */
class LangPlural
{
    /**
     * WBCE language codes that are not the ISO 639 code. Lang passes the
     * WBCE code ('GR'); the rules are keyed by ISO ('el').
     */
    private const ALIASES = ['gr' => 'el'];

    /**
     * Return the CLDR plural category for locale + number.
     *
     * @param  string    $locale  'DE', 'de_AT', 'pl_PL', 'GR' (WBCE code) …
     * @param  int|float $n       The number to categorise (absolute value used)
     * @return string             'zero'|'one'|'two'|'few'|'many'|'other'
     */
    public static function category(string $locale, int|float $n): string
    {
        $lang = strtolower(explode('_', str_replace('-', '_', $locale))[0]);
        $lang = self::ALIASES[$lang] ?? $lang;
        $o    = self::operands($n);

        return match ($lang) {
            // ── one: i = 1 and v = 0 ─────────────────────────────────────────
            'en', 'de', 'nl', 'sv', 'fi', 'et', 'ur', 'sw', 'fy', 'gl', 'ia', 'io' => self::oneIV($o),

            // ── one: n = 1 ───────────────────────────────────────────────────
            'el', 'hu', 'tr', 'bg', 'nb', 'no', 'nn', 'az', 'ka', 'sq', 'eu', 'lb',
            'mn', 'ne', 'ta', 'te', 'uz', 'kk', 'ky', 'ps', 'om', 'mr' => $o['n'] == 1 ? 'one' : 'other',

            // ── + many for exact millions (CLDR 38+) ────────────────────────
            'es'       => $o['n'] == 1 ? 'one' : self::million($o),
            'it', 'ca' => self::oneIV($o) === 'one' ? 'one' : self::million($o),
            'pt', 'fr' => ($o['i'] === 0 || $o['i'] === 1) ? 'one' : self::million($o),
            'ff', 'kab', 'hy' => ($o['i'] === 0 || $o['i'] === 1) ? 'one' : 'other',

            // ── Danish: n = 1 or t != 0 and i = 0,1 ──────────────────────────
            'da' => ($o['n'] == 1 || ($o['t'] !== 0 && ($o['i'] === 0 || $o['i'] === 1))) ? 'one' : 'other',

            // ── Persian, Hindi: i = 0 or n = 1 ───────────────────────────────
            'fa', 'hi', 'bn', 'gu', 'kn', 'zu', 'am' =>($o['i'] === 0 || $o['n'] == 1) ? 'one' : 'other',

            'ro'             => self::romanian($o),
            'hr', 'bs', 'sr' => self::southSlavic($o),
            'pl'             => self::polish($o),
            'ru', 'uk'       => self::eastSlavic($o),
            'be'             => self::belarusian($o),
            'cs', 'sk'       => self::czech($o),
            'sl'             => self::slovenian($o),
            'lt'             => self::lithuanian($o),
            'lv'             => self::latvian($o),
            'ar'             => self::arabic($o),
            'he', 'iw'       => self::hebrew($o),
            'ga'             => self::irish($o),
            'gd'             => self::scottishGaelic($o),
            'mk'             => self::macedonian($o),
            'is'             => self::icelandic($o),

            // ── no plural forms ──────────────────────────────────────────────
            'ja', 'zh', 'ko', 'vi', 'th', 'id', 'ms', 'km', 'lo', 'my', 'jv' => 'other',

            // ── Default: one for exactly 1 ───────────────────────────────────
            default => self::oneIV($o),
        };
    }

    /**
     * Pick the form for $n from a language file's plural array (not yet
     * sprintf'd). The one rule for Lang::getPlural(), Ln_() and the
     * LayoutParser filter |plural:
     *
     *   1. n = 0 and a 'zero' key → that one (WBCE: "No files" instead of
     *      "0 files", in any language)
     *   2. the CLDR category for the locale
     *   3. missing → 'other' → 'many' → 'one' → the first form
     *
     * @param array<string, string> $forms  keys in lower case
     */
    public static function select(array $forms, string $locale, int|float $n): string
    {
        if ($n == 0 && isset($forms['zero'])) {
            return (string) $forms['zero'];
        }
        $category = self::category($locale, $n);
        return (string) ($forms[$category] ?? $forms['other'] ?? $forms['many'] ?? $forms['one'] ?? reset($forms));
    }

    /** Kept for callers that reset state between tests; nothing is cached any more. */
    public static function resetCache(): void
    {
    }

    // ── Operands ──────────────────────────────────────────────────────────────

    /**
     * CLDR operands of a number. A float is read with up to 6 fraction
     * digits; trailing zeros vanish (PHP floats keep none), so v = 0 for 1.0.
     *
     * @return array{n: float|int, i: int, v: int, f: int, t: int}
     */
    private static function operands(int|float $num): array
    {
        $num = abs($num);
        if (is_int($num) || floor($num) == $num) {
            $i = (int) $num;
            return ['n' => $i, 'i' => $i, 'v' => 0, 'f' => 0, 't' => 0];
        }
        $text  = rtrim(sprintf('%.6F', $num), '0');
        [$int, $frac] = explode('.', $text) + [1 => ''];
        $f = (int) $frac;
        return ['n' => $num, 'i' => (int) $int, 'v' => strlen($frac), 'f' => $f, 't' => $f];
    }

    /** True when n is an integer in [$from, $to] — CLDR "n = a..b" (n with no fraction). */
    private static function nIn(array $o, int $from, int $to): bool
    {
        return $o['v'] === 0 && $o['i'] >= $from && $o['i'] <= $to;
    }

    // ── Rule implementations (CLDR 42) ────────────────────────────────────────

    /** one: i = 1 and v = 0 */
    private static function oneIV(array $o): string
    {
        return ($o['i'] === 1 && $o['v'] === 0) ? 'one' : 'other';
    }

    /** many: e = 0 and i != 0 and i % 1000000 = 0 and v = 0 — else other */
    private static function million(array $o): string
    {
        return ($o['v'] === 0 && $o['i'] !== 0 && $o['i'] % 1000000 === 0) ? 'many' : 'other';
    }

    /**
     * Romanian
     * one:  i = 1 and v = 0
     * few:  v != 0 or n = 0 or n != 1 and n % 100 = 1..19
     */
    private static function romanian(array $o): string
    {
        if ($o['i'] === 1 && $o['v'] === 0) return 'one';
        if ($o['v'] !== 0 || $o['i'] === 0 || ($o['i'] % 100 >= 1 && $o['i'] % 100 <= 19)) return 'few';
        return 'other';
    }

    /**
     * Croatian / Bosnian / Serbian
     * one: v = 0 and i % 10 = 1 and i % 100 != 11  or  f % 10 = 1 and f % 100 != 11
     * few: v = 0 and i % 10 = 2..4 and i % 100 != 12..14  or  the same for f
     */
    private static function southSlavic(array $o): string
    {
        $i10 = $o['i'] % 10; $i100 = $o['i'] % 100;
        $f10 = $o['f'] % 10; $f100 = $o['f'] % 100;
        if (($o['v'] === 0 && $i10 === 1 && $i100 !== 11) || ($f10 === 1 && $f100 !== 11)) return 'one';
        if (($o['v'] === 0 && $i10 >= 2 && $i10 <= 4 && ($i100 < 12 || $i100 > 14))
            || ($f10 >= 2 && $f10 <= 4 && ($f100 < 12 || $f100 > 14))) return 'few';
        return 'other';
    }

    /**
     * Polish
     * one:  i = 1 and v = 0
     * few:  v = 0 and i % 10 = 2..4 and i % 100 != 12..14
     * many: v = 0 and (i != 1 and i % 10 = 0..1  or  i % 10 = 5..9  or  i % 100 = 12..14)
     * other: fractions
     */
    private static function polish(array $o): string
    {
        if ($o['v'] !== 0) return 'other';
        $i10 = $o['i'] % 10; $i100 = $o['i'] % 100;
        if ($o['i'] === 1) return 'one';
        if ($i10 >= 2 && $i10 <= 4 && ($i100 < 12 || $i100 > 14)) return 'few';
        return 'many';
    }

    /**
     * Russian, Ukrainian
     * one:  v = 0 and i % 10 = 1 and i % 100 != 11
     * few:  v = 0 and i % 10 = 2..4 and i % 100 != 12..14
     * many: v = 0 and (i % 10 = 0  or  i % 10 = 5..9  or  i % 100 = 11..14)
     * other: fractions
     */
    private static function eastSlavic(array $o): string
    {
        if ($o['v'] !== 0) return 'other';
        $i10 = $o['i'] % 10; $i100 = $o['i'] % 100;
        if ($i10 === 1 && $i100 !== 11) return 'one';
        if ($i10 >= 2 && $i10 <= 4 && ($i100 < 12 || $i100 > 14)) return 'few';
        return 'many';
    }

    /**
     * Belarusian — like Russian, but on n (a fraction with no integer form
     * of its own is 'other')
     */
    private static function belarusian(array $o): string
    {
        return $o['v'] === 0 ? self::eastSlavic($o) : 'other';
    }

    /**
     * Czech / Slovak
     * one:  i = 1 and v = 0 | few: i = 2..4 and v = 0 | many: v != 0 (fractions)
     * other: 0, 5, 6, … (integers)
     */
    private static function czech(array $o): string
    {
        if ($o['v'] !== 0) return 'many';
        if ($o['i'] === 1) return 'one';
        if ($o['i'] >= 2 && $o['i'] <= 4) return 'few';
        return 'other';
    }

    /**
     * Slovenian
     * one: v = 0 and i % 100 = 1 | two: v = 0 and i % 100 = 2
     * few: v = 0 and i % 100 = 3..4  or  v != 0
     */
    private static function slovenian(array $o): string
    {
        if ($o['v'] !== 0) return 'few';
        $i100 = $o['i'] % 100;
        if ($i100 === 1) return 'one';
        if ($i100 === 2) return 'two';
        if ($i100 === 3 || $i100 === 4) return 'few';
        return 'other';
    }

    /**
     * Lithuanian
     * one:  n % 10 = 1 and n % 100 != 11..19
     * few:  n % 10 = 2..9 and n % 100 != 11..19
     * many: f != 0 (fractions)
     * other: 0, 10–20, 30, … (integers)
     */
    private static function lithuanian(array $o): string
    {
        if ($o['f'] !== 0) return 'many';
        $i10 = $o['i'] % 10; $i100 = $o['i'] % 100;
        $teen = $i100 >= 11 && $i100 <= 19;
        if ($i10 === 1 && !$teen) return 'one';
        if ($i10 >= 2 && !$teen) return 'few';
        return 'other';
    }

    /**
     * Latvian
     * zero: n = 0
     * one:  n % 10 = 1 and n % 100 != 11
     * other: everything else
     *
     * Deliberately NOT full CLDR: CLDR's Latvian "zero" also covers 10–20,
     * 30, 40, … But WBCE language files use the 'zero' key for the
     * "nothing there" message (select() picks it at n = 0), so a CLDR-exact
     * rule would print "No results" for 10 hits. Latvian strings therefore
     * put the 10–20 form into 'other'. Fractions follow CLDR's 'one'.
     */
    private static function latvian(array $o): string
    {
        if ($o['v'] === 0 && $o['i'] === 0) return 'zero';
        $i10 = $o['i'] % 10; $i100 = $o['i'] % 100;
        if ($o['v'] === 0) {
            return ($i10 === 1 && $i100 !== 11) ? 'one' : 'other';
        }
        $f10 = $o['f'] % 10; $f100 = $o['f'] % 100;
        if (($o['v'] === 2 && $f10 === 1 && $f100 !== 11) || ($o['v'] !== 2 && $f10 === 1)) return 'one';
        return 'other';
    }

    /**
     * Arabic
     * zero: n = 0 | one: n = 1 | two: n = 2
     * few:  n % 100 = 3..10 | many: n % 100 = 11..99 | other
     */
    private static function arabic(array $o): string
    {
        if ($o['v'] !== 0) return 'other';
        $i100 = $o['i'] % 100;
        if ($o['i'] === 0) return 'zero';
        if ($o['i'] === 1) return 'one';
        if ($o['i'] === 2) return 'two';
        if ($i100 >= 3 && $i100 <= 10) return 'few';
        if ($i100 >= 11) return 'many';
        return 'other';
    }

    /**
     * Hebrew (CLDR 42 dropped 'many')
     * one: i = 1 and v = 0  or  i = 0 and v != 0 | two: i = 2 and v = 0
     */
    private static function hebrew(array $o): string
    {
        if (($o['i'] === 1 && $o['v'] === 0) || ($o['i'] === 0 && $o['v'] !== 0)) return 'one';
        if ($o['i'] === 2 && $o['v'] === 0) return 'two';
        return 'other';
    }

    /**
     * Irish
     * one: n = 1 | two: n = 2 | few: n = 3..6 | many: n = 7..10
     */
    private static function irish(array $o): string
    {
        if (self::nIn($o, 1, 1))  return 'one';
        if (self::nIn($o, 2, 2))  return 'two';
        if (self::nIn($o, 3, 6))  return 'few';
        if (self::nIn($o, 7, 10)) return 'many';
        return 'other';
    }

    /**
     * Scottish Gaelic
     * one: n = 1,11 | two: n = 2,12 | few: n = 3..10,13..19
     */
    private static function scottishGaelic(array $o): string
    {
        if (self::nIn($o, 1, 1) || self::nIn($o, 11, 11)) return 'one';
        if (self::nIn($o, 2, 2) || self::nIn($o, 12, 12)) return 'two';
        if (self::nIn($o, 3, 10) || self::nIn($o, 13, 19)) return 'few';
        return 'other';
    }

    /**
     * Macedonian
     * one: v = 0 and i % 10 = 1 and i % 100 != 11  or  f % 10 = 1 and f % 100 != 11
     */
    private static function macedonian(array $o): string
    {
        return (($o['v'] === 0 && $o['i'] % 10 === 1 && $o['i'] % 100 !== 11)
            || ($o['f'] % 10 === 1 && $o['f'] % 100 !== 11)) ? 'one' : 'other';
    }

    /**
     * Icelandic
     * one: t = 0 and i % 10 = 1 and i % 100 != 11  or  t % 10 = 1 and t % 100 != 11
     */
    private static function icelandic(array $o): string
    {
        return (($o['t'] === 0 && $o['i'] % 10 === 1 && $o['i'] % 100 !== 11)
            || ($o['t'] % 10 === 1 && $o['t'] % 100 !== 11)) ? 'one' : 'other';
    }
}
