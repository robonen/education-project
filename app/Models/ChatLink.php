<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'link',
        'class_id',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function creator()
    {
        return $this->hasMany(User::class, 'creator');
    }


}
