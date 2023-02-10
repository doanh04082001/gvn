<?php

namespace App\View\Components;

use App\Models\OrderItem;
use Illuminate\View\Component;

class CartProductItem extends Component
{
    /**
     * @var OrderItem
     */
    public $orderItem;

    /**
     * @var integer
     */
    public $orderKey;

    /**
     * @var boolean
     */
    public $changeNumberAble;

    /**
     * Create a new component instance.
     *
     * @param array $orderItem
     */
    public function __construct(OrderItem $orderItem, $orderKey = null, $changeNumberAble = false)
    {
        $this->orderItem = $orderItem;
        $this->orderKey = $orderKey;
        $this->changeNumberAble = $changeNumberAble;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.cart-product-item');
    }
}
