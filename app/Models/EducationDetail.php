<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationDetail extends Model
{
    protected $fillable = [
        'registration_id',
        'education_name',
        'education_image',
        'education_date',
        'education_location',
        'education_grade',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
