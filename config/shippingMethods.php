<?php

return [
    /**
     * Config for Ahamove
     */
    'ahamove' => [
        'base_endpoint' => [
            'local' => 'https://apistg.ahamove.com/',
            'production' => 'https://api.ahamove.com/',
            'testing' => 'https://apistg.ahamove.com/',
        ],
        'payment_method' => [
            'local' => 'CASH',
            'production' => 'CASH',
            'testing' => 'https://apistg.ahamove.com/',
        ],
        'get_token_endpoint' => 'v1/partner/register_account',
        'get_city_detail_endpoint' => 'v1/order/city_detail',
        'get_order_list_endpoint' => 'v1/order/list',
        'get_order_detail_endpoint' => 'v1/order/detail',
        'create_order_endpoint' => 'v1/order/create',
        'cancel_order_endpoint' => 'v1/order/cancel',
        'estimate_order_fee_endpoint' => 'v1/order/estimated_fee',
        'name' => env('AHAMOVE_NAME', 'Ahamove Test User'),
        'mobile' => env('AHAMOVE_MOBILE', '84908842280'),
        'api_key' => env('AHAMOVE_API_KEY', '8b59b7b5fe231e5aa0dfbc15779851a8'),
    ],
    'shilin' => [
        'name' => 'Shilin',
        'default_shipping_fee' => 15000,
        'order_prepare_time' => 25,
    ],
];
