<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;

class ProductItem extends Component
{
    /**
     * @var Product
     */
    public Product $product;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.product-item');
    }
}
