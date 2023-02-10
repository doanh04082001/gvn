<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImageUploadPreview extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.image-upload-preview');
    }
}
