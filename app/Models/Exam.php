<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'user_id',
        'exam_date',
        'total_marks',
        'pass_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
