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

Route::group(['middleware' => ['auth:api', 'roles'], 'roles' => ['Api', 'Client']], function() {
    Route::get('details', 'API\UserController@details');
    Route::post('projectDetails', 'API\ProjectController@projectDetails');
    Route::post('projectType', 'API\ProjectController@projectType');
    Route::post('validateUid', 'API\ProjectController@validateUid');
    Route::post('createContactEvent', 'API\UserController@createContactEvent');
    Route::post('getContactEvent', 'API\UserController@getContactEvent');

    Route::get('checkPaymentMethod', 'API\PaymentController@checkPaymentMethod');
    Route::post('deductPayment', 'API\PaymentController@deductPayment');
    Route::get('myRecentProjects', 'API\ProjectController@myRecentProjects');
    Route::post('deleteRecentProject', 'API\ProjectController@deleteRecentProject');


    Route::post('updateContactEvent', 'API\UserController@updateContactEvent');
    Route::post('deleteContactEvent', 'API\UserController@deleteContactEvent');
    Route::post('trackerSupport', 'API\ProjectController@trackerSupport');
    Route::post('getMeta', 'API\UserController@getMeta');
    Route::post('getProjectOwner', 'API\UserController@getProjectOwner');
    Route::post('projectReoccuring', 'API\ProjectController@projectReoccuring');
    Route::get('getProfile', 'API\UserController@getProfile');
    Route::post('updateProfile', 'API\UserController@updateProfile');
    Route::post('changePassword', 'API\UserController@changePassword');
    Route::get('getTransactions', 'API\UserController@getTransactions');
    Route::get('getHelp', 'API\UserController@getHelp');
    Route::get('getTutorials', 'API\UserController@getTutorials');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
