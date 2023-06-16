<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class MailChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     *
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $merchant = cache(session('merchant'));
        $message = $notification->toMailjet($notifiable, $merchant);
        $message->send();
    }
}
