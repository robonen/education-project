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

    public function banktasks()
    {
        return $this->hasMany(BankTask::class);
    }

    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'academic_plans')->withPivot('hours_per_week', 'hours_per_year');
    }

}
