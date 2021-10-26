<?php

namespace App\Models;

use App\Mail\sendMailFeed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Feed extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(fn(Feed $feed) => $feed->id = (string) Uuid::uuid4());
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'pub_date',
        'uri',
        'url',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'pub_date' => 'datetime',
    ];

    public static function findOrCreate($title)
    {
        $feed = static::where('title', $title)->first();
        return $feed ? $feed : new static;
    }

    public static function loadFeedG1()
    {
        $g1 = json_decode(json_encode(simplexml_load_file('https://g1.globo.com/rss/g1/', null, LIBXML_NOCDATA)));
        $data = $g1->channel->item;

        foreach($data as $item) {
            preg_match("/\<img.+src\=(?:\"|\')(.+?)(?:\"|\')(?:.+?)\>/", $item->description, $out);
            $description = substr(str_replace('   <br />   ', '', str_replace($out, '', $item->description)), 0, 350);
            $image = array_pop($out) ?: "https://s2.glbimg.com/veNWQCjPmWVRAfzfLSJt35f_V58=/i.s3.glbimg.com/v1/AUTH_afd7a7aa13da4265ba6d93a18f8aa19e/pox/g1.png";

            $feed = Feed::findOrCreate($item->title);
            $feed->title = $item->title;
            $feed->uri = $item->guid;
            $feed->pub_date = $item->pubDate;
            $feed->status = 1;
            $feed->image = $image;
            $feed->description = substr($description, 0, strrpos($description, ' ')).'[...]';
            $feed->save();
        };

        return [];
    }

    public function sendFeed(Feed $feed = null)
    {
        if(!is_null($feed)) {
            event(new sendMailFeed($feed));
        }
    }

    public function audiences()
    {
        return $this->belongToMany(Audience::class);
    }
}
