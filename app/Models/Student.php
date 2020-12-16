<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Student extends Model
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
        return $this->belongsTo(SchoolClass::class, 'class_id')->where('');
    }
    public function scores()
    {
        return $this->hasMany(Journal::class, 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
