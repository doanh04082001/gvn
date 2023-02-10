<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use App\Repositories\Contracts\RoleRepository;

class RoleController extends AdminController
{
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return view('admin.pages.roles', ['roles' => $this->roleRepository->getAllRoles()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Admin\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        return response()->json(
            $this->roleRepository->create($request->validated())
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Admin\RoleRequest  $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->validated());

        return response()->json($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws Illuminate\Http\Exceptions\HttpResponseException;
     */
    public function destroy(Role $role)
    {
        if ($role->name === Role::SUPER_ADMIN_NAME) {
            abort(403);
        }

        $role->delete();

        return response()->json(['message' => 'success']);
    }
}
