<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\ApplyLeaveRepository;
use App\Repositories\Contracts\OvertimeRepository;
use App\Repositories\Contracts\RoleRepository;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Http\Request;

class DashboardController extends AdminController
{
    protected $userRepository;
    protected $applyLeaveRepository;
    protected $roleRepository;
    protected $overtimeRepository;

    public function __construct(UserRepository $userRepository, ApplyLeaveRepository $applyLeaveRepository, RoleRepository $roleRepository,OvertimeRepository $overtimeRepository) {
        $this->userRepository = $userRepository;
        $this->applyLeaveRepository = $applyLeaveRepository;
        $this->roleRepository = $roleRepository;
        $this->overtimeRepository = $overtimeRepository;
    }

    public function index(){
        return view('admin.pages.dashboard', [
            'users' => $this->userRepository->all(),
            'roles' => $this->roleRepository->all(),
        ]);
    }

    // get applyLeave (filter user_id, role_id)
    public function getApplyLeaveDatatable(Request $request){   
        return $this->applyLeaveRepository->getStatistic($request);  
    }

    public function getOvertimeDatatable(Request $request){
        return $this->overtimeRepository->getStatistic($request);
    }
}