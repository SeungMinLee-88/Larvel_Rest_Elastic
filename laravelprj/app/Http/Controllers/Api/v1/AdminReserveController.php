<?php
namespace App\Http\Controllers\Api\v1;
use App\User;
use App\Reserve;
use App\Transformers\ReserveTransformer;
use App\Transformers\UserTransformer;
use App\Http\Controllers\AdminReserveController as ParentController;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AdminReserveController extends ParentController{
    use Helpers;
    public function __construct()
    {
        $this->middleware('api', ['except' => ['']]);
        $this->middleware('jwt.auth', ['except' => ['apireserveList']]);
        parent::__construct();
    }
    public function apireserveList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hallid'   => 'required',
            'reservedate' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->respondValidationError($validator);
        }
        $hallid = $request->input("hallid");
        $reservedate = $request->input("reservedate");
        $resvelists = Reserve::with("reservetime", "hall")->where('hall_id', $hallid)->where('reserve_date', 'like', $reservedate.'%')->paginate();

        return $this->response->paginator($resvelists, new ReserveTransformer);

    }
    public function apiuserList(Request $request)
    {
        $users =  User::all();
        return  $this->response->collection($users, new UserTransformer);
    }

    protected function respondCreated(Reserve $reserve, $hall_id)
    {
        return $this->response->created();
    }

    protected function respondValidationError($validator)
    {
        return $this->response->array(['error message' => $validator->errors()]);
    }
}


