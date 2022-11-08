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

//Route::get('menuBar/lists', 'MenuMainController@lists');

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

        Route::prefix('ksher')->group(function () { // api/v1/guest/ksher
            Route::get('fetch', 'Order\KsherChannelPaymentController@fetch');
            Route::get('getUseKsherChannelPayment', 'Order\KsherChannelPaymentController@getUseKsherChannelPayment');
            Route::post('orderCreate', 'Order\KsherPayController@orderCreate');
            Route::get('{ksher}/checkStatusPaid', 'Order\KsherPayController@checkStatusPaid');
        });

        Route::prefix('noticeOfPaymentFromCustomer')->group(function () { // api/v1/guest/ksher
            Route::post('createByUuid', 'Order\NoticeOfPaymentFromCustomerController@createByUuid');
        });

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
            Route::get('fetchByUUID/{uuid}', 'Order\AOrderController@fetchByUUID');
            Route::post('uploadImagesByUUID', 'Order\AOrderController@uploadImagesByUUID');
            Route::post('removeImageIdByUUID', 'Order\AOrderController@removeImageIdByUUID');
            Route::post('store', 'Momday\OrderController@store');
            Route::get('{uuid}/fetchByUUID', 'Momday\OrderController@fetchByUUID');
            Route::post('confirmConsentConditions', 'Order\ACustomerController@confirmConsentConditions');
            Route::post('updateRatingByUuid', 'Order\AOrderController@updateRatingByUuid');
        });

        Route::prefix('payment')->group(function () { // api/v1/guest/
            Route::post('store', 'Momday\paymentController@store');
            Route::post('cash/store', 'Momday\paymentController@storeCash');
        });

        Route::prefix('google')->group(function () { // api/gueœst/order/
            Route::post('uploadImage', 'ShabuNooNee\GoogleImageController@storeNotAuth');
        });

        Route::get('shotlink/{shotlink}', 'Order\ShotlinkV2Controller@redirect');

        Route::prefix('lucky')->group(function () { // api/gueœst/order/
            Route::post('reward/getByUUID', 'Order\RewardCustomerController@getByUUID');
            Route::post('reward/openReward', 'Order\RewardLabelController@openReward');
            Route::post('reward/getRedeemCode', 'Order\RewardLabelController@getRedeemCode');
        });

        Route::post('endpoint_payment', 'Order\RewardCustomerController@endpointPayment');

        Route::prefix('verify_identity')->group(function () { // api/gueœst/order/
            Route::post('{token}/register_member', 'Order\RegisterMemberTempController@update');
        });
    });



    Route::prefix('otp')->group(function () { // api/gueœst/order/
        Route::post('store', 'OTPController@store');
        Route::post("verify", "OTPController@verify");
    });
});

Route::middleware("admin:api")->group(function () { //สำหรับ waitress

    Route::prefix('menuBar')->group(function () { // api/menuBar/...
        Route::get('all', 'ShabuNooNee\MenuMainController@all');

        Route::post('storeMain', 'ShabuNooNee\MenuMainController@storeMain');

        Route::get('selectMain', 'ShabuNooNee\MenuMainController@selectMain');


        Route::post('{id}/changeMain', 'ShabuNooNee\MenuMainController@changeMain');
        Route::post('{id}/changeSub', 'ShabuNooNee\MenuSubController@changeSub');
    });

    Route::prefix('admin')->group(function () { // api/waitress/...

        Route::prefix('menuBar')->group(function () { // api/menuBar/...
            Route::get('all', 'ShabuNooNee\MenuMainController@all');

            Route::post('storeMain', 'ShabuNooNee\MenuMainController@storeMain');

            Route::get('selectMain', 'ShabuNooNee\MenuMainController@selectMain');


            Route::post('{id}/changeMain', 'ShabuNooNee\MenuMainController@changeMain');
            Route::post('{id}/changeSub', 'ShabuNooNee\MenuSubController@changeSub');
        });



        Route::prefix("v1")->group(function () {

            Route::prefix('pos')->group(function () { // api/v1/pos/...
                Route::prefix('goods')->group(function () { // api/v1/pos/goods/...
                    Route::post('store', 'Pos\GoodsController@store');
                    Route::post('{id}/update', 'Pos\GoodsController@update');
                    Route::get('fetch', 'Pos\GoodsController@fetch');
                });
                Route::prefix('category_goods')->group(function () { // api/v1/pos/goods/...
                    Route::post('store', 'Pos\CategoryGoodsController@store');
                    Route::get('fetch', 'Pos\CategoryGoodsController@fetch');
                });

            });

            Route::prefix('categoryMoneyService')->group(function () { // api/v1/guest/ksher
                Route::get('fetch', 'Order\CategoryMoneyServiceController@fetch');
            });

            Route::prefix('moneyServices')->group(function () { // api/v1/guest/ksher
                Route::post('store', 'Order\MoneyServicesController@store');
                Route::post('{id}/update', 'Order\MoneyServicesController@update');
                Route::post('{id}/delete', 'Order\MoneyServicesController@delete');
            });

            Route::prefix('setting')->group(function () { // api/v1/guest/ksher
                Route::get('fetch', 'Order\SettingController@fetch');
                Route::post('update', 'Order\SettingController@update');
            });

            Route::prefix('StoreDayOff')->group(function () { // api/v1/guest/ksher
                Route::get('fetch', 'Order\StoreDayOffController@fetch');
                Route::post('store', 'Order\StoreDayOffController@store');
                Route::post('{id}/remove', 'Order\StoreDayOffController@remove');
            });

            Route::prefix('facebook')->group(function () { // api/v1/facebook/

                Route::get('search_profile', 'Order\FacebookController@search_profile');
                Route::post('{profile}/connect_profile', 'Order\FacebookController@connect_profile');
                Route::post('{profile}/disconnect_profile', 'Order\FacebookController@disconnect_profile');


                Route::prefix('reply')->group(function () { // api/v1/facebook/reply
                    Route::get('fetch', 'Order\FacebookReplyController@fetch');
                    Route::post('store', 'Order\FacebookReplyController@store');
                    Route::post('{reply}/update', 'Order\FacebookReplyController@update');
                });


                Route::prefix('webhook')->group(function () { // api/v1/facebook/reply
                    Route::get('fetch', 'Order\FacebookWebhookController@fetch');
                    Route::post('store', 'Order\FacebookWebhookController@store');
                    Route::post('{webhook}/addReply', 'Order\FacebookWebhookController@addReply');
                    Route::post('{webhook}/removeReply', 'Order\FacebookWebhookController@removeReply');
                });
            });

            Route::prefix('line')->group(function () { // api/v1/line/
                Route::get('search', 'Order\LineController@search');
                Route::post('{profile}/connect_profile', 'Order\LineController@connect_profile');
                Route::post('{profile}/disconnect_profile', 'Order\LineController@disconnect_profile');
            });

            Route::prefix('adjustExcessPayment')->group(function () { // api/v1/guest/ksher
                Route::get('fetchChannels', 'Order\AdjustExcessPaymentChannelController@fetch');
                Route::post('order/{order}/store', 'Order\AdjustExcessPaymentChannelController@store');
            });

            Route::prefix('ksher')->group(function () { // api/v1/guest/ksher
                Route::get('fetch', 'Order\KsherChannelPaymentController@fetch');
                Route::post('setDayOff', 'Order\KsherChannelPaymentController@setDayOff');
                Route::post('{ksher}/update_status_use', 'Order\KsherChannelPaymentController@update_status_use');
                Route::post('update_sort', 'Order\KsherChannelPaymentController@update_sort');
                Route::prefix('dayOff')->group(function () { // api/v1/guest/ksher
                    Route::get('fetch', 'Order\KsherDayOffController@fetch');
                    Route::post('{id}/remove', 'Order\KsherDayOffController@remove');
                });
            });

            Route::prefix('QRCodeGenerator')->group(function () { // api/admin/v1/...
                Route::post('promptPayQrCodeSCB', 'Order\AOrderController@promptPayQrCodeSCB');
            });

            Route::prefix('ksher')->group(function () { // api/admin/v1/...
                Route::get('{mch_order_no}/orderQuery', 'Order\KsherPayController@orderQuery');
            });

            Route::prefix('delivery_service')->group(function () { // api/admin/v1/...
                Route::post('{order}/store', 'Order\DeliveryServiceController@store');
                Route::post('{delivery_service}/update', 'Order\DeliveryServiceController@update');
                Route::post('{delivery_service}/remove', 'Order\DeliveryServiceController@remove');
                Route::post('{delivery_service}/shipping', 'Order\DeliveryServiceController@shipping');
                Route::post('{delivery_service}/success', 'Order\DeliveryServiceController@success');
            });


            Route::prefix('noticeOfPaymentFromCustomer')->group(function () { // api/admin/v1/...
                Route::get('getAllByAdmin', 'Order\NoticeOfPaymentFromCustomerController@getAllByAdmin');
                Route::get('{id}/getCheckSlip', 'Order\NoticeOfPaymentFromCustomerController@getCheckSlip');
                Route::post('postCheckSlip', 'Order\NoticeOfPaymentFromCustomerController@postCheckSlip');
                Route::post('postUpdateSlip', 'Order\NoticeOfPaymentFromCustomerController@postUpdateSlip');
                Route::post('postAppealSlip', 'Order\NoticeOfPaymentFromCustomerController@postAppealSlip');
            });

            Route::prefix('orders')->group(function () { // api/admin/v1/orders/...
                Route::get('fetch', 'Order\AOrderController@fetch_orders');
                Route::prefix('details')->group(function () { // api/admin/v1/orders/...
                    Route::get('fetch', 'Order\OrderDetailController@fetch');
                });
            });

            Route::prefix("order")->group(function () {
                Route::post('newOrder', 'Order\AOrderController@newOrder');
                Route::post('{order}/addGoodsCake', 'Order\AOrderController@addGoodsCake');
                Route::post('{order}/changeCustomer', 'Order\AOrderController@changeCustomer');
                Route::post('{order}/changeDateTimeGet', 'Order\AOrderController@changeDateTimeGet');
                Route::post('{order}/prepareGoods', 'Order\AOrderController@prepareGoods');
                Route::post('{order}/pickUpGoods', 'Order\AOrderController@pickUpGoods');
                Route::post('{order}/customerNoPayment', 'Order\AOrderController@customerNoPayment');

                Route::prefix('channelPayment')->group(function () { // api/admin/v1/...
                    Route::get('getUse', 'Order\ChannelPaymentController@getUse');
                });

                Route::prefix('productAddOn')->group(function () { // api/admin/v1/order/productAddOn/...
                    Route::get('fetch', 'Order\ProductAddOnController@fetch');
                    Route::post('create', 'Order\ProductAddOnController@create');
                });

                Route::prefix('goodsAddOn')->group(function () { // api/admin/v1/order/productAddOn/...
                    Route::get('fetch', 'Order\GoodsAddOnController@fetch');
                    Route::post('updateOrCreate', 'Order\GoodsAddOnController@updateOrCreate');
                });
                Route::prefix('m4')->group(function () { // api/admin/v1/order/productAddOn/...
                    Route::get('fetch', 'Order\AM4Controller@fetch');
                });

                Route::prefix('detail')->group(function () { // api/admin/v1/order/detail/...
                    Route::prefix('temp')->group(function () { // api/admin/v1/order/detail/temp/...
                        Route::post('create', 'Order\OrderDetailTempController@create');
                        Route::post('{id}/update', 'Order\OrderDetailTempController@update');
                        Route::post('{id}/delete', 'Order\OrderDetailTempController@delete');
                        Route::get('{order_temp_id}/fetch', 'Order\OrderDetailTempController@fetch');
                    });
                    Route::get('getUse', 'Order\ChannelPaymentController@getUse');

                    Route::post('{id}/delete', 'Order\OrderDetailController@delete');
                    Route::post('{id}/update', 'Order\OrderDetailController@update');

                    Route::prefix('addOn')->group(function () { // api/admin/v1/order/detail/addOn
                        Route::post('{id}/autoUpdateAddOns', 'Order\OrderDetailController@autoUpdateAddOns');
                        Route::post('{id}/create', 'Order\OrderDetailController@createAddOn');
                        Route::post('{id}/delete', 'Order\OrderDetailController@deleteAddOn');
                    });

                    Route::prefix('productPrototype')->group(function () { // api/admin/v1/order/detail/addOn
                        Route::post('{detail_id}/store', 'Order\OrderProductPrototypeController@store');
                        Route::post('{detail_id}/delete', 'Order\OrderProductPrototypeController@delete');
                    });

                    Route::post('{detail}/switchStatusUploadImagesFromCustomer', 'Order\OrderDetailController@switchStatusUploadImagesFromCustomer');
                    Route::post('{detail}/switchIsTakeAPhoto', 'Order\OrderDetailController@switchIsTakeAPhoto');

                    Route::prefix("imageGoodsReviewToCustomer")->group(function () {
                        Route::post('{detail_id}/store', 'Order\ImageGoodsReviewToCustomerController@store');
                        Route::post('{detail_id}/delete', 'Order\ImageGoodsReviewToCustomerController@delete');
                    });
                });

                Route::prefix('temp')->group(function () { // api/admin/v1/order/detail/...
                    Route::post('setTemp', 'Order\OrderTempController@setTemp');
                    Route::get('{customer_id}/fetch', 'Order\OrderTempController@fetch');
                });

                Route::post('alertPaymentByOrderID', 'Order\AOrderController@alertPaymentByOrderID');

                Route::get('{order_id}/getOrderByID', 'Order\AOrderController@getOrderByID');
                Route::post('paymentByOrderID', 'Order\AOrderController@paymentByOrderID');
                Route::post('{order_id}/pickUpOrderByID', 'Order\AOrderController@pickUpOrderByID');

                Route::prefix("channel")->group(function () {
                    Route::post('fetchUse', 'Order\OrderChannelController@fetchUse');
                });

                Route::prefix("product")->group(function () {
                    Route::post('fetchPriceOfCake', 'Order\APriceController@fetchPriceOfCake');
                    Route::get('fetchOption', 'Order\APriceController@fetchOption');
                    Route::get('fetchAddOn', 'Order\ProductAddOnController@fetchAddOn');
                    Route::get('{option}/fetch_options', 'Order\APriceController@fetch_options');
                    Route::post('add_option', 'Order\APriceController@add_option');
                    Route::post('edit_option', 'Order\APriceController@edit_option');
                    Route::post('{product}/editPrice', 'Order\APriceController@editPrice');
                    Route::post('/addPrice', 'Order\APriceController@addPrice');
                    Route::post('{product}/uploadImageProduct', 'Order\APriceController@uploadImageProduct');

                    Route::post('/update_sort', 'Order\APriceController@update_sort');
                });

                Route::post('checkDateTimeGet', 'Order\AOrderController@checkDateTimeGet');

                Route::prefix("category")->group(function () {

                    Route::get('getSize', 'Order\CategoryDetailController@getSize');
                    Route::get('{sizeID}/getCakeTexture', 'Order\CategoryDetailController@getCakeTexture');
                    Route::get('{relationship1}/getCategoryRelationship1', 'Order\CategoryDetailController@getCategoryRelationship1');

                    Route::prefix("sub")->group(function () {
                        Route::get('fetch', 'Order\CategorySubController@fetch');
                        Route::get('{id}/getRelationship', 'Order\CategorySubRelationshipController@getRelationship');
                    });
                });
            });



            Route::prefix("lucky")->group(function () {
                Route::post('reward/getOTP', 'Order\RewardController@getOTP');
                Route::post('reward/register', 'Order\RewardController@register');
            });


            Route::prefix("customer")->group(function () {
                Route::post('getSearchByPhoneNumber', 'Order\CustomerController@getSearchByPhoneNumber');
                Route::post('/', 'Order\CustomerController@store');
            });
        });

        Route::prefix("order")->group(function () {
            Route::post('checkDateTimeGet', 'Order\CustomerController@getSearchByPhoneNumber');

            Route::post('{order}/updateStatusGoodsDone', 'Momday\OrderController@updateStatusGoodsDone');
            Route::post('{order}/updateStatusGoodsGet', 'Momday\OrderController@updateStatusGoodsGet');
            Route::get('{order_id}/fetchByID', 'Momday\OrderController@fetchByID');
        });

        Route::prefix('payment')->group(function () { // api/gueœst/order/
            Route::get('fetchCheck', 'Momday\paymentController@fetchCheck');
            Route::get('{order_id}/fetchByOrderId', 'Momday\paymentController@fetchByOrderId');
            Route::post('{payment}/confirm', 'Momday\paymentController@confirm');
            Route::post('{payment}/confirmOnline', 'Momday\paymentController@confirmOnline');
            Route::post('{payment}/confirmCash', 'Momday\paymentController@confirmCash');
            Route::post('cash/store', 'Momday\paymentController@storeCash');
            Route::post('{payment}/cancel', 'Momday\paymentController@cancel');
        });

        Route::prefix('promotions')->group(function () { // api/gueœst/order/
            Route::get('{promotion_id}/fetchAllByID', 'Momday\PromotionController@fetchAllByID');
            Route::get('{promotion_id}/{order_status_id}/countProduct', 'Momday\PromotionController@countProduct');
        });
    });
});

Route::get('{promotion_id}/test', 'Momday\PromotionController@test');


Route::get('/clear-cache/fghrfywertgsdfdrwet', function () {
    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return 'FINISHED';
});

Route::get('/artisan/df4sd6f41wa6f1f6g8qw3f4as6df4196/migrate', function () {
    return Artisan::call('migrate');
});

Route::get('/artisan/df4sd6f41wa6f1f6g8qw3f4as6df4196/db/seed/{seed}', function ($seed) {
    return Artisan::call('db:seed --class=' . $seed);
});

Route::get('/artisan/df4sd6f41wa6f1f6g8qw3f4as6df4196/{value}', function ($value) {
    return Artisan::call($value);
});


Route::prefix('callback')->group(function () { // api/callback/...
    Route::post('ksherPay', 'Order\KsherPayController@callBack');
});

Route::prefix('webhook')->group(function () { // api/webhook/...
    Route::post('facebook', 'Order\FacebookController@webhook');
    Route::get('facebook', 'Order\FacebookController@webhook');
    Route::post('line', 'Order\LineController@webhook');
    // Route::get('facebook', 'Order\FacebookController@webhook');
});


Route::get('sumOrderToday', 'Order\AOrderController@sumOrderToday');

Route::prefix('cronjobs')->group(function () { // api/v1/...
    Route::get('waitConfirmFromCustomer', 'Order\AOrderController@waitConfirmFromCustomer');
    Route::get('sumAnnual', 'Order\AOrderController@sumAnnual');
    Route::get('sumMonthly', 'Order\AOrderController@sumMonthly');
    Route::get('sumWeekly', 'Order\AOrderController@sumWeekly');
    Route::get('sumDaily', 'Order\AOrderController@sumDaily');
    Route::get('orderToDay', 'Order\AOrderController@orderToDay');
    //
    Route::get('noticePaymetByCustomer', 'Order\NoticeOfPaymentFromCustomerController@cronjobNoticePaymetByCustomer');
});
