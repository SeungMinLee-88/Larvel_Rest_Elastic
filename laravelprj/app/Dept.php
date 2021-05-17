<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dept extends Model
{
    //
    protected $table = 'dept';

    protected $fillable = [
        'deptnum', 'deptcode', 'deptname', 'deptdepth',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function users()
    {
        return $this->hasMany(User::class,'deptcode','deptcode');
    }
/*    public function applydeptname()
    {
        return $this->hasMany(User::class,'deptcode');
    }

    public function applydeptcode()
    {
        return $this->hasMany(User::class,'deptcode');
    }*/
}
