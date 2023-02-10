<?php

namespace App\Http\Resources;

class ProductDetailResource extends ProductResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = parent::toArray($request);
        $product['variants'] = new VariantCollection($this->variants);
        $product['toppings'] = new ToppingCollection($this->toppings);

        return $product;
    }
}
