<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '-1');

        $seeders = [
            UserSeeder::class,
            RoleAndPermissionSeeder::class,
            TeamSeeder::class,
            AddRevenueStatisticPermissionSeeder::class,
        ];

        DB::transaction(function () use ($seeders) {
            $this->call($seeders);
        });
    }
}
