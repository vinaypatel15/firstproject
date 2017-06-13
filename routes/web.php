<?php

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

// Access Key ID: AKIAJ2J2RQTFGF2UGNOQ
// Secret Access Key: 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

Route::get('/', function () {
    return view('welcome');
});

Route::get('user', 'UserController@show');