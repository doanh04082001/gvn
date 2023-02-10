<?php

namespace Database\Factories;

use App\Models\Promotion;
use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Promotion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startAt = $this->faker->dateTimeBetween('-1 week', 'now');
        $type = $this->faker->randomElement([Promotion::TYPE_SAME_PRICE, Promotion::TYPE_PERCENT]);
        $discountAmount = $this->faker->numberBetween(10, 70);

        return [
            'discount_value' => $type == Promotion::TYPE_PERCENT ? $discountAmount : $discountAmount * 1000,
            'max_discount_amount' => $type == Promotion::TYPE_PERCENT ? $this->faker->numberBetween(30, 50) * 1000 : null,
            'type' => $type,
            'start_at' => $startAt,
            'expire_at' => (clone $startAt)->add(new DateInterval('PT' . rand(50, 1440) . 'H')),
            'positions' => [Promotion::POSITION_TOP, Promotion::POSITION_MIDDLE],
            'status' => Promotion::STATUS_ACTIVE,
            'description' => 'Ăn gà thả ga',
        ];
    }
}
