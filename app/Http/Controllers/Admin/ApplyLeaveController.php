<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ApplyLeaveRequest;
use App\Models\ApplyLeave;
use App\Repositories\Contracts\ApplyLeaveRepository;
use App\Repositories\Contracts\RoleRepository;
use Auth;
class ApplyLeaveController extends AdminController
{
    protected $applyLeaveRepository;
    protected $roleRepository;
    
    public function __construct(ApplyLeaveRepository $applyLeaveRepository, RoleRepository $roleRepository)
    {
        $this->applyLeaveRepository = $applyLeaveRepository;
        $this->roleRepository = $roleRepository;
    }
    public function index()
    {
        $user = auth()->user();
        $apply_leaves = $user->isSuperAdmin()
            ? $this->applyLeaveRepository->getApplyLeaveStatus()
            : ($user->isLeader() ?  $this->applyLeaveRepository->applyLeaves() : "");
        $my_leaves = $this->applyLeaveRepository->myApplyLeaves();
        $roles = $this->roleRepository->all();
        return view('admin.pages.apply-leave.index', compact('apply_leaves', 'my_leaves','roles'));
    }

    /**
     * Show the form for creating a new store.
     *
     */
    public function create()
    {
        $roles = $this->roleRepository->all();
        $isEdit = false;
        return view('admin.pages.apply-leave.form', compact('roles','isEdit'));
    }

    public function store(ApplyLeaveRequest $request)
    {
        $dataCreate = [
            "user_id" => auth()->id(),
            "name" => Auth::user()->name,
            "email" => Auth::user()->email,
            "phone" => $request->phone,
            "address" => Auth::user()->address,
            "reason" => $request->reason,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "position" =>  Auth::user()->roles[0]->id,
            "status" => ApplyLeave::STATUS_SEND,
        ];
        $createApplyLeave = $this->applyLeaveRepository->create($dataCreate);
        session()->flash('success', "Successfully");
        return response()->json(['store' => $createApplyLeave]);
    }

    public function edit($id)
    {
        return view('admin.pages.apply-leave.form', [
            'isEdit' => true,
            'roles' => $this->roleRepository->all(),
            'store' => $this->applyLeaveRepository->applyLeaveEdit($id),
        ]);
    }

    /**
     * Update the specified store in database.
     *
     * @param ApplyLeaveRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ApplyLeaveRequest $request, $id)
    {
        $dataUpdate = [
            "phone" => $request->phone,
            "reason" => $request->reason,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
        ];
        $store = $this->applyLeaveRepository->update($dataUpdate, $id);
        session()->flash('success', 'Update Success');
        return response()->json(['store' => $store]);
    }


    /**
     * Remove the specified store from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->applyLeaveRepository->delete($id);
        session()->flash('success', 'Delete Success');
        return response()->json();
    }

    public function updateStatus($id)
    {
        $superAdmin = auth()->user()->isSuperAdmin();
        $lead = auth()->user()->isLeader();
        $data =  ApplyLeave::find($id);
        if ($superAdmin) {
            $data = ["status" => ApplyLeave::STATUS_SUCCESS,];
        } elseif ($lead) {
            $data = ["status" => ApplyLeave::STATUS_CONFIRM_LEAD,];
        }
        $this->applyLeaveRepository->update($data, $id);
        session()->flash('success', ' Update Success');
        return response()->json();
    }

    public function updateStatusFail($id)
    {
        $data =  ApplyLeave::find($id);
        $data = [
            "status" => ApplyLeave::STATUS_FAIL,
        ];
        $this->applyLeaveRepository->update($data, $id);
        session()->flash('success', ' Update Success');
        return response()->json();
    }

   
}
