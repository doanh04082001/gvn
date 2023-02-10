<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentService as PaymentServiceContract;
use App\Services\Payment\Factories\PaymentFactory;

class PaymentService implements PaymentServiceContract
{
    /**
     * Create payment request
     *
     * @param Order $order
     * @param array $param
     * @return array
     */
    public function createPaymentRequest(Order $order, $param = []): array
    {
        $method = $order->payment_method;

        if (!empty($param)) {
            $order->customer_number = $param['customer_number'];
            $order->app_data = $param['app_data'];
        }

        return PaymentFactory::makeInstance($method)
            ->createPaymentRequest($order);
    }

    /**
     * Verify hold money for WEB.
     *
     * @param string $method
     * @param array $params
     * @return array
     */
    public function verifyForWeb(string $method, array $params): array
    {
        return PaymentFactory::makeInstance($method)
            ->verifyForWeb($params);
    }

    /**
     * Verify hold money for APP.
     *
     * @param string $method
     * @param array $params
     * @return array
     */
    public function verifyForApp(string $method, array $params): array
    {
        return PaymentFactory::makeInstance($method)
            ->verifyForApp($params);
    }

    /**
     * Verify callback
     *
     * @param string $method
     * @param array $params
     * @return bool
     */
    public function verifyCallback(string $method, array $params): bool
    {
        return PaymentFactory::makeInstance($method)
            ->verifyCallback($params);
    }

    /**
     * Commit transaction
     *
     * @param Order $order
     * @param string $action
     * @return array
     */
    public function commitTransaction(Order $order, string $action): array
    {
        $method = $order->payment_method;

        return PaymentFactory::makeInstance($method)
            ->commitTransaction($order, $action);
    }

    /**
     * Refund order
     *
     * @param Order $order
     * @return array
     */
    public function refund(Order $order): array
    {
        $method = $order->payment_method;

        return PaymentFactory::makeInstance($method)
            ->refund($order);
    }
}
