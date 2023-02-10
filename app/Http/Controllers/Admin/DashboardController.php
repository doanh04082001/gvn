<?php

namespace App\Http\Controllers\Admin;

// use App\Models\Order;

use App\Models\ApplyLeave;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Contracts\ApplyLeaveRepository;
use App\Repositories\Contracts\CustomerRepository;
use App\Repositories\Contracts\RoleRepository;
// use App\Repositories\Contracts\OrderRepository;
use App\Repositories\Contracts\StoreRepository;
use App\Repositories\Contracts\UserRepository;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends AdminController
{
    protected $userRepository;
    protected $applyLeaveRepository;
    protected $roleRepository;

    public function __construct(UserRepository $userRepository, ApplyLeaveRepository $applyLeaveRepository, RoleRepository $roleRepository) {
        $this->userRepository = $userRepository;
        $this->applyLeaveRepository= $applyLeaveRepository;
        $this->roleRepository= $roleRepository;
    }

    public function index(Request $params){
        return view('admin.pages.dashboard', [
            'users' => $this->userRepository->all(),
            'roles' => $this->roleRepository->all(),
        ]);
    }

    /**
     * Get pending order datatable json.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getApplyLeaveDatatable(Request $request)
    {   
        return  $this->applyLeaveRepository->getStatistic([
            // 'user_id'=>'de7dd006-6463-45f0-b88d-081c42e6a298',
            // 'start_date'=>'2023-01-01 00:00:00',
            // 'end_date'=>'2023-02-01 00:00:00',
            // 'role_id' => 'e89c7893-7278-460f-97b6-69ee66c44cf4',
        ]);
        
        // return  $this->applyLeaveRepository->getStatistic($request);
    }

    /**
     * Get processing order datatable json.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProcessingOrderDatatable(Request $request)
    {
        // return $this->orderRepository
        //     ->buildOrderDatatableByStatus(Order::STATUS_PROCESSING)
        //     ->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBarChartData(Request $request)
    {
        // return response()->json(
        //     $this->orderRepository->buildBarChartData($request->store_id, $request->timezone)
        // );
    }

    /**
     * Get data statistical.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatistical(Request $request)
    {
        // return response()->json(array_merge(
        //     $this->orderRepository->buildStatisticalData(
        //         $request->store_id,
        //         $request->timezone
        //     ),
        //     [
        //         'total_customer' => $this->customerRepository
        //             ->getTotalCustomerCreatedToday(
        //                 $request->timezone
        //             )
        //     ]

        // ));
    }
}
