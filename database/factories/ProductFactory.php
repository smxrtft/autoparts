<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'slug' => $this->faker->slug,
            'category_id' => 1,
            'status_id' => 1,
            'hit' => 0,
            'sale' => 0,
            'price' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}
