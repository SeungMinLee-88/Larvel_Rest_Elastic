<?php

namespace App\Http\Controllers;

use App\Dept;
use App\User;
use Illuminate\Http\Request;
class DeptController extends Controller
{
    public function index(Request $request)
    {
        $query = new Dept;
        $query = $query->firstOrFail();
        $query = $this->SelectDeptList($request, $query->orderBy('deptcode', 'asc'));
        $depts = $query->get();
        $returnarray =array();
        for($i=0;$i<sizeof($depts);$i++){
		$returnarray[$i]["deptnum"] = $depts[$i]["deptnum"];
		$returnarray[$i]["deptcode"] = $depts[$i]["deptcode"];
		$returnarray[$i]["deptname"] = $depts[$i]["deptname"];
		$returnarray[$i]["deptdepth"] = $depts[$i]["deptdepth"];
        $repcode = $depts[$i]["deptcode"];
        $repcode = str_replace("0", "",$repcode);
        $depthval = $depts[$i]["deptdepth"];
        $depcount = $this->SelectDeptCount($repcode, $depthval);
        $usercount = $this->SelectUserCount($depts[$i]["deptcode"]);
        $returnarray[$i]["deptchild"] = $depcount;
        $returnarray[$i]["userchild"] = $usercount;
        }
        $returndepts = $returnarray;

            return response()->json($returndepts);

    }

    protected function SelectDeptList($request, $query)
    {
        $depth = $request->input('depth');
        if($depth == "0"){
            $code = null;
        }else{
        $code = $request->input('code');
        }
        if ($depth != null) {
            $query->where('deptdepth', $depth+1);
        }
        if ($code != null) {
            $query->where('deptcode', 'like', $code.'%');
        }

        return $query;
    }

    protected function SelectDeptCount($repcode, $depthval)
    {
        $repcode = $repcode;
        $depthval = $depthval;
        $deptquery = Dept::select(Dept::raw('count(*) as deptcount'))
            ->where('deptdepth', '>', $depthval)->where('deptcode', 'like', $repcode.'%')->get();

        return $deptquery[0]["deptcount"];
    }

    protected function SelectUserCount($deptcode)
    {
        $deptcode = $deptcode;
        $userquery = User::select(User::raw('count(*) as usercount'))->where('deptcode', $deptcode)->get();

        return $userquery[0]["usercount"];
    }

    protected function SelectUserList(Request $request)
    {
        $query = new User;
        $query = $query->orderBy('id', 'asc');
        $code = $request->input('depcode');
        $query = $query->where('deptcode', $code);
        $users = $query->get();
        $returnarray =array();
        $i=0;
        foreach($users as $user){
            $returnarray[$i]["usernum"] = $user->id;
            $returnarray[$i]["deptcode"] = $user->deptcode;
            $returnarray[$i]["username"] = $user->name;
            $i++;
        }
        $returnusers = $returnarray;

        return response()->json($returnusers);
    }
}
