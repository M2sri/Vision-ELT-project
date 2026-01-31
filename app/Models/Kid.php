<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


    class Kid extends Model
{
    protected $fillable = [
        'zone', 'kid_name', 'age', 'phone', 'country', 'city'
    ];

    public function testAttempts()
    {
        return $this->hasMany(TestAttempt::class);
    }

    public function completedTestAttempts()
    {
        return $this->hasMany(TestAttempt::class)
            ->where('status', 'completed');
    }

    public function inProgressTestAttempt()
    {
        return $this->hasOne(TestAttempt::class)
            ->where('status', 'in_progress');
    }

    public function latestCompletedAttempt()
    {
        return $this->hasOne(TestAttempt::class)
            ->where('status', 'completed')
            ->latestOfMany();
    }
}


