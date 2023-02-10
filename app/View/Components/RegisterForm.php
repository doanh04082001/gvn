<?php

namespace App\View\Components;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RegisterForm extends Component
{

    /**
     * @var array
     */
    public array $gender = [
        'GENDER_FEMALE' => Customer::GENDER_FEMALE,
        'GENDER_MALE' => Customer::GENDER_MALE,
        'GENDER_NA' => Customer::GENDER_NA,
    ];

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('web.components.register-form');
    }
}
