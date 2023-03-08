<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaleProfileResource extends JsonResource
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
            'avatar' => $this->avatar, 
            'location' => $this->location, 
            'about' => $this->about, 
            'hobbies' => $this->hobbies, 
            'age' => $this->age, 
            'images' => $this->my_images, 
        ];
    }
}
