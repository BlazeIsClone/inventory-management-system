<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed raw products to the database.
     */
    public function run(): void
    {
        User::factory(1)->create();
    }
}
