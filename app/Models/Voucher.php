<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code', 'title', 'description', 'discount_type', 'discount_value',
        'max_discount', 'min_purchase', 'max_uses', 'used_count', 'points_required',
        'valid_from', 'valid_until', 'status',
    ];

    protected function casts(): array
    {
        return [
            'valid_from'     => 'date',
            'valid_until'    => 'date',
            'discount_value' => 'decimal:2',
            'max_discount'   => 'decimal:2',
            'min_purchase'   => 'decimal:2',
        ];
    }

    public function redemptions()
    {
        return $this->hasMany(VoucherRedemption::class);
    }

    public function isValid(): bool
    {
        if ($this->status !== 'active') return false;
        if ($this->valid_until && $this->valid_until->isPast()) return false;
        if ($this->max_uses > 0 && $this->used_count >= $this->max_uses) return false;
        return true;
    }
}
