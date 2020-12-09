<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'deadline', 'teacher_id', 'subject_id'];

    public function banktask() {
        return $this->hasMany(BankTask::class, 'class_task');
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function class() {
        $this->belongsTo(SchoolClass::class);
    }

}
