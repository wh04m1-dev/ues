<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentDetail extends Model
{
    protected $fillable = [
        'registration_id',
        'fathername',
        'father_job',
        'father_alive',
        'mothername',
        'mother_job',
        'mother_alive',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
