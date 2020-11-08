<?php

use Illuminate\Http\Request;
Use App\Job;

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

Route::middleware('auth:api')

	->get('/user', function (Request $request) {
    	return $request->user();
});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
});

Route::get('users', 'UserController@index');

/** Jobs */

Route::get('jobs', 'JobsController@index');
Route::get('jobs/{id}', 'JobsController@details');
Route::post('jobs', 'JobsController@create');
Route::put('jobs/{id}', 'JobsController@update');
Route::delete('jobs/{id}', 'JobsController@delete');

Route::get('jobs', function(){
	return Job::all();
})->middleware('jwt.verify');

Route::get('jobs/{Id}', function($Id){
	return Job::find($Id);
})->middleware('jwt.verify');

Route::post('jobs', function(Request $request){
	return Job::create($request->all());
})->middleware('jwt.verify');

Route::put('jobs/{Id}', function(Request $request, $Id) {
    $Job = Job::findOrFail($Id);
    $Job->update($request->all());

    return $Job;
})->middleware('jwt.verify');

Route::delete('jobs/{Id}', function($Id){
	Job :: find($Id)->delete();
	return 204;
})->middleware('jwt.verify');