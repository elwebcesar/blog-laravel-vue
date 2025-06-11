<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::fallback(function () {
    return response()->json(
    [
        'status'=> 'success',
        'code'=> 200,
        'message'=> 'Conexión exitosa',
        'resultado'=> [
            'status'=> 'danger',
            'code'=> 401,
            'message'=> 'Token expirado o incorrecto',
        ]
    ], 200);
});

// OPEN END POINTS
// all post
Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');

// paginated post
Route::get('/posts/paginated', [App\Http\Controllers\PostController::class, 'paginated'])->name('posts.paginated');

// specified post
Route::get('/posts/{id}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');


Route::prefix('v1')->middleware('throttle:530,1')->group(function () {
    Route::post('auth/signup', [App\Http\Controllers\AuthController::class, 'signup'])->name('signup');
    Route::post('auth/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
});


// END POINTS WITH TOKEN
Route::prefix('v1')->namespace('App\Http\Controllers')->middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::post('post/get', 'PostController@get')->name('get');
    Route::post('post/delete', 'PostController@delete')->name('delete');
    Route::post('post/save', 'PostController@save')->name('save');

    Route::post('user/update', 'UserController@update')->name('update');
    Route::post('user/avatar', 'UserController@avatar')->name('avatar');

    Route::post('auth/token', 'AuthController@token')->name('token');

    Route::post('user/mypermits', 'UserController@mypermits')->name('mypermits');
    Route::post('user/assignpermit', 'UserController@assignpermit')->name('assignpermit');

    Route::post('user/get', 'UserController@get')->name('get');
    Route::post('user/delete', 'UserController@delete')->name('delete');
    Route::post('user/save', 'UserController@save')->name('save');

    Route::post('module/get', 'ModuleController@get')->name('get');
    Route::post('module/delete', 'ModuleController@delete')->name('delete');
    Route::post('module/save', 'ModuleController@save')->name('save');
});
