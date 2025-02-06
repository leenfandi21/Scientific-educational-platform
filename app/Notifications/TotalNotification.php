<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TotalNotification extends Notification
{
    use Queueable;

    private $total;

    public function __construct($total)
    {
        $this->total = $total;
    }

    public function via($notifiable)
    {
        return ['pusher'];
    }

    public function toPusher($notifiable)
    {
        return [
            'message' => 'Your total: ' . $this->total,
        ];
    }
}
