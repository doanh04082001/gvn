<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductItemReview extends Component
{
    /**
     * Product item
     *
     * @var \App\Models\Product $product
     *
     */
    public $product;

    /**
     * Create a new component instance.
     *
     * @param \App\Models\OrderItem $item
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->product = $item->realProduct();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.product-item-review');
    }
}
