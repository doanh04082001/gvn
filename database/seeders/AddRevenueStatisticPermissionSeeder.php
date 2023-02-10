<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class AddRevenueStatisticPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate([
            'guard_name' => ADMIN_RESOURCE,
            'name' => Permission::STATISTIC_GROUP
        ]);

        foreach (Permission::GROUPS[Permission::STATISTIC_GROUP] as $permission) {
            Permission::firstOrCreate([
                'guard_name' => ADMIN_RESOURCE,
                'name' => $permission
            ]);
        }
    }
}
