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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('admin', 'Admin\AdminController@index');
Route::resource('admin/roles', 'Admin\RolesController');
Route::resource('admin/permissions', 'Admin\PermissionsController');
Route::resource('admin/users', 'Admin\UsersController');
Route::get('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
Route::post('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);
Route::get('admin/arDashboard', 'Admin\ArController@index');

Route::get('uploadDataVuforia', 'Admin\ArController@uploadDataVuforia');
Route::get('deleteAllTargets', 'Admin\ArController@deleteAllTargets');
Route::post('admin/trackerUpload', 'Admin\ArController@trackerUpload');



Route::resource('admin/projects', 'Admin\\ProjectsController');
Route::resource('admin/objects', 'Admin\\objectsController');
Route::resource('admin/trackers', 'Admin\\TrackersController');

Route::post('admin/addUpdateObject', 'Admin\objectsController@addUpdateObject');

Route::post('admin/finalizeTracker', 'Admin\ArController@finalizeTracker');

Route::resource('admin/actions', 'Admin\\ActionsController');

//Google
Route::get('admin/google', 'Admin\ActionsController@google');
Route::get('admin/facebook', 'Admin\ActionsController@facebook');
Route::get('admin/audio', 'Admin\ActionsController@audio');
Route::get('admin/email', 'Admin\ActionsController@email');

Route::get('admin/video', 'Admin\ActionsController@video');
Route::post('admin/googleUpload', 'Admin\ActionsController@googleUpload');
Route::post('admin/facebookUpload', 'Admin\ActionsController@facebookUpload');
Route::post('admin/videoUpload', 'Admin\ActionsController@videoUpload');
Route::post('admin/emailUpload', 'Admin\ActionsController@emailUpload');
