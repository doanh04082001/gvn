<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
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
            'group' => $this->group,
            'question' => $this->question,
            'answer' => $this->answer,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
