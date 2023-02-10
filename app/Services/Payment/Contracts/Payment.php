<?php

namespace App\Services\Payment\Contracts;

// use App\Models\Order;

interface Payment
{
    /**
     * Create payment request.
     *
     * @return array
     * @throws OrderPaidException
     */
    // public function createPaymentRequest(Order $order);

    /**
     * Verify hold money for WEB.
     *
     * @param array $params
     * @return array
     * @throws MomoSignatureException
     */
    public function verifyForWeb($params): array;

    /**
     * Verify hold money for APP.
     *
     * @param array $params
     * @return array
     * @throws MomoSignatureException
     */
    public function verifyForApp($params): array;

    /**
     * Verify callback.
     *
     * @param array $params
     * @return bool
     */
    public function verifyCallback($params): bool;

    /**
     * Commit transaction when payment with APP.
     *
     * @param Order $order
     * @param string $action
     * @return array
     * @throws TransactionStatusConflict
     */
    // public function commitTransaction(Order $order, $action): array;

    /**
     * Refund transaction.
     *
     * @param Order $order
     * @return array
     * @throws TransactionStatusConflict
     * @throws MomoRequestFailException
     * @throws HandlerMomoDataException
     */
    // public function refund(Order $order): array;
}
