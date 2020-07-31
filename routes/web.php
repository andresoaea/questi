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

// Route::get('/', function () {
//     return view('welcome');
// });


// Authentification routes
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('get-questions', 'HomeController@getQuestions');

Route::get('add-question', 'QuestionController@create')->name('addQuestion');


//Profile 
Route::get('profile', 'ProfileController@index')->middleware('auth');
Route::get('profile/{any}', 'ProfileController@index')->middleware('auth');