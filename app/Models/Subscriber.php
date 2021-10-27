<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class Subscriber extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $keyType =  'string';
    protected $primaryKey = 'id';
    public $incrementing = false;

    public static function booted()
    {
        static::creating(fn(Subscriber $subscriber) => $subscriber->id = (string) Uuid::uuid4());
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    public function audiences()
    {
        return $this->hasMany(Audience::class);
    }

    public static function countAudiences($id)
    {
        $subscriber = Subscriber::where('id',$id)->first();
        $subscriber->feeds;


        $feeds = array();
        $filtro = array_count_values(array_column($subscriber->feeds->toArray(), 'title'));


        foreach($filtro as $k=>$v) {
            $item = $subscriber->feeds->filter(fn($fd) => $fd->title == $k ? $fd->uri : '')->first();
            $feeds[] = array(
                'title' => $k,
                'count' => $v,
                'url' => $item->uri,
                'image' => $item->image
            );
        }

        $feed_count = count($feeds);

        return [
            'feeds' => $feeds,
            'subscriber' => $subscriber,
            'feed_count' => $feed_count
        ];
        // dd($subscriber, $feeds, $filtro, $feed_count);

    }

    public function feeds()
    {
        return $this->belongsToMany(Feed::class,'audiences');
    }

}
