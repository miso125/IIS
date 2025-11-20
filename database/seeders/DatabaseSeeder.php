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
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            WineyardRowSeeder::class,
            TreatmentSeeder::class,
            HarvestSeeder::class,
            WineBatchSeeder::class,
            PurchaseSeeder::class,
        ]);
    }
}
