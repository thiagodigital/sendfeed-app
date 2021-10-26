<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Feed extends Model
{
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
}
