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
