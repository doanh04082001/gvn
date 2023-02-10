<?php

namespace App\View\Components;

use App\Repositories\Contracts\OrderRepository;
use App\Repositories\Contracts\StoreRepository;
use Illuminate\View\Component;

/**
 * Class SearchArea
 *
 * @package App\View\Components
 */
class SearchArea extends Component
{

    /**
     * @var StoreRepository
     */
    private StoreRepository $storeRepository;

    /**
     * SearchArea constructor.
     *
     * @param StoreRepository $storeRepository
     */
    public function __construct(StoreRepository $storeRepository, OrderRepository $orderRepository)
    {
        $this->storeRepository = $storeRepository;
        $this->cart = $orderRepository->getCartFromSession();
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

        return view('web.components.search-area', [
            'currentStore' => $currentStore,
            'totalItems' => $this->cart->totalItems(),
        ]);
    }
}
