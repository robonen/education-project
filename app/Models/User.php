<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @param array $roles
     * @return bool
     */
    public function hasRole(array $roles)
    {
        foreach ($roles as $role)
        {
            if ($this->role->contains('name', $role))
                return true;
        }

        return false;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function headteacher()
    {
        return $this->hasOne(HeadTeacher::class);
    }

    public function makeToken(bool $remember)
    {
        $token = $this->createToken(config('app.name'));
        $token->token->expires_at = $remember ? Carbon::now()->addMonth() : Carbon::now()->addDay();
        $token->token->save();
        return $token;
    }
}
