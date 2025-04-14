<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerNotification extends Notification
{
    use Queueable;

    public $Member;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($Member)
    {
        $this->Member = $Member;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                            ->subject('Status Keanggotaan Pelanggan')
                            ->line($this->Member ? 'Terima kasih, Anda telah terdaftar sebagai member.' : 'Anda terdaftar sebagai non-member.')
                            ->action('Kunjungi Kami', url('/'))
                            ->line('Terima kasih atas pendaftaran Anda!');
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
