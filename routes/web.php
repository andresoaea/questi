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

// Authentification routes
Auth::routes();

// Home routes

// Route::get('/{url}', function ($url) {

//     return Redirect::to('/');

// })->where(['url' => 'url1|url2|url3']);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/{url}', 'HomeController@index')
    ->where(['url' => '/|most-answered|without-answer'])
    ->name('home');


Route::get('get-questions', 'QuestionController@getQuestions');

Route::get('add-question', 'QuestionController@create')->name('addQuestion');
Route::post('save-question', 'QuestionController@store')->name('saveQuestion');

//Profile 
Route::get('profile', 'ProfileController@index')->middleware('auth');
Route::get('profile/{any}', 'ProfileController@index')->middleware('auth');


// Administration routes
Route::redirect('admin', 'admin/dashboard', 301);
Route::prefix('admin')->middleware(['auth', 'checkAdmin'])->group(function() {
    Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('languages', 'Admin\LanguagesController@create')->name('languages');
});

Route::get('setloc', function() {
	//App::setLocale('en');

	var_dump( App::getLocale());	
});

Route::get('{category}/{slug}', 'QuestionController@show')->name('showSingleQuestion');

// Route::get('test', function() {

// 	 $t = App\Answer::whereAuthor(4)->paginate(5)->each(function($answer) {
// 	 		$answer->makeHidden(['id', 'for', 'author', 'reactions', 'updated_at']);
// 	 		$answer->setAppends(['related_question', 'related_author']);
// 	 	    return $answer;
// 	 });

// 	 dd($t);

// 	 //$model = 'App\Question';
// 	// $questions = $model::test()->whereAuthor(4)->get()->toArray();

// 	// $model = new App\Question;
// 	// $questions = $model->whereAuthor(4)->get()->first();
// 	// $questions->test()->toArray();

// 	// dd($questions);

// 	// foreach ($questions as $question) {
// 	// 	var_dump($question);
// 	// }
// });