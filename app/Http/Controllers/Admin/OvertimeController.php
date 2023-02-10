<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OvertimeRequest;
use App\Models\Overtime;
use App\Repositories\Contracts\OvertimeRepository;
use Auth;

class OvertimeController extends Controller
{
    /**
     * StoreController constructor.
     *
     * @param OverTimeRepository $overTimeRepository
     */
    protected $overTimeRepository;
    public function __construct(OvertimeRepository $overTimeRepository)
    {
        $this->overTimeRepository = $overTimeRepository;
    }

    public function index()
    {
        $user = auth()->user();
        $overTimes = $user->isSuperAdmin()
            ? $this->overTimeRepository->getOvertimeStatus()
            : $this->overTimeRepository->overTimes();
        $myOvertimes = $this->overTimeRepository->myOverTime();
        return view('admin.pages.overtime.index', compact('overTimes', 'myOvertimes'));
    }

    public function create()
    {
        return view('admin.pages.overtime.form');
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
            "position" =>  preg_replace('/[^0-9]/', '', $request->position),
            "status" => 0,
        ];
        $createOverTime = $this->overTimeRepository->create($dataCreate);
        session()->flash('success', "Successfully");
        return response()->json(['store' => $createOverTime]);
    }

    public function edit($id)
    {
        $store = Overtime::find($id);
        return view('admin.pages.overtime.form', compact('store'));
    }

    public function update(OvertimeRequest $request, $id)
    {
        $dataUpdate = [
            "phone" => $request->phone,
            "work_content" => $request->work_content,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "position" =>  preg_replace('/[^0-9]/', '', $request->position),
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
                "status" => 2,
            ];
        } elseif ($lead) {
            $data = [
                "status" => 1,
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
            "status" => 3,
        ];
        $this->overTimeRepository->update($data, $id);
        session()->flash('success', ' Update Success');
        return response()->json();
    }
}
