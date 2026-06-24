<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointHistory extends Model
{
    protected $fillable = [
        'user_id', 'points', 'type', 'source', 'reference_id', 'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper to log an earn event and update user points
     */
    public static function earn(int $userId, int $points, string $source, string $description, ?int $referenceId = null): self
    {
        $history = self::create([
            'user_id'      => $userId,
            'points'       => $points,
            'type'         => 'earn',
            'source'       => $source,
            'reference_id' => $referenceId,
            'description'  => $description,
        ]);

        $userPoint = UserPoint::firstOrCreate(
            ['user_id' => $userId],
            ['total_points' => 0]
        );
        $userPoint->increment('total_points', $points);

        return $history;
    }

    /**
     * Helper to log a spend event and update user points
     */
    public static function spend(int $userId, int $points, string $source, string $description, ?int $referenceId = null): self
    {
        $history = self::create([
            'user_id'      => $userId,
            'points'       => $points,
            'type'         => 'spend',
            'source'       => $source,
            'reference_id' => $referenceId,
            'description'  => $description,
        ]);

        $userPoint = UserPoint::where('user_id', $userId)->first();
        if ($userPoint) {
            $userPoint->decrement('total_points', $points);
        }

        return $history;
    }
}
