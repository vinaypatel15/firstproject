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

// Access Key ID: AKIAJBBDWTVA2GR37Y6A
//  123456066a-21
// Secret Access Key: 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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/items', 'MainController@getItems');