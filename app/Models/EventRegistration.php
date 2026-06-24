<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'full_name',
        'phone',
        'ktp_number',
        'ktp_file',
        'payment_status',
        'payment_proof',
        'expired_at',
        'voucher_redemption_id',
        'reward_redemption_id',
        'snap_token',
        'quantity',
        'total_amount',
        'ticket_price',
    ];

    protected function casts(): array
    {
        return [
            'expired_at'   => 'datetime',
            'total_amount' => 'decimal:2',
            'ticket_price' => 'decimal:2',
        ];
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Data peserta sebelum pembayaran (participant form data)
     */
    public function eventTickets()
    {
        return $this->hasMany(EventTicket::class, 'registration_id');
    }

    /**
     * Tiket final setelah pembayaran sukses
     */
    public function generatedTickets()
    {
        return $this->hasMany(Ticket::class, 'event_registration_id');
    }

    /**
     * Alias for generatedTickets() — backward compatibility
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'event_registration_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'registration_id');
    }

    public function voucherRedemption()
    {
        return $this->belongsTo(VoucherRedemption::class);
    }

    public function rewardRedemption()
    {
        return $this->belongsTo(RewardRedemption::class);
    }

    /**
     * ✅ FIX: Use proper scoped relation for feedback
     * This avoids the raw where() that breaks eager loading.
     */
    public function feedback()
    {
        return $this->hasOne(EventFeedback::class, 'event_id', 'event_id')
            ->whereColumn('event_feedbacks.user_id', 'event_registrations.user_id');
    }

    /**
     * Check if registration is expired
     */
    public function isExpired(): bool
    {
        return $this->payment_status === 'pending'
            && $this->expired_at
            && $this->expired_at->isPast();
    }

    /**
     * Calculate discount amount for display purposes
     */
    public function getDiscountAmountAttribute(): float
    {
        $subtotal = ($this->ticket_price ?? 0) * ($this->quantity ?? 1);
        return max(0, $subtotal - ($this->total_amount ?? 0));
    }
}