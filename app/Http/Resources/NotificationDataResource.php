<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class NotificationDataResource extends JsonResource
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
            'type' => $this->type,
            'order' => Arr::only($this->order, [
                'id',
                'store_id',
                'customer_id',
                'code',
                'status',
                'payment_status',
                'delivery_type',
                'received_at',
                'amount',
                'total_amount',
                'discount',
                'payment_method',
            ]),
        ];
    }
}
