<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'country',
        'city',
        'branch',
        'age',
        'phone',
        'whatsapp',
        'prefer_time',
        'attempts',
    ];

    /* =========================
       TEST RESULTS (FINAL SCORE)
    ========================= */

    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    /* =========================
       TEST ATTEMPTS (LIFECYCLE)
    ========================= */

    public function testAttempts(): HasMany
    {
        return $this->hasMany(TestAttempt::class);
    }

    public function completedTestAttempts(): HasMany
    {
        return $this->hasMany(TestAttempt::class)
            ->where('status', 'completed');
    }

    public function inProgressTestAttempt(): HasOne
    {
        return $this->hasOne(TestAttempt::class)
            ->where('status', 'in_progress')
            ->latest();
    }

    public function latestCompletedAttempt(): HasOne
    {
        return $this->hasOne(TestAttempt::class)
            ->where('status', 'completed')
            ->latest();
    }
}
