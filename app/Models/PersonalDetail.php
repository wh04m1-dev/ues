<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalDetail extends Model
{
    protected $fillable = [
        'registration_id',
        'firstname',
        'lastname',
        'picture',
        'gender',
        'dob',
        'address',
        'phone',
        'phonenumber',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
