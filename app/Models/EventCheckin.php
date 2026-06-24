<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCheckin extends Model
{
    protected $fillable = [
        'ticket_id', 'user_id', 'event_id', 'checked_in_at', 'points_awarded',
    ];

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
        ];
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
