<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{    protected $fillable = [
    'hallname',
];
    public function reserve()
    {
        return $this->hasMany(Reserve::class, 'hall_id');
    }

    public function restrict()
    {
        return $this->hasMany(Restrict::class, 'hall_id');
    }
}
