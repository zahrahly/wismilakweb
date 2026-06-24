<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutletProduct extends Model
{
    protected $fillable = ['outlet_id', 'product_id', 'is_available', 'notes'];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
