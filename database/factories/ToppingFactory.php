<?php

namespace Database\Factories;

use App\Models\Topping;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToppingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Topping::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $price = $this->faker->numberBetween(40, 200);

        return [
            'name' => $this->faker->sentence(5),
            'description' => $this->faker->sentence(20),
            'status' => Topping::STATUS_ACTIVE,
            'cost' => (int) ($price * $this->faker->numberBetween(50, 70) / 100) * 1000,
        ];
    }
}
