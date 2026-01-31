<?php

// app/Models/Teacher.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'title',
        'description',
        'image',
        'is_active',
    ];
}
