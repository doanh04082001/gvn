<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseTestSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            UserSeeder::class,
            TaxonomySeeder::class,
            RoleAndPermissionSeeder::class,
            CustomerSeeder::class,
        ];

        $this->call($seeders);
    }
    // StoreSeeder::class,
    // AhamoveSettingSeeder::class,
    // ProductSeeder::class,
    // PaymentMethodSeeder::class,
}
