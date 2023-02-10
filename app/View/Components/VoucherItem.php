<?php

namespace App\View\Components;

use App\Models\Voucher;
use Illuminate\View\Component;

class VoucherItem extends Component
{
    /**
     * @var Voucher
     */
    public $voucher;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.voucher-item');
    }
}
