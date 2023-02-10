<?php

namespace App\View\Components;

use App\Models\Product;
use App\Repositories\Contracts\StoreRepository;
use Illuminate\Session\SessionManager;
use Illuminate\View\Component;

class ProductDetail extends Component
{
    /**
     * @var boolean
     */
    public $isCartExists;

    /**
     * @var Product
     */
    public Product $product;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        Product $product,
        StoreRepository $storeRepository,
        SessionManager $sessionManager
    ) {
        $this->product = $product;
        $this->storeRepository = $storeRepository;
        $this->sessionManager = $sessionManager;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        if (!$this->sessionManager->has(config('params.store.current_store'))) {
            $this->sessionManager->put(config('params.store.current_store'), $this->storeRepository->first());
        }

        return view('web.components.product-detail');
    }
}
