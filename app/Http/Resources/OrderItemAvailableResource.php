<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemAvailableResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = $this->realProduct();
        $variant = $this->product_id != $product->id ? $this->product : null;

        return [
            'product' => new OrderItemProductResource($product),
            'variant' => $variant ? new OrderItemProductResource($variant) : null,
            'toppings' => new OrderItemToppingCollection($this->toppings),
            'image' => $product->image_url,
            'note' => $this->note,
            'quantity' => $this->quantity
        ];
    }
}
