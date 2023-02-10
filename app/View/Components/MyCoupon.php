<?php

namespace App\View\Components;

use App\Models\Voucher;
use App\Repositories\Contracts\VoucherRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class MyCoupon extends Component
{
    /**
     * @var Collection
     */
    public $vouchers;

    /**
     * Create a new component instance.
     *
     * @param VoucherRepository $voucherRepository
     * @param string $code
     */
    public function __construct(VoucherRepository $voucherRepository, $code = '')
    {
        $conditions = [
            ['status', Voucher::STATUS_ACTIVE],
            ['start_at', '<=', now()],
            ['expire_at', '>', now()],
        ];
        if ($code != null && $code != '') {
            $conditions['code'] = $code;
        }
        $this->vouchers = $voucherRepository->myCoupon($conditions);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.my-coupon');
    }
}
