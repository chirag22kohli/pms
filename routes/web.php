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

Route::get('status', [
    'as' => 'status',
    'uses' => 'PaymentController@getPaymentStatus'
]);

Route::get('uploadDataVuforia', 'Admin\ArController@uploadDataVuforia');
Route::get('deleteAllTargets', 'Admin\ArController@deleteAllTargets');
Route::get('/home', 'HomeController@index')->name('home');


// Admin MiddleWare-------------------------------------------------------------
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'roles'], 'roles' => 'Admin'], function () {
    Route::get('/', 'Admin\AdminController@index');
    Route::resource('roles', 'Admin\RolesController');
    Route::resource('permissions', 'Admin\PermissionsController');
    Route::resource('users', 'Admin\UsersController');
    Route::get('generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
    Route::post('generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);
    Route::resource('user-plans', 'admin\\UserPlansController');
    Route::resource('plans', 'admin\\PlansController');
});

Route::group(['middleware' => ['auth', 'roles'], 'roles' => 'Admin'], function () {
    Route::resource('plans', 'admin\\PlansController');
});

//Client MiddleWare-------------------------------------------------------------
Route::group(['prefix' => 'client', 'middleware' => ['auth', 'roles', 'verifyPayment'], 'roles' => 'Client'], function () {
    Route::get('home', [
        'as' => 'home',
        'uses' => 'ClientController@home'
    ]);
    Route::get("/support", function() {
        return View::make("client.support");
    });

    Route::get('planinfo', 'Admin\PlansController@planinfo');
    
    Route::get('profile', 'ClientController@profile');
    Route::post('updateProfile', 'ClientController@updateProfile');
});
Route::post('client/makePayment', 'PaymentController@payWithStripe');



//Common MiddleWare-------------------------------------------------------------
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'roles'], 'roles' => ['Admin', 'Client']], function () {
    Route::resource('admin/projects', 'Admin\\ProjectsController');
    Route::get('arDashboard', 'Admin\ArController@index');
    Route::post('trackerUpload', 'Admin\ArController@trackerUpload');
    Route::post('addUpdateObject', 'Admin\objectsController@addUpdateObject');
    Route::post('finalizeTracker', 'Admin\ArController@finalizeTracker');
    Route::get('qrcode', 'Admin\ArController@qrCode');
    Route::resource('actions', 'Admin\\ActionsController');

//OBJECTS

    Route::get('google', 'Admin\ActionsController@google');
    Route::get('facebook', 'Admin\ActionsController@facebook');
    Route::get('audio', 'Admin\ActionsController@audio');
    Route::get('video', 'Admin\ActionsController@video');
    Route::get('email', 'Admin\ActionsController@email');
    Route::get('image', 'Admin\ActionsController@image');
    Route::get('webLink', 'Admin\ActionsController@webLink');
    Route::get('event', 'Admin\ActionsController@event');
    Route::get('contact', 'Admin\ActionsController@contact');
    Route::get('youtube', 'Admin\ActionsController@youtube');
    Route::get('flip', 'Admin\ActionsController@flip');
    Route::get('screenShot', 'Admin\ActionsController@screenShot');

    Route::post('googleUpload', 'Admin\ActionsController@googleUpload');
    Route::post('facebookUpload', 'Admin\ActionsController@facebookUpload');
    Route::post('audioUpload', 'Admin\ActionsController@audioUpload');
    Route::post('videoUpload', 'Admin\ActionsController@videoUpload');
    Route::post('emailUpload', 'Admin\ActionsController@emailUpload');
    Route::post('imageUpload', 'Admin\ActionsController@imageUpload');
    Route::post('webLinkUpload', 'Admin\ActionsController@webLinkUpload');
    Route::post('eventUpload', 'Admin\ActionsController@eventUpload');
    Route::post('contactUpload', 'Admin\ActionsController@contactUpload');
    Route::post('youtubeUpload', 'Admin\ActionsController@youtubeUpload');
    Route::post('flipUpload', 'Admin\ActionsController@flipUpload');
    Route::post('screenShotUpload', 'Admin\ActionsController@screenShotUpload');
    Route::post('updateHieghtNewObject', 'Admin\ActionsController@updateHieghtNewObject');
    


//delete object
    Route::post('deleteObject', 'Admin\objectsController@deleteObject');
    Route::resource('projects', 'Admin\\ProjectsController');


    Route::resource('objects', 'Admin\\objectsController');
    Route::resource('trackers', 'Admin\\TrackersController');


    Route::resource('restricted-uid', 'Admin\\RestrictedUidController');
    Route::get('import', 'Admin\RestrictedUidController@import');
    // Route::get('/', 'ImportController@getImport')->name('import');
    Route::post('/import_parse', 'Admin\RestrictedUidController@parseImport')->name('import_parse');
    Route::post('/import_process', 'RestrictedUidController@processImport')->name('import_process');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


