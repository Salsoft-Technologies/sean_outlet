<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MaleDateLogsResource extends JsonResource
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
            'avatar' => $this->female_info->avatar,
            'female_id' => $this->female_id,
            'female_name' => $this->female_info->full_name,
            'user_name' => $this->female_info->user_name,
            'date' => $this->slot_info->date,
            'status' => $this->status,
            'price' => $this->price,
        ];
    }
}
