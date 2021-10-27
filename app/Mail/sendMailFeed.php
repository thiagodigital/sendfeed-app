<?php

namespace App\Mail;

use App\Models\Feed;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class sendMailFeed extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;
    public $feed;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber, Feed $feed)
    {
        $this->subscriber = $subscriber;
        $this->feed = $feed;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->feed->status = 2;
        $this->feed->save();

        $this->feed->url = env('APP_URL').'/'.$this->subscriber->id.'/'.$this->feed->id;

        $this->from($this->subscriber->phone.'@site.test')
            ->subject($this->feed->title)
            ->view('email-feed', ['feed' => $this->feed, 'subscriber' => $this->subscriber]);
    }
}
