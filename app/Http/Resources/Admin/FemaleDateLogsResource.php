<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FemaleDateLogsResource extends JsonResource
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
            'avatar' => $this->male_info->avatar,
            'male_id' => $this->male_id,
            'male_name' => $this->male_info->full_name,
            'user_name' => $this->male_info->user_name,
            'date_schedule' => $this->slot_info->date,
            'date_paid' => $this->created_at->format('d/m/Y'),
            'price' => $this->price,
        ];
    }
}
