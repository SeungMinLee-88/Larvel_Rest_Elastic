<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserve extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'hall_id',
        'reserve_period',
        'reserve_date',
        'reserve_reason',
    ];

    protected $hidden = [
        'reserve_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }

    public function reservetime()
    {
        return $this->belongsToMany(Reservetime::class);
    }
}
