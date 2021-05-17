<?php

namespace App\Http\Controllers;

use App\User;
use App\Dept;
use App\Transformers\ArticleTransformer;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
        parent::__construct();
    }
    public function create(Request $request)
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
            $returnarray[$i]["deptchild"] = $depcount;
        }
        $returndepts = $returnarray;
        if (api_request() == false) {

            return view('auth.register', compact('returndepts'));
        }else if(api_request() == true){

            return json()->respond($returndepts);
        }
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

    protected function SelectUserCount($request, $query)
    {
        $depth = $request->input('depth');
        $code = $request->input('code');
        if ($depth != null) {
            $query->where('deptdepth', $depth+1);
        }
        if ($code != null) {
            $query->where('code', 'like', $code.'%');
        }

        return $query;
    }

    public function store(Request $request)
    {
        if ($user = User::where('email', '=', $request->input('email'))->noPassword()->first()) {
            return $this->syncAccountInfo($request, $user);
        }

        return $this->createAccount($request);
    }

    protected function syncAccountInfo(Request $request, User $user)
    {
        $validator = \Validator::make($request->except('_token'), [
            'deptname'     => 'required|min:3|max:255',
            'deptcode'     => 'required|min:3|max:255',
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return $this->respondValidationError($validator);
        }
        $user->update([
            'name'     => $request->input('name'),
            'password' => bcrypt($request->input('password')),
        ]);
        $this->addMemberRole($user);

        return $this->respondCreated($user);
    }

    protected function createAccount(Request $request)
    {
        $validator = \Validator::make($request->except('_token'), [
            'deptname'     => 'required|min:3|max:255',
            'deptcode'     => 'required|min:3|max:255',
            'name'     => 'required|max:255|unique:users',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return $this->respondValidationError($validator);
        }
        $user = User::create([
            'deptcode'     => $request->input('deptcode'),
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        $this->addMemberRole($user);

        return $this->respondCreated($user);
    }

    protected function addMemberRole(User $user)
    {
        // 1 is admin, 2 is member
        return $user->roles()->sync([2]);
    }

    protected function respondValidationError(Validator $validator)
    {
        return back()->withInput()->withErrors($validator);
    }

    protected function respondCreated(User $user)
    {
        flash("Account ".$user->name." is created");
        return redirect(route('sessions.create'));
    }
    public function getRemind()
    {
        return view('auth.password');
    }

    public function postRemind(Request $request)
    {
        $validator = \Validator::make($request->all(),['email' => 'required|email']);
        if ($validator->fails()) {
            flash()->error("password field is required");
            return back()->withInput()->withErrors($validator);;
        }
        if (User::where('email', '=', $request->input('email'))->noPassword()->first()) {
            $message = sprintf("%s %s", "user singed at social");
            return back()->withInput();
        }
        $response = Password::sendResetLink($request->only('email'), function ($m) {
            $m->subject("password reset link");
        });
        switch ($response) {
            case Password::RESET_LINK_SENT:
                flash()->error("Password reset link is sent");
                return back()->withInput();

            case Password::INVALID_USER:
                flash("invalid user email");
                return back();
        }
    }

    public function getReset(Request $request)
    {
        if (is_null($request->input("token"))) {
            throw new NotFoundHttpException;
        }
        return view('auth.reset')->with('token', $request->input("token"))->with('email', $request->input("email"));
    }

    public function postReset(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed',
        ]
        );
        if ($validator->fails()) {

            flash()->error("some field is required");
            return back()->withInput()->withErrors($validator);;
        }

        $resetvalue = $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );
        $response = Password::reset($resetvalue, function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });
        flash()->error("Your password is reset");
        return redirect(route('sessions.create'));
    }
}
