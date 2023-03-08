<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingLogsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'female_id' => $this->female_id,
            'user_name' => $this->female_info->user_name,
            'date' => $this->slot_info->date,
            'status' => $this->status,
            'price' => $this->price,
        ];
    }
}
