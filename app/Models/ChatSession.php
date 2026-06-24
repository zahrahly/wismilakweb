<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    protected $fillable = ['user_id', 'name', 'email', 'status', 'mode', 'assigned_at', 'needs_admin'];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
        ];
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isBot(): bool
    {
        return $this->mode === 'bot';
    }

    public function isLive(): bool
    {
        return $this->mode === 'live';
    }

    public function switchToAdmin()
    {
        $this->update([
            'mode'        => 'live',
            'needs_admin' => true,
            'assigned_at' => now(),
        ]);
    }
}
