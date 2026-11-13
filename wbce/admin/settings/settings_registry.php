<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

/**
 * Settings registry — what the settings page shows and accepts.
 *
 * Pure data; SettingsForm does the work. A setting the registry does not
 * list is never written from this page, whatever is posted: everything else
 * in {TP}settings has its own screen (SecureForm, captcha, output filters,
 * modules …) or none.
 *
 * Section keys: icon (Font Awesome class), heading (language key), fields.
 *
 * Field keys:
 *   level     basic | advanced | superadmin — who sees AND may save it
 *             (superadmin = settings_advanced + user_id 1)
 *   type      text | textarea | html | bool | select | radio | number |
 *             password | timezone | filemode
 *   label     language key ('TEXT:…') or plain text
 *   values    bool only: [on, off] as stored — default ['true', 'false']
 *   options   select/radio/timezone: source name (SettingsForm::options())
 *             or an inline list [value => language key]
 *   pattern   regex the cleaned value must match
 *   error     language key shown when the pattern fails
 *   min, max  number only — the value is clamped, not refused
 *   required  the value must not be empty
 *   depends   [field, value] — the row is shown only while that field has
 *             that value (display only; the value is still saved)
 *   guard     extra condition by name (SettingsForm::guard())
 *   wide      text input across the full width
 *   mono      text input / textarea in the monospace font (--font-mono)
 *
 * The hint under a field is not set here: it is $HINT['SETTINGS_<NAME>']
 * in the core language files (no entry = no hint).
 *
 * wbSeoTool (only while the module is installed; its config is the JSON
 * setting 'seo_cfg'):
 *   counter   seo_cfg key (iTitleCount, iDescriptionCount) — a character
 *             counter under the field, coloured by its minimum/optimum,
 *             shown only while that counter is switched on in the tool
 *   seo_label true — the label becomes the tool's own name for the
 *             keywords field (keywordsConfig.wordReplace), if not "keywords"
 *
 * Select presentation (wbeSelect, include/wbeSelect):
 *   badge     true — the option value as a badge on the right (data-right);
 *             an empty value or 'false'/'none' gets none
 *   icon      'visibility' (include/wbeSelect/icons/<value>.svg) |
 *             'flag' (languages/<value>.svg) — image on the left (data-left)
 *   widget    wbeSelect options, e.g. ['customSelector' => 'title_only'];
 *             a field with a badge defaults to cfg-lang (the variant that
 *             shows the badge on the selected item, too)
 *
 * @since 1.7.0
 */

return [

    'website' => [
        'icon'    => 'fa-globe',
        'heading' => 'HEADING:GENERAL_SETTINGS',
        'fields'  => [
            // counters and the keywords field follow wbSeoTool, if installed
            'website_title'       => ['level' => 'basic', 'type' => 'text',     'label' => 'TEXT:WEBSITE_TITLE',
                                      'wide' => true, 'mono' => true, 'counter' => 'iTitleCount'],
            'website_description' => ['level' => 'basic', 'type' => 'textarea', 'label' => 'TEXT:WEBSITE_DESCRIPTION',
                                      'mono' => true, 'counter' => 'iDescriptionCount'],
            'website_keywords'    => ['level' => 'basic', 'type' => 'textarea', 'label' => 'TEXT:WEBSITE_KEYWORDS',
                                      'mono' => true, 'guard' => 'seo_keywords', 'seo_label' => true],
            'website_header'      => ['level' => 'basic', 'type' => 'html',     'label' => 'TEXT:WEBSITE_HEADER'],
            'website_footer'      => ['level' => 'basic', 'type' => 'html',     'label' => 'TEXT:WEBSITE_FOOTER'],
        ],
    ],

    'pages' => [
        'icon'    => 'fa-sitemap',
        'heading' => 'MENU:PAGES',
        'fields'  => [
            // on/off only: the core knows 'inline' (deleted pages stay in
            // the tree, restorable) and 'disabled'; the old third value
            // 'separate' has no view anywhere (admin/pages/trash.php only
            // redirects), its deleted pages simply vanished from sight
            'page_trash' => [
                'level'  => 'basic',
                'type'   => 'bool',
                'label'  => 'TEXT:PAGE_TRASH',
                'values' => ['inline', 'disabled'],
            ],
            'intro_page'           => ['level' => 'basic',    'type' => 'bool',   'label' => 'TEXT:INTRO_PAGE'],
            'home_folders'         => ['level' => 'basic',    'type' => 'bool',   'label' => 'TEXT:HOME_FOLDERS'],
            'page_level_limit'     => ['level' => 'advanced', 'type' => 'select', 'label' => 'TEXT:PAGE_LEVEL_LIMIT',
                                       'options' => 'page_levels', 'widget' => ['customSelector' => 'title_only']],
            'page_languages'       => ['level' => 'advanced', 'type' => 'bool',   'label' => 'TEXT:PAGE_LANGUAGES'],
            'multiple_menus'       => ['level' => 'advanced', 'type' => 'bool',   'label' => 'TEXT:MULTIPLE_MENUS'],
            'manage_sections'      => ['level' => 'advanced', 'type' => 'bool',   'label' => 'HEADING:MANAGE_SECTIONS'],
            'section_blocks'       => ['level' => 'advanced', 'type' => 'bool',   'label' => 'TEXT:SECTION_BLOCKS'],
            'homepage_redirection' => ['level' => 'advanced', 'type' => 'bool',   'label' => 'TEXT:HOMEPAGE_REDIRECTION'],
        ],
    ],

    'frontend' => [
        'icon'    => 'fa-sign-in',
        'heading' => 'TEXT:FRONTEND',
        'fields'  => [
            'frontend_login'  => ['level' => 'basic', 'type' => 'bool', 'label' => 'TEXT:LOGIN'],
            'frontend_signup' => [
                'level'   => 'basic',
                'type'    => 'select',
                'label'   => 'TEXT:SIGNUP',
                'options' => 'signup_groups',
                'badge'   => true,   // the group id, as in Access
                'widget'  => ['customSelector' => 'cfg-lang'],
                'depends' => ['frontend_login', 'true'],
            ],
            'smart_login'     => ['level' => 'advanced', 'type' => 'bool', 'label' => 'TEXT:SMART_LOGIN'],
            // ends up in a <script> (messageBox): -1 or 0 … 10000 ms only
            'redirect_timer'  => [
                'level' => 'advanced',
                'type'  => 'number',
                'label' => 'TEXT:REDIRECT_AFTER',
                'min'   => -1,
                'max'   => 10000,
            ],
            // only the visibility — everything else about the search lives
            // in the WBCE Search admin tool
            'search' => [
                'level'   => 'basic',
                'type'    => 'select',
                'label'   => 'TEXT:SEARCH',
                'guard'   => 'search_tool',
                'icon'    => 'visibility',
                'widget'  => ['customSelector' => 'cfg-visibility'],
                'options' => [
                    'public'     => 'TEXT:PUBLIC',
                    'private'    => 'TEXT:PRIVATE',
                    'registered' => 'TEXT:REGISTERED',
                    'none'       => 'TEXT:NONE',
                ],
            ],
        ],
    ],

    'defaults' => [
        'icon'    => 'fa-sliders',
        'heading' => 'HEADING:DEFAULT_SETTINGS',
        'fields'  => [
            // as in Access → users: code badge + flag
            'default_language'    => ['level' => 'basic',    'type' => 'select',   'label' => 'TEXT:LANGUAGE',
                                      'options' => 'languages', 'badge' => true, 'icon' => 'flag',
                                      'widget' => ['customSelector' => 'cfg-lang']],
            'default_timezone'    => ['level' => 'basic',    'type' => 'timezone', 'label' => 'TEXT:TIMEZONE',
                                      'options' => 'timezones', 'widget' => ['customSelector' => 'title_only']],
            'default_date_format' => ['level' => 'basic',    'type' => 'select',   'label' => 'TEXT:DATE_FORMAT',
                                      'options' => 'date_formats', 'widget' => ['customSelector' => 'title_only']],
            'default_time_format' => ['level' => 'basic',    'type' => 'select',   'label' => 'TEXT:TIME_FORMAT',
                                      'options' => 'time_formats', 'widget' => ['customSelector' => 'title_only']],
            'default_template'    =>['level' => 'basic',    'type' => 'select',   'label' => 'TEXT:TEMPLATE',
                                      'options' => 'templates', 'widget' => ['customSelector' => 'title_only']],
            'default_theme'       => ['level' => 'basic',    'type' => 'select',   'label' => 'TEXT:THEME',
                                      'options' => 'themes', 'widget' => ['customSelector' => 'title_only']],
            'wysiwyg_editor'      => ['level' => 'advanced', 'type' => 'select',   'label' => 'TEXT:WYSIWYG_EDITOR',
                                      'options' => 'editors', 'widget' => ['customSelector' => 'title_only']],
            'default_charset'     => ['level' => 'advanced', 'type' => 'select',   'label' => 'TEXT:CHARSET',
                                      'options' => 'charsets', 'widget' => ['customSelector' => 'title_only']],
            'er_level'            => ['level' => 'advanced', 'type' => 'select',   'label' => 'TEXT:PHP_ERROR_LEVEL',
                                      'options' => 'er_levels', 'badge' => true],
        ],
    ],

    'server' => [
        'icon'    => 'fa-server',
        'heading' => 'HEADING:SERVER_SETTINGS',
        'fields'  => [
            'app_name' => [
                'level'    => 'basic',
                'type'     => 'text',
                'label'    => 'TEXT:SESSION_IDENTIFIER',
                'pattern'  => '/^[a-z0-9_-]+$/',
                'error'    => 'MESSAGE:INVALID_SESSION_NAME',
                'required' => true,
            ],
            'sec_anchor'  => ['level' => 'basic', 'type' => 'text', 'label' => 'TEXT:SEC_ANCHOR',
                              'pattern' => '/^[A-Za-z0-9_-]*$/'],
            'page_spacer' => ['level' => 'basic', 'type' => 'text', 'label' => 'TEXT:PAGE_SPACER',
                              'pattern' => '/^[A-Za-z0-9_.-]*$/'],
            // empty = pages in the web root
            'pages_directory' => ['level' => 'advanced', 'type' => 'text', 'label' => 'TEXT:PAGES_DIRECTORY',
                                  'pattern' => '#^(/[A-Za-z0-9_-]+)*$#'],
            'media_directory' => ['level' => 'advanced', 'type' => 'text', 'label' => 'TEXT:MEDIA_DIRECTORY',
                                  'pattern' => '#^(/[A-Za-z0-9_-]+)+$#', 'required' => true],
            'page_extension'  => ['level' => 'advanced', 'type' => 'text', 'label' => 'TEXT:PAGE_EXTENSION',
                                  'pattern' => '/^\.[a-z0-9]+$/', 'required' => true],
            'operating_system' => [
                'level'   => 'superadmin',
                'type'    => 'radio',
                'label'   => 'TEXT:SERVER_OPERATING_SYSTEM',
                'options' => ['linux' => 'TEXT:LINUX_UNIX_BASED', 'windows' => 'TEXT:WINDOWS'],
            ],
            // a list of extensions, entries may be regex fragments ("ph.*?")
            'rename_files_on_upload' => ['level' => 'superadmin', 'type' => 'text', 'label' => 'TEXT:RENAME_FILES_ON_UPLOAD',
                                         'pattern' => '/^[A-Za-z0-9.*?|,]*$/'],
            'string_file_mode' => ['level' => 'superadmin', 'type' => 'filemode', 'label' => 'TEXT:FILES',
                                   'depends' => ['operating_system', 'linux']],
            'string_dir_mode'  => ['level' => 'superadmin', 'type' => 'filemode', 'label' => 'TEXT:DIRECTORIES',
                                   'depends' => ['operating_system', 'linux']],
        ],
    ],

    'mailer' => [
        'icon'    => 'fa-envelope',
        'heading' => 'HEADING:WBMAILER_SETTINGS',
        'fields'  => [
            'server_email'                => ['level' => 'basic', 'type' => 'text',
                                              'label' => 'TEXT:WBMAILER_DEFAULT_SENDER_MAIL', 'required' => true],
            'wbmailer_default_sendername' => ['level' => 'basic', 'type' => 'text',
                                              'label' => 'TEXT:WBMAILER_DEFAULT_SENDER_NAME'],
            'wbmailer_routine' => [
                'level'   => 'basic',
                'type'    => 'radio',
                'label'   => 'TEXT:WBMAILER_FUNCTION',
                'options' => ['phpmail' => 'TEXT:WBMAILER_PHP', 'smtp' => 'TEXT:WBMAILER_SMTP'],
            ],
            'wbmailer_smtp_host' => ['level' => 'basic', 'type' => 'text', 'label' => 'TEXT:WBMAILER_SMTP_HOST',
                                     'depends' => ['wbmailer_routine', 'smtp']],
            'wbmailer_smtp_port' => ['level' => 'basic', 'type' => 'number', 'label' => 'SMTP Port',
                                     'min' => 1, 'max' => 65535, 'depends' => ['wbmailer_routine', 'smtp']],
            'wbmailer_smtp_secure' => [
                'level'   => 'basic',
                'type'    => 'select',
                'label'   => 'SMTP Secure',
                'options' => ['' => 'TEXT:NONE', 'TLS' => 'TLS', 'SSL' => 'SSL'],
                'widget'  => ['customSelector' => 'title_only'],
                'depends' => ['wbmailer_routine', 'smtp'],
            ],
            // Mailer reads this with (bool) — 'false' would switch auth ON
            'wbmailer_smtp_auth' => [
                'level'   => 'basic',
                'type'    => 'bool',
                'label'   => 'TEXT:WBMAILER_SMTP_AUTH',
                'values'  => ['1', '0'],
                'depends' => ['wbmailer_routine', 'smtp'],
            ],
            'wbmailer_smtp_username' => ['level' => 'basic', 'type' => 'text', 'label' => 'TEXT:WBMAILER_SMTP_USERNAME',
                                         'depends' => ['wbmailer_smtp_auth', '1']],
            'wbmailer_smtp_password' => ['level' => 'basic', 'type' => 'password', 'label' => 'TEXT:WBMAILER_SMTP_PASSWORD',
                                         'depends' => ['wbmailer_smtp_auth', '1']],
        ],
    ],

];
