<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Parentt extends Model
{
    use HasFactory;

    protected $guarded = [
        'user_id',
    ];

}
