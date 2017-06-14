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

// Access Key ID: AKIAIOX5M3Y4CGFTOUTA
//  abcdefgh06-21
// Secret Access Key: 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

Route::get('/', function () {
    return view('welcome');
});

Route::get('user', 'UserController@show');