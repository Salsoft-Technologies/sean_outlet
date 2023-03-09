<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FemaleDetailResource extends JsonResource
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
            'full_name' => $this->full_name,
            'user_name' => $this->user_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'location' => $this->location,
            'age' => $this->age,
            'price' => $this->price,
            'about' => $this->about,
            'hobbies' => $this->hobbies,
            'commision' => "",
            'avatar' => $this->avatar,
            'status' => $this->status,
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }
}
