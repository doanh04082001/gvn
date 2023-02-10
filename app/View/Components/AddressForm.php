<?php

namespace App\View\Components;

use App\Repositories\Contracts\ProvinceRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class AddressForm extends Component
{
    /**
     * @var Collection
     */
    public $provinces;

    /**
     * AddressForm constructor.
     *
     * @param ProvinceRepository $provinceRepository
     */
    public function __construct(ProvinceRepository $provinceRepository)
    {
        $this->provinces = $provinceRepository->get(['id', 'name']);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.address-form');
    }
}
