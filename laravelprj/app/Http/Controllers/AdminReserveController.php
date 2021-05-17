<?php

namespace App\Http\Controllers;

use App\Providers\AppServiceProvider;
use App\Reserve;
use App\Dept;
use App\Reservetime;
use App\Hall;
use App\User;
use App\Http\Requests\ReserveRequest;
use App\Http\Requests\ReserveFilterRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminReserveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = DB::table('reserves')->select('id, user_id, reserve_time, reserve_period, reserve_date, reserve_reason');
        $reserves = $query;
        $hallval = $request->input("hallid") == "" ?  Hall::find('1') : Hall::find($request->input("hallid"));
        $reservetimes = \App\Reservetime::all();

        return $this->respondCollection($reserves, $hallval,$reservetimes);
    }

    protected function respondCollection($reserves, $hallval, $reservetimes)
    {
        return view('reserve.index', compact('reserves'))->with("hall",$hallval)->with("reservetimes",$reservetimes);
    }

    public function userlist(Request $request)
    {
        $deptusers =  Dept::with('users')->get();

        return $this->responduserlist($deptusers);
    }

    protected function responduserlist($deptusers)
    {
        return view('reserve.userlist', compact('deptusers'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id'   => 'required',
            'hall_id' => 'required',
            'reservetime' => 'required',
            'reserve_date' => 'required',
            'reserve_reason' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->respondValidationError($validator);
        }
        $payload = $request->except('_token');
        $users = User::find($request->user_id);
        $payload["reserve_period"] = count($request->input("reservetime"));
        $hall_id = $request->input("hall_id");
        $reserve = $users->find($request->user_id)->reserve()->create($payload);
        $reserve->reservetime()->sync($request->input('reservetime'));
        DB::table('reserve_reservetime')->where('reserve_id', $reserve->id)->update(['reserve_date' => $reserve->reserve_date]);
        return $this->respondCreated($reserve, $hall_id);
    }

    protected function respondCreated(Reserve $reserve, $hall_id)
    {
        flash()->success("reserve create");

        return redirect(route('admin.reserve',['hallid' => $hall_id]));
    }

    public static function HallReserveList($hallid, $hallname, $inputDate)
    {
        $resvelists = Reserve::with("reservetime", "hall")->where('hall_id', $hallid)->where('reserve_date', $inputDate)->get();
        $resrvecollections=collect([]);
        $i="0";

        foreach($resvelists as $resvelist){
            $resrvecollections->put($i,
                [
                    "id" => $resvelist->id,
                    "user_id" => $resvelist->user_id,
                    "reserve_time" => $resvelist->reservetime,
                    "reserve_date" => $resvelist->reserve_date
                ]
            );
            $i++;
        }

        return $resrvecollections;
    }

    public static function HallReserveStatusGet($hallid, $hallname, $inputDate)
    {
        $resvelistsum = DB::table('reserves')->select(DB::raw("SUM(reserve_period) as sumperiod"))->where('hall_id', $hallid)->where('reserve_date', $inputDate)->get();
        $restrictreserve = DB::table('restricts')->select(DB::raw("COUNT(id) as restrictcnt"))->where('hall_id', $hallid)->where('reserve_date', $inputDate)->get();
        $resrvestatuscollection = [
            "reservesum" => $resvelistsum[0]->sumperiod,
            "restrictcnt" => $restrictreserve[0]->restrictcnt,
        ];

        return $resrvestatuscollection;
    }

    public function reservelist(Request $request)
    {
        $query= Reserve::with('reservetime','hall','user')->where("hall_id",$request->input("hallid"));
        $query = $this->filter($query);
        $reserves = $query->get();
        $hallname = Hall::where("id",$request->input("hallid"))->get();
        $page = $request->input("page") ?? 1;
        $count = $reserves->count();

        $perPage = 10;
        $offset = ($page-1) * $perPage;
        $reservesarr = [];
        foreach($reserves as $reserve){
                array_push($reservesarr, $reserve);
        }
        $reservesarrs = array_slice($reservesarr, $offset, $perPage);
        $reservesarr = new LengthAwarePaginator($reservesarrs, $count, $perPage, $page, ['path'  => $request->url(),'query' => $request->query(),]);

        return view('reserve.reservelist', ['reserves' => $reservesarr], ['reservescount' => $reserves->count()])->with( ['hallname' => $hallname[0]->hallname]);
    }

    protected function filter($query)
    {
        $sort = request()->input('sortfield', 'reserve_date');
        $direction = request()->input('sortmethod', 'desc');

        return $query->orderBy($sort, $direction);
    }

    public function reserveedit(Request $request)
    {
        $query = DB::table('reserves')->select('id, user_id, reserve_time, reserve_period, reserve_date, reserve_reason');


        $hallid =  $request->input("hallid");
        $hallname =  $request->input("hallname");
        $reserveid = $request->input("reserveid");
        $hall= new \stdClass();
        $hall->id = $request->input("hallid");
        $hall->hallname = $request->input("hallname");
        $userid = $request->input("userid");
        $username = $request->input("username");
        $reservedate = $request->input("reservedate");
        $reservereason = $request->input("reservereason");
        $reservetimes =Reserve::find($request->input("reserveid"));
        $reservetime_cur = array();

        foreach ($reservetimes->reservetime as $reservetime) {
            array_push($reservetime_cur,$reservetime->id);
        }
        $month = $request->input("month");

        return view('reserve.reservemodify', compact('reserveid'))->with("hall",$hall)->with("userid",$userid)->with("username",$username)->with("reservedate",$reservedate)->with("reservereason",$reservereason)->with("reservetime_cur",$reservetime_cur)->with("month",$month);
    }

    public function update(Request $request)
    {
        $payload = $request->except('_token');
        $reserve = Reserve::findOrFail($request->input('reserve_id'));
        $payload["reserve_period"] = count($request->input("reservetime"));
        $reserve->update($payload);
        $reserve->reservetime()->sync($request->input('reservetime'));
        DB::table('reserve_reservetime')->where('reserve_id', $reserve->id)->update(['reserve_date' => $reserve->reserve_date]);
        flash()->success("reserve modified");

        return redirect(route('admin.reservelist',["hallid" => $request->input("hall_id")]));

    }

    protected function respondValidationError(Validator $validator)
    {
        return back()->withInput()->withErrors($validator);
    }

    public function destroy(Request $request)
    {
        $reserve = Reserve::findOrFail($request->input("reserveid"));
        $reserve->delete();

        if($request->ajax()){
            return response()->json(['deleted' => 'success']);

        }
    }
}
