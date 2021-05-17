<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destroy']);
        parent::__construct();
    }

    public function index()
    {
        return view('auth.welcome');
    }

    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return $this->respondValidationError($validator);
        }
        $approveget = User::select('email', 'password', 'approve')
            ->where('email', '=', $request->input('email'))->get();
        if(isset($approveget[0])) {
            $check = Hash::check($request->input('password'), $approveget[0]->password);
            $valid = false;
            if($check && $approveget[0]['approve'] == "y"){
                $valid = api_request()
                    ? JWTAuth::attempt($request->only('email', 'password'))
                    : Auth::attempt($request->only('email', 'password'), $request->has('remember'));
            }else if(!$check && $approveget[0]['approve'] == "y"){
                flash()->error(trans('auth.failed'));
            }else if($check && $approveget[0]['approve'] == "n"){
                flash()->error("account is not approved by admin");
            }else if(!$check && $approveget[0]['approve'] == "n"){
                flash()->error("Please, Check your account and is not approved by admin");
                return back()->withInput();
            }
            if (! $valid) {
                return $this->respondLoginFailed();
            }
       }else{
            flash()->error("User is not exist");
            return $this->respondLoginFailed();
       }

        return $this->respondCreated($request->input('return'));
    }

    protected function respondValidationError(Validator $validator)
    {
        return back()->withInput()->withErrors($validator);
    }

    protected function respondLoginFailed()
    {
        flash()->error(trans('auth.failed'));

        return back()->withInput();
    }

    protected function respondCreated($return = '')
    {
        $loginuser = Auth::user()->name;
        flash()->success("welcome $loginuser");
        return ($return)
            ? redirect(urldecode($return))
            : redirect()->intended("/board");
    }

    public function destroy()
    {
        Auth::logout();
        flash()->success("logout success");
        return redirect(route('sessions.create'));
    }
}
