<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MyOrders extends Component
{
    /**
     * @var Illuminate\Database\Eloquent\Order $orders
     */
    public $orders;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.my-orders');
    }
}
