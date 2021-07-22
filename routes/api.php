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

Route::get('todos/{id}', 'TaskController@fetchAll');
Route::post('todos', 'TaskController@store');
Route::delete('todos/{id}', 'TaskController@delete');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::post('/test/logOut', 'AuthController@testLogOut');

Route::post('/loginByQrCode', 'AuthController@loginByQrCode');

//Route::middleware(["admin","cashier"])->get('user', 'AuthController@me');
Route::get('user', 'AuthController@me');
Route::get('menuBar/lists', 'ShabuNooNee\MenuMainController@lists');

Route::middleware("admin")->group(function () { //สำหรับ admin
    //Route::get('user', 'AuthController@me');
    //Route::get('dashboard', 'AuthController@me');
    //Route::get('test', 'Order\AOrderController@DashboardToday');

    Route::prefix('admin')->group(function () { // api/product/...
        Route::prefix('userType')->group(function () { // api/product/...
            Route::get('nextTo', 'ShabuNooNee\UserTypeController@nextTo');
        });
    });

    Route::prefix('product')->group(function () { // api/product/...

        Route::post('store', 'ShabuNooNee\ProductController@store');
        Route::post('/{id}/update', 'ShabuNooNee\ProductController@update');
        Route::get('all', 'ShabuNooNee\ProductController@all');

        Route::post('group', 'ShabuNooNee\ProductGroupController@store');
        Route::post('group/{id}/switchStatus', 'ShabuNooNee\ProductGroupController@switchStatus');
        Route::post('group/{id}/update', 'ShabuNooNee\ProductGroupController@update');
        Route::get('group/all', 'ShabuNooNee\ProductGroupController@all');
    });

    Route::prefix('google')->group(function () { // api/product/...
        Route::post('uploadImage', 'ShabuNooNee\GoogleImageController@store');
    });

    Route::prefix('menuBar')->group(function () { // api/menuBar/...
        Route::get('all', 'ShabuNooNee\MenuMainController@all');

        Route::post('storeMain', 'ShabuNooNee\MenuMainController@storeMain');

        Route::get('selectMain', 'ShabuNooNee\MenuMainController@selectMain');


        Route::post('{id}/changeMain', 'ShabuNooNee\MenuMainController@changeMain');
        Route::post('{id}/changeSub', 'ShabuNooNee\MenuSubController@changeSub');
    });
});

Route::middleware("cashier")->group(function () { //สำหรับ cashier
    Route::prefix('diningTable')->group(function () { // api/diningTable/...
        Route::get('allTable', 'ShabuNooNee\DiningTableController@allTable');
        Route::get('{id}/table', 'ShabuNooNee\DiningTableController@table');
        Route::post('{id}/tableUpdate', 'ShabuNooNee\DiningTableController@tableUpdate');
        Route::post('{id}/tableChangePriceRange', 'ShabuNooNee\DiningTableController@tableChangePriceRange');
        Route::post('store', 'ShabuNooNee\DiningTableController@store');
    });

    Route::prefix('priceRange')->group(function () { // api/diningTable/...
        Route::get('all', 'ShabuNooNee\PriceRangeController@all');
    });
});

Route::middleware("waitress")->group(function () { //สำหรับ waitress
    Route::prefix('waitress')->group(function () { // api/waitress/...
        Route::get('self', 'ShabuNooNee\WaitressQueueOrderController@self');
        Route::post('{waitress}/finished', 'ShabuNooNee\WaitressQueueOrderController@finished');
    });

});

Route::middleware("kitchen")->group(function () { //สำหรับ kitchen
    Route::prefix('kitchen')->group(function () { // api/kitchen/...
        Route::get('self', 'ShabuNooNee\KitchenQueueOrderController@self');
        Route::post('{kitchen}/nextToWaitress', 'ShabuNooNee\KitchenQueueOrderController@nextToWaitress');
    });

});

Route::middleware("customer")->group(function () { //สำหรับ cashier
    Route::prefix('tableOrder')->group(function () { // api/diningTable/...
        Route::post('checkUUID', 'ShabuNooNee\DiningTableController@checkUUID');

        Route::get('self', 'ShabuNooNee\TableOrderController@self');
        Route::post('selfUUID', 'ShabuNooNee\TableOrderController@selfUUID');
        Route::post('productGroupAllow', 'ShabuNooNee\TableOrderController@productGroupAllow');
        Route::post('store', 'ShabuNooNee\TableOrderController@store');
        Route::post('testStore', 'ShabuNooNee\TableOrderController@testStore');
    });
});

Route::middleware('admin')->prefix("old")->group(function () { //สำหรับ admin
    //Route::get('user', 'AuthController@me');
    //Route::get('dashboard', 'AuthController@me');
    //Route::get('test', 'Order\AOrderController@DashboardToday');

    Route::prefix('customer')->group(function () { // api/customer/...

        Route::get('/', 'Order\CustomerController@index');
        Route::post('{customer}/edit', 'Order\CustomerController@edit');
        Route::get('customer/find', 'Order\CustomerController@Find')->name('admin.order.customer.find');
        Route::post('customer/find', 'Order\CustomerController@Finded')->name('admin.order.customer.finded');
        Route::get('customer/new/{phone}', 'Order\CustomerController@NewCustomer')->where('phone', '[0][0-9]{9}')->name('admin.order.customer.new');
        Route::post('store', 'Order\CustomerController@store');

        Route::get('phoneOnly', 'Order\CustomerController@phoneOnly');
        Route::get('{phone}/selectCustomerByPhone', 'Order\CustomerController@selectCustomerByPhone');
    });

    Route::prefix('channelOfPurchase')->group(function () { // api/channelOfPurchase/...

        Route::get('/useonly', 'Order\ChannelOfPurchaseController@UseOnly');
    });

    Route::prefix('order')->group(function () { // api/order/...

        Route::get('all', 'Order\OrderController@all');
        Route::get('{order}/getByID', 'Order\OrderController@getByID');

        Route::get('timeGets', 'Order\OrderController@timeGets');

        Route::post('create', 'Order\OrderController@create');
        Route::post('checkDateTimeForGet', 'Order\OrderController@checkDateTimeForGet');

        Route::post('{order}/changeDateTimeGet', 'Order\OrderController@changeDateTimeGet');
        Route::post('{order}/goodsDone', 'Order\OrderController@goodsDone');
        Route::post('{order}/productReceived', 'Order\OrderController@productReceived');

        Route::prefix('detail')->group(function () { // api/order/detail
            Route::post('store', 'Order\OrderDetailController@store');
            Route::post('{detail}/update', 'Order\OrderDetailController@update');
            Route::post('{detail}/delete', 'Order\OrderDetailController@delete');
            Route::post('{detail}/redelete', 'Order\OrderDetailController@redelete');
            Route::get('{order_id}/getByOrderID', 'Order\OrderDetailController@getByOrderID');

            Route::post('{detail}/uploadFinishedProductImage', 'Order\OrderDetailController@uploadFinishedProductImage');

            Route::post('{detail}/sentLinkForUploadImage', 'Order\OrderDetailController@sentLinkForUploadImage');
            Route::get('{public_id}/downloadImage', 'Order\OrderDetailController@downloadImage');
        });
    });

    Route::prefix('payment')->group(function () { // api/payment/...
        Route::post('create', 'Order\OrderPaymentController@create');
        Route::post('{payment}/cancel', 'Order\OrderPaymentController@cancel');
        Route::post('alert', 'Order\OrderPaymentController@alert');
        Route::post('{slip}/unVerifySlip', 'Order\OrderPaymentController@unVerifySlip');
        Route::get('unVerifyReasoning', 'Order\OrderPaymentController@unVerifyReasoning');
        Route::post('notPayDeposit', 'Order\OrderPaymentController@notPayDeposit');
        Route::post('scb', 'Order\OrderPaymentController@scb');

        Route::prefix('method')->group(function () { // api/payment/method/...
            Route::get('all', 'Order\OrderPaymentMethodController@all');
            Route::get('useonly', 'Order\OrderPaymentMethodController@useonly');
        });
    });

    Route::prefix('product')->group(function () { // api/product/...
        Route::get('/', 'Order\ProductController@get');
        Route::get('useonly', 'Order\ProductController@useOnly');

        Route::post('store', 'Order\ProductController@store');
        Route::post('v2/store', 'Order\ProductController@v2store');

        Route::post('/{id}/edit', 'Order\ProductController@update');

        Route::prefix('image')->group(function () { // api/product/image/...
            Route::post('store', 'Order\ProductImageController@store');
            Route::post('{id}/update', 'Order\ProductImageController@update');
            Route::post('{id}/destroy', 'Order\ProductImageController@destroy');
        });

        Route::prefix('tag')->group(function () { // api/product/tag/...
            Route::get('{id}', 'Order\ProductTagController@tag');
            Route::post('store', 'Order\ProductTagController@store');
            Route::post('{id}/update', 'Order\ProductTagController@update');
            Route::post('{id}/destroy', 'Order\ProductTagController@destroy');
            Route::get('{id}/isProductTags', 'Order\ProductTagController@isProductTags');
        });

        Route::prefix('category')->group(function () { // api/product/category/...
            Route::get('/', 'Order\ProductCategoryController@get');
            Route::get('/useonly', 'Order\ProductCategoryController@useonly');
            Route::post('store', 'Order\ProductCategoryController@store');
            Route::post('/{id}/edit', 'Order\ProductCategoryController@update');

            Route::get('/useonly/with/subs', 'Order\ProductCategoryController@UseOnlyWithSubs');
            Route::get('/{id}/subs', "Order\ProductCategoryController@getSubsByID");

            Route::prefix('sub')->group(function () { // api/product/category/sub/...
                Route::get('/', 'Order\ProductCategorySubController@get');
                Route::get('useonly', 'Order\ProductCategorySubController@useOnly');
                Route::get('useonly/with/product/category', 'Order\ProductCategorySubController@useOnlyWithProductCategory');
                Route::post('store', 'Order\ProductCategorySubController@store');
                Route::post('/{id}/edit', 'Order\ProductCategorySubController@update');
            });
        });

        Route::prefix('option')->group(function () { // api/product/tag/...

            Route::get('{id}/productCheck', 'Order\OptionMainController@productCheck');
            Route::get('{product_id}/{op1}/check', 'Order\OptionMainController@check');

            Route::post("store", "Order\OptionMainController@store");
        });
    });

    /*
Route::prefix('order')->group(function () { // api/order/...

Route::get('customers', 'Order\CustomerController@index');
Route::get('customer/find', 'Order\CustomerController@Find')->name('admin.order.customer.find');
Route::post('customer/find', 'Order\CustomerController@Finded')->name('admin.order.customer.finded');
Route::get('customer/new/{phone}', 'Order\CustomerController@NewCustomer')->where('phone', '[0][0-9]{9}')->name('admin.order.customer.new');
Route::post('customer/store', 'Order\CustomerController@store');
});
 */
});

Route::prefix('v1')->group(function () { // api/v1/...
    Route::prefix('guest')->group(function () { // api/v1/guest/
        Route::prefix('order')->group(function () { // api/guest/order/
            Route::get('{token}', 'Order\OrderController@getByToken');
            Route::get('{token}/payment/alert', 'Order\OrderController@getByTokenForPaymentAlert');
            Route::post('{token}/payment/alert/uploadslip', 'Order\OrderPaymentController@uploadslip');

            Route::post('{token}/updateWrite', 'Order\OrderDetailController@updateWriteByToken');
            Route::get('{token}/uploadImageByToken', 'Order\OrderDetailController@uploadImageByToken');
            Route::post('{token}/uploadImageByToken/{image}/ImageMain', 'Order\OrderDetailController@ImageMain');
            Route::post('{token}/uploadImageByToken/example', 'Order\OrderDetailController@uploadImageByTokenExample');
            Route::post('{token}/uploadImageByToken/images', 'Order\OrderDetailController@uploadImageByTokenImages');
            Route::delete('{token}/uploadImageByToken/{image}/delete', 'Order\OrderDetailController@uploadImageByTokenDelete');
        });

        Route::prefix('scbpayment')->group(function () { // api/guest/order/
            Route::get('{amount}/{ref1}/{ref2}/deeplinkUrl', 'Order\SCBController@deeplink');
        });
    });

    Route::prefix('otp')->group(function () { // api/gueœst/order/
        Route::post('store', 'OTPController@store');
        Route::post("verify", "OTPController@verify");
    });
});

Route::get('scbtest', 'Order\SCBController@callback');

Route::middleware('auth')->group(function () { //สำหรับ user

});

//Route::get('link', 'Order\ProductCategoryController@link');

Route::middleware('signed')->prefix('protected')->group(function () {
    Route::get('linkPass', 'Order\ProductCategoryController@link2')->name('testlink');
});
