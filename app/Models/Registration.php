<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
    ];

    public function personalDetail()
    {
        return $this->hasOne(PersonalDetail::class);
    }

    public function parentDetail()
    {
        return $this->hasOne(ParentDetail::class);
    }

    public function educationDetail()
    {
        return $this->hasOne(EducationDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
