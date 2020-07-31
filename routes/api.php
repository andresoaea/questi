<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('answers/{question_id}', ['as' => 'answers.index', 'uses' => 'AnswerController@index']);


Route::get('reaction/{question_id}/{current_user?}', 'ReactionController@show');

Route::group(['middleware' => ['auth:api']], function () {
   // Route::resource('reaction', 'ReactionController', ['only' => ['store']]);

	// Answer routes
	Route::resource('answer', 'AnswerController', ['except' => ['index']]);

	// Reaction routes
    Route::post('reaction', 'ReactionController@store');
    Route::post('reaction/delete', 'ReactionController@delete');

    //Profile routes
    Route::group(['prefix' => 'profile'], function() {
    	Route::get('/', 'API\ProfileController@index');
    	Route::get('data/{expected_data}', 'API\ProfileController@getData');
   		Route::post('general', 'API\ProfileController@saveGeneralSettings');
   		Route::post('change-password', 'API\ProfileController@changePassword');
   		Route::delete('{to_delete}', 'API\ProfileController@delete');
    });

});