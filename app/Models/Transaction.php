<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'registration_id', 'user_id', 'amount', 'payment_method',
        'transaction_code', 'status', 'paid_at', 'gateway_response',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'amount'  => 'decimal:2',
        ];
    }

    public function registration()
    {
        return $this->belongsTo(EventRegistration::class, 'registration_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ✅ FIX: Check for both 'paid' and 'success' status
     * Midtrans callback now stores 'paid', but old data may have 'success'
     */
    public function isPaid(): bool
    {
        return in_array($this->status, ['paid', 'success']);
    }

    /**
     * Access tickets through registration
     */
    public function tickets()
    {
        return $this->hasManyThrough(
            Ticket::class,
            EventRegistration::class,
            'id',                      // FK on event_registrations
            'event_registration_id',   // FK on tickets
            'registration_id',         // local key on transactions
            'id'                       // local key on event_registrations
        );
    }

    public static function generateCode(): string
    {
        return 'TRX-' . strtoupper(uniqid()) . '-' . now()->format('Ymd');
    }
}
