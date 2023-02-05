<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Seed raw products to the database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Maya',
            'email' => 'mayalkdevelopers@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin@mayalk'),
            'remember_token' => Str::random(10),
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin@super'),
            'remember_token' => Str::random(10),
        ]);
    }
}
