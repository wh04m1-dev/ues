<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
