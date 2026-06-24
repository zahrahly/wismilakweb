<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
    'title',
    'description',
    'points_required',
    'stock',
    'image',
    'status',
];

    public function redemptions()
    {
        return $this->hasMany(RewardRedemption::class);
    }
}


