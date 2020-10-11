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


Route::get('/', 'WelcomeController@welcome');
Route::get('signup/{plan_id}', 'WelcomeController@register');
Route::get('/viewPlans', 'WelcomeController@viewPlans');
Route::get('terms', 'WelcomeController@terms');

Auth::routes();

Route::get('status', [
    'as' => 'status',
    'uses' => 'PaymentController@getPaymentStatus'
]);

Route::get('uploadDataVuforia', 'Admin\ArController@uploadDataVuforia');
Route::get('deleteAllTargets', 'Admin\ArController@deleteAllTargets');
Route::get('homepage', 'HomeController@index');


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
    Route::resource('support', 'Admin\\SupportController');
    Route::get('trackerSupport', 'Admin\SupportController@trackerSupport');
    Route::resource('meta', 'Admin\\MetaController');
    Route::resource('cron', 'Admin\\CronController');
    Route::resource('help', 'Admin\\HelpController');
    Route::get('users/reports/{user_id}', 'Admin\UsersController@getReports');
    Route::resource('tutorial-manager', 'Admin\\tutorialManagerController');
    Route::resource('scanpacks', 'Admin\\ScanpacksController');

    Route::resource('user-scan-packs', 'Admin\\UserScanPacksController');

    Route::resource('paid-scan-packs-history', 'Admin\\PaidScanPacksHistoryController');
    Route::resource('user-project-scan', 'Admin\\userProjectScanController');
});

Route::group(['middleware' => ['auth', 'roles'], 'roles' => 'Admin'], function () {
    Route::resource('plans', 'admin\\PlansController');
});



Route::get('client/planinfo', 'Admin\PlansController@planinfo');
//Client MiddleWare-------------------------------------------------------------
Route::group(['prefix' => 'client', 'middleware' => ['auth', 'roles', 'verifyPayment', 'checkPaymentMethod', 'PlanExpiry'], 'roles' => ['Api', 'Client']], function () {
    Route::get('home', [
        'as' => 'home',
        'uses' => 'ClientController@home'
    ]);
    Route::get("/support", function() {
        return View::make("client.support");
    });

    // Route::get('planinfo', 'Admin\PlansController@planinfo');

    Route::get('profile', 'ClientController@profile');

    Route::get('settings', 'ClientController@settings');
    Route::get('reports', 'ClientController@reports');
    Route::get("newPaymentMethod", function() {
        return View::make("client.addPaymentMethod");
    });
    Route::post('updateProfile', 'ClientController@updateProfile');
    Route::post('renewPlan', 'PaymentController@renewPlan');
    Route::post('updateSettings', 'ClientController@updateSettings');







    Route::post('manageReoccurring', 'PaymentController@manageReoccurring');

    Route::get('upgradePlanView', 'PaymentController@upgradePlanView');
    Route::get('upgradeNow', 'PaymentController@upgradeNow');
    Route::post('upgradeNowPlan', 'PaymentController@upgradeNowPlan');
    Route::post('createSupport', 'Admin\SupportController@createSupport');
    Route::get('scanpack', 'ClientController@viewScanPack');
    Route::post('setTrackerLimit', 'Admin\UserScanPacksController@setTrackerLimit');
    Route::get('updateScanPack', 'Admin\UserScanPacksController@updateScanPack');
    Route::get('getPaidProjectGraphData', 'ClientController@getPaidProjectGraphData');
    Route::post('getFinances', 'ClientController@getFinances');


    Route::get('ecommerce', 'ClientController@ecommerce');
    Route::get('editAttribute', 'ClientController@editAttribute');
    Route::post('attributeForm', 'ClientController@attributeForm');
});

Route::post('client/makePayment', 'PaymentController@payWithStripe');
Route::post('client/addPaymentMethod', 'PaymentController@addPaymentMethod');


//Common MiddleWare-------------------------------------------------------------
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'roles', 'verifyPayment', 'checkPaymentMethod', 'PlanExpiry'], 'roles' => ['Admin', 'Client', 'Api']], function () {
    Route::resource('admin/projects', 'Admin\\ProjectsController');
    Route::get('arDashboard', 'Admin\ArController@index');
    Route::get('tok', 'Admin\ArController@tok');
    Route::post('trackerUpload', 'Admin\ArController@trackerUpload');
    Route::post('addUpdateObject', 'Admin\objectsController@addUpdateObject');
    Route::post('finalizeTracker', 'Admin\ArController@finalizeTracker');
    Route::get('qrcode', 'Admin\ArController@qrCode');
    Route::resource('actions', 'Admin\\ActionsController');
    Route::post('newSubscribeTrigger', 'PaymentController@newSubscribeTrigger');

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
    Route::get('tapAudio', 'Admin\ActionsController@tapAudio');
    Route::get('tapVideo', 'Admin\ActionsController@tapVideo');
    Route::get('ecom', 'Admin\ActionsController@ecom');



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
    Route::post('tapAudioUpload', 'Admin\ActionsController@tapAudioUpload');
    Route::post('tapVideoUpload', 'Admin\ActionsController@tapVideoUpload');
    Route::post('ecomUpload', 'Admin\ActionsController@ecomUpload');



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
    Route::get('checkPlanUsage', 'ClientController@checkPlanUsage');
    Route::post('deleteMultipleUid', 'Admin\RestrictedUidController@deleteMultipleUid');

    Route::post('getProductAttributeStock', 'Admin\ProductsController@getProductAttributeStock');
    Route::post('updateStock', 'Admin\ProductsController@updateStock');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('getMetas', 'WelcomeController@getMetas');
Route::post('forgotPassword', 'WelcomeController@forgotPassword');
Route::post('client/choosePlan', 'admin\PlansController@choosePlan');
Route::get('/testPayment', 'PaymentController@testPayment');


Route::get('finalize', 'Admin\ArController@finalize');


Route::get('planCron', 'CronController@planCron');
Route::get('projectCron', 'CronController@projectCron');
Route::get('scanPackReset', 'CronController@scanPackReset');

Route::get('testCron', 'CronController@testCron');
Route::post('client/renewExpiredPlan', 'PaymentController@renewExpiredPlan');





Route::resource('admin/product-categories', 'Admin\\ProductCategoriesController');
Route::resource('admin/products', 'Admin\\ProductsController');
Route::resource('admin/cart', 'Admin\\CartController');
Route::resource('admin/product-options', 'Admin\\ProductOptionsController');
Route::resource('admin/product-attribute-combinations', 'Admin\\ProductAttributeCombinationsController');
Route::resource('admin/user-address', 'Admin\\UserAddressController');
Route::get('admin/updateOrderStatus', 'Admin\OrdersController@updateOrderStatus');
Route::get('admin/getOrdersAjax', 'Admin\OrdersController@getOrdersAjax');

Route::resource('admin/orders', 'Admin\\OrdersController');
Route::resource('admin/order-details', 'Admin\\OrderDetailsController');
