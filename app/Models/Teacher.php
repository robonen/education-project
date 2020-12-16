<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = [
        'updated_at',
    ];

    protected $hidden = [
        'user_id',
    ];

    public function schoolClass()
    {
        return $this->hasOne(SchoolClass::class, 'classroom_teacher');
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function tasks(){
        return $this->hasMany(Task::class);
    }

}
