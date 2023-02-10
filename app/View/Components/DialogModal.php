<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DialogModal extends Component
{
    /**
     * @var string $id
     */
    public string $id;

    /**
     * @var string|mixed
     * example = modal-sm|modal-lg|modal-xl..
     */
    public string $size;

    /**
     * @var bool
     */
    public bool $isShowHeader;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $size = '', $isShowHeader = false)
    {
        $this->id = $id;
        $this->size = $size;
        $this->isShowHeader = $isShowHeader;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.dialog-modal');
    }

}
