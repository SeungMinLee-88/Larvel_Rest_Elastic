<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
        $api->group(['prefix' => 'v1'], function ($api) {
            /*************************************************
             *
             * Accommodation Api Crud
             *
             **************************************************/
            /* Session*/
            $api->post('auth/login', 'App\Http\Controllers\Api\v1\SessionsController@store');
            $api->get('auth/token', 'App\Http\Controllers\Api\v1\SessionsController@refresh');
            $api->get('auth/sendpass', 'App\Http\Controllers\Api\v1\SessionsController@sendpass');

            /* Admin Reserve*/
            $api->group(['prefix' => 'admin'], function ($api) {
                $api->get('reservelist',[
                    'uses' => 'App\Http\Controllers\Api\v1\AdminReserveController@apireserveList'
                ])->name('api.v1.board.admin.apireserveList');
                $api->get('userlist',[
                    'uses' => 'App\Http\Controllers\Api\v1\AdminReserveController@apiuserList'
                ])->name('api.v1.board.admin.apiuserList');
                $api->post('reservecreate',[
                    'uses' => 'App\Http\Controllers\Api\v1\AdminReserveController@store'
                ])->name('api.v1.board.admin.reservecreate');
            });
            /* Member Reserve*/
            $api->group(['prefix' => 'member'], function ($api) {
                $api->get('reservelist',[
                    'uses' => 'App\Http\Controllers\Api\v1\MemberReserveController@apireservelist'
                ])->name('api.v1.board.member.apireserveList');
                $api->get('myreservelist',[
                    'uses' => 'App\Http\Controllers\Api\v1\MemberReserveController@apimyreservelist'
                ])->name('api.v1.board.member.apireserveList');
                $api->post('reservecreate',[
                    'uses' => 'App\Http\Controllers\Api\v1\MemberReserveController@store'
                ])->name('api.v1.board.member.reservecreate');
            });
            /* Board*/
            $api->get('board', 'App\Http\Controllers\Api\v1\BoardController@index');
            $api->get('board/{id}',[
                'uses' => 'App\Http\Controllers\Api\v1\BoardController@show'
            ])->name('api.v1.board.show');
            $api->post('board/create',[
                'uses' =>  'App\Http\Controllers\Api\v1\BoardController@store'
            ])->name('api.v1.board.store');
        });
});

