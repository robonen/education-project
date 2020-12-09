<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerToTask extends Model
{
    use HasFactory;

    protected $table = 'answers_to_task';
    protected $fillable = ['description', 'student_id', 'task_id', 'class_id', 'checked', 'mark', 'comment_by_teacher'];
}
