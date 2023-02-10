<?php

return [
    'menu_top' => [
        [
            'route' => 'home.index',
            'name' => 'web.home',
        ],
        [
            'route' => 'categories.index',
            'name' => 'web.promotions',
            'params' => 'combo'
        ],
        [
            'route' => 'categories.index',
            'name' => 'web.menu',
        ],
        [
            'route' => 'account.help',
            'name' => 'web.support',
        ],
        [
            'route' => 'contact',
            'name' => 'web.contact.menu_name',
        ],
    ],
    'footer' => [
        'col_1' => [
            [
                'url' => 'help',
                'title' => 'web.footer.faq',
            ],
            [
                'url' => 'contact',
                'title' => 'web.footer.contact',
            ],
        ],
        'col_2' => [
            [
                'url' => 'page/chinh-sach-giao-hang',
                'title' => 'web.footer.shiping_policy',
            ],
            [
                'url' => 'page/chinh-sach-va-quy-dinh-chung',
                'title' => 'web.footer.general_policy',
            ],
            [
                'url' => 'page/chinh-sach-bao-mat',
                'title' => 'web.footer.privacy_policy',
            ],
        ],
        'col_3' => [
            [
                'url' => 'page/tuyen-dung',
                'title' => 'web.footer.recruitment',
            ],
            [
                'url' => 'page/ve-chung-toi',
                'title' => 'web.footer.about_us',
            ],
        ],
        'col_4' => [

        ]
    ],
    'profile_sidebar' => [
        [
            'icon' => 'shilin-user-full',
            'route' => 'my-account.show',
            'title' => 'my_profile',
        ],

        [
            'icon' => 'shilin-setting-notification',
            'route' => 'my.setting-notification',
            'title' => 'notification_setting',
        ],
        [
            'icon' => 'shilin-menu',
            'route' => 'my-orders.get-orders',
            'title' => 'my_order',
        ],
        [
            'icon' => 'shilin-heart',
            'route' => 'my.favorite-stores.get',
            'title' => 'favorite_store',
        ],
        [
            'icon' => 'shilin-promotion',
            'route' => 'my-coupons.index',
            'title' => 'coupon',
        ],
        [
            'icon' => 'shilin-block',
            'route' => 'my.password.get',
            'title' => 'change_password',
        ],
    ],
];
