<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model
{
    use HasFactory;
    protected $table = 'task_files';
    protected $fillable = ['name', 'type', 'extension', 'url', 'task_id', 'user_id'];
    protected $hidden = ['review'];
}
