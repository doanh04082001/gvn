<?php

namespace Database\Factories;

use App\Models\Voucher;
use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoucherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Voucher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = $this->faker->randomElement([Voucher::TYPE_PERCENT, Voucher::TYPE_FIX]);
        $discountAmount = $this->faker->numberBetween(5, 70);
        $startAt = $this->faker->dateTimeBetween('-1 month', '+1 month');

        return [
            'description' => 'Ăn gà thả ga cùng hàng ngàn voucher từ Shilin',
            'status' => Voucher::STATUS_ACTIVE,
            'start_at' => $startAt,
            'expire_at' => (clone $startAt)->add(new DateInterval('PT' . rand(30, 1440) . 'H')),
            'type' => $type,
            'discount_amount' => $type == Voucher::TYPE_PERCENT ? $discountAmount : ($discountAmount * 1000),
            'max_discount_amount' => $type == Voucher::TYPE_PERCENT ? $this->faker->numberBetween(30, 50) * 1000 : null,
            'min_order_amount' => $this->faker->numberBetween(80, 150) * 1000,
            'apply_count' => $this->faker->numberBetween(0, 30),
            'max_apply' => $this->faker->numberBetween(50, 100),
        ];
    }
}
