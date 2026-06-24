<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerProfile extends Model
{
    protected $fillable = [
        'user_id', 'company_name', 'company_address', 'contact_person', 'phone', 'logo',
        'business_description', 'business_license',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
