<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
class Board extends Model
{
    //use SoftDeletes;
    protected $fillable = [
        'writer_id',
        'title',
        'content',
        'writer_alert',
        'noticed',
    ];

    protected $hidden = [
        'writer_id',
        'writer_alert',
        'noticed',
    ];
    protected $dates = [
        'deleted_at'
    ];

    public function writer()
    {
        return $this->belongsTo(User::class, 'writer_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,'board_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class,'board_id');
    }
    public function isWriter()
    {
        return $this->writer->id == auth()->user()->id;
    }
    public function isNoticed()
    {
        return $this->noticed ? true : false;
    }
    public function scopeNotice($query)
    {
        return $query->where('noticed', '=', true);
    }
}
