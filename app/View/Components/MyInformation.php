<?php

namespace App\View\Components;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepository;
use Illuminate\View\Component;

class MyInformation extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.my-information');
    }
}
