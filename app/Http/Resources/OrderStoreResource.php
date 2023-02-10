<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderStoreResource extends JsonResource
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
            'store_id' => $this->store_id,
            'customer_id' => $this->customer_id,
            'code' => $this->code,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'delivery_type' => $this->delivery_type,
            'received_at' => $this->received_at,
            'amount' => $this->amount,
            'total_amount' => $this->total_amount,
            'discount' => $this->discount,
            'email' => $this->email,
            'phone' => $this->phone,
            'shipping_name' => $this->shipping_name,
            'shipping_address' => $this->shipping_address,
            'shipping_fee' => $this->shipping_fee,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'is_reviewed' => $this->isReviewed(),
            'customer' => new CustomerResource($this->customer),
            'note' => $this->note,
        ];
    }
}
