<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
    'ticket_number',
    'event_registration_id',
    'user_id',
    'event_id',

    'full_name',
    'email',
    'phone',
    'date_of_birth',
    'ktp_number',

    'status',
];

    public function eventRegistration()
    {
        return $this->belongsTo(EventRegistration::class);
    }

    /**
     * Alias for eventRegistration() — backward compatibility
     */
    public function registration()
    {
        return $this->belongsTo(EventRegistration::class, 'event_registration_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function checkin()
    {
        return $this->hasOne(EventCheckin::class);
    }

    /**
     * Data encoded in QR code for scanning
     */
    public function getQrDataAttribute(): string
    {
        return json_encode([
            'ticket_id'     => $this->id,
            'ticket_number' => $this->ticket_number,
            'event_id'      => $this->event_id,
            'user_id'       => $this->user_id,
            'hash'          => hash('sha256', $this->ticket_number . $this->id . config('app.key')),
        ]);
    }

    public function isCheckedIn(): bool
    {
        return $this->checkin()->exists();
    }
}
