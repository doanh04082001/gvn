<?php
return [
    /**
     * Config for Momo
     */
    'momo' => [
        'notify_route' => 'webhooks.momo.web',
        'redirect_order_route' => 'my-orders.get-orders',
        'base_endpoint' => [
            'local' => 'https://test-payment.momo.vn/',
            'production' => 'https://payment.momo.vn/',
            'testing' => 'https://test-payment.momo.vn/',
        ],
        'create_web_payment_endpoint' => 'v2/gateway/api/create',
        'confirm_web_payment_endpoint' => 'v2/gateway/api/confirm',
        'create_app_payment_endpoint' => 'pay/app',
        'confirm_app_payment_endpoint' => 'pay/confirm',
        'refund_endpoint' => 'v2/gateway/api/refund',
        'accepted_ips' => [
            'local' => [
                '210.245.113.71',
                '118.69.210.244',
            ],
            'production' => [
                '118.69.212.158',
                '118.69.210.244',
            ],
            'testing' => [
                '210.245.113.71',
                '118.69.210.244',
            ],
        ],
        'partner_code' => env('MOMO_PARTNER_CODE', 'MOMO2O7520210713'),
        'access_key' => env('MOMO_ACCESS_KEY', 'aZhnJzYvJZJHCN9L'),
        'secret_key' => env('MOMO_SECRET_KEY', 'uNscyCi66oTkbkwC68rsVkkzchGxkHbA'),
        'ios_scheme_id' => env('MOMO_IOS_SCHEME_ID', 'momo2o7520210713'),
        'publish_key' => env('MOMO_PUBLISH_KEY', 'MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEApdmqtN9ElI4RoJUR/QxI2aXI2hIWbFb+++uC+i0SGtE3ydT5/MrsqQS9uaDbl4KN+SEQivWeWEQaYxIDahLYiQT9dkYdEoSXATp4b2SEgSHc6vUh+P05kET76mG+9E8KZIZsE0GMSw/VTioxK/WA933wR4zrdiEaVkL178k90nVmuQE0BLcwejV94poVK+Ek3nQPGzC4f1fmmk+peZflCK5NYDhqJMMM9Eq0Iz1HhzgB/Inz8UJq9/+9xU6jw2c5fWzeyKgxmE2y+JwTy85cyCHWH/oZ1BFrxkspKSyY+uWFRzzdFSzeMDTenNDXbGptwAvBATgTcIq7Czgp0eVevx8+mGHNUPL7L/fmrBZkXgEfJ2eIFpdSorpIvqu3/o64w3rPUkFiWdNCD00SX+Gq8f//2urnmPDoYbUZ96lI2/GcioPg0NUcyd8P6lngZc24sZXVl5U83Xd+5EgMMSeLnZlLnekF3pTGPY2Sg4O6KGkmrfg6Be3fmsmuC90hWstlRYcPFmnRxfn/t78YlxZm2kwSCtbjEvIBkeRBmcYfnUn5+sIosmLUfkDUqz30afD8pPo/FrD1pp1fEwYQIX2XhwpVGBoppaZxWP9db6UQveOybQYLxF5R5pQ0MIOlWPsVj3gog6lZfACbhUh0LIRQKkbGH8eGesG/764SfA9vCDMCAwEAAQ=='),
    ]
];
