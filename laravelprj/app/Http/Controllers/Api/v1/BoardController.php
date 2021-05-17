<?php
namespace App\Http\Controllers\Api\v1;
use App\Board;
use App\Transformers\BoardTransformer;
use App\Http\Controllers\BoardController as ParentController;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
class BoardController extends ParentController{
    use Helpers;
    public function __construct()
    {
        $this->middleware('api', ['except' => ['']]);
        //$this->middleware('jwt.auth', ['except' => ['index','show']]);
        $this->middleware('jwt.auth', ['except' => ['']]);
        $this->middleware('throttle.api:2,30');

        parent::__construct();
    }
    protected function respondCollection(LengthAwarePaginator $boards, $noticeboards)
    {
        return $this->response->paginator($boards, new BoardTransformer);
    }

    protected function respondValidationError(Validator $validator)
    {
        return $this->response->errorBadRequest();
    }
    protected function respondCreated(Board $board)
    {
        return $this->response->array(['status' => 'ok']);
    }

    protected function respondItem(Board $board, Collection $commentsCollection = null)
    {
        return $this->response->item($board, new BoardTransformer);
    }

    protected function respondUpdated(Board $board)
    {
        return json()->success('Updated');
    }

    protected function respondDeleted(Board $board)
    {
        return json()->noContent();
    }
}


