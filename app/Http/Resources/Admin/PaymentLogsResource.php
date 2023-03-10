<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentLogsResource extends JsonResource
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
            'male_id' => $this->male_id,
            'male_name' => $this->male_info->full_name,
            'male_image' => $this->male_info->avatar,
            'female_name' => $this->female_info->full_name,
            'female_image' => $this->female_info->avatar,
            'price' => $this->price,
            'commission' => $this->commission,
            'female_revenue' => $this->price - $this->commission,
            'date_paid' => $this->created_at->format('d/m/Y'),
        ];
    }
}
