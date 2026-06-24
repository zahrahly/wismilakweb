<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
        'phone',
        'date_of_birth',
        'city',
        'gender',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ─── ROLE RELATION ───────────────────────────────────────
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // ─── PROFILE RELATIONS ───────────────────────────────────
    public function customerProfile()
    {
        return $this->hasOne(CustomerProfile::class);
    }

    public function adminProfile()
    {
        return $this->hasOne(AdminProfile::class);
    }

    public function partnerProfile()
    {
        return $this->hasOne(PartnerProfile::class);
    }

    public function managerProfile()
    {
        return $this->hasOne(ManagerProfile::class);
    }

    /**
     * Get the profile for the current user based on their role.
     */
    public function profile()
    {
        return match ($this->role?->name) {
            'admin'    => $this->adminProfile(),
            'manager'  => $this->managerProfile(),
            'partner'  => $this->partnerProfile(),
            'customer' => $this->customerProfile(),
            default    => $this->customerProfile(),
        };
    }

    // ─── ROLE HELPERS ────────────────────────────────────────
    public function hasRole(string $role): bool
    {
        return $this->role?->name === $role;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }

    public function isPartner(): bool
    {
        return $this->hasRole('partner');
    }

    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    // ─── POINTS & REWARDS ────────────────────────────────────
    public function point()
    {
        return $this->hasOne(UserPoint::class);
    }

    public function redemptions()
    {
        return $this->hasMany(RewardRedemption::class);
    }

    // ─── EVENTS ──────────────────────────────────────────────
    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function createdEvents()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    /**
     * Alias for createdEvents – used by withCount('events') in manager reports.
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    // ─── CHAT ────────────────────────────────────────────────
    public function chatSessions()
    {
        return $this->hasMany(ChatSession::class);
    }

    // ─── FEEDBACK & CHECKIN ─────────────────────────────────
    public function feedbacks()
    {
        return $this->hasMany(EventFeedback::class);
    }

    public function checkins()
    {
        return $this->hasMany(EventCheckin::class);
    }

    public function pointHistories()
    {
        return $this->hasMany(PointHistory::class);
    }

    public function voucherRedemptions()
    {
        return $this->hasMany(VoucherRedemption::class);
    }

    public function outlets()
{
    return $this->belongsToMany(
        Outlet::class,
        'partner_outlets',
        'partner_id',
        'outlet_id'
    );
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

public function notifications()
{
    return $this->hasMany(Notification::class)->latest();
}

public function getAvatarUrlAttribute()
{
    $avatarPath = null;
    if ($this->isCustomer()) {
        $avatarPath = $this->customerProfile?->avatar;
    } elseif ($this->isAdmin()) {
        $avatarPath = $this->adminProfile?->avatar;
    } elseif ($this->isManager()) {
        $avatarPath = $this->managerProfile?->avatar;
    } elseif ($this->isPartner()) {
        $avatarPath = $this->partnerProfile?->logo;
    }

    if ($avatarPath) {
        if (filter_var($avatarPath, FILTER_VALIDATE_URL)) {
            return $avatarPath;
        }
        return asset('storage/' . $avatarPath);
        }

        return null;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }
}
