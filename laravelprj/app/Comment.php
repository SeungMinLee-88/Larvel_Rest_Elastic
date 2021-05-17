<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'board_id',
        'writer_id',
        'parent_id',
        'title',
        'content'
    ];

    protected $hidden = [
        'writer_id',
        'commentable_type',
        'commentable_id',
        'parent_id',
        'deleted_at',
    ];
    public function writer()
    {
        return $this->belongsTo(User::class, 'writer_id');
    }

    public function boards()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'id', 'parent_id');
    }
    public function isWriter()
    {
        return $this->writer->id == auth()->user()->id;
    }
}
