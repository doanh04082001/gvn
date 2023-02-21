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
        $office = Role::firstOrCreate([
            'guard_name' => ADMIN_RESOURCE,
            'name' => Role::OFFICE
        ]);
        $superAdmin = User::where('email', env('SUPER_ADMIN_ID', 'admin@example.com'))->first();
        if ($superAdmin) {
            $superAdmin->assignRole($superAdminRole);
        }
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
        $roleAdmin = Role::where('name', Role::SUPER_ADMIN_NAME)->first();
        if($roleAdmin){
            $roleAdmin->givePermissionTo($roles);
        }

        $roleStaff = Role::where('name', Role::STAFF)->first();
        if($roleStaff){
            $roleStaff->givePermissionTo(Permission::GROUPS['apply_leaves'],Permission::GROUPS['overtimes']);
        }

        $roleLeader = Role::where('name', Role::LEADER)->first();
        if($roleLeader){
            $roleLeader->givePermissionTo(Permission::GROUPS['apply_leaves'],Permission::GROUPS['overtimes'],Permission::GROUPS['confirm_from_leader']);
        }

        $roleOffice = Role::where('name', Role::OFFICE)->first();
        if($roleOffice){
            $roleOffice->givePermissionTo(Permission::GROUPS['apply_leaves'],Permission::GROUPS['overtimes'],Permission::GROUPS['statistics']);
        }
       
       
    }
}
