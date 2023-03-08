<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TimeSlotResource extends JsonResource
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
            'date' => $this->date,
            'from' => $this->from,
            'to' => $this->to,
            'status' => $this->status,
        ];
    }
}