<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTask extends Model
{
    use HasFactory;

    protected $guarded = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }


}
