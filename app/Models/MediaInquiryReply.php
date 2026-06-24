<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaInquiryReply extends Model
{
    protected $fillable = [
        'media_inquiry_id',
        'message',
    ];

    public function inquiry()
    {
        return $this->belongsTo(MediaInquiry::class, 'media_inquiry_id');
    }
}
