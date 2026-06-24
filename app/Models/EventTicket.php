<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    protected $fillable = [
        'registration_id',
        'full_name',
        'email',
        'phone',
        'date_of_birth',
        'ktp_number',
        'ktp_file'
    ];

    public function registration()
    {
        return $this->belongsTo(EventRegistration::class);
    }

}
