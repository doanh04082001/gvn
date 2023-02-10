<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PermissionRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface PermissionRepository extends RepositoryInterface
{
    /**
     * Get all permission group
     *
     * @return array
     */
    public function getAllGroups(): array;

    /**
     * Get user's permissions 
     *
     * @return Illuminate\Support\Collection
     */
    public function getMyPermissions();
}
