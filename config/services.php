<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'gitlab' => [
        // 'client_id' => '86d32a5cf148ba4bad2fb0ac2a6bfc7cab54e0f4420869a24cc1866495fa48e3',
        // 'client_secret' => '47af7b6811129770fbed3ae167f0ebe18397bb322b88450598368e450dc87373',
        'client_id' => 'e36d66569c5709643f8a4f1bd685060094617e12afc060419627fc4cdaa069b4',
        'client_secret' => '8c2559eebeb5ae3ee8be5b81305c2acf8dda9f054c6d96863aeae11d888bf3e1',
        // 'redirect' => 'http://localhost:8000/gitlab/callback',
        'redirect' => 'http://shilin.test/admin/gitlab/callback',
        'host' => 'https://gitlab.gvn.com/'
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
