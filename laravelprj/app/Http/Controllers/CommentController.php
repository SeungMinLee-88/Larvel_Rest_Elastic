<?php

namespace App\Http\Controllers;
use App\Board;
use App\Comment;
use Illuminate\Http\Request;
class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('author:comment', ['except' => ['store', 'vote']]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [

            'board_id'   => 'required|numeric',
            'parent_id'        => 'numeric|exists:comments,id',
            'content'          => 'required',
        ]);
        $comment = Board::find($request->input('board_id'))
            ->comments()->create([
                'writer_id' => \Auth::user()->id,
                'parent_id' => $request->input('parent_id', null),
                'content'   => $request->input('content')
            ]);
        flash()->success("comment is added");

        return back();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content'          => 'required',
        ]);
        $comment = Comment::findOrFail($id);
        $comment->update($request->only('content'));
        flash()->success("comment is updated");

        return back();
    }

    public function destroy(Request $request, $id)
    {
        $comment = Comment::with('replies')->find($id);
        $this->recursiveDestroy($comment);
        $comment->delete();
        if ($request->ajax()) {
            flash()->success('Your Flash Message for redirect');
            return response()->json('', 204);
        }
        flash()->success("comment is delted");

        return back();
    }

    public function recursiveDestroy(Comment $comment)
    {
        if ($comment->replies->count()) {
            $comment->replies->each(function($reply) {
                if ($reply->replies->count()) {
                    $this->recursiveDestroy($reply);
                } else {
                    $reply->delete();
                }
            });
        }

        return $comment->delete();
    }
}
