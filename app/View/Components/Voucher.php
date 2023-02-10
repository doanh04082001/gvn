<?php

namespace App\View\Components;

use App\Repositories\Contracts\StoreRepository;
use App\Repositories\Contracts\VoucherRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Voucher extends Component
{
    /**
     * @var Collection
     */
    public $vouchers;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(VoucherRepository $voucherRepository, StoreRepository $storeRepository, $code = '')
    {
        $this->vouchers = $voucherRepository->getVouchersByStore($storeRepository->getCurrentStoreSession());

        if ($code != null && $code != '') {
            $this->vouchers = $this->vouchers->where('code', $code);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.voucher');
    }
}
