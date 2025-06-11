<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::namespace('App\Http\Controllers')->group( function () {
    Route::get('viewfile/{filename}', 'ImageController@viewfile')->name('viewfile');
});

