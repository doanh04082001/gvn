<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSuperAdmin();
        $this->createAndAssignPermissions();
    }

    /**
     * Create Super Admin record
     *
     * @return void
     */
    private function createSuperAdmin()
    {
        $superAdminRole = Role::firstOrCreate([
            'guard_name' => ADMIN_RESOURCE,
            'name' => Role::SUPER_ADMIN_NAME
        ]);
        $leader = Role::firstOrCreate([
            'guard_name' => ADMIN_RESOURCE,
            'name' => Role::LEADER
        ]);
        $staff = Role::firstOrCreate([
            'guard_name' => ADMIN_RESOURCE,
            'name' => Role::STAFF
        ]);
        $superAdmin = User::where('email', env('SUPER_ADMIN_ID', 'superadmin@shilin.vn'))->first();
        if ($superAdmin) {
            $superAdmin->assignRole($superAdminRole, $leader);
        }

        $leader = User::where('email', '=', 'nv@gmail.com')->first();
        if ($leader) {
            $leader->assignRole('staff');
        }

        // $staff = User::where('email', 'nv@gmail.com')->first();
        // if ($staff) {
        //     $staff->assignRole($staff);
        // }
    }

    /**
     * Random to create fake roles
     * Create permissions from Permission::Groups
     * Random to assign permissions to role
     *
     * @return void
     */
    private function createAndAssignPermissions()
    {
        $roles = Role::all();
        foreach (Permission::GROUPS as $group => $permissions) {
            Permission::firstOrCreate(['guard_name' => ADMIN_RESOURCE, 'name' => $group]);
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['guard_name' => ADMIN_RESOURCE, 'name' => $permission]);
            }
        }

        $permissions = Permission::all();
        $roles->each(function (Role $role) use ($permissions) {
            $role->givePermissionTo($permissions->random(2, $permissions->count()));
        });
    }
}
