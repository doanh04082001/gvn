<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $storePivot = $this->pivot;

        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'promotion_id' => $this->promotion_id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'sold' => $storePivot->sold,
            'slug' => $this->slug,
            'image' => $this->image_url,
            'rating_count' => $this->rating_count,
            'rating' => $this->rating,
            'price' => $storePivot->price,
            'sale_price' => $storePivot->sale_price,
            'promotion_price' => $storePivot->sale_price,
            'cost' => $this->cost,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'is_online' => $this->is_online,
        ];
    }
}
