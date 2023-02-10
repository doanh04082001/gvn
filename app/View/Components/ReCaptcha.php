<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ReCaptcha extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.re-captcha');
    }
}
