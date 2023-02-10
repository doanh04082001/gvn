<?php

namespace App\View\Components;

use App\Repositories\Contracts\StoreRepository;
use Illuminate\View\Component;

/**
 * Class Store
 *
 * @package App\View\Components
 */
class Store extends Component
{
    /**
     * @var StoreRepository
     */
    private StoreRepository $storeRepository;

    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $currentStore = session()->get(config('params.store.current_store'));
        if (empty($currentStore)) {
            $currentStore = $this->storeRepository->first();
        }

        return view('web.components.store', [
            'currentStore' => $currentStore,
            'stores' => $this->storeRepository->getStores([])
        ]);
    }
}
