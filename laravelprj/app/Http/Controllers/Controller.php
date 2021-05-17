<?php

namespace App\Http\Controllers;
use App\Hall;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $cache;
    private $sessionuser;
    private $signed_in;
    public $sidemenu;
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->sessionuser = Auth::user();
            $this->signed_in = Auth::check();
            $this->signed_in = Auth::check() ? view()->share('currentUser', $this->sessionuser) : view()->share('currentUser', "");
            $this->sidemenu = DB::table('halls')->select('id','hallname')->get();
            view()->share('sidemenus', $this->sidemenu);
            view()->share('currentRouteName', \Route::currentRouteName());
            view()->share('currentUrl', \Request::fullUrl());
            return $next($request);
        });
        $this->cache = app('cache');
    }
}
