<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMovieNotification extends Notification
{
    use Queueable;

    public $movie;

    /**
     * Create a new notification instance.
     */
    public function __construct($movie)
    {
        $this->movie = $movie;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => $this->movie->title,
            'description' => $this->movie->description,
            'movie_id' => $this->movie->id,
            'url' => url('/movie/show/'.$this->movie->id),
        ];
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
