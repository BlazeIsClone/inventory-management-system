<?php

namespace Database\Factories;

use App\Models\RawProduct;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseBill>
 */
class PurchaseBillFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'vendor_id' => Vendor::factory(),
            'purchase_date' => fake()->date(),
            'sub_total' => fake()->numberBetween(100, 10_000),
            'payment_bill' => fake()->imageUrl(),
            'payment_bill_note' => fake()->paragraph(),
        ];
    }
}
