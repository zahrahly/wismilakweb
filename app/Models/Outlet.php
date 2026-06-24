<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $fillable = [
        'name',
        'address',
        'region',
        'city',
        'latitude',
        'longitude',
        'phone',
        'opening_hours',
        'status',
    ];
    public function events()
    {
        return $this->belongsToMany(
            Event::class,
            'event_outlets'
        )->withPivot('location_detail');
    }

    public function partners()
    {
        return $this->belongsToMany(
            User::class,
            'partner_outlets',
            'outlet_id',
            'partner_id'
        );
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'outlet_products'
        )->withPivot('is_available', 'notes')->withTimestamps();
    }

    public function availableProducts()
    {
        return $this->products()->wherePivot('is_available', true);
    }
}
