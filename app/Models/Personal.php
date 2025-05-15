<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'personal_code',
        'name_kh',
        'name_en',
        'gender',
        'dob',
        'pob',
        'nationality',
        'marital_status',
        'email',
        'phone',
        'address',
        'current_address',
        'status'
    ];
}
