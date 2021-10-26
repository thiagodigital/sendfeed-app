<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['subscriber_id', 'feed_id'];
}
