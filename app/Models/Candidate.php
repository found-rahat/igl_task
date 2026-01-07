<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'experience_years',
        'previous_experience',
        'age',
        'status',
        'interview_date',
    ];

    protected $casts = [
        'previous_experience' => 'array',
        'interview_date' => 'datetime',
    ];
}
