<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $guarded = [
        'board_id',
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }
}
