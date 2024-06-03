<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class NewLogin extends Notification
{
    use Queueable;
    public $user;
    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'vonage', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Login Notification')
            ->greeting('Hello ' . $this->user->name . '!')
            ->line('You have successfully logged into the application.')
            ->line('If this wasn’t you, please contact support immediately.')
            ->action('Visit Dashboard', url('/jobs'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message_id' => '',
            'message' => 'User ' . $this->user->name . ' has logged in.',
            'user_id' => $this->user->id,
            'type' => 'newLogin'
        ];
    }

    public function toVonage($notifiable)
    {
        return (new VonageMessage)
            ->content('New login to you account was detected')
            ->from(config('vonage.sms_from'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
