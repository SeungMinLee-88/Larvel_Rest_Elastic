<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'MEMBER_NAME', 'MEMBER_DEPTCODE', 'MEMBER_ID', 'MEMBER_PW', 'MEMBER_ADMIN',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'MEMBER';
	
    protected $hidden = [
        'MEMBER_PW',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
	public function DEPTNAME()
    {
        return $this->belongsTo(DEPART::class,'DEPT_NAME');
    }
	
	public function DEPTCODE()
    {
        return $this->belongsTo(DEPART::class,'DEPT_CODE');
    }
	
	public function REFERENCES()
    {
        return $this->hasMany(ROOMA::class,'BOOK_MEMBER');
    }
	
	public function DOWNLOAD()
    {
        return $this->hasMany(DOWNLOAD::class,'DOWNLOAD_WRITER');
    }

	
}
