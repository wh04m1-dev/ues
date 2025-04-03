<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    //
    protected $table = 'education';
    protected $fillable = [
        'education_name',
        'education_date',
        'education_location',
        'education_grade',
        'user_id'
    ];
}
