<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call custom seeders
        $this->call([
            ServiceSeeder::class,  // ✅ add our services seeder here
        ]);
    }
}
