<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Repositories\Contracts\RoleRepository;
use App\Repositories\Contracts\StoreRepository;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Http\Request;

class UserController extends AdminController
{
    protected $userRepository;
    protected $roleRepository;
    protected $storeRepository;

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        StoreRepository $storeRepository
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->storeRepository = $storeRepository;
    }

    /**
     * Display a listing of the user.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.pages.users.index', [
            'roles' => $this->roleRepository->all(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\JsonResponse
     */
    public function getDatatable(Request $request)
    {
        return $this->userRepository
            ->builDataTableQuery($request->only([
                'name',
            ]))
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.pages.users.form', [
            'roles' => $this->roleRepository->all(),
            'teams' => $this->userRepository->teams()
        ]);
    }

    /**
     * Store a newly created user in database.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $user = $this->userRepository->store($validated);
        $this->userRepository->syncToRoles($user, [$validated['user_role']]);
        $this->userRepository->syncToTeams($user, [$validated['team']]);
        return redirect()->route('admin.users.index')->withSuccess(__('app.messages.success.add'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        return view('admin.pages.users.form', [
            'user' => $user,
            'roles' => $this->roleRepository->all(),
            'teams' => $this->userRepository->teams()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest $request
     * @param  User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();
        if (isset($validated['password']))
            $validated['password'] = bcrypt($validated['password']);
        $user->update($validated);
        $this->userRepository->syncToRoles($user, [$validated['user_role']]);
        $this->userRepository->syncToTeams($user, [$validated['team']]);

        return redirect()->route('admin.users.index')->withSuccess(__('app.messages.success.modify'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'success']);
    }
}
