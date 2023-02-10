<?php

namespace App\Repositories\Contracts;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface RoleRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface RoleRepository extends RepositoryInterface
{
    /**
     * Get all roles
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllRoles(): Collection;

    /**
     * Where role not is Super Admin
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function whereNotSuperAdmin();

    /**
     * Map role with permission
     *
     * @param Role $role
     * @return array
     */
    public function getRolePermissionMap(Role $role): array;

    /**
     * Assign or revoke permission to role
     *
     * @param Role $role
     * @param array $map
     *
     * @return void
     */
    public function assignOrRevokePermissionsOfRole(Role $role, array $map): void;
}
