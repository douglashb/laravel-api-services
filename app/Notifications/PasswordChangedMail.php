<?php

namespace App\Notifications;

use App\Channels\MailChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Libraries\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangedMail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
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
                'mails.password-changed',
                [
                    'merchant' => $merchant,
                    'client' => $notifiable->first_name . ' ' . $notifiable->first_last_name,
                ]
            )
            ->to($notifiable->email, $notifiable->first_name . ' ' . $notifiable->first_last_name)
            ->subject(__('notification_mail.password_changed_subject'));
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
