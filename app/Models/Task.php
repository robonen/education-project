<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['banktask_id', 'deadline', 'teacher_id', 'class_id'];

    public function banktask() {
        return $this->belongsTo(BankTask::class);
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function class() {
       return  $this->belongsTo(SchoolClass::class);
    }

    public function tasks() {
       return $this->hasMany(Task::class);
    }

    public function answers() {
       return $this->hasMany(AnswerToTask::class);
    }

}
