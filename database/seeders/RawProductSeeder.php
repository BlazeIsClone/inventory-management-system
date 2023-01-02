<?php

namespace Database\Seeders;

use App\Models\PurchaseBill;
use App\Models\RawProduct;
use Illuminate\Database\Seeder;

class RawProductSeeder extends Seeder
{
    /**
     * Seed raw products to the database.
     */
    public function run(): void
    {
        RawProduct::factory(150)->create();
    }
}
