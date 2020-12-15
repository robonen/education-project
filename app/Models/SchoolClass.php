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
        'profile',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'academic_plans', 'class_id')
            ->withPivot('hours_per_week', 'hours_per_year');
    }

    public function chatLinks()
    {
        return $this->hasMany(ChatLink::class, 'class_id');
    }


}
