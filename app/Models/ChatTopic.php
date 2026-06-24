<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatTopic extends Model
{
    protected $fillable = ['keyword', 'response', 'category', 'is_escalation', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_escalation' => 'boolean',
            'is_active'     => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeEscalation($query)
    {
        return $query->where('is_escalation', true);
    }
}
