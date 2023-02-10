<?php

namespace App\View\Components;

use App\Models\PaymentMethod;
use App\Repositories\Contracts\PaymentMethodRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class PaymentList extends Component
{
    /**
     * Payment methods list
     *
     * @var Collection
     */
    public $payments;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(PaymentMethodRepository $paymentMethodRepository)
    {
        $this->payments = $paymentMethodRepository->findWhere([
            'status' => PaymentMethod::STATUS_ACTIVE,
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.payment-list');
    }
}
