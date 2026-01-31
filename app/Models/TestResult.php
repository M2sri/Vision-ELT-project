<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = [
        'student_id',
        'answers',
        'score',
        'level',
    ];

    protected $casts = [
        'answers' => 'array', // 🔥 AUTO JSON ↔ ARRAY
    ];

   
}
