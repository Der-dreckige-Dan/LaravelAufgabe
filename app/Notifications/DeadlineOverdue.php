<?php

namespace App\Notifications;

use App\Models\Aufgabe;
use DateTimeImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeadlineOverdue extends Notification {
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected Aufgabe $aufgabe
    ) {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array {
        $deadline = (new DateTimeImmutable($this->aufgabe->deadline))->format('d/m/Y');
        return [
            'user_id' => $notifiable->id,
            'aufgabe_id' => $this->aufgabe->id,
            'deadline' => $deadline,
            'message'=> sprintf("Die Aufgabe, %s, ist seit dem %s überfällig", $this->aufgabe->title,$deadline)
        ];
    }
}
