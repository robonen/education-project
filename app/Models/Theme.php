<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'variant'
    ];

    public function banktaks()
    {
        return $this->hasMany(BankTask::class);
    }
}
