<?php

use Illuminate\Http\Request;
Use App\Job;
Use App\Project;
Use App\System;

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

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::get('open', 'DataController@open');

Route::get('projects', 'ProjectsController@index')->middleware('jwt.verify');
Route::get('project/{id}', 'ProjectsController@details')->middleware('jwt.verify');
Route::post('projects/new', 'ProjectsController@create')->middleware('jwt.verify');
Route::delete('project/{id}/delete', 'ProjectsController@delete')->middleware('jwt.verify');
Route::put('project/{id}/update', 'ProjectsController@update')->middleware('jwt.verify');

Route::get('systems', 'SystemsController@index')->middleware('jwt.verify');
Route::get('system/{id}', 'SystemsController@details')->middleware('jwt.verify');
Route::post('systems/new', 'SystemsController@create')->middleware('jwt.verify');
Route::delete('system/{id}/delete', 'SystemsController@delete')->middleware('jwt.verify');
Route::put('system/{id}/update', 'SystemsController@update')->middleware('jwt.verify');

Route::middleware('auth:api')

	->get('/user', function (Request $request) {
    	return $request->user();
});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
});