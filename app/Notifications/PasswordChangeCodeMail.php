<?php

namespace App\Notifications;

use App\Channels\MailChannel;
use App\Libraries\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PasswordChangeCodeMail extends Notification
{
    use Queueable;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public int   $code
    )
    {
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
                'mails.request-change-password',
                [
                    'merchant' => $merchant,
                    'client' => $notifiable->first_name . ' ' . $notifiable->first_last_name,
                    'code' => $this->code
                ]
            )
            ->to($notifiable->email, $notifiable->first_name . ' ' . $notifiable->first_last_name)
            ->subject(__('notification_mail.forgot_subject'));
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
