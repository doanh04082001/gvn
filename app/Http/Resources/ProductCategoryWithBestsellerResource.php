<?php

namespace App\Http\Resources;

class ProductCategoryWithBestsellerResource extends TaxonomyItemResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $category = parent::toArray($request);
        $category['products'] = new ProductCollection($this->bestsellers);
        
        return $category;
    }
}
