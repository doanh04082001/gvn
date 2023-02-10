<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $images_url = $this->getOriginal()['images'];
        
        foreach ($images_url as $type => $path) {
            $images_url[$type] = $this->images[$type . '_url'];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'discount_value' => $this->discount_value,
            'max_discount_amount' => $this->max_discount_amount,
            'start_at' => $this->start_at,
            'expire_at' => $this->expire_at,
            'images' => $images_url,
            'positions' => $this->positions,
            'status' => $this->status,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
