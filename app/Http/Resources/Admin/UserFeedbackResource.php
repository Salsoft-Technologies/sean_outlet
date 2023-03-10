<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserFeedbackResource extends JsonResource
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
            'user_id' => $this->user_id,
            'full_name' => $this->user->full_name,
            'avatar' => $this->user->avatar,
            'gender' => $this->user_type,
            // 'subject' => $this->subject,
            // 'message' => $this->message,
            'date_filed' => $this->created_at->format('d/m/Y'),
        ];
    }
}
