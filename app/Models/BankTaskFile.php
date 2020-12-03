<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTaskFile extends Model
{
    use HasFactory;
    protected $table = 'bank_tasks_files';
    protected $fillable = ['name', 'type', 'extension', 'url', 'banktask_id'];
}
