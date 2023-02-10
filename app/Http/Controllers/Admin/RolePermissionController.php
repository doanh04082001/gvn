<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RolePermissionRequest;
use App\Models\Role;
use App\Repositories\Contracts\PermissionRepository;
use App\Repositories\Contracts\RoleRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends AdminController
{
    public function __construct(
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Role $role)
    {
        return view('admin.pages.permissions', [
            'roles' => $this->roleRepository->getAllRoles(),
            'role' => $role,
            'mapping' => $this->roleRepository->getRolePermissionMap($role),
            'languages' => __('permissions'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RolePermissionRequest $request, Role $role)
    {
        DB::beginTransaction();
        try {
            $this->roleRepository->assignOrRevokePermissionsOfRole(
                $role,
                $request->only(
                    $this->permissionRepository->getAllGroups()
                )
            );

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(
                [
                    'error' => __('app.permissions.Changed permissions fail.'),
                    'message' => $e->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response()->json($this->roleRepository->getRolePermissionMap($role));
    }

    /**
     * Redirect to setting permissions page for first role
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        $firstRole = $this->roleRepository->whereNotSuperAdmin()->first();

        return empty($firstRole)
            ? redirect()->route('admin.roles.index')
            : redirect()->route('admin.roles.permissions.index', ['role' => $firstRole->id]);
    }
}
