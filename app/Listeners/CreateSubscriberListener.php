<?php

namespace App\Listeners;

use App\Events\SendEmailFeed;
use App\Mail\sendMailFeed;
use App\Models\Feed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CreateSubscriberListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  SendEmailFeed  $event
     * @return void
     */
    public function handle(SendEmailFeed $event)
    {
        $feeds = Feed::all();

        foreach($feeds as $feed) {
            Mail::to('email@site.test')->send(new sendMailFeed($event->subscriber, $feed));
        };
    }
}
