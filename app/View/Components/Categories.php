<?php

namespace App\View\Components;

use App\Repositories\Contracts\TaxonomyItemRepository;
use Illuminate\View\Component;

/**
 * Class Categories
 *
 * @package App\View\Components
 */
class Categories extends Component
{
    /**
     * @var TaxonomyItemRepository
     */
    private TaxonomyItemRepository $taxonomyItemRepository;

    /**
     * Categories constructor.
     * @param TaxonomyItemRepository $taxonomyItemRepository
     */
    public function __construct(TaxonomyItemRepository $taxonomyItemRepository)
    {
        $this->taxonomyItemRepository = $taxonomyItemRepository;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.categories', [
            'categories' => $this->taxonomyItemRepository->getProductCategories(),
        ]);
    }
}
