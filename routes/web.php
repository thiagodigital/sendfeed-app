<?php

use App\Mail\sendMailFeed;
use App\Models\Audience;
use App\Models\Feed;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/audience/{subscriber}', function($subscriber){
    return Subscriber::countAudiences($subscriber);
});
Route::get('/{subscriber}/{feed}', function($subscriber, $feed) {
    Audience::create([
        'subscriber_id' => $subscriber,
        'feed_id'   => $feed
    ]);
    $item = Feed::findOrFail($feed);
    return Redirect::to($item->uri);
});
Route::get('teste', function () {

    $subscribers = Subscriber::where('status', 1)->get();
    $feeds = Feed::all();

    foreach($subscribers as $subscriber) {
        foreach($feeds as $feed) {
            $feed->sendFeed($feed);
            $feed->status = 2;
            $feed->save();
            $feed->url = env('APP_URL').'/'.$subscriber->id.'/'.$feed->id;
            Mail::to($subscriber->phone.'@site.com')->send(new sendMailFeed($feed));
        }
    }
    return $feeds;
});
Route::get('/', function () {
    return redirect('/admin');
});
