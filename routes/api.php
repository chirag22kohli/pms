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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => ['auth:api', 'roles'], 'roles' => ['Api','Client']], function(){
Route::get('details', 'API\UserController@details');
Route::post('projectDetails', 'API\ProjectController@projectDetails');
Route::post('projectType', 'API\ProjectController@projectType');
Route::post('validateUid', 'API\ProjectController@validateUid');
Route::post('createContactEvent', 'API\UserController@createContactEvent');
Route::post('getContactEvent', 'API\UserController@getContactEvent');




});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
    
});
