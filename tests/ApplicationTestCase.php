<?php

namespace Tests;

use App\Models\Customer;
// use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class ApplicationTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Add authorization token of customer for the request.
     *
     * @return $this
     */
    protected function withCustomerAuth()
    {
        // return $this->withToken(auth()
        //         ->guard('api')
        //         ->login(Customer::first())
        // );
    }

    /**
     * Add authorization token of customer for the request.
     *
     * @return $this
     */
    protected function withSalerAuth()
    {
        // return $this->withToken(
        //     auth()
        //         ->guard('sale-api')
        //         ->login(User::first())
        // );
    }

    /**
     * Get mock order create data with payment method.
     *
     * @param  string $paymentMethod
     * @return array
     */
    protected function getDataCreateOrder($paymentMethod)
    {
        return [
            'store_id' => Store::first()->id,
            'phone' => '0345678910',
            'payment_method' => $paymentMethod,
            'shipping_name' => 'Mr.Tester',
            'shipping_address' => 'Miss Ao Dai Building, 21 Nguyễn Trung Ngạn, Bến Nghé, Quận 1, Hồ Chí Minh, Vietnam',
            // 'delivery_type' => Order::DELIVERY_TYPE_SHIPPING,
            'products' => [
                [
                    'id' => Product::first()->id,
                    'toppings' => [],
                    'quantity' => 1,
                ],
            ],
        ];
    }

    /**
     * Make Request Create Order
     *
     * @param string $paymentMethod
     * @return \Illuminate\Testing\TestResponse
     */
    protected function makeRequestCreateOrder($paymentMethod)
    {
        return $this->withCustomerAuth()
            ->postJson(
                '/api/v1/my/orders',
                $this->getDataCreateOrder($paymentMethod)
            );
    }
}
