<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'registration_id',
        'exam_date',
        'total_marks',
        'pass_status'
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
