<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use jeremykenedy\LaravelRoles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject as JWTSubject;
class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    HasRoleAndPermissionContract,
    JWTSubject
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    use HasRoleAndPermission;
    use Notifiable;
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'deptname', 'deptcode', 'password', 'admin', 'approve'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['last_login'];

    public function depts()
    {
        return $this->belongsTo(Dept::class,'deptcode', 'deptcode');
    }

    public function boards()
    {
        return $this->hasMany(Board::class,'writer_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class,'writer_id');
    }

    public function reserve()
    {
        return $this->hasMany(Reserve::class,'user_id');
    }

    public function scopeNoPassword($query)
    {
        return $query->whereNull('password');
    }

    public function getuserRoles()
    {
        return $this->getRoles();
    }

    public function isAdmin()
    {
        return $this->roles()->where('slug','admin')->exists();
    }
    public function scopeNoApprove($query)
    {
        return $query->where('approve', '=', "n");
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
