<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OvertimeRequest;
use App\Models\Overtime;
use App\Repositories\Contracts\OvertimeRepository;
use App\Repositories\Contracts\RoleRepository;
use Auth;

class OvertimeController extends Controller
{
    /**
     * StoreController constructor.
     *
     * @param OverTimeRepository $overTimeRepository
     */
    protected $overTimeRepository;
    protected $roleRepository;

    public function __construct(OvertimeRepository $overTimeRepository, RoleRepository $roleRepository)
    {
        $this->overTimeRepository = $overTimeRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $user = auth()->user();
        $overTimes = $user->isSuperAdmin()
            ? $this->overTimeRepository->getOvertimeStatus()
            : $this->overTimeRepository->overTimes();
        $myOvertimes = $this->overTimeRepository->myOverTime();
        $roles = $this->roleRepository->all();

        return view('admin.pages.overtime.index', compact('overTimes', 'myOvertimes','roles'));
    }

    public function create()
    {
        $roles = $this->roleRepository->all();
        return view('admin.pages.overtime.form',compact('roles'));
    }

    public function store(OvertimeRequest $request)
    {
        $dataCreate = [
            "user_id" => auth()->id(),
            "name" => Auth::user()->name,
            "email" =>  Auth::user()->email,
            "phone" => $request->phone,
            "address" =>  Auth::user()->address,
            "work_content" => $request->work_content,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "position" =>  Auth::user()->roles[0]->id,
            "status" => Overtime::STATUS_SEND,
        ];
        $createOverTime = $this->overTimeRepository->create($dataCreate);
        session()->flash('success', "Successfully");
        return response()->json(['store' => $createOverTime]);
    }

    public function edit($id)
    {
        $roles = $this->roleRepository->all();
        $store = Overtime::find($id);
        return view('admin.pages.overtime.form', compact('store','roles'));
    }

    public function update(OvertimeRequest $request, $id)
    {
        $dataUpdate = [
            "phone" => $request->phone,
            "work_content" => $request->work_content,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
        ];
        $store = $this->overTimeRepository->update($dataUpdate, $id);
        session()->flash('success', 'Update Success');
        return response()->json(['store' => $store]);
    }

    public function destroy($id)
    {
        $this->overTimeRepository->delete($id);
        session()->flash('success', 'Delete Success');
        return response()->json();
    }

    public function updateStatus($id)
    {
        $superAdmin = auth()->user()->isSuperAdmin();
        $lead = auth()->user()->isLeader();
        $data =  Overtime::find($id);
        if ($superAdmin) {
            $data = [
                "status" => Overtime::STATUS_CONFIRM_ADMIN,
            ];
        } elseif ($lead) {
            $data = [
                "status" => Overtime::STATUS_CONFIRM_LEAD,
            ];
        }
        $this->overTimeRepository->update($data, $id);
        session()->flash('success', ' Update Success');
        return response()->json();
    }

    public function updateStatusFail($id)
    {
        $data =  Overtime::find($id);
        $data = [
            "status" => Overtime::STATUS_FAIL,
        ];
        $this->overTimeRepository->update($data, $id);
        session()->flash('success', ' Update Success');
        return response()->json();
    }
}
