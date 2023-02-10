<?php

namespace App\Repositories\Contracts;

use App\Models\Team;
use App\Models\User;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface UserRepository extends RepositoryInterface
{
    /**
     * DataTables using Eloquent Builder.
     *
     * @param array $params
     * @return Yajra\DataTables\EloquentDataTable
     */
    public function builDataTableQuery($params);

    /**
     * Store a newly created user in database.
     *
     * @param Array $data
     * @return User
     */
    public function store($data);

    /**
     * Sync stores which user work in
     *
     * @param User $user
     * @param array $data
     * @return array
     */
    public function syncToStores(User $user, $data);

    /**
     * Sync roles which user has
     *
     * @param User $user
     * @param array $data
     * @return array
     */
    public function syncToRoles(User $user, $data);

    public function syncToTeams(User $user, $data);

    /**
     * Store user's device token
     *
     * @param \App\Models\User $user
     * @param mixed $token
     * @return null
     */
    public function storeDeviceToken(User $user, $token);

    public function teams();
}
