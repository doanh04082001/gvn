<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Contracts\PermissionRepository;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PermissionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    /**
     * Get all permission group
     *
     * @return array
     */
    public function getAllGroups(): array
    {
        return array_keys(Permission::GROUPS);
    }

    /**
     * Get user's permissions 
     *
     * @return Illuminate\Support\Collection
     */
    public function getMyPermissions()
    {
        $user = auth()->user();

        $allPermissions = Collect(Permission::GROUPS);
        $userPermissions = $user->getAllPermissions()->pluck('name');
        $groupPermissions = $allPermissions->keys();

        $userPermissions->intersect($groupPermissions)
            ->each(function($userGroupPermission) use (&$userPermissions, $allPermissions) {
                $userPermissions = $userPermissions->concat($allPermissions->get($userGroupPermission));
            });

        return $userPermissions->unique()
            ->diff($groupPermissions)
            ->values();
    }
}
