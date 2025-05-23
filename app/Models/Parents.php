<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    protected $fillable = [
        'user_id',
        'fathername',
        'job',
        'father_alive',
        'mothername',
        'mother_job',
        'mother_alive',
        'phonenumber',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
