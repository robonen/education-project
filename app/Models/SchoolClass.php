<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'letter',
        'count_students',
        'profile',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'classroom_teacher');
    }
}
