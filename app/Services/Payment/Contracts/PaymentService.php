<?php

namespace App\Services\Payment\Contracts;

// use App\Models\Order;

interface PaymentService
{
    /**
     * Create payment request
     *
     * @param array $param
     * @return array
     */
    // public function createPaymentRequest(Order $order, $param = []): array;

    /**
     * Verify hold money for WEB.
     *
     * @param string $method
     * @param array $params
     * @return array
     */
    public function verifyForWeb(string $method, array $params): array;

    /**
     * Verify hold money for APP.
     *
     * @param string $method
     * @param array $params
     * @return array
     */
    public function verifyForApp(string $method, array $params): array;

    /**
     * Verify callback
     *
     * @param string $method
     * @param array $params
     * @return bool
     */
    public function verifyCallback(string $method, array $params): bool;

    /**
     * Commit transaction
     *
     * @param Order $order
     * @param string $action
     * @return array
     */
    // public function commitTransaction(Order $order, string $action): array;

    /**
     * Refund order
     *
     * @param Order $order
     * @return array
     */
    // public function refund(Order $order): array;
}
