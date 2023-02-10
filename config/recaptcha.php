<?php

/**
 *--------------------------------------------------------------------------
 * Re-Captcha configuration
 *--------------------------------------------------------------------------
 */

return [
    'api' => 'https://www.google.com/recaptcha/api/siteverify',
    'site_key' => env('CAPTCHA_SITE_KEY', null),
    'secret_key' => env('CAPTCHA_SECRET_KEY', null),
];
