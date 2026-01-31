<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'test_id',
        'type',
        'question',
        'options',
        'correct_answer',
        'section',
        'marks',
        'order',
    ];

    // 🔑 THIS IS THE MISSING PIECE
    protected $casts = [
        'options' => 'array',
        'correct_answer' => 'array',
    ];

    public function totalMarks(): int
{
    if ($this->type === 'match') {
        return is_array($this->correct_answer)
            ? count($this->correct_answer) * $this->marks
            : 0;
    }

    return $this->marks;
}


}



