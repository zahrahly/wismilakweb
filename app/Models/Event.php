<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventPackage;
use App\Models\Outlet;

class Event extends Model
{
    protected $fillable = [
        'title', 'date', 'location', 'quota', 'description', 'image',
        'status', 'price_type', 'price', 'created_by',
        'verification_status', 'rejection_reason',
        'approved_by', 'published_by', 'approved_at', 'published_at',
        'remaining_quota', 'start_time',
'end_time',
'contact_person_name',
'contact_person_phone',
'is_all_outlets',
'created_by_role',
    ];

    protected function casts(): array
    {
        return [
            'date'         => 'datetime',
            'approved_at'  => 'datetime',
            'published_at' => 'datetime',
            'price'        => 'decimal:2',
        ];
    }

    // ─── RELATIONS ───────────────────────────────────────────
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function paidTickets()
    {
        return $this->hasMany(Ticket::class)->whereHas('eventRegistration', function($q) {
            $q->where('payment_status', 'paid');
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    public function transactions()
    {
        return $this->hasManyThrough(
            Transaction::class,
            EventRegistration::class,
            'event_id',
            'registration_id',
            'id',
            'id'
        );
    }

    // ─── ACCESSORS ───────────────────────────────────────────
    public function getRegisteredCountAttribute()
    {
        return (int) $this->registrations()->where('payment_status', 'paid')->sum('quantity');
    }

    /**
     * Compute remaining quota dynamically (use this instead of DB column)
     */
    public function getComputedRemainingQuotaAttribute()
    {
        return max(0, $this->quota - $this->registered_count);
    }

    /**
     * Quota status label for UI display
     */
    public function getQuotaStatusAttribute()
    {
        $remaining = $this->computed_remaining_quota;
        if ($remaining <= 0) return 'Full';
        if ($remaining <= ($this->quota * 0.2)) return 'Almost Full';
        return 'Available';
    }

    /**
     * Public-facing event status (visible without login)
     */
    public function getPublicStatusAttribute(): string
    {
        if (\Carbon\Carbon::parse($this->date)->endOfDay()->isPast()) {
            return 'Event Passed';
        }

        if ($this->remaining_quota <= 0 || $this->status === 'quota_full') {
            return 'Full';
        }

        if (in_array($this->status, ['completed'])) {
            return 'Event Passed';
        }

        return 'Available';
    }

    public function getIsVerifiedAttribute()
    {
        return $this->verification_status === 'approved' || $this->status === 'published';
    }

    public function getTotalRevenueAttribute()
    {
        return $this->transactions()->where('status', 'paid')->sum('amount');
    }

    // ─── SCOPES ──────────────────────────────────────────────
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // ─── WORKFLOW HELPERS ────────────────────────────────────
    public function submitForApproval()
    {
        $this->update([
            'status'              => 'pending',
            'verification_status' => 'pending',
        ]);
    }

    public function approve($managerId)
    {
        $this->update([
            'status'              => 'approved',
            'verification_status' => 'approved',
            'approved_by'         => $managerId,
            'approved_at'         => now(),
            'rejection_reason'    => null,
        ]);
    }

    public function reject($managerId, $reason = null)
    {
        $this->update([
            'status'              => 'rejected',
            'verification_status' => 'rejected',
            'approved_by'         => $managerId,
            'approved_at'         => now(),
            'rejection_reason'    => $reason,
        ]);
    }

    public function resubmit()
    {
        $this->update([
            'status'              => 'resubmitted',
            'verification_status' => 'pending',
            'rejection_reason'    => null,
        ]);
    }

    public function publish($adminId)
    {
        $updateData = [
            'status'       => 'published',
            'published_by' => $adminId,
            'published_at' => now(),
        ];

        if ($this->remaining_quota <= 0 && $this->quota > 0 && $this->registered_count < $this->quota) {
            $updateData['remaining_quota'] = $this->quota - $this->registered_count;
        }

        $this->update($updateData);
    }
public function outlets()
{
    return $this->belongsToMany(
        Outlet::class,
        'event_outlets' // ← tambahkan ini
    )->withPivot('location_detail');
}

public function packages()
{
    return $this->hasMany(EventPackage::class);
}

public function feedbacks()
{
    return $this->hasMany(EventFeedback::class);
}

    // ─── STATUS AUTOMATION ──────────────────────────────────
    /**
     * Auto-update event statuses based on date and quota.
     * Call this before listing events for customers.
     */
    public static function autoUpdateStatuses(): void
    {
        // published events whose date has passed → completed
        static::where('status', 'published')
            ->whereDate('date', '<', now()->toDateString())
            ->update(['status' => 'completed']);

        // published events with no remaining quota → quota_full
        static::where('status', 'published')
            ->where('remaining_quota', '<=', 0)
            ->update(['status' => 'quota_full']);
    }

    /**
     * Only events visible to customers: published, ongoing, completed, quota_full, with published_at not null
     */
    public function scopeVisibleToCustomers($query)
    {
        return $query->whereIn('status', ['published', 'ongoing', 'completed', 'quota_full'])
                     ->whereNotNull('published_at');
    }

    /**
     * Upcoming events sorted by nearest date
     */
    public function scopeUpcoming($query)
    {
        return $query->whereIn('status', ['published', 'ongoing'])
                     ->whereNotNull('published_at')
                     ->whereDate('date', '>=', now()->toDateString())
                     ->orderBy('date', 'asc');
    }
}
