<?php

namespace Database\Seeders;

use App\Models\FinishProduct;
use Illuminate\Database\Seeder;

class FinishProductSeeder extends Seeder
{
    /**
     * Seed raw products to the database.
     */
    public function run(): void
    {
        FinishProduct::factory(50)->create();
    }
}
