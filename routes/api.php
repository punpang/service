<?php
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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
return $request->user();
});
 */

// Route::get('todos/{id}', 'TaskController@fetchAll');
// Route::post('todos', 'TaskController@store');
// Route::delete('todos/{id}', 'TaskController@delete');

Route::get('menuBar/lists', 'MenuMainController@lists');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::get('user', 'AuthController@me');
Route::get('menuBar/lists', 'ShabuNooNee\MenuMainController@lists');

Route::prefix('v1')->group(function () { // api/v1/...
    Route::prefix('guest')->group(function () { // api/v1/guest/
        Route::prefix('promotions')->group(function () { // api/v1/guest/
            Route::get('fetchAll/promotion', 'Momday\PromotionController@fetchAll');
        });

        Route::prefix('product')->group(function () { // api/v1/guest/
            Route::get('{promotion_id}/fetchByPromotionID', 'Momday\PromotionProductController@fetchByPromotionID');
        });

        Route::prefix('product')->group(function () { // api/v1/guest/
            Route::prefix('punpang')->group(function () { // api/v1/guest/
                Route::get('fetchAllUse', 'Punpang\ProductController@fetchAllUse');
            });
            Route::get('{promotion_id}/fetchByPromotionID', 'Momday\PromotionProductController@fetchByPromotionID');
        });

        Route::prefix('order')->group(function () { // api/v1/guest/
            Route::post('store', 'Momday\OrderController@store');
            Route::get('{uuid}/fetchByUUID', 'Momday\OrderController@fetchByUUID');
        });

        Route::prefix('payment')->group(function () { // api/v1/guest/
            Route::post('store', 'Momday\paymentController@store');
            Route::post('cash/store', 'Momday\paymentController@storeCash');
        });

        Route::prefix('google')->group(function () { // api/gueœst/order/
            Route::post('uploadImage', 'ShabuNooNee\GoogleImageController@storeNotAuth');
        });
    });



    Route::prefix('otp')->group(function () { // api/gueœst/order/
        Route::post('store', 'OTPController@store');
        Route::post("verify", "OTPController@verify");
    });
});

Route::middleware("admin:api")->group(function () { //สำหรับ waitress
    Route::prefix('admin')->group(function () { // api/waitress/...

        Route::prefix('payment')->group(function () { // api/gueœst/order/
            Route::get('fetchCheck', 'Momday\paymentController@fetchCheck');
            Route::get('{order_id}/fetchByOrderId', 'Momday\paymentController@fetchByOrderId');
            Route::post('{payment}/confirm', 'Momday\paymentController@confirm');
            Route::post('{payment}/confirmOnline', 'Momday\paymentController@confirmOnline');
            Route::post('{payment}/cancel', 'Momday\paymentController@cancel');
        });
        
        Route::prefix('promotions')->group(function () { // api/gueœst/order/
            Route::get('{promotion_id}/fetchAllByID', 'Momday\PromotionController@fetchAllByID');
            Route::get('{promotion_id}/{order_status_id}/countProduct', 'Momday\PromotionController@countProduct');
        });
        
    });
});

Route::get('{promotion_id}/test', 'Momday\PromotionController@test');


Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return 'FINISHED';
});
