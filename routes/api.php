<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', 'App\Http\Controllers\AuthController@login')->middleware(['api', 'cors']);

Route::get('projects', 'App\Http\Controllers\ProjectsController@index')->middleware('jwt.verify');
Route::get('project/{id}', 'App\Http\Controllers\ProjectsController@details')->middleware('jwt.verify');
Route::post('projects/new', 'App\Http\Controllers\ProjectsController@create')->middleware('jwt.verify');
Route::post('project/{id}/note/new', 'App\Http\Controllers\ProjectsController@createNote')->middleware('jwt.verify');
Route::delete('project/{id}/delete', 'App\Http\Controllers\ProjectsController@delete')->middleware('jwt.verify');
Route::delete('project/{id}/note/{noteid}/delete', 'App\Http\Controllers\ProjectsController@deleteNote')->middleware('jwt.verify');
Route::put('project/{id}/update', 'App\Http\Controllers\ProjectsController@update')->middleware('jwt.verify');

Route::get('systems', 'App\Http\Controllers\SystemsController@index')->middleware('jwt.verify');
Route::get('system/{id}', 'App\Http\Controllers\SystemsController@details')->middleware('jwt.verify');
Route::post('system/{id}/note/new', 'App\Http\Controllers\SystemsController@createNote')->middleware('jwt.verify');
Route::post('systems/new', 'App\Http\Controllers\SystemsController@create')->middleware('jwt.verify');
Route::delete('system/{id}/delete', 'App\Http\Controllers\SystemsController@delete')->middleware('jwt.verify');
Route::delete('system/{id}/note/{noteid}/delete', 'App\Http\Controllers\SystemsController@deleteNote')->middleware('jwt.verify');
Route::put('system/{id}/update', 'App\Http\Controllers\SystemsController@update')->middleware('jwt.verify');
