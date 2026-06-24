<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',

        // IMAGE
        'image_main',
        'image_detail',

        // DESCRIPTION
        'short_description',
        'description',

        // SPECIFICATIONS
        'weight',
        'genome',
        'assembly',
        'varietal',
        'wrapper',
        'filler',
        'profile',
        'size',

        // STATUS
        'status'
    ];

    public function outlets()
    {
        return $this->belongsToMany(
            Outlet::class,
            'outlet_products'
        )->withPivot('is_available', 'notes')->withTimestamps();
    }
}
