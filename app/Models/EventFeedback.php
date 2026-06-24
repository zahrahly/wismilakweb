<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFeedback extends Model
{
    protected $table = 'event_feedbacks';
    protected $fillable = [
    'event_id',
    'user_id',
    'rating',
    'comment',
    'image',
    'points_awarded'
];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
