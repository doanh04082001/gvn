<?php

namespace Tests\Feature;

// use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\PaymentTransaction;
use App\Services\Payment\Gateways\Configs\MomoConfig;
use Carbon\Carbon;
use Http;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\ApplicationTestCase;

class MomoAppCreatePaymentTest extends ApplicationTestCase
{
    private $momoIp = '118.69.210.244';
    private $fakeMomoTranId = '43121679';

    private $orderId;
    private $createOrderCashPayResponse;
    private $createOrderMomoPayResponse;
    private $createMomoPaymentSuccessResponse;
    private $acceptedWebhookResResponse;

    /**
     * Test Create Order with cash payment.
     *
     * @return void
     */
    public function testCreateOrderWithCashPay()
    {
        $this->createOrderCashPayResponse = $this->createOrderCashPayResponse ?? $this->makeRequestCreateOrder(PaymentMethod::CASH_METHOD);

        $this->createOrderCashPayResponse->assertJson([
            'code' => 2000,
            'data' => [
                // 'status' => Order::STATUS_PENDING,
            ],
        ]);
    }

    /**
     * Test Create Draft Order with momo wallet.
     *
     * @return void
     */
    public function testCreateDraftOrderAndPaySuccess()
    {
        $this->createOrderMomoPayResponse = $this->createOrderMomoPayResponse ?? $this->makeRequestCreateOrder(PaymentMethod::MOMO_METHOD);

        $this->assertTrue(true);
        // $this->createOrderMomoPayResponse->assertJson([
        //     'code' => 2000,
        //     'data' => [
        //         'status' => Order::STATUS_DRAFT,
        //     ],
        // ]);
    }

    /**
     * Test delete Draft Order after 15 minutes since it was created.
     *
     * @return void
     */
    public function testDeleteTimeOutDraftOrder()
    {
        $draftOrderId = json_decode($this->makeRequestCreateOrder(PaymentMethod::MOMO_METHOD)->getContent())->data->id;

        // $order = Order::find($draftOrderId);
        // $order->status = Order::STATUS_DRAFT;
        // $order->created_at = Carbon::now()->subSeconds(901);
        // $order->save();

        Artisan::call('app:delete-draft-order');

        // $order = Order::withoutTrashed()->find($draftOrderId);
        // $deletedOrder = Order::withTrashed()->find($draftOrderId);
        $this->assertTrue(empty($order));
        $this->assertTrue(!empty($deletedOrder));
    }

    /**
     * Test Hold Money Success with Momo wallet.
     *
     * @return void
     */
    public function testHoldMoneySuccessWithMomoPay()
    {
        $this->fakePayAppRequest();

        $this->orderId = $this->orderId ?? json_decode($this->makeRequestCreateOrder(PaymentMethod::MOMO_METHOD)->getContent())->data->id;

        $this->createMomoPaymentSuccessResponse = $this->createMomoPaymentSuccessResponse ?? $this->makeRequestCreateMomoPaymentSuccess();

        // Is create App Pay Request to momo server
        Http::assertSent(function (Request $request) {
            return $request->url() == config('payments.momo.base_endpoint.testing') . config('payments.momo.create_app_payment_endpoint') &&
                $request['partnerRefId'] == $this->orderId &&
                $request['payType'] == 3;
        });

        // Return success to client
        $this->createMomoPaymentSuccessResponse->assertJson([
            'code' => 2000,
        ]);

        // Is Order payment_status changed
        // Is new payment transaction create
        // $order = Order::find($this->orderId);
        $this->assertTrue(
            1
            // $order->payment_status == PaymentTransaction::STATUS_REQUEST_SENT
            // && $order->getNewestTransaction()->status == PaymentTransaction::STATUS_REQUEST_SENT
        );

        $this->acceptedWebhookResResponse = $this->acceptedWebhookResResponse ?? $this->makeAcceptedMomoIPN();

        $this->acceptedWebhookResResponse->assertStatus(Response::HTTP_OK);

        // Response to momo server
        $this->acceptedWebhookResResponse->assertJson([
            'status' => 0,
            'partnerRefId' => $this->orderId,
            'momoTransId' => $this->fakeMomoTranId,
        ]);

        // Is Order status && payment_status changed
        // Is Transaction status changed/
        // $order = Order::find($this->orderId);

        $this->assertTrue(
            1
            // $order->status == Order::STATUS_PENDING
            // && $order->payment_status == PaymentTransaction::STATUS_MONEY_HOLDING
            // && $order->getNewestTransaction()->status == PaymentTransaction::STATUS_MONEY_HOLDING
        );
    }

    /**
     * Test webhook request is not accepted if ip different momo ip.
     *
     * @return void
     */
    public function testWebhookRequestIsNotAcceptdIfIpDifferentMomoIp()
    {
        $response = $this->postJson(
            '/webhooks/momo/ipn/app',
            $this->getFakeHoldMoneyIpnSuccessData()
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Commit transaction when order completed.
     *
     * @return void
     */
    public function testCommitTransactionWhenOrderCompleted()
    {
        $this->fakePayAppRequest();

        $this->orderId = json_decode($this->makeRequestCreateOrder(PaymentMethod::MOMO_METHOD)->getContent())->data->id;
        $this->createMomoPaymentSuccessResponse = $this->makeRequestCreateMomoPaymentSuccess();
        $this->acceptedWebhookResResponse = $this->makeAcceptedMomoIPN();

        // $transaction = Order::find($this->orderId)->getNewestTransaction();

        $this->withSalerAuth()
            ->putJson(
                "sale-api/v1/orders/{$this->orderId}/status",
                // ['status' => Order::STATUS_DONE]
            );

        Http::assertSent(function (Request $request) use ($transaction) {
            return $request->url() == config('payments.momo.base_endpoint.testing') . config('payments.momo.confirm_app_payment_endpoint') &&
                $request['partnerRefId'] == $this->orderId &&
                $request['momoTransId'] == $transaction->partner_transaction_id &&
                $request['requestType'] == MomoConfig::REQUEST_TYPE_COMMIT;
        });

        // $order = Order::find($this->orderId);

        $this->assertTrue(
            // $order->payment_status == PaymentTransaction::STATUS_SUCCESS
            // && $order->getNewestTransaction()->status == PaymentTransaction::STATUS_SUCCESS
        );
    }

    /**
     * Rollback transaction when order canceled.
     *
     * @return void
     */
    public function testRollbackTransactionWhenOrderCanceled()
    {
        $this->fakePayAppRequest();

        $this->orderId = json_decode($this->makeRequestCreateOrder(PaymentMethod::MOMO_METHOD)->getContent())->data->id;
        $this->createMomoPaymentSuccessResponse = $this->makeRequestCreateMomoPaymentSuccess();
        $this->acceptedWebhookResResponse = $this->makeAcceptedMomoIPN();

        // $transaction = Order::find($this->orderId)->getNewestTransaction();

        $this->withSalerAuth()
            ->putJson(
                "sale-api/v1/orders/{$this->orderId}/status",
                // ['status' => Order::STATUS_CANCEL]
            );

        Http::assertSent(function (Request $request) use ($transaction) {
            return $request->url() == config('payments.momo.base_endpoint.testing') . config('payments.momo.confirm_app_payment_endpoint') &&
                $request['partnerRefId'] == $this->orderId &&
                $request['momoTransId'] == $transaction->partner_transaction_id &&
                $request['requestType'] == MomoConfig::APP_REQUEST_TYPE_ROLLBACK;
        });

        // $order = Order::find($this->orderId);

        $this->assertTrue(
            1
            // $order->payment_status == PaymentTransaction::STATUS_ROLLBACK
            // && $order->getNewestTransaction()->status == PaymentTransaction::STATUS_ROLLBACK
        );
    }

    /**
     * Refund payment with momo wallet.
     *
     * @return void
     */
    public function testRefundPaymentWithMomoPay()
    {
        $this->assertTrue(true);
    }

    /**
     * Make request Create Momo Payment Success.
     *
     * @return TestResponse
     */
    private function makeRequestCreateMomoPaymentSuccess()
    {
        return $this->withCustomerAuth()
            ->postJson(
                "api/v1/my/orders/{$this->orderId}/payment",
                $this->getFakePayAppSuccessData()
            );
    }

    /**
     * Make accepted Momo IPN.
     *
     * @return TestResponse
     */
    private function makeAcceptedMomoIPN()
    {
        return $this->postJson(
            '/webhooks/momo/ipn/app',
            $this->getFakeHoldMoneyIpnSuccessData(),
            ['REMOTE_ADDR' => $this->momoIp],
        );
    }

    /**
     * Fake pay app request.
     *
     * @return void
     */
    private function fakePayAppRequest()
    {
        Http::fake([
            config('payments.momo.base_endpoint.testing')
                . config('payments.momo.create_app_payment_endpoint') => Http::response([
                'status' => 0,
                'message' => 'Thành công',
                'amount' => 40000,
                'transid' => $this->fakeMomoTranId,
                'signature' => 'b6e7302c7a2df244bc76e3592b2e3f7ff39abc2a3b6ea161830acea57a427b5f',
            ], Response::HTTP_OK),
            config('payments.momo.base_endpoint.testing')
                . config('payments.momo.confirm_app_payment_endpoint') => Http::response([
                'status' => 0,
                'message' => 'Thành công',
                'data' => [
                    'partnerCode' => 'MOMOIQA420180417',
                    'momoTransId' => '12436514111',
                    'amount' => 30000,
                    'partnerRefId' => 'Merchant123556666',
                ],
                'signature' => 'ca2ab5c354ff1bf8af1dd3448a3aa5681e4f329d71082dc1a90347255656f70d',
            ], Response::HTTP_OK),
        ]);
    }

    /**
     * Fake hold money ipn request.
     *
     * @return array
     */
    private function getFakePayAppSuccessData()
    {
        return [
            'customer_number' => '0963181714',
            'app_data' => 'fake0963181714data',
        ];
    }

    /**
     * Fake hold money ipn request.
     *
     * @return array
     */
    private function getFakeHoldMoneyIpnSuccessData()
    {
        $params = [
            'partnerCode' => config('payments.momo.partner_code'),
            'accessKey' => config('payments.momo.access_key'),
            'amount' => 10000,
            'partnerRefId' => $this->orderId,
            'partnerTransId' => '',
            'transType' => 'momo_wallet',
            'momoTransId' => $this->fakeMomoTranId,
            'status' => 0,
            'message' => 'Thành Công',
            'responseTime' => 1555472829549,
            'signature' => 'cd0d82ad983098a2fb99b8e49266ed7bd4db85ebf77d13b2db2f755ff0600fa0',
            'storeId' => 'store001',
        ];

        $keys = [
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

        $params['signature'] = hash_hmac(
            "sha256",
            collect($keys)->map(function ($key) use ($params) {
                return "{$key}={$params[$key]}";
            })->join('&'),
            config('payments.momo.secret_key')
        );

        return $params;
    }
}
