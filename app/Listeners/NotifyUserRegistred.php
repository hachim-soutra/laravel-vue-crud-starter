<?php

namespace App\Listeners;

use App\Events\UserRegistred;
use App\Notifications\newUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUserRegistred
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistred  $event
     * @return void
     */
    public function handle(UserRegistred $event)
    {
        $event->user->notify(new newUser());
    }
}
