<?php
namespace App\Http\Controllers\Api\v1;
use App\User;
use App\Reserve;
use App\Transformers\ReserveTransformer;
use App\Transformers\UserTransformer;
use App\Http\Controllers\MemberReserveController as ParentController;
use Dingo\Api\Routing\Helpers;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class MemberReserveController extends ParentController{
    use Helpers;
    public function __construct()
    {
        $this->middleware('api', ['except' => ['']]);
        //$this->middleware('jwt.auth', ['except' => ['reservelist','apiuserList','reservecreate','store']]);
        $this->middleware('jwt.auth', ['except' => ['reservelist','apiuserList','reservecreate']]);
        /*        $this->middleware('throttle.api:1,60');*/

        parent::__construct();
    }
        public function apireservelist(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'hallid'    => 'required|min:1',
            'reservedate' => 'required|date',
        ]);
        if ($validator->fails()) {
            return $this->response->array(['status' => 'invalid value input']);
        }
        $hallid = $request->input("hallid");
        $reservedate = $request->input("reservedate");
        $resvelists = Reserve::with("reservetime", "hall")->where('hall_id', $hallid)->where('reserve_date', 'like', $reservedate.'%')->paginate();
        return $this->response->paginator($resvelists, new ReserveTransformer);
    }

    public function apimyreservelist(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'hallid'    => 'required|min:1',
            'reservedate' => 'required|date',
        ]);
        if ($validator->fails()) {
            return $this->response->array(['status' => 'invalid value input']);
        }
        $hallid = $request->input("hallid");
        $reservedate = $request->input("reservedate");
        $resvelists = Reserve::with("reservetime", "hall")->where('hall_id', $hallid)->where("user_id",$request->user()->id)->where('reserve_date', 'like', $reservedate.'%')->paginate();

        return $this->response->paginator($resvelists, new ReserveTransformer);
    }

    protected function respondCreated(Reserve $reserve, $hall_id)
    {
        return $this->response->created();
    }

    protected function respondValidationError(Validator $validator)
    {
        return $this->response->errorBadRequest();
    }
}


