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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(["middleware" => ["auth","role"]], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/create-form', 'HomeController@createForm')->name('create-form');
 });
 
Route::get("/test", function(){ echo "<h3>Welcome To Route 2</h3>"; });