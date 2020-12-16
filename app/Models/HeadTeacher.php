<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadTeacher extends Model
{
    use HasFactory;

    protected $guarded = [
        'updated_at',
    ];

    protected $hidden = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
