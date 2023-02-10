<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Products extends Component
{
    /**
     * @var String $title
     */
    public string $title;

    /**
     * @var Illuminate\Database\Eloquent\Collection $products
     */
    public $products;

    /**
     * Create a new component instance.
     *
     * @param String $title
     * @param Illuminate\Database\Eloquent\Collection $products
     */
    public function __construct($title = '', $products)
    {
        if (Route::currentRouteName() == 'home.index' && $products->count() % 2 == 1) {
            $products->pop();
        }
        $this->title = $title;
        $this->products = $products;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.products');
    }
}
