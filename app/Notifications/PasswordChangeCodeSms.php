<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use App\Libraries\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PasswordChangeCodeSms extends Notification
{
    use Queueable;

    public int $code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(int $code)
    {
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toTwilio($notifiable, array $merchant): SmsMessage
    {
        return (new SmsMessage($merchant))
            ->to('+1' . $notifiable->phone)
            ->line(__('sms.change_password', [
                'name' => $notifiable->first_name,
                'merchant' => $merchant['name'],
                'code' => $this->code,
            ]))
            ->line(__('sms.disclaimer'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

        ];
    }
}
