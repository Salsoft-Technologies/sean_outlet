<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDateRequest extends Notification
{
    use Queueable;

    public $male;
    public $date_info;

    public function __construct($user, $date_request)
    {
        $this->male = $user;
        $this->date_info = $date_request->slot_info;;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'male_id' => $this->male->id,
            'date' => $this->date_info->date,
            'time' => $this->date_info->from,
            'content' => $this->male->full_name.' has requested you for a date. Check it out!',
        ];
    }
}