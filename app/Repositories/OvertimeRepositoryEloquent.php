<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\Contracts\OvertimeRepository;
use App\Models\Overtime;
use DB;

/**
 * Class OvertimeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OvertimeRepositoryEloquent extends BaseRepository implements OvertimeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OverTime::class;
    }

    public function myOverTime()
    {
        return OverTime::where('user_id', '=', auth()->id())->get();
    }

    public function overTimes()
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
            $listApplyLeaveByIds = OverTime::whereIn('user_id', $arrIdUserOfTeams)->where('status', '!=', Overtime::STATUS_CONFIRM_ADMIN)->latest()->get();
            return $listApplyLeaveByIds;
    }

    public function getOvertimeStatus()
    {
        return OverTime::latest()->get();
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
            return $q->where('status', '=', $status)->where('status', Overtime::STATUS_CONFIRM_ADMIN);
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
