<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaleRequestsResource extends JsonResource
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
            'image' => $this->male_info->avatar,
            'date' => $this->slot_info->date,
            'time' => $this->slot_info->from,
            'request_text' => "",
            'status' => $this->status,
        ];
    }
}
