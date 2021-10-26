<?php

namespace App\Mail;

use App\Models\Feed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class sendMailFeed extends Mailable
{
    use Queueable, SerializesModels;

    public $feed;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('email@site.com')
                    ->subject($this->feed->title)
                    ->view('email-feed', ['feed' => $this->feed]);
    }
}
