<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RawProduct>
 */
class RawProductFactory extends Factory
{
    private static array $rawProducts = [
        'flour',
        'sugar',
        'salt',
        'baking powder',
        'butter',
        'eggs',
        'milk',
        'vanilla extract',
        'lemon zest',
        'cocoa powder',
        'chocolate chips',
        'chopped nuts',
        'dried fruit',
        'yeast',
        'water',
        'olive oil',
        'garlic',
        'onion',
        'bell pepper',
        'mushrooms',
        'tomatoes',
        'spinach',
        'kale',
        'lettuce',
        'cabbage',
        'carrots',
        'potatoes',
        'sweet potatoes',
        'corn',
        'peas',
        'green beans',
        'lima beans',
        'chickpeas',
        'lentils',
    ];

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(Self::$rawProducts),
            'unit' => fake()->randomElement(['ton', 'kg', 'g', 'mg']),
        ];
    }
}
