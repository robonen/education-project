<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

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
            if ($this->role->name == $role)
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

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function parent()
    {
        return $this->hasOne(Parentt::class);
    }

    public function chatLinks()
    {
        return $this->hasMany(ChatLink::class, 'creator');
    }

}
