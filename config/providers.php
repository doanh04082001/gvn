<?php

/**
 * --------------------------------------------
 * This config library providers for app
 * --------------------------------------------
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers for All
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
     */
    'all' => [
        // App\Providers\RegisterViaOtpServiceProvider::class,
        // App\Services\ShippingFee\ShippingFeeServiceProvider::class,
        App\Services\Payment\PaymentServiceProvider::class,
        // App\Services\Cart\CartServiceProvider::class,
        // App\Services\Shipping\ShippingServiceProvider::class,
        // App\Providers\GoogleDriveServiceProvider::class,
        Spatie\Backup\BackupServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers for admin
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
     */
    'admin' => [
        Yajra\DataTables\DataTablesServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers for api
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
     */
    'api' => [
        App\Services\Otp\OtpServiceProvider::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoload Service Providers for web
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
     */
    // 'web' => [
    //     App\Services\Cart\CartServiceProvider::class,
    //     App\Services\Otp\OtpServiceProvider::class
    // ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers for sale api
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
     */
    'sale-api' => [],
];
