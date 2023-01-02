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
            $purchaseBill->rawProducts()->attach($rawProducts);
        }
    }
}
