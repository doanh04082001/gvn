<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Traits\DeviceToken;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    use DeviceToken;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function getUsers()
    {
        return $this->all();
    }

    /**
     * DataTables using Eloquent Builder.
     *
     * @param array $params
     * @return Yajra\DataTables\EloquentDataTable
     */
    public function builDataTableQuery($params)
    {
        return dataTables()
            ->eloquent(
                $this->model->query()->with('roles:id,name')
            )
            ->filter(function ($query) {
                if (!auth()->user()->hasRole(Role::SUPER_ADMIN_NAME)) {
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', '<>', Role::SUPER_ADMIN_NAME);
                    });
                }
            })
            ->filterColumn('roles.name', function ($query, $keyword) {
                $query->whereHas('roles', function ($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            });
    }

    /**
     * Store a newly created user in database.
     *
     * @param Array $data
     * @return User
     */
    public function store($data)
    {
        $data['password'] = bcrypt($data['password']);

        return $this->create($data);
    }

    /**
     * Sync stores which user work in
     *
     * @param User $user
     * @param array $data
     * @return array
     */
    public function syncToStores(User $user, $data)
    {
        return $user->stores()->sync($data);
    }

    /**
     * Sync roles which user has
     *
     * @param User $user
     * @param array $data
     * @return array
     */
    public function syncToRoles(User $user, $data)
    {
        return $user->roles()->sync($data);
    }

    public function syncToTeams(User $user, $data)
    {
        return $user->teams()->sync($data);
    }

    public function teams()
    {
        return Team::all();
    }
}
