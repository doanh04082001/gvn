<?php

namespace App\Services\Payment\Gateways\Configs;

use App\Models\PaymentMethod;
use App\Repositories\Contracts\PaymentMethodRepository;

class MomoConfig
{
    const ACCEPTED_IPS = 'accepted_ips';
    const ACCESS_KEY = 'access_key';
    const BASE_ENDPOINT = 'base_endpoint';
    const SECRET_KEY = 'secret_key';
    const PUBLISH_KEY = 'publish_key';
    const NOTIFY_URL = 'notify_url';
    const REDIRECT_ORDER_URL = 'redirect_order_url';
    const PARTNER_CODE = 'partner_code';
    const CREATE_REQUEST_ENPOINT = 'create_web_payment_endpoint';
    const CREATE_APP_PAYMENT_ENPOINT = 'create_app_payment_endpoint';
    const COMMIT_WEB_PAYMENT_ENPOINT = 'commit_web_payment_endpoint';
    const COMMIT_APP_PAYMENT_ENPOINT = 'commit_app_payment_endpoint';
    const REFUND_ENPOINT = 'refund_endpoint';
    const REQUEST_TYPE_COMMIT = 'capture';
    const WEB_REQUEST_TYPE_ROLLBACK = 'cancel';
    const APP_REQUEST_TYPE_ROLLBACK = 'revertAuthorize';

    /**
     * @var string
     */
    public static string $client = '';

    /**
     * @var array
     */
    public static array $configs = [];

    /**
     * Get config momo gateway
     *
     * @param string $key partner_code|access_key|secret_key|base_endpoint|accepted_ips
     * @param string $client
     * @return array|mixed
     */
    public static function getConfigs(string $key = '', string $client = PaymentMethod::CLIENT_WEBSITE)
    {
        $environment = app()->environment();

        if (empty(self::$configs) || $client != self::$client) {
            self::$client = $client;
            self::$configs = app(PaymentMethodRepository::class)->getConfigs(PaymentMethod::MOMO_METHOD, $client);
            self::$configs[self::BASE_ENDPOINT] = config('payments.momo.base_endpoint')[$environment];
            self::$configs[self::ACCEPTED_IPS] = config('payments.momo.accepted_ips')[$environment];
            self::$configs[self::CREATE_REQUEST_ENPOINT] = config('payments.momo.create_web_payment_endpoint');
            self::$configs[self::CREATE_APP_PAYMENT_ENPOINT] = config('payments.momo.create_app_payment_endpoint');
            self::$configs[self::COMMIT_WEB_PAYMENT_ENPOINT] = config('payments.momo.confirm_web_payment_endpoint');
            self::$configs[self::COMMIT_APP_PAYMENT_ENPOINT] = config('payments.momo.confirm_app_payment_endpoint');
            self::$configs[self::REFUND_ENPOINT] = config('payments.momo.refund_endpoint');
            self::$configs[self::NOTIFY_URL] = route(config('payments.momo.notify_route'));
            self::$configs[self::REDIRECT_ORDER_URL] = route(config('payments.momo.redirect_order_route'));
        }

        return $key && isset(self::$configs[$key])
            ? self::$configs[$key]
            : self::$configs;
    }
}
