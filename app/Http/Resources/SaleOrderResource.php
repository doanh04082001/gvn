<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
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
            'real_shipping_fee' => $this->real_shipping_fee,
            'shipping_method' => $this->shipping_method,
            'shipping_id' => $this->shipping_id,
            'shipping_status' => $this->shipping_status,
            'tracking_code' => $this->tracking_code,
            'delivery_time' => $this->delivery_time,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'store' => new StoreResource($this->store),
            'customer' => new CustomerResource($this->customer),
            'voucher' => new VoucherResource($this->voucher),
            'payment_method' => new PaymentMethodResource($this->payment),
            'order_items' => new OrderItemCollection($this->orderItems),
            'note' => $this->note,
        ];
    }
}
