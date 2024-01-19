<?php

namespace App\Notifications\Application\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected string $password,
        protected string $loginCode
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Hey ' . $notifiable->first_name . ', seu acesso ao APP DO TREINADOR foi criado! Clique para mais detalhes')
            ->markdown('emails.application.users.created-notification', [
                'notifiable'    => $notifiable,
                'password'      => $this->password,
                'loginCode'     => $this->loginCode,
                'appStoreLink'  => 'https://apps.apple.com/br/app/app-do-treinador/id1560817099',
                'playStoreLink' => 'https://play.google.com/store/apps/details?id=com.appdotreinador.app',
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
