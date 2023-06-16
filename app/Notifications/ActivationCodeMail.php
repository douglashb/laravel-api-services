<?php

namespace App\Notifications;

use App\Channels\MailChannel;
use App\Libraries\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ActivationCodeMail extends Notification
{
    use Queueable;

    public string $code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $code)
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
        return [MailChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @param array $merchant
     *
     * @return MailMessage
     */
    public function toMailjet($notifiable, array $merchant): MailMessage
    {
        return (new MailMessage($merchant))
            ->view(
                'mails.welcome-code',
                [
                    'merchant' => $merchant,
                    'title' => __('notification_mail.welcome_subject', ['merchant' => $merchant['name']]),
                    'message' => __('notification_mail.welcome_intro_code'),
                    'client' => $notifiable->first_name . ' ' . $notifiable->first_last_name,
                    'code' => $this->code,
                ]
            )
            ->to($notifiable->email, $notifiable->first_name . ' ' . $notifiable->first_last_name)
            ->subject(__('notification_mail.welcome_subject', ['merchant' => $merchant['name']]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

        ];
    }
}
