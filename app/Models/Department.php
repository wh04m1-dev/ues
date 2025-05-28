<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = "departments";

    protected $fillable = ['name', 'image', 'description'];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
