<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'status' => $this->status,
            'start_at' => $this->start_at,
            'expire_at' => $this->expire_at,
            'type' => $this->type,
            'discount_amount' => $this->discount_amount,
            'max_discount_amount' => $this->max_discount_amount,
            'min_order_amount' => $this->min_order_amount,
            'apply_count' => $this->apply_count,
            'max_apply' => $this->max_apply,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
