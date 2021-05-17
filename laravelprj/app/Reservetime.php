<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservetime extends Model
{
   protected $fillable = [
    'reservetime_id',
    'reserve_date',
];
    public function reserve()
    {
        return $this->belongsToMany(Reserve::class);
    }
}
