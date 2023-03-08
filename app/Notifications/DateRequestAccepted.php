<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DateRequestAccepted extends Notification
{
    use Queueable;
    public $female;
    public $date_info;

    public function __construct($user, $data_request)
    {
        $this->female = $user;
        $this->date_info = $data_request->slot_info;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'female_id' => $this->female->id,
            'date' => $this->date_info->date,
            'time' => $this->date_info->from,
            'content' => 'Your date request has been accepted, against '.$this->female->full_name,
        ];
    }
}