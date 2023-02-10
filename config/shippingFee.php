<?php
/**
 * config for calculating shipping fee
 */

return [
    'resource' => [
        'google' => [
            'url' => 'https://maps.googleapis.com/maps/api/distancematrix/json',
            'default_params' => [
                'departure_time' => 'now',
                'key' => env('GOOGLE_DISTANCE_MATRIX_KEY'),
            ],
        ],
    ],
    'default_fee' => 15000,
    'stops' => [
        [
            'stop' => 3,
            'fee' => 15000,
            'type' => 1,
        ],
        [
            'stop' => 5,
            'fee' => 20000,
            'type' => 1,
        ],
        [
            'stop' => 10,
            'fee' => 4000,
            'type' => 2,
        ],
        [
            'stop' => INF,
            'fee' => 3000,
            'type' => 2,
        ],
    ],
    'stop_type' => [
        'fix' => 1,
        'each_km' => 2,
    ],
];
