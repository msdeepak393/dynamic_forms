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
    return view('index');
});
Route::get('/get-user-form', 'FrontendController@getFormData');

Auth::routes();

Route::group(["middleware" => ["auth","role"]], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/create-form', 'FormController@createForm')->name('create-form');
    Route::get('/get-option-types', 'FormController@getOptionTypes')->name('get-option-types');
    Route::post('/submit-form', 'FormController@submitForm')->name('submit-form');  
    Route::get('/show-form', 'FormController@showForm')->name('show-form');
    Route::get('/get-forms', 'FormController@getForms')->name('/get-forms');
    Route::get('/delete-forms/{id}', 'FormController@deleteForms');
    Route::get('/get-form-data/{id}', 'FormController@getFormData');
    Route::post('/update-form', 'FormController@updateForm')->name('update-form');  
 });
 
