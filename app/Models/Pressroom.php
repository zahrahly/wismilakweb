<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pressroom extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'excerpt',
        'content',
        'published_at',
        'status',
    ];
}

