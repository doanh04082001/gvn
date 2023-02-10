<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->email(),
            'password' => bcrypt('abc123456'),
            'status' => Customer::STATUS_ACTIVE,
            'points' => $this->faker->numberBetween(0, 1000),
            'phone' => '0' . rand(100000000, 999999999),
            'birthday' => $this->faker->dateTimeBetween('-60 years', '-10 years'),
            'note' => $this->faker->paragraph(),
            'orders_count' => $this->faker->numberBetween(0, 5),
            'verified_at' => now(),
        ];
    }
}
