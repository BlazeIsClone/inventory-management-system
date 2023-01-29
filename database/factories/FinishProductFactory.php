<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FinishProduct>
 */
class FinishProductFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'labour_percentage' => fake()->randomElement([2_000, 5_000, 10_000]),
            'sales_price' => fake()->randomNumber(4),
        ];
    }
}
