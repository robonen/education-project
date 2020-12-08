<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicPlan extends Model
{
    use HasFactory;

    protected $primaryKey = ['subject_id', 'class_id'];

    public $incrementing = false;
}
