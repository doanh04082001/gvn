<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\ApplyLeaveRepository;
use App\Models\ApplyLeave;
use App\Models\User;
use DB;

/**
 * Class ApplyLeaveRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ApplyLeaveRepositoryEloquent extends BaseRepository implements ApplyLeaveRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ApplyLeave::class;
    }

    public function myApplyLeaves()
    {
        return ApplyLeave::where('user_id', '=', auth()->id())->orderBy('created_at', 'DESC')->get();
    }

    public function applyLeaveEdit($id){
        return ApplyLeave::findOrFail($id);
    }

    public function applyLeaves()
    {
        $teams = auth()->user()->teams;
            $arrIdUserOfTeams = [];
            foreach ($teams as $team) {
                $result = DB::table('team_user')
                    ->where('team_id', $team->id)
                    ->get();
                $userOfTeam = collect($result);
                foreach ($userOfTeam as $user) {
                    $arrIdUserOfTeams[] = $user->user_id;
                }
                $arrIdUserOfTeams = array_diff($arrIdUserOfTeams, [auth()->id()]);
            }
            $listApplyLeaveByIds = ApplyLeave::whereIn('user_id', $arrIdUserOfTeams)->where('status', '!=', ApplyLeave::STATUS_SUCCESS)->latest()->get();
            return $listApplyLeaveByIds;    
    }

    public function getApplyLeaveStatus()
    {
        return ApplyLeave::latest()->get();
    }

    /**
     * Get store list.
     *
     * @param array $params
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getStores(array $params): Collection
    {
        $keyword = $params['keyword'] ?? '';

        return $this->when($keyword != '', function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . escapeLike($keyword) . '%')
                ->orWhere('address', 'like', '%' . escapeLike($keyword) . '%');
        })
            ->get();
    }

    /**
     * Get stores with current admin
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getStoresForAdmin(): Collection
    {
        $admin = auth()->user();

        return $admin->isSuperAdmin()
            ? $this->get()
            : $admin->stores;
    }

    // public function buildOrderDatatableByStatus($status)
    // {
    //     // return 
    //     $idUsers = [];
    //     $users = User::all();
        
    // }
    public function buildOrderDatatableByStatus($status)
    {
        return dataTables()
            ->eloquent(
                $this->buildLastOrderQuery()
                    ->where('status', $status)
            );
    }
    public function buildLastOrderQuery()
    {
        return $this->orderBy('created_at', 'ASC');
    }

    public function getStatistic($params) {
        $user_id = $params['user_id'] ?? null;
        $start_date = $params['start_date'] ?? null;
        $end_date = $params['end_date'] ?? null;
        $role_id = $params['role_id'] ?? null;
        $status = 2;
        return $this->when($user_id, function($q, $user_id) {
            return $q->where('user_id', $user_id);
        })
        ->when($start_date, function($q, $start_date){
            return $q->where('start_date', '>=', $start_date);
        })
        ->when($end_date, function($q, $end_date){
            return $q->where('end_date', '<=', $end_date);
        })
        ->when($status, function($q, $status){
            return $q->where('status', '=', $status)->where('status', 2);
        })
        ->when($role_id, function($q) use ($role_id) {
            $q->whereHas('users', function($q) use ($role_id) {
                $q->whereHas('roles', function($q) use ($role_id) {
                    $q->where('id', $role_id);
                });
            });
        })
        ->get()->toArray();
    }

}
