<?php

namespace App\Services\Payment\Gateways\Signature;

use App\Services\Payment\Gateways\Configs\MomoConfig;

/**
 * Class MomoSignature
 *
 * @package App\Services\Payment\Gateways\Signature
 */
class MomoSignature
{
    /**
     * Make signature
     *
     * @param $params
     * @return false|string
     */
    private function makeSignature($fillable, $params)
    {
        return hash_hmac(
            "sha256",
            $this->makeRawHash($fillable, $params),
            MomoConfig::getConfigs(MomoConfig::SECRET_KEY)
        );
    }

    /**
     * Make raw hash string
     *
     * @param array $keys
     * @param array $params
     * @return string
     */
    private function makeRawHash(array $keys, array $params): string
    {
        return collect($keys)->map(function ($key) use ($params) {
            return "{$key}={$params[$key]}";
        })->join('&');
    }

    /**
     * Make signature for create request
     *
     * @param array $params
     * @return string
     */
    public function makeForCreateRequest(array $params): string
    {
        $fillable = [
            'accessKey',
            'amount',
            'extraData',
            'ipnUrl',
            'orderId',
            'orderInfo',
            'partnerCode',
            'redirectUrl',
            'requestId',
            'requestType',
        ];

        return $this->makeSignature($fillable, $params);
    }

    /**
     * Make signature for web verify
     *
     * @param array $params
     * @return false|string
     */
    public function makeForWebVerify(array $params)
    {
        $fillable = [
            'accessKey',
            'amount',
            'extraData',
            'message',
            'orderId',
            'orderInfo',
            'orderType',
            'partnerCode',
            'payType',
            'requestId',
            'responseTime',
            'resultCode',
            'transId',
        ];

        return $this->makeSignature($fillable, $params);
    }

    /**
     * Make signature for app verify
     *
     * @param array $params
     * @return false|string
     */
    public function makeForAppVerify(array $params)
    {
        $fillable = [
            'accessKey',
            'amount',
            'message',
            'momoTransId',
            'partnerCode',
            'partnerRefId',
            'partnerTransId',
            'responseTime',
            'status',
            'storeId',
            'transType',
        ];

        return $this->makeSignature($fillable, $params);
    }

    /**
     * Make signature for response app hold money confirm
     *
     * @param array $params
     * @return false|string
     */
    public function makeForResponseAppHoldMoneyConfirm(array $params)
    {
        $fillable = [
            'amount',
            'message',
            'momoTransId',
            'partnerRefId',
            'status',
        ];

        return $this->makeSignature($fillable, $params);
    }

    /**
     * Make signature for response web hold money confirm
     *
     * @param array $params
     * @return false|string
     */
    public function makeForResponseWebHoldMoneyConfirm(array $params)
    {
        $fillable = [
            'accessKey',
            'extraData',
            'message',
            'orderId',
            'partnerCode',
            'requestId',
            'responseTime',
            'resultCode',
        ];

        return $this->makeSignature($fillable, $params);
    }

    /**
     * Make signature for response app commit
     *
     * @param array $params
     * @return false|string
     */
    public function makeForRequestAppCommit(array $params)
    {
        $fillable = [
            'partnerCode',
            'partnerRefId',
            'requestType',
            'requestId',
            'momoTransId',
        ];

        return $this->makeSignature($fillable, $params);
    }

    /**
     * Make signature for response web commit
     *
     * @param array $params
     * @return false|string
     */
    public function makeForRequestWebCommit(array $params)
    {
        $fillable = [
            'accessKey',
            'amount',
            'description',
            'orderId',
            'partnerCode',
            'requestId',
            'requestType',
        ];

        return $this->makeSignature($fillable, $params);
    }

    /**
     * Make signature for refund
     *
     * @param array $params
     * @return false|string
     */
    public function makeForRefund(array $params)
    {
        $fillable = [
            'accessKey',
            'amount',
            'description',
            'orderId',
            'partnerCode',
            'requestId',
            'transId',
        ];

        return $this->makeSignature($fillable, $params);
    }
}
