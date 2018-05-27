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

Route::model('user', 'App\Models\User');
Route::model('prof', 'App\Models\Professor\Professor');
Route::model('school', 'App\Models\School\School');

Route::group(['prefix' => '/auth'], function() {

	Route::post('login', 'Auth\LoginController@login')->name('login');

	Route::post('logout', 'Auth\LoginController@logout')->middleware('auth:api')
		->name('logout');

	Route::post('/pwd/change', 'ResetPasswordController@update')->middleware('auth:api')
		->name('pwd.change');

});

Route::post('/signup/student', 'Auth\RegisterController@create')->name('signup');

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

Route::group(['prefix' => '/deptartment'], function() {

	Route::post('/new', 'DepartmentController@create')->name('deptartment.create');

	Route::get('/fetch', 'DepartmentController@fetch')->name('deptartment.fetch');

	Route::get('{deptartment}', 'DepartmentController@index')->name('deptartment');

	Route::put('/{deptartment}', 'DepartmentController@update')->name('deptartment.update');

	Route::delete('/{deptartment}', 'DepartmentController@delete')->name('deptartment.delete');

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
