<?php

return [

    /**
     *--------------------------------------------------------------------------
     * Title
     *--------------------------------------------------------------------------
     *
     * Here you can change the default title of your admin panel.
     *
     * For detailed instructions you can look the title section here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
     *
     */

    'title' => 'GVN Admin',
    'title_prefix' => '',
    'title_postfix' => '',

    /**
     *--------------------------------------------------------------------------
     * Favicon
     *--------------------------------------------------------------------------
     *
     * Here you can activate the favicon.
     *
     * For detailed instructions you can look the favicon section here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
     *
     */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /**
     *--------------------------------------------------------------------------
     * Logo
     *--------------------------------------------------------------------------
     *
     * Here you can change the logo of your admin panel.
     *
     * For detailed instructions you can look the logo section here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
     *
     */

    'logo' => '<b>GVN TECHNOLOGY</b>',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Shilin Admin',

    /**
     *--------------------------------------------------------------------------
     * User Menu
     *--------------------------------------------------------------------------
     *
     * Here you can activate and change the user menu.
     *
     * For detailed instructions you can look the user menu section here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
     *
     */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /**
     *--------------------------------------------------------------------------
     * Layout
     *--------------------------------------------------------------------------
     *
     * Here we change the layout of your admin panel.
     *
     * For detailed instructions you can look the layout section here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
     *
     */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /**
     *--------------------------------------------------------------------------
     * Authentication Views Classes
     *--------------------------------------------------------------------------
     *
     * Here you can change the look and behavior of the authentication views.
     *
     * For detailed instructions you can look the auth classes section here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
     *
     */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /**
     *--------------------------------------------------------------------------
     * Admin Panel Classes
     *--------------------------------------------------------------------------
     *
     * Here you can change the look and behavior of the admin panel.
     *
     * For detailed instructions you can look the admin panel classes here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
     *
     */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /**
     *--------------------------------------------------------------------------
     * Sidebar
     *--------------------------------------------------------------------------
     *
     * Here we can modify the sidebar of the admin panel.
     *
     * For detailed instructions you can look the sidebar section here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
     *
     */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /**
     *--------------------------------------------------------------------------
     * Control Sidebar (Right Sidebar)
     *--------------------------------------------------------------------------
     *
     * Here we can modify the right sidebar aka control sidebar of the admin panel.
     *
     * For detailed instructions you can look the right sidebar section here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
     *
     */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /**
     *--------------------------------------------------------------------------
     * URLs
     *--------------------------------------------------------------------------
     *
     * Here we can modify the url settings of the admin panel.
     *
     * For detailed instructions you can look the urls section here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
     *
     */

    'use_route_url' => true,
    'dashboard_url' => 'admin.dashboard',
    'logout_url' => 'admin.logout',
    'login_url' => 'admin.login',
    'register_url' => false,
    'password_reset_url' => 'admin.password.update',
    'password_email_url' => 'admin.password.email',
    'profile_url' => false,

    /**
     *--------------------------------------------------------------------------
     * Laravel Mix
     *--------------------------------------------------------------------------
     *
     * Here we can enable the Laravel Mix option for the admin panel.
     *
     * For detailed instructions you can look the laravel mix section here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
     *
     */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /**
     *--------------------------------------------------------------------------
     * Menu Items
     *--------------------------------------------------------------------------
     *
     * Here we can modify the sidebar/top navigation of the admin panel.
     *
     * For detailed instructions you can look here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
     *
     */

    'menu' => [
        [
            'text' => 'dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'fas fa-fw fa-tachometer-alt',
        ],

        ['header' => 'management'],
        [
            'text' => 'apply_leave',
            'icon' => 'far fa-edit',
            'can' => ['apply_leaves.create', 'apply_leaves.show'],
            'submenu' => [
                [
                    'text' => 'add_apply_leave',
                    'icon' => 'fas fa-fw fa-plus',
                    'route' => 'admin.apply-leaves.create',
                    'can' => 'apply_leaves.create',

                ],
                [
                    'text' => 'list_apply_leave',
                    'icon' => 'fas fa-fw fa-list',
                    'route' => 'admin.apply-leaves.index',
                    'can' => 'apply_leaves.show',
                ],
            ],
        ],
        [
            'text' => 'overtime',
            'icon' => 'far fa-edit',
            'can' => ['overtimes.create', 'overtimes.show'],
            'submenu' => [
                [
                    'text' => 'add_overtime',
                    'icon' => 'fas fa-fw fa-plus',
                    'route' => 'admin.overtime.create',
                    'can' => 'overtimes.create',
                ],
                [
                    'text' => 'list_overtime',
                    'icon' => 'fas fa-fw fa-list',
                    'route' => 'admin.overtime.index',
                    'can' => 'overtimes.show',
                ],
            ],
        ],

        [
            'header' => 'settings',
            'can' => ['roles', 'users']
        ],
        [
            'text' => 'roles_and_permissions',
            'icon' => 'fas fa-fw fa-user-tag',
            'active' => ['regex:/roles/'],
            'can' => 'roles.show',
            'submenu' => [
                [
                    'text' => 'role_manage',
                    'route' => 'admin.roles.index',
                    'can' => 'roles.create',
                ],
                [
                    'text' => 'permission_manage',
                    'active' => ['regex:/roles\/[a-z0-9\-\/]/'],
                    'route' => 'admin.roles.permissions.redirect',
                    'can' => 'roles.show',
                ],
            ],

        ],
        [
            'text' => 'user_manager',
            'icon' => 'fas fa-fw fa-user',
            'can' => 'users.show',
            'submenu' => [
                [
                    'text' => 'create_user',
                    'icon' => 'fas fa-fw fa-plus',
                    'route' => 'admin.users.create',
                    'can' => 'users.create',
                ],
                [
                    'text' => 'list_user',
                    'icon' => 'fas fa-fw fa-list',
                    'route' => 'admin.users.index',
                    'can' => 'users.show',
                ],
            ],
        ],
    ],

    /**
     *--------------------------------------------------------------------------
     * Menu Filters
     *--------------------------------------------------------------------------
     *
     * Here we can modify the menu filters of the admin panel.
     *
     * For detailed instructions you can look the menu filters section here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
     *
     */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /**
     *--------------------------------------------------------------------------
     * Plugins Initialization
     *--------------------------------------------------------------------------
     *
     * Here we can modify the plugins used inside the admin panel.
     *
     * For detailed instructions you can look the plugins section here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
     *
     */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'module' => true,
                    'asset' => true,
                    'location' => '/assets/admin/js/utils/datatable-handler-errors.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '/vendor/toastr/toastr.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '/vendor/toastr/toastr.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.16/sweetalert2.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.16/sweetalert2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.16/sweetalert2.css',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'Moment' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '/vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '/vendor/moment/moment-with-locales.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '/vendor/moment/moment-timezone.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '/vendor/moment/moment-timezone-with-data.min.js',
                ],
            ],
        ],
        'Firebase' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '/vendor/firebase8.6.1/firebase-app.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '/vendor/firebase8.6.1/firebase-messaging.js',
                ],
            ],
        ],
    ],

    /**
     *--------------------------------------------------------------------------
     * Livewire
     *--------------------------------------------------------------------------
     *
     * Here we can enable the Livewire support.
     *
     * For detailed instructions you can look the livewire here:
     * https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
     */

    'livewire' => false,
];