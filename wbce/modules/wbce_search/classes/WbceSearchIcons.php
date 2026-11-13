<?php
/**
 * wbce_search — WbceSearchIcons
 *
 * Registers an `icon(name, class)` Twig function — same contract as
 * modules/WbceAnalytics/WbceAnalyticsIcons.php so both tools look alike.
 * Paths are Tabler outline icons (https://tabler.io/icons, MIT), drawn
 * inside render()'s 24×24 stroke wrapper.
 *
 * @license GNU General Public License
 */

declare(strict_types=1);

defined('WB_PATH') or die();

class WbceSearchIcons
{
    private const ICONS = [
        // Tabler "layout-dashboard"
        'overview' => '<path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1"/>'
            . '<path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1"/>'
            . '<path d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1"/>'
            . '<path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1"/>',

        // Tabler "puzzle"
        'modules' => '<path d="M4 7h3a1 1 0 0 0 1 -1v-1a2 2 0 0 1 4 0v1a1 1 0 0 0 1 1h3a1 1 0 0 1 1 1v3'
            . 'a1 1 0 0 0 1 1h1a2 2 0 0 1 0 4h-1a1 1 0 0 0 -1 1v3a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-1'
            . 'a2 2 0 0 0 -4 0v1a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1h1a2 2 0 0 0 0 -4h-1'
            . 'a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1"/>',

        // Tabler "template"
        'layout' => '<path d="M5 4h14a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1"/>'
            . '<path d="M5 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1"/>'
            . '<path d="M14 12h6"/><path d="M14 16h6"/><path d="M14 20h6"/>',

        // Tabler "adjustments"
        'settings' => '<path d="M4 10a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/><path d="M6 4v4"/><path d="M6 12v8"/>'
            . '<path d="M10 16a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/><path d="M12 4v10"/><path d="M12 18v2"/>'
            . '<path d="M16 7a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/><path d="M18 4v1"/><path d="M18 9v11"/>',

        // Tabler "chart-bar"
        'stats' => '<path d="M3 13a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"/>'
            . '<path d="M15 9a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"/>'
            . '<path d="M9 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"/>'
            . '<path d="M4 20h14"/>',

        // Tabler "search"
        'search' => '<path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"/><path d="M21 21l-6 -6"/>',

        // Tabler "history" — link back to the old single-page UI
        'legacy' => '<path d="M12 8l0 4l2 2"/><path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5"/>',
    ];

    public static function register(\Twig\Environment $twig): void
    {
        $twig->addFunction(new \Twig\TwigFunction(
            'icon',
            [self::class, 'render'],
            ['is_safe' => ['html']]
        ));
    }

    /** Unknown names render nothing — a typo must not break the nav. */
    public static function render(string $name, string $class = 'nav-icon'): string
    {
        if (!isset(self::ICONS[$name])) {
            if (defined('WB_TWIG_DEBUG') && WB_TWIG_DEBUG) {
                trigger_error("WbceSearchIcons: unknown icon '$name'", E_USER_WARNING);
            }
            return '';
        }

        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" '
             . 'fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" '
             . 'class="' . htmlspecialchars($class, ENT_QUOTES) . '" aria-hidden="true">'
             . self::ICONS[$name]
             . '</svg>';
    }
}
