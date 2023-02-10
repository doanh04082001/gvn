<?php

namespace App\View\Components;

use App\Repositories\Contracts\ShippingAddressRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class AddressRadioGroup extends Component
{
    /**
     * @var Collection
     */
    public $addresses;

    /**
     * AddressRadioGroup constructor.
     *
     * @param ShippingAddressRepository $shippingAddressRepository
     * @param string $keyword
     */
    public function __construct(ShippingAddressRepository $shippingAddressRepository, $keyword = '')
    {
        $this->addresses = $shippingAddressRepository
            ->findWhere([
                'customer_id' => auth()->id(),
                ['address', 'LIKE', '%' . escapeLike($keyword) . '%'],
            ]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.address-radio-group');
    }
}
