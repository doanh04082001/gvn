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
        $user = auth()->user();
        if ($user->isLeader()) {
            $teams = $user->teams;
            foreach ($teams as $key => $team) {
                $result = DB::table('team_user')
                    ->where('team_id', $team->id)
                    ->get();
                $userOfTeam = collect($result);
                $arrIdUserOfTeams = [];
                foreach ($userOfTeam as $key => $user) {
                    $arrIdUserOfTeams[] = $user->user_id;
                }
                $arrIdUserOfTeams = array_diff($arrIdUserOfTeams, [auth()->id()]);
                $listApplyLeaveByIds = OverTime::whereIn('user_id', $arrIdUserOfTeams)
                    ->get();
                return $listApplyLeaveByIds;
            }
        }
        return OverTime::where('user_id', '!=', auth()->id())->orderBy('created_at', 'DESC')->get();
    }

    public function getOvertimeStatus()
    {
        return OverTime::where('status', '=', '1')->get();
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
}
