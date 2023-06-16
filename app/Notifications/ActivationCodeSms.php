<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use App\Libraries\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ActivationCodeSms extends Notification
{
    use Queueable;

    public int|string $code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(int|string $code)
    {
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    /**
     * Get the Twilio / SMS representation of the notification.
     *
     * @param mixed $notifiable
     */
    public function toTwilio($notifiable, array $merchant): SmsMessage
    {
        return (new SmsMessage($merchant))
            ->to('+1' . $notifiable->phone)
            ->line(__('sms.activation', [
                'name' => $notifiable->first_name,
                'merchant' => $merchant['name'],
                'code' => $this->code,
            ]))
            ->line(__('sms.disclaimer'));
    }
}
