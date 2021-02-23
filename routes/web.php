<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(["middleware" => ["auth", "2fa"]], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::group(["prefix" => "two_face_auths"], function() {
        Route::get("/", "TwoFaceAuthsController@index")->name("2fa_setting");
        Route::post("/enable", "TwoFaceAuthsController@enable")->name("enable_2fa_setting");
    });
});

Route::group(["middleware" => ["auth"], "prefix" => "two_face"], function() {
    Route::get("/", "VerifyTwoFaceController@index")->name("two_face.index");
    Route::post("/verify", "VerifyTwoFaceController@verify")->name("two_face.verify");
});