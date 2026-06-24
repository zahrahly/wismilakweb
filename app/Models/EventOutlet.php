<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventOutlet extends Model
{

    protected $fillable = [

        'event_id',

        'outlet_id',

        'location_detail'

    ];

}