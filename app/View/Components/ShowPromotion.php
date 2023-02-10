<?php

namespace App\View\Components;

use App\Models\Promotion;
use App\Repositories\Contracts\PromotionRepository;
use Illuminate\View\Component;

class ShowPromotion extends Component
{
    /**
     * Create a new component instance.
     *
     * @param CustomerRepository $customerRepository
     */
    public function __construct(PromotionRepository $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.show-promotion', [
            'promotion' => $this->promotionRepository
                ->getPromotions(['position' => Promotion::POSITION_MIDDLE])->first(),
        ]);
    }
}
