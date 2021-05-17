<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::with('depts')->where('deptcode',"!=",'A0000');
            $validator = \Validator::make($request->all(), [
                'sortfield'   => 'in:id,name',
                'sortmethod'  => 'in:asc,desc',
            ]);
            if ($validator->fails()) {
                return $this->respondValidationError($validator);
            }
        $users = $this->filter($query);
        return view('users.index', compact('users'));
    }

    protected function filter($query)
    {
        if (request()->input('noapprove')) {
            $query->NoApprove();
        }
        $sort = request()->input('sortfield', 'id');
        $direction = request()->input('sortmethod', 'desc');
        return $query->orderBy("approve", "desc")->orderBy($sort, $direction)->paginate(10);
    }

    protected function respondValidationError(Validator $validator)
    {
        return back()->withInput()->withErrors($validator);
    }

    public function approve(Request $request)
    {
        $user = User::findOrFail($request->input("userid"));
        $user = $user->update([
            'approve'     => $request->input("approve"),
        ]);
        if($request->ajax()){
            return response()->json(['approve' => 'success']);

        }
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->input("userid"));
        $user->reserve()->delete();
        $user->delete();
        if($request->ajax()){
            return response()->json(['deleted' => 'success']);
        }
    }
}
