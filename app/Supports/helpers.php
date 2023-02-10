<?php

// use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Response;

/*
 *--------------------------------------------------------------------------
 * Helpers
 *--------------------------------------------------------------------------
 *
 * Here is where you can write helpers function for project
 * You need run:  composer dump-autoload to load functions writed
 *
 */

if (!function_exists('isAdmin')) {
    /**
     * Detect admin guard
     *
     * @return string
     */
    function isAdmin()
    {
        return Auth::getDefaultDriver() == ADMIN_RESOURCE;
    }
}

if (!function_exists('isApi')) {
    /**
     * Detect api guard
     *
     * @return string
     */
    function isApi()
    {
        return Auth::getDefaultDriver() == API_RESOURCE;
    }
}

if (!function_exists('isSaleApi')) {
    /**
     * Detect sale api guard
     *
     * @return string
     */
    function isSaleApi()
    {
        return Auth::getDefaultDriver() == SALE_API_RESOURCE;
    }
}

if (!function_exists('isWeb')) {
    /**
     * Detect api guard
     *
     * @return string
     */
    function isWeb()
    {
        return Auth::getDefaultDriver() == WEB_RESOURCE;
    }
}

if (!function_exists('domain')) {
    /**
     * Parse domain from url
     *
     * @return string
     */
    function domain()
    {
        return parse_url(config('app.url'), PHP_URL_HOST);
    }
}

if (!function_exists('apiUrl')) {
    /**
     * Render base api Url via 'APP_URL'
     *
     * @param string $uri
     * @return string
     */
    function apiUrl(string $uri = null)
    {
        $uri = $uri && $uri[0] != '/' ? "/$uri" : $uri;
        $appUrl = config('app.url');
        $domain = domain();
        $useSubdomain = env('APP_USE_SUB_DOMAIN', false);

        return $useSubdomain
            ? str_replace($domain, API_RESOURCE . '.' . $domain, $appUrl) . $uri
            : $appUrl . '/api' . $uri;
    }
}

if (!function_exists('saleApiUrl')) {
    /**
     * Render base sale api Url via 'APP_URL'
     *
     * @param string $uri
     * @return string
     */
    function saleApiUrl(string $uri = null)
    {
        $uri = $uri && $uri[0] != '/' ? "/$uri" : $uri;
        $appUrl = config('app.url');
        $domain = domain();
        $useSubdomain = env('APP_USE_SUB_DOMAIN', false);

        return $useSubdomain
            ? str_replace($domain, SALE_API_RESOURCE . '.' . $domain, $appUrl) . $uri
            : $appUrl . '/sale-api' . $uri;
    }
}

if (!function_exists('webUrl')) {
    /**
     * Render base web Url via 'APP_URL'
     *
     * @param string $uri
     * @return string
     */
    function webUrl(string $uri = null)
    {
        $uri = $uri && $uri[0] != '/' ? "/$uri" : $uri;

        return config('app.url') . $uri;
    }
}

if (!function_exists('adminUrl')) {
    /**
     * Render admin Url
     *
     * @param string $uri
     * @return string
     */
    function adminUrl(string $uri = null)
    {
        $uri = $uri && $uri[0] != '/' ? "/$uri" : $uri;
        $appUrl = config('app.url');
        $domain = domain();
        $useSubdomain = env('APP_USE_SUB_DOMAIN', false);

        return $useSubdomain
            ? str_replace($domain, ADMIN_RESOURCE . '.' . $domain, $appUrl) . $uri
            : $appUrl . '/admin' . $uri;
    }
}

if (!function_exists('escapeLike')) {
    /**
     * Escape special characters for a LIKE query.
     *
     * @param string $value
     * @param string $char
     *
     * @return string
     */
    function escapeLike(string $value, string $char = '\\'): string
    {
        return str_replace(
            [$char, '%', '_'],
            [$char . $char, $char . '%', $char . '_'],
            $value
        );
    }
}

if (!function_exists('generateUniqueCode')) {
    /**
     * Generates a unique CODE based on the microtime
     *
     * @return string $code
     */
    function generateUniqueCode(): string
    {
        return strtoupper(uniqid());
    }
}

if (!function_exists('parseItemsPerPage')) {
    /**
     * Generates a unique CODE based on the microtime
     *
     * @param mixed $limit
     * @param integer $maxAllow
     * @return int
     */
    function parseItemsPerPage($limit, int $maxAllow = 20): int
    {
        return ($limit = intval($limit)) > 0 && $limit <= $maxAllow
            ? $limit
            : $maxAllow;
    }
}

if (!function_exists('parseItemsLimit')) {
    /**
     * Generates a unique CODE based on the microtime
     *
     * @param mixed $limit
     * @param integer $defaultLimit
     * @return int
     */
    function parseItemsLimit($limit, int $defaultLimit): int
    {
        return ($limit = intval($limit)) > 0
            ? $limit
            : $defaultLimit;
    }
}

if (!function_exists('arrayToParams')) {
    /**
     * Generates a params string from an array
     *
     * @param array $array
     * @return string $string
     */
    function arrayToParams($array): string
    {
        $string = '';
        foreach ($array as $key => $value) {
            $key === array_key_first($array)
                ? $string .= "$key=$value"
                : $string .= "&$key=$value";
        };

        return $string;
    }
}

if (!function_exists('canAccessStore')) {
    /**
     * Check user can access a store
     *
     * @param string $id
     * @return void
     */
    function canAccessStore($storeId)
    {
        if (!auth()->user()->canAccessStore($storeId)) {
            return abort(Response::HTTP_FORBIDDEN, __('app.messages.error.can_not_access_store'));
        }
    }
}

if (!function_exists('getOrderPrepareTime')) {
    /**
     * Get order prepare time
     *
     * @return int
     */
    function getOrderPrepareTime()
    {
        // return (Setting::whereCode(Setting::SHIPPING_METHOD)
        //     ->first()
        // ->config[Setting::SHILIN_SHIPPING_METHOD]['order_prepare_time'] ?? Order::TIMEOUT_PREPARING) * 60;
    }
}

if (!function_exists('getDefaultShippingFee')) {
    /**
     * Get default shipping fee
     *
     * @return int
     */
    function getDefaultShippingFee()
    {
        return Setting::whereCode(Setting::SHIPPING_METHOD)
            ->first();
        // ->config['default_shipping_fee'] ?? Order::DEFAULT_SHIPPING_FEE;
    }
}
