<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'email' => $this->email, 
            'avatar' => $this->avatar, 
            'about' => $this->about, 
            'hobbies' => $this->hobbies, 
            'phone_number' => $this->phone_number, 
            'age' => $this->age, 
            'images' => $this->my_images, 
            'price' => $this->price, 
        ];
    }
}
