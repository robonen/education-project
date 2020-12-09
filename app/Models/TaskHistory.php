<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
    use HasFactory;

    protected $table = 'banktask_task';
    protected $fillable = ['banktask_id', 'task_id'];
    public $timestamps = false;
}
