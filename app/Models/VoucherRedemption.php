<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherRedemption extends Model
{
    protected $fillable = [
        'voucher_id', 'user_id', 'points_spent', 'voucher_code', 'status', 'redeemed_at', 'expired_at'
    ];

    protected function casts(): array
    {
        return [
            'redeemed_at' => 'datetime',
            'expired_at'  => 'datetime',
        ];
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
