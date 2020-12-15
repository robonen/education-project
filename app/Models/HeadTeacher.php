<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadTeacher extends Model
{
    use HasFactory;

    protected $guarded = [
        'user_id',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
