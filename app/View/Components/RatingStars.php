<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RatingStars extends Component
{
    /**
     * Name of the input.
     *
     * @var string $name
     */
    public $name;

    /**
     * Create a new component instance.
     *
     * @param string $name
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.rating-stars');
    }
}
