<?php

namespace Database\Factories;

// use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $price = $this->faker->numberBetween(50, 150);
        $promotion_id = $this->faker->randomElement([null, Promotion::inRandomOrder()->first()->id]);

        return [
            // 'order_id' => $this->faker->randomElement(Order::all()->pluck('id')),
            'promotion_id' => $promotion_id,
            'note' => $this->faker->paragraph(3),
            'quantity' => 1,
            'price' => $price * 1000,
            'sale_price' => $promotion_id
                ? (($price - $this->faker->numberBetween(5, 20)) * 1000)
                : ($price * 1000),
        ];
    }
}
