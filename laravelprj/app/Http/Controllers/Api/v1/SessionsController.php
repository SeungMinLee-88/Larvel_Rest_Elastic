<?php

namespace App\Http\Controllers\Api\v1;
Use App\Http\Controllers\SessionsController as ParentController;
use App\Mail\OrderShipped;
use App\User;
use http\Env\Request;
use Illuminate\Contracts\Validation\Validator;
use Dingo\Api\Routing\Helpers;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
class SessionsController extends ParentController{
    use Helpers;
public function __construct()
{
    $this->middleware = [];
    $this->middleware('jwt.auth', ['only' => ['login']]);
    $this->middleware('token.refresh', ['only' => ['refresh']]);
    parent::__construct();
}
    public function store(\Illuminate\Http\Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return $this->response->array(['status' => 'invalid value input']);
        }
        $approveget = User::select('email', 'password', 'approve')
            ->where('email', '=', $request->input('email'))->get();

        if(isset($approveget[0])) {
            $check = Hash::check($request->input('password'), $approveget[0]->password);

            $valid = false;
            if($check && $approveget[0]['approve'] == "y"){
                $valid = JWTAuth::attempt($request->only('email', 'password'));
            }else if(!$check && $approveget[0]['approve'] == "y"){
                return $this->response->array(['status' => 'authenticate fail']);

            }else if($check && $approveget[0]['approve'] == "n"){
                return $this->response->array(['status' => 'account is not approved by admin']);
            }else if(!$check && $approveget[0]['approve'] == "n"){
                return $this->response->array(['status' => 'Please, Check your account and is not approved by admin']);
            }
            if (!$valid) {
                //return $this->respondLoginFailed();
            }
        }else{
            return $this->response->array(['status' => 'User is not exist']);
        }
        if($request->input('ajaxcall')){

            return $this->response->array(['token' => $valid, 'status' => 'success']);
        }else{
            return $this->respondCreated($request->input('return'), $valid);
        }
    }

    protected function respondValidationError(Validator $validator)
    {
        return $this->response->errorBadRequest();

    }

    protected function respondLoginFailed()
    {
        return $this->response->errorUnauthorized();
    }

    protected function respondCreated($return = '', $token = '')
    {
        $token = ['token' => $token];
        return $this->response->array($token, new UserTransformer);
    }
    public function refresh()
    {
        return true;
    }
    protected function sendpass(\Illuminate\Http\Request $request)
    {
        $temppass = bcrypt(str::random(10));
        $user= User::where('email', '=', $request->input('email'))->update(['password' => $temppass]);
        Mail::to($request->input('email'))->send(new OrderShipped($temppass));

        return  $user == true ? "success" : $this->response->errorUnauthorized();
    }
}
