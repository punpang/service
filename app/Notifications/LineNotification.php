<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Hinaloe\LineNotify\Message\LineMessage;

class LineNotification extends Notification
{
    use Queueable;

    public function __construct($message)
    {
      $this->data = $message;
    }

    public function via($notifiable)
    {
        return ['line'];
    }

    public function toLine($notifable)
    {
        return (new LineMessage())->message($this->data);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
