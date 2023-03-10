<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MisconductReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'female_id' => $this->female_id,
            'full_name' => $this->female_info->full_name,
            'user_name' => $this->female_info->user_name,
            'avatar' => $this->female_info->avatar,
            'male_id' => $this->male_id,
            'reason' => $this->reason,
            'date_filed' => $this->created_at->format('d/m/Y'),
        ];
    }
}
