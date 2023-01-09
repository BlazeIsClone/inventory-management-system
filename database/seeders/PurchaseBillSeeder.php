<?php

namespace Database\Seeders;

use App\Models\PurchaseBill;
use App\Models\RawProduct;
use Illuminate\Database\Seeder;

class PurchaseBillSeeder extends Seeder
{
    /**
     * Seed raw products to the database.
     */
    public function run(): void
    {
        PurchaseBill::factory(25)->create();

        foreach (PurchaseBill::all() as $purchaseBill) {
            $rawProducts = RawProduct::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $attributes = ['product_quantity' => rand(1, 100), 'product_price' => rand(1_00, 10_000)];

            $purchaseBill->rawProducts()->attach($rawProducts, $attributes);
        }
    }
}
