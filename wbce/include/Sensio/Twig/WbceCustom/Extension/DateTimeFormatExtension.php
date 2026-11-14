<?php
/**
 * DateTimeFormatExtension
 *
 * Localized dates in Twig, through DateTimeFormat (framework/DateTimeFormat.php):
 *
 *   {{ post.posted_when|datetime }}                       DATE_FORMAT
 *   {{ post.posted_when|datetime('long+time') }}          1. August 2026 um 18:00
 *   {{ post.posted_when|datetime('@blog.teaser') }}       named format
 *   {{ post.posted_when|datetime('relative', 30) }}       <time>, "vor 5 Minuten"
 *   {{ event.start|datetime_range(event.end, 'long') }}   1.–3. August 2026
 *
 * The spec is the same string as in PHP and LayoutParser; see the class
 * comment of DateTimeFormat. Twig's own |date stays as it is.
 *
 * The output is marked safe: it is either date text from the CLDR tables or
 * the <time> element of 'relative', whose text DateTimeFormat escapes.
 *
 * Registration in TwigLoader.php:
 *   $oTwig->addExtension(new \Twig\WbceCustom\Extension\DateTimeFormatExtension());
 *
 * @copyright WBCE Project (2015-)
 * @license   GNU GPL2 (or any later version)
 */

namespace Twig\WbceCustom\Extension;

use DateTimeFormat;
use DateTimeInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DateTimeFormatExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('datetime', [$this, 'datetime'], ['is_safe' => ['html']]),
            new TwigFilter('datetime_range', [$this, 'range'], ['is_safe' => ['html']]),
        ];
    }

    /** $maxDays only counts for 'relative' (default 7). */
    public function datetime(mixed $value, ?string $spec = null, ?int $maxDays = null): string
    {
        $value = self::value($value);
        $spec  = DateTimeFormat::resolve($spec);
        if ($spec === 'relative' || str_starts_with($spec, 'relative:')) {
            return DateTimeFormat::relative($value, substr($spec, 9) ?: 'datetime', $maxDays ?? 7);
        }
        return DateTimeFormat::format($value, $spec);
    }

    public function range(mixed $start, mixed $end, ?string $spec = null): string
    {
        return DateTimeFormat::range(self::value($start), self::value($end), $spec);
    }

    /** Template data is loosely typed: a float timestamp counts, anything else is empty. */
    private static function value(mixed $v): int|string|DateTimeInterface|null
    {
        return match (true) {
            is_int($v), is_string($v), $v instanceof DateTimeInterface => $v,
            is_float($v) => (int) $v,
            default      => null,
        };
    }
}
