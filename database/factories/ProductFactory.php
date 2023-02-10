<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Taxonomy;
use App\Models\TaxonomyItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rating_count = $this->faker->numberBetween(0, 30);

        return [
            'sku' => $this->faker->lexify('???????????'),
            'unit_id' => $this->faker->randomElement(TaxonomyItem::where('taxonomy_id', Taxonomy::PRODUCT_UNIT_ID)->pluck('id')->toArray()),
            'description' => $this->faker->sentence(20),
            'status' => Product::STATUS_ACTIVE,
            'sold' => $this->faker->numberBetween(0, 1000),
            'rating_count' => $rating_count,
            'rating' => !empty($rating_count) > 0 ? $this->faker->randomFloat(1, 4, 5) : null,
        ];
    }
}
