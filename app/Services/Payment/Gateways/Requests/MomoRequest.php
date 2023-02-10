<?php

namespace App\Services\Payment\Gateways\Requests;

use App\Models\PaymentMethod;
use App\Models\PaymentTransaction;
use App\Services\Payment\Gateways\Configs\MomoConfig;
use Illuminate\Support\Facades\Http;

trait MomoRequest
{
    /**
     * Send request to server momo
     *
     * @param $enpoint
     * @param array $data
     * @return array|mixed|null
     */
    public function exec($enpoint, $data)
    {
        $response = Http::accept('application/json')
            ->post(MomoConfig::getConfigs(MomoConfig::BASE_ENDPOINT) . $enpoint, $data);

        return $response->successful()
            ? (json_decode($response->body() ?? null, true) ?? null)
            : null;
    }

    /**
     * Make params for create request
     *
     * @param array $data
     * @return array
     */
    private function makeParamForCreateRequest($data): array
    {
        return [
            'amount' => $data['total_amount'],
            'extraData' => base64_encode(json_encode([
                'method' => PaymentMethod::MOMO_METHOD,
                'transaction_id' => $data['transactionId'] ?? '',
            ])),
            'orderId' => $data['orderId'] ?? '',
            'orderInfo' => __('app.payment.pay_for_order', ['id' => $data['code']]),
            'redirectUrl' => MomoConfig::getConfigs(MomoConfig::REDIRECT_ORDER_URL),
            'requestId' => $data['id'] ?? '',
            'requestType' => 'captureWallet',
            'accessKey' => MomoConfig::getConfigs(MomoConfig::ACCESS_KEY),
            'ipnUrl' => MomoConfig::getConfigs(MomoConfig::NOTIFY_URL),
            'partnerCode' => MomoConfig::getConfigs(MomoConfig::PARTNER_CODE),
            'lang' => env('APP_LANG', 'vi'),
        ];
    }

    /**
     * Make params for create app request
     *
     * @param array $data
     * @return array
     */
    private function makeParamForCreateAppRequest($data): array
    {
        $rawData = [
            'partnerCode' => MomoConfig::getConfigs(MomoConfig::PARTNER_CODE),
            'partnerRefId' => $data['id'],
            'amount' => $data['total_amount'],
            'partnerName' => config('app.name'),
            'description' => __('app.payment.pay_for_order', ['id' => $data['id']]),
        ];

        return array_merge($rawData, [
            'customerNumber' => $data['customer_number'],
            'appData' => $data['app_data'],
            'hash' => encryptRsa($rawData, MomoConfig::getConfigs(MomoConfig::PUBLISH_KEY, PaymentMethod::CLIENT_MOBILE)),
            'version' => 2,
            'payType' => 3,
        ]);
    }

    /**
     * Make params for web commit request
     *
     * @param PaymentTransaction $transaction
     * @param string $action
     * @return array
     */
    private function makeParamForWebCommitRequest($transaction, $action): array
    {
        return [
            'accessKey' => MomoConfig::getConfigs(MomoConfig::ACCESS_KEY),
            'amount' => $transaction->order->total_amount,
            'description' => $action,
            'orderId' => $transaction->code,
            'partnerCode' => MomoConfig::getConfigs(MomoConfig::PARTNER_CODE),
            'requestId' => $transaction->order->id,
            'requestType' => $action === PaymentTransaction::RESQUEST_COMMIT
                ? MomoConfig::REQUEST_TYPE_COMMIT
                : MomoConfig::WEB_REQUEST_TYPE_ROLLBACK,
            'lang' => 'vi',
        ];
    }

    /**
     * Make params for app commit request
     *
     * @param PaymentTransaction $transaction
     * @param string $action
     * @return array
     */
    private function makeParamForAppCommitRequest($transaction, $action): array
    {
        return [
            'partnerCode' => MomoConfig::getConfigs(MomoConfig::PARTNER_CODE),
            'partnerRefId' => $transaction->order->id,
            'requestType' => $action === PaymentTransaction::RESQUEST_COMMIT
                ? MomoConfig::REQUEST_TYPE_COMMIT
                : MomoConfig::APP_REQUEST_TYPE_ROLLBACK,
            'requestId' => generateUniqueCode(),
            'momoTransId' => $transaction->partner_transaction_id,
            'description' => $action,
        ];
    }

    /**
     * Build params for WEB verify
     *
     * @param array $data
     * @return string[]
     */
    private function makeParamsForWebVerifyRequest(array $data): array
    {
        return [
            'accessKey' => MomoConfig::getConfigs(MomoConfig::ACCESS_KEY),
            'amount' => $data['amount'] ?? 0,
            'extraData' => $data['extraData'] ?? '',
            'message' => $data['message'] ?? '',
            'orderId' => $data['orderId'] ?? '',
            'orderInfo' => $data['orderInfo'] ?? '',
            'orderType' => $data['orderType'] ?? '',
            'partnerCode' => $data['partnerCode'] ?? '',
            'payType' => $data['payType'] ?? '',
            'requestId' => $data['requestId'] ?? '',
            'responseTime' => $data['responseTime'] ?? '',
            'resultCode' => $data['resultCode'] ?? '',
            'transId' => $data['transId'] ?? '',
        ];
    }

    /**
     * Build params for APP verify
     *
     * @param array $data
     * @return string[]
     */
    private function makeParamsForAppVerifyRequest(array $data): array
    {
        return [
            'accessKey' => MomoConfig::getConfigs(MomoConfig::ACCESS_KEY),
            'amount' => $data['amount'] ?? 0,
            'message' => $data['message'] ?? '',
            'momoTransId' => $data['momoTransId'] ?? '',
            'partnerCode' => $data['partnerCode'] ?? '',
            'partnerRefId' => $data['partnerRefId'] ?? '',
            'partnerTransId' => $data['partnerTransId'] ?? '',
            'responseTime' => $data['responseTime'] ?? '',
            'status' => $data['status'] ?? '',
            'storeId' => $data['storeId'] ?? '',
            'transType' => 'momo_wallet',
        ];
    }

    /**
     * Make params for refund request
     *
     * @param array $data
     * @param string $transId
     * @return array
     */
    public function makeParamsForRefund(array $data, string $transId): array
    {
        return [
            'accessKey' => MomoConfig::getConfigs(MomoConfig::ACCESS_KEY),
            'amount' => $data['total_amount'],
            'description' => sprintf("%s: %s", __('app.payment.refund_for_order'), $data['code']),
            'orderId' => generateUniqueCode(),
            'partnerCode' => MomoConfig::getConfigs(MomoConfig::PARTNER_CODE),
            'requestId' => $data['id'] ?? '',
            'transId' => $transId ?? '',
            'lang' => env('APP_LANG', 'vi'),
        ];
    }
}
