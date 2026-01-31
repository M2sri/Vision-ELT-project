<?php

// app/Models/TestAnswer.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestAnswer extends Model
{
    protected $fillable = [
        'student_id',
        'question_number',
        'selected_answer'
    ];
}
