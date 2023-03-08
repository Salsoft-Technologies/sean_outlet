<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FemaleProfileResource extends JsonResource
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
            'avatar' => $this->avatar, 
            'location' => $this->location, 
            'about' => $this->about, 
            'hobbies' => $this->hobbies, 
            'age' => $this->age, 
            'price' => $this->price, 
            'images' => $this->my_images, 
            'slots' => $this->time_slot, 
        ];
    }
}
