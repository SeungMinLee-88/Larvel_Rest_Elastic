<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restrict extends Model
{
    protected $fillable = [
        'hall_id',
        'reserve_date',
    ];

    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
}
