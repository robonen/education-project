<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];
}
