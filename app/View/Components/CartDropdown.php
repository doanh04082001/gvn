<?php

namespace App\View\Components;

use App\Repositories\Contracts\OrderRepository;
use Illuminate\Session\SessionManager;
use Illuminate\View\Component;

class CartDropdown extends Component
{
    /**
     * @var int
     */
    public $totalItems;

    /**
     * @var double
     */
    public $totalAmount;

    /**
     * @var Collecttion
     */
    public $orderItems;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        SessionManager $sessionManager
    ) {
        $this->orderRepository = $orderRepository;
        $this->sessionManager = $sessionManager;
        $this->cart = $orderRepository->getCartFromSession();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->totalItems = $this->cart->totalItems();
        $this->totalAmount = $this->cart->order()->amount;
        $this->orderItems = $this->cart->orderItems();

        return view('web.components.cart-dropdown');
    }

}
