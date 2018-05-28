<?php

use Illuminate\Http\Request;

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

Route::model('user', 'App\User');
Route::model('prof', 'App\Models\Professor\Professor');
Route::model('prof.review', 'App\Models\Professor\ProfessorReview');
Route::model('school', 'App\Models\School\School');
Route::model('department', 'App\Models\School\Department');

Route::group(['prefix' => '/auth'], function() {

	Route::post('login', 'Auth\LoginController@login')->name('login');

	Route::post('logout', 'Auth\LoginController@logout')->middleware('auth:api')
		->name('logout');

	Route::post('/pwd/change', 'Auth\ResetPasswordController@update')->middleware('auth:api')
		->name('pwd.change');

	Route::group(['prefix' => '/signup'], function() {

		Route::post('/student', 'Auth\RegisterController@createStudent')->name('signup.student');
		
		Route::post('/prof', 'Auth\RegisterController@createProf')->name('signup.prof');
	});

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/profile', 'middleware' => 'auth:api'], function() {

	Route::get('{user}', 'UserController@index')->name('profile');

	Route::put('{user}', 'UserController@update')->name('profile.update');

});

Route::group(['prefix' => '/prof'], function() {

	Route::post('/new', 'ProfessorController@create')->middleware('auth:api')->name('prof.create');

	Route::get('/fetch', 'ProfessorController@fetch')->name('prof.fetch');

	Route::get('{prof}', 'ProfessorController@index')->name('prof');

	Route::group(['prefix' => '/review'], function() {

		Route::post('/', 'ProfessorReviewController@create')->middleware('auth:api');

		Route::get('{prof.review}', 'ProfessorReviewController@index');

		Route::get('/prof/{id}', 'ProfessorReviewController@professor');

		Route::get('/tags', 'ReviewTagsController@index');

		Route::put('{prof.review}', 'ProfessorReviewController@update')->middleware('auth:api');

		Route::delete('{prof.review}', 'ProfessorReviewController@delete')->middleware('auth:api');

	});

	Route::group(['middleware' => ['auth:api','isAdmin']], function() {

		Route::put('/{prof}', 'ProfessorController@update')->name('prof.update');

		Route::delete('/{prof}', 'ProfessorController@delete')->name('prof.delete');

		Route::put('/{prof}/approve', 'ProfessorController@approve')->name('prof.approve');
	
	});

});

Route::group(['prefix' => '/school'], function() {

	Route::post('/new', 'SchoolController@create')->name('school.create');

	Route::get('/fetch', 'SchoolController@fetch')->name('school.fetch');

	Route::get('{school}', 'SchoolController@index')->name('school');

	Route::group(['middleware' => ['auth:api','isAdmin']], function() {

		Route::put('/{school}', 'SchoolController@update')->name('school.update');

		Route::put('/{school}/approve', 'SchoolController@approve')->name('school.approve');

		Route::delete('/{school}', 'SchoolController@delete')->name('school.delete');

	});

});

Route::group(['prefix' => '/department'], function() {

	Route::post('/new', 'DepartmentController@create')->name('department.create');

	Route::get('/fetch', 'DepartmentController@fetch')->name('department.fetch');

	Route::get('{department}', 'DepartmentController@index')->name('department');

	Route::put('/{department}', 'DepartmentController@update')->name('department.update');

	Route::delete('/{department}', 'DepartmentController@delete')->name('department.delete');

});

Route::group(['prefix' => '/admin'], function() {

	Route::get('fetch/users', 'UserController@fetch')->name('users.fetch');
});

/**
 * Add routes for :
 * CRUD ratings on professors & schools
 * Approve school & professors ratings
 * CRUD review tickets (corrections) for reviews, professors & schools
 * CRUD for rating student's written reviews
 */

Route::get('/login', function() {
	return 'please login';
})->name('login');
