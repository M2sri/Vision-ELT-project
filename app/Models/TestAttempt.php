<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestAttempt extends Model
{
    protected $fillable = [
        'student_id',
        'kid_id',
        'test_id',
        'status',
        'score',
        'total_marks',
        'percentage',
        'level',
        'started_at',
        'submitted_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at'   => 'datetime',
        'submitted_at' => 'datetime',
        'completed_at' => 'datetime',
        'percentage'   => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Adult student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Kid student
    public function kid()
    {
        return $this->belongsTo(Kid::class);
    }

    // Test being taken
    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    // Answers for this attempt
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers (optional but useful)
    |--------------------------------------------------------------------------
    */

    public function isKid(): bool
    {
        return !is_null($this->kid_id);
    }

    public function isAdult(): bool
    {
        return !is_null($this->student_id);
    }
}
