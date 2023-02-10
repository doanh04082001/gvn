<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->sentence(20),
            'images' => [UploadedFile::fake()->image(Str::random(10) . '.png')],
            'rating' => $this->faker->numberBetween(3, 5),
            'status' => $this->faker->numberBetween(Review::STATUS_ACTIVE, Review::STATUS_INACTIVE),
        ];
    }
}
