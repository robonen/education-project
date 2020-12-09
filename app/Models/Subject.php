<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function banktasks()
    {
        return $this->hasMany(BankTask::class);
    }

    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'academic_plans', 'class_id')
            ->withPivot('hours_per_week', 'hours_per_year');
    }

}
