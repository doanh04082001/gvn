<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use Illuminate\Http\Response;
use App\Http\Requests\Admin\StoreRequest;
use App\Repositories\Contracts\StoreRepository;

class StoreController extends AdminController
{
    /**
     * StoreController constructor.
     *
     * @param StoreRepository $storeRepository
     */
    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * Display a listing of the store.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = auth()->user();

        $stores = $user->isSuperAdmin()
            ? $this->storeRepository->all()
            : $user->stores;

        return view('admin.pages.stores.index', ['stores' => $stores]);
    }

    /**
     * Show the form for creating a new store.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.pages.stores.form');
    }

    /**
     * Show the form for editing the specified store.
     *
     * @param Store $store
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Store $store)
    {
        canAccessStore($store->id);

        return view('admin.pages.stores.form', compact('store'));
    }

    /**
     * Store a newly created store in database.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $store = $this->storeRepository->create($request->validated());

        session()->flash('success', __('app.messages.success.add'));

        return response()->json(['store' => $store]);
    }

    /**
     * Update the specified store in database.
     *
     * @param StoreRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreRequest $request, $id)
    {
        $store = $this->storeRepository->update($request->validated(), $id);

        session()->flash('success', __('app.messages.success.modify'));

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
        canAccessStore($id);

        $this->storeRepository->delete($id);
        session()->flash('success', __('app.messages.success.delete'));

        return response()->json();
    }
}
