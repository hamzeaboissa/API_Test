<?php

namespace Database\Factories;

use App\Models\Category;
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
    public function definition()
    {
        $categoryIds = Category::all()->pluck('id');
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomNumber(),
            'category_id' => $this->faker->randomElement($categoryIds),
        ];
    }
}
