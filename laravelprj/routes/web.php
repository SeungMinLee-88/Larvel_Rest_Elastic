<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* Image */
Route::pattern('image', '([a-z\/a-z0-9\-\_]+[\.gif|jpg|bmp|gif|png]+)');
Route::get('/images/{image}', [
    'uses' => 'ImageController@image'
])->name('Image.image');


/* Session */
Route::name('sessions.')->prefix('auth')->group(function () {
Route::get('login', [
    'uses' => 'SessionsController@create'
])->name('create');
Route::post('login', [
    'uses' => 'SessionsController@store'
])->name('store');
Route::get('logout', [
    'uses' => 'SessionsController@destroy'
])->name('destroy');
});

Route::get('welcome', [

    'uses' => 'SessionsController@index'
])->name('sessions.welcome');
Route::get('deptlist', [
    'uses' => 'DeptController@index'
])->name('api.dept.deptlist');

Route::get('userlist', [
    'uses' => 'DeptController@SelectUserList'
])->name('api.dept.userlist');

/* User Registration */
Route::name('member.')->prefix('auth')->group(function () {
    Route::get('create', [
        'uses' => 'UsersController@create'
    ])->name('create');
    Route::post('register', [
        'uses' => 'UsersController@store'
    ])->name('store');
});

/* Social login */
Route::get('social/google', [
    'uses' => 'SocialController@redirectToProvider',
])->name('social/google');

Route::get('social/google/callback', [
    'uses' => 'SocialController@handleProviderCallback',
])->name('social/google/callback');

/* Password Reminder */
Route::get('auth/remind', [
    'uses' => 'UsersController@getRemind',
])->name('auth.getremind');
Route::post('auth/remind', [
    'uses' => 'UsersController@postRemind',
])->name('auth.postremind');
Route::get('password/reset', [
    'uses' => 'UsersController@getReset',
])->name('password.reset');
Route::post('password/reset', [
    'uses' => 'UsersController@postReset',
])->name('password.reset');
Route::post('password/resetsotre', [
    'uses' => 'UsersController@resetsotre',
])->name('password.resetsotre');

/* Admin */
Route::group(['prefix' => 'admin'], function () {
    /* Admin Reserve*/
    Route::get('/reserve', [
        'uses' => 'AdminReserveController@index'
    ])->name('admin.reserve');
    Route::get('/reservelist', [
        'uses' => 'AdminReserveController@reservelist'
    ])->name('admin.reservelist');
    Route::get('/reserveedit', [
        'uses' => 'AdminReserveController@reserveedit'
    ])->name('admin.reserveedit');
    Route::post('/reserveedit', [
        'uses' => 'AdminReserveController@update'
    ])->name('admin.reserveedit');
    Route::post('/reservestore', [
        'uses' => 'AdminReserveController@store'
    ])->name('admin.reservestore');
    Route::get('/reservedelete', [
        'uses' => 'AdminReserveController@destroy'
    ])->name('admin.reservedelete');

    /* Admin Manage User*/
    Route::get('/userlist', [
        'uses' => 'AdminReserveController@userlist'
    ])->name('admin.userlist');
    Route::get('/restrictreserve', [
        'uses' => 'RestrictController@restrict'
    ])->name('admin.restrictreserve');
    Route::get('/unrestrictreserve', [
        'uses' => 'RestrictController@unrestrict'
    ])->name('admin.unrestrictreserve');
    Route::get('/manageruserlist', [
        'uses' => 'AdminUserController@index'
    ])->name('admin.manageruserlist');
    Route::get('/approveuser', [
        'uses' => 'AdminUserController@approve'
    ])->name('admin.approveuser');
    Route::get('/deleteuser', [
        'uses' => 'AdminUserController@destroy'
    ])->name('admin.deleteuser');
});

/* Member*/
Route::group(['prefix' => 'member'], function () {
    /* Member Reserve*/
    Route::get('/reserve', [
        'uses' => 'MemberReserveController@index'
    ])->name('member.reserve');
    Route::get('/reservelist', [
        'uses' => 'MemberReserveController@reservelist'
    ])->name('member.reservelist');
    Route::get('/reserveedit', [
        'uses' => 'MemberReserveController@reserveedit'
    ])->name('member.reserveedit');
    Route::post('/reserveedit', [
        'uses' => 'MemberReserveController@update'
    ])->name('member.reserveedit');
    Route::post('/reservestore', [
        'uses' => 'MemberReserveController@store'
    ])->name('member.reservestore');
    Route::get('/reservedelete', [
        'uses' => 'MemberReserveController@destroy'
    ])->name('member.reservedelete');


});

/* Board*/
Route::group(['prefix' => 'board'], function () {
    Route::get('/', [
        'uses' => 'BoardController@index'
    ])->name('board.index');
    Route::get('create', [
        'uses' => 'BoardController@create'
    ])->name('board.create');
    Route::post('store', [
        'uses' => 'BoardController@store'
    ])->name('board.store');
    Route::get('{id}', [
        'uses' => 'BoardController@show'
    ])->name('board.show');
    Route::get('{id}/edit', [
        'uses' => 'BoardController@edit'
    ])->name('board.edit');
    Route::put('update/{id}', [
        'uses' => 'BoardController@update'
    ])->name('board.update');
    Route::get('/delete/{id}', [
        'uses' => 'BoardController@destroy'
    ])->name('board.delete');
});

/* Comment*/
Route::group(['prefix' => 'comment'], function () {
    Route::post('/store', [
        'uses' => 'CommentController@store'
    ])->name('comment.store');
    Route::post('/update/{id}', [
        'uses' => 'CommentController@update'
    ])->name('comment.update');
    Route::get('/destroy/{id}', [
        'uses' => 'CommentController@destroy'
    ])->name('comment.destroy');
});

Route::resource('files', 'AttachmentsController', ['only' => ['store', 'destroy']]);
