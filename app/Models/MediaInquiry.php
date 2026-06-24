<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaInquiry extends Model
{
protected $fillable = [
    'name',
    'email',
    'phone',
    'organization',
    'subject',
    'inquiry_type',
    'message',
    'is_read',
];
    public function replies()
{
    return $this->hasMany(MediaInquiryReply::class);
}

}

