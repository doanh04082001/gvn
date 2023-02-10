<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use App\Repositories\Contracts\RoleRepository;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RoleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    /**
     * Get all roles except Super Admin
     *
     * @return Collection
     */
    public function getAllRoles(): Collection
    {
        return $this->whereNotSuperAdmin()
            ->get();
    }

    /**
     * Where role not is Super Admin
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function whereNotSuperAdmin()
    {
        return $this->where('name', '<>', Role::SUPER_ADMIN_NAME);
    }

    /**
     * Map role with permission
     *
     * @param Role $role
     * @return array
     */
    public function getRolePermissionMap(Role $role): array
    {
        $map = [];

        foreach (Permission::GROUPS as $group => $permissions) {
            $map[$group] = [
                'hasGroupPermission' => false,
                'permissions' => array_fill_keys($permissions, false),
            ];

            if ($role->hasPermissionTo($group)) {
                $map[$group]['hasGroupPermission'] = true;
                $map[$group]['permissions'] = array_fill_keys($permissions, true);

                continue;
            }

            $map[$group]['hasGroupPermission'] = $this->mapRoleWithGroupPermissions(
                $role,
                $permissions,
                $map[$group],
            );
        }

        return $map;
    }

    /**
     * Each permission of a group to assign that to map
     * And return has group permissions or no
     *
     * @param Role $role
     * @param array $groupPermissions
     * @param array &$groupMap
     * @return bool
     */
    private function mapRoleWithGroupPermissions(
        Role $role,
        array $groupPermissions,
        array &$groupMap
    ) {
        $hasGroupPermission = true;

        foreach ($groupPermissions as $permission) {
            $hasPermission = $role->hasPermissionTo($permission);
            $groupMap['permissions'][$permission] = $hasPermission;
            $hasGroupPermission = $hasGroupPermission && $hasPermission;
        }

        return $hasGroupPermission;
    }

    /**
     * Assign or revoke permission to role
     *
     * @param Role $role
     * @param array $map
     *
     * @return void
     */
    public function assignOrRevokePermissionsOfRole(Role $role, array $map): void
    {
        foreach ($map as $group => $permissionMap) {
            if ($permissionMap['hasGroupPermission']) {
                $role->givePermissionTo($group);

                continue;
            }

            $this->changeGroupPermissionsOfRole(
                $role,
                $group,
                $permissionMap['permissions']
            );
        }
    }

    /**
     * Assign or revoke permission of a group to role
     *
     * @param Role $role
     * @param string $group
     * @param array $groupPermissionsMap
     * @return void
     */
    private function changeGroupPermissionsOfRole(
        Role $role,
        string $group,
        array $groupPermissionsMap
    ) {
        $needToAssignGroup = true;

        foreach ($groupPermissionsMap as $permission => $needToAssign) {
            $needToAssignGroup = $needToAssignGroup && $needToAssign;
            $changeAction = $needToAssign ? 'givePermissionTo' : 'revokePermissionTo';
            $role->{$changeAction}($permission);
        }

        $changeGroupAction = $needToAssignGroup ? 'givePermissionTo' : 'revokePermissionTo';
        $role->{$changeGroupAction}($group);
    }
}
