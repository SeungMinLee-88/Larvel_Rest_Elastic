<?php

namespace App\Http\Controllers;

use App\Board;
use App\Comment;
use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Requests\BoardRequest;
use App\Http\Requests\FilterBoardRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;

class BoardController extends Controller
{
    public function __construct()
    {
        if(api_request() == false){
        $this->middleware('author:board', ['only' => ['index', 'create','update', 'destroy', 'show']]);
        }
        parent::__construct();
    }

    public function index(Request $request)
    {
        $query = Board::with("comments");
        $noticequery = Board::with("comments")->Notice()->orderBy("created_at", "desc")->orderBy("updated_at", "desc")->get();
        $noticeboards = $noticequery;
        $validator = \Validator::make($request->all(), [
            'limit'  => 'size:1,10',
            'sortfield'   => 'in:created_at,title',
            'sortmethod'  => 'in:asc,desc',
        ]);
        if ($validator->fails()) {
            return $this->respondValidationError($validator);
        }
        $boards = $this->filter($query);

        return $this->respondCollection($boards, $noticeboards);
    }
    protected function respondCollection(LengthAwarePaginator $boards, $noticeboards)
    {
        return view('board.index', compact('boards'))->with("noticeboards",$noticeboards);
    }

    protected function filter($query)
    {
        if ($keyword = request()->input('search')) {
            if (request()->input('searchfield') == "writer"){
                $writerkeyword = User::select('id')->where('email', 'like', "%".request()->input('search')."%")->get();
                $raw = 'writer_id = ?';
                $query=$query->whereRaw($raw, $writerkeyword[0]["id"]);
            }else{
                $query=$query->whereRaw("MATCH(".request()->input("searchfield").") AGAINST('*".$keyword."*' in boolean mode)");
            }

        }
        $sort = request()->input('sortfield', 'id');
        $direction = request()->input('sortmethod', 'desc');
        return $query->orderBy($sort, $direction)->paginate(10);
    }

    protected function respondValidationError(Validator $validator)
    {
        return back()->withInput()->withErrors($validator);
    }

    public function create()
    {
        $board = new Board;

        return view('board.create', compact('board'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->respondValidationError($validator);
        }
        $payload = array_merge($request->except('_token'), [
            'writer_alert' => $request->has('writer_alert')
        ]);
        $board = $request->user()->boards()->create($payload);
        if ($request->has('attachments')) {
            $attachments = \App\Attachment::whereIn('id', $request->input('attachments'))->get();
            $attachments->each(function($attachment) use($board) {
                $attachment->board()->associate($board);
                $attachment->save();
            });
        }
        return $this->respondCreated($board);
    }

    protected function respondCreated(Board $article)
    {
        flash()->success("board create");

        return redirect(route('board.index'));
    }

    public function show($id)
    {
        $board = Board::with('attachments','comments')->findOrFail($id);
        $comments = $board->comments;
        return $this->respondItem($board, $comments);
    }

    protected function respondItem(Board $board, Collection $comment)
    {
        return view('board.show', [
            'board' => $board,
            'comments'  => $comment,
            'board_id'  => $board ->id,
        ]);
    }

    public function edit($id)
    {
        $board = Board::with('attachments')->findOrFail($id);
        return view('board.edit', compact('board'));
    }

    public function update(Request $request, $id)
    {
        $payload = array_merge($request->except('_token'), [
            'noticed' => $request->has('noticed')
        ]);
        $board = Board::findOrFail($id);
        $board->update($payload);
        if ($request->has('attachments')) {
            $attachments = \App\Attachment::whereIn('id', $request->input('attachments'))->get();
            $attachments->each(function($attachment) use($board) {
                $attachment->board()->associate($board);
                $attachment->save();
            });
        }
        return $this->respondUpdated($board);
    }

    protected function respondUpdated(Board $board)
    {
        flash()->success(trans('common.updated'));

        return redirect(route('board.show', $board->id));
    }

    public function destroy($id)
    {
        $board = Board::with('attachments','comments')->findOrFail($id);

        foreach($board->attachments as $attachment) {
            \File::delete(attachment_path($attachment->name));
        }

        $board->attachments()->delete();

        $board->delete();
        return $this->respondDeleted($board);
    }

    protected function respondDeleted(Board $article)
    {
        flash()->success("board is deleted");

        return redirect(route('board.index'));
    }
}
