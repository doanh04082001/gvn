<?php

namespace App\Http\Resources;

// use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingFeeResource extends JsonResource
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
            // 'distance' => $this->resource['distance'] ?? 0,
            // 'shipping_fee' => $this->resource['total_price'] ?? getDefaultShippingFee(),
            // 'currency' => $this->resource['currency'] ?? __('app.currency.unit'),
            // 'received_at' => Carbon::now()
            //     ->addSeconds(
            //         ($this->resource['duration'] ?? Order::TIMEOUT_DELIVERY)
            //          + getOrderPrepareTime()
            //     )
            //     ->format('Y-m-d H:i:s'),
        ];
    }
}
