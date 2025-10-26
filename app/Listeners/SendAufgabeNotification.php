<?php

namespace App\Listeners;

use App\Events\AufgabeUpdated;
use App\Models\User;
use App\Notifications\DeadlineOverdue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAufgabeNotification {
    /**
     * Create the event listener.
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AufgabeUpdated $event): void {
        $aufgabe = $event->aufgabe;
        if($aufgabe->deadline < now()) {
            /** @var User $user */
            $user = $aufgabe->user;
            $user->notify(new DeadlineOverdue($aufgabe));
        }
    }
}
