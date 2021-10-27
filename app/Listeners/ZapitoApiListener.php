<?php

namespace App\Listeners;

use App\Events\ZapitoApiEvent;
use App\Models\Feed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class ZapitoApiListener
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
     * @param  ZapitoApiEvent  $event
     * @return void
     */
    public function handle(ZapitoApiEvent $event)
    {
        $user = $event->subscriber;

        $feeds = Feed::all();
        $messages = array();

        foreach($feeds as $feed){
            $messages[] = [
                "phone" => $user->phone,
                "message" => env('APP_URL') .'/'.$user->id.'/'.$feed->id,
                "bot_id" => "20462",
                "file" => [
                    "url" => $feed->image,
                    "name" => $feed->title,
                    "headers" => [
                        "X-Custom-Header" => "valor_custom_header"
                    ],
                    "optional" => false
                ],
                "check_phone" => true
            ];
        }

        $api = Http::withHeaders([
            'Authorization' => 'Bearer Y7o2sXZRIvYYXcDyWXe5wSqf541PNuz6bn8Cr90W5nYZ6S4vjCUSXBB0Mo3Y',
            'Content-Type' => 'application/json'
        ])->post('https://zapito.com.br/api/messages', [
            "test_mode" => true,
            "data" => $messages
        ]);

        return $api;
    }
}
