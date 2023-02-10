<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_id' => $this->realProduct()->id,
            'name' => $this->name(),
            'image' => $this->realProduct()->image_url,
            'toppings' => $this->renderToppings(),
            'quantity' => $this->quantity,
            'price' => $this->totalRealAmount(),
            'sale_price' => $this->totalAmount(),
            'note' => $this->note,
        ];
    }
}
