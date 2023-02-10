<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Store;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $customer = Customer::inRandomOrder()->first();
        $status = $this->faker->randomElement(Order::STATUS_ALLOWS);

        return [
            'store_id' => $this->faker->randomElement(Store::all()->pluck('id')),
            'customer_id' => $customer->id,
            'voucher_id' => $this->faker->randomElement([null, Voucher::inRandomOrder()->first()->id]),
            'status' => $status,
            'delivery_type' => $this->faker->randomElement([
                Order::DELIVERY_TYPE_SHIPPING,
                Order::DELIVERY_TYPE_AT_STORE,
            ]),
            'received_at' => $status != Order::STATUS_CANCEL ? $this->faker->dateTimeBetween('now', '+45 minutes') : null,
            'amount' => $this->faker->numberBetween(100, 2000) * 1000,
            'discount' => $this->faker->randomElement([0, $this->faker->numberBetween(5, 20) * 1000]),
            'payment_method' => $this->faker->randomElement([
                PaymentMethod::CASH_METHOD,
                PaymentMethod::ATM_METHOD,
                PaymentMethod::VISA_METHOD,
                PaymentMethod::MOMO_METHOD,
                PaymentMethod::AIRPAY_METHOD,
            ]),
            'email' => $customer->email,
            'phone' => $customer->phone,
            'shipping_name' => $this->faker->name(),
            'shipping_address' => $this->faker->address(),
            'note' => $this->faker->paragraph(3),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
        ];
    }
}
