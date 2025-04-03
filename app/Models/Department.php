<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;
    protected $table = "departments";
    protected $fillable = ['name', 'image'];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
