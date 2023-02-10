<?php

namespace App\View\Components;

use App\Repositories\Contracts\OrderRepository;
use App\Repositories\Contracts\TaxonomyItemRepository;
use Illuminate\View\Component;

class ReviewStore extends Component
{
    /**
     * The order id.
     *
     * @var string $orderId
     */
    public $orderId;

    /**
     * Create a new component instance.
     *
     * @param OrderRepository $orderRepository
     * @param TaxonomyItemRepository $taxonomyItemRepository
     * @param string $orderId
     *
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        TaxonomyItemRepository $taxonomyItemRepository,
        $orderId
    ) {
        $this->orderRepository = $orderRepository;
        $this->taxonomyItemRepository = $taxonomyItemRepository;
        $this->orderId = $orderId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $order = $this->orderRepository->find($this->orderId);

        return view('web.components.review-store', [
            'order' => $order,
            'tags' => $this->taxonomyItemRepository->getReviewTags(),
            'isFavorite' => auth()->user()->isFavoriteStore($order->store_id),
        ]);
    }
}
