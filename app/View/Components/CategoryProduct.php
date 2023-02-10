<?php

namespace App\View\Components;

use App\Repositories\Contracts\TaxonomyItemRepository;
use Illuminate\View\Component;

class CategoryProduct extends Component
{
    /**
     * Create a new component instance.
     * @param TaxonomyItemRepository $taxonomyItemRepository
     * @return void
     */
    public function __construct(TaxonomyItemRepository $taxonomyItemRepository)
    {
        $this->taxonomyItemRepository = $taxonomyItemRepository;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View
     */
    public function render()
    {
        return view('web.components.category-product', [
            'categories' => $this->taxonomyItemRepository->getProductCategoriesForMenu()
        ]);
    }
}
