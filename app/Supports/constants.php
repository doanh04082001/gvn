<?php

/*
 *--------------------------------------------------------------------------
 * Constant
 *--------------------------------------------------------------------------
 *
 * Here is where you can write constants for project
 * You need run:  composer dump-autoload to load functions writed
 *
 */

if (!defined('ADMIN_RESOURCE')) {
    define('ADMIN_RESOURCE', 'admin');
}

if (!defined('API_RESOURCE')) {
    define('API_RESOURCE', 'api');
}

if (!defined('WEB_RESOURCE')) {
    define('WEB_RESOURCE', 'web');
}

if (!defined('SALE_API_RESOURCE')) {
    define('SALE_API_RESOURCE', 'sale-api');
}

if (!defined('VOUCHER_CODE_REGEX')) {
    define('VOUCHER_CODE_REGEX', '/^[a-zA-Z0-9-]*$/');
}

if (!defined('FILE_SIZE_10240')) {
    define('FILE_SIZE_10240', 10240);
}

if (!defined('DATE_FORMAT_VALIDATION')) {
    define('DATE_FORMAT_VALIDATION', '"Y-m-d","Y/m/d"');
}

if (!defined('WEB_DATE_FORMAT_VALIDATION')) {
    define('WEB_DATE_FORMAT_VALIDATION', 'd/m/Y');
}

if (!defined('ALLOWED_IMAGE_MINES')) {
    define('ALLOWED_IMAGE_MINES', 'jpeg,jpg,png,bmp,gif');
}

if (!defined('PRODUCT_SKU_REGEX')) {
    define('PRODUCT_SKU_REGEX', '/^[a-zA-Z0-9]*$/');
}

if (!defined('LATITUDE_REGEX')) {
    define('LATITUDE_REGEX', '/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/');
}

if (!defined('LONGITUDE_REGEX')) {
    define('LONGITUDE_REGEX', '/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/');
}

if (!defined('PHONE_REGEX')) {
    define('PHONE_REGEX', '/^(0?)([1-9]{1})\d{8}$/');
}

if (!defined('STORE_PHONE_REGEX')) {
    define('STORE_PHONE_REGEX', '/^[0-9-]*$/');
}

if (!defined('PRODUCTS_PER_PAGE')) {
    define('PRODUCTS_PER_PAGE', 10);
}

if (!defined('PRODUCTS_PER_SECTION')) {
    define('PRODUCTS_PER_SECTION', 6);
}

if (!defined('MIN_PASSWORD_LENGTH')) {
    define('MIN_PASSWORD_LENGTH', 6);
}

if (!defined('DEFAULT_CLIENT_TIMEZONE')) {
    define('DEFAULT_CLIENT_TIMEZONE', 'Asia/Saigon');
}

if (!defined('NOT_LIMIT_ITEMS')) {
    define('NOT_LIMIT_ITEMS', -1);
}
