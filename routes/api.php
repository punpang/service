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

        Route::get('check_uuid/{uuid}', 'Order\AOrderController@check_uuid');


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
                Route::get('order_details/fetch_for_menu', 'Order\OrderDetailController@fetch_for_menu');
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

        Route::prefix('lottery')->group(function () { // api/gueœst/order/
            Route::get('{customer}/get_period', 'Order\LotteryPeriodController@get_period');
            Route::post('{customer}/{lottery}/register', 'Order\LotteryPeriodController@register');
        });

        Route::prefix('verify_identity')->group(function () { // api/gueœst/order/
            Route::post('{token}/register_member', 'Order\RegisterMemberTempController@update');
            Route::get('profile', 'Order\FacebookController@update');
            Route::post('register_member', 'Order\FacebookController@update');
        });

        Route::prefix('profile')->group(function () { // api/gueœst/order/
            Route::get('psid', 'Order\FacebookController@get_psid_profile')->name("profile_psid");
            // ->middleware("signed");
            Route::post('psid', 'Order\FacebookController@post_psid_profile')->name("profile_psid")->middleware("signed");
        });

        Route::post('register_member_by_facebook', 'Order\RegisterMemberTempController@register_member_by_facebook')->name("register_member_by_facebook")->middleware("signed");
    });



    Route::prefix('otp')->group(function () { // api/gueœst/order/
        Route::post('store', 'OTPController@store');
        Route::post("verify", "OTPController@verify");
    });
});

Route::prefix('v2')->group(function () { // api/gueœst/order/
    Route::prefix('guest')->group(function () { // api/gueœst/order/
        Route::prefix('ksher')->group(function () { // api/v1/guest/ksher
            Route::get('{order}/getUseKsherChannelPayment', 'Order\KsherChannelPaymentController@getUseKsherChannelPayment_v2');
        });
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


            Route::prefix('product_interest')->group(function () { // api/v1/pos/goods/...
                Route::post('store', 'Order\ProductInterestController@store');
                Route::get('fetch', 'Order\ProductInterestController@fetch');
                Route::post('{goods}/alert_to_customer', 'Order\ProductInterestController@alert_to_customer');
            });

            Route::prefix('import')->group(function () { // api/v1/pos/goods/...
                Route::post('excel', 'Order\WongnaiPosBillsController@import');
            });

            Route::prefix('sms')->group(function () { // api/v1/pos/goods/...
                Route::prefix('messages')->group(function () { // api/v1/pos/goods/...
                    Route::post('store', 'Order\SmsMessagesController@store');
                    Route::post('{smsID}/update', 'Order\SmsMessagesController@update');
                    Route::post('send', 'Order\SmsMessagesController@send');
                    Route::get('fetch', 'Order\SmsMessagesController@fetch');
                });
            });

            Route::prefix('coupons')->group(function () { // api/v1/pos/goods/...
                Route::post('store', 'Order\CouponsController@store');
                Route::post('{id}/update', 'Order\CouponsController@update');
                Route::post('{id}/delete', 'Order\CouponsController@delete');
                Route::get('fetch', 'Order\CouponsController@fetch');

                Route::post('useCoupon', 'Order\CouponUsedController@useCoupon');
            });

            Route::prefix('pos')->group(function () { // api/v1/pos/...
                Route::prefix('goods')->group(function () { // api/v1/pos/goods/...
                    Route::post('store', 'Pos\GoodsController@store');
                    Route::post('{id}/update', 'Pos\GoodsController@update');
                    Route::post('{id}/updateStatusUse', 'Pos\GoodsController@updateStatusUse');
                    Route::get('fetch', 'Pos\GoodsController@fetch');
                });
                Route::prefix('category_goods')->group(function () { // api/v1/pos/goods/...
                    Route::post('store', 'Pos\CategoryGoodsController@store');
                    Route::get('fetch', 'Pos\CategoryGoodsController@fetch');
                    Route::post('{id}/update', 'Pos\CategoryGoodsController@update');
                    Route::post('{id}/updateStatusUse', 'Pos\CategoryGoodsController@updateStatusUse');
                });

                Route::prefix('raw_material')->group(function () { // api/v1/pos/goods/...
                    Route::post('store', 'Pos\RawMaterialsController@store');
                    Route::get('fetch', 'Pos\RawMaterialsController@fetch');
                    Route::post('{id}/update', 'Pos\RawMaterialsController@update');
                    Route::post('{id}/updateStatusUse', 'Pos\RawMaterialsController@updateStatusUse');
                });

                Route::prefix('link_raw_material')->group(function () { // api/v1/pos/goods/...
                    Route::post('store', 'Pos\LinkRawMaterialsController@store');
                    Route::post('{id}/update', 'Pos\LinkRawMaterialsController@update');
                    Route::post('{id}/remove', 'Pos\LinkRawMaterialsController@remove');
                });

                Route::prefix('order')->group(function () { // api/v1/pos/goods/...
                    Route::post('store', 'Pos\OrderController@store');
                    Route::post('{id}/update', 'Pos\OrderController@update');
                    Route::post('{id}/delete', 'Pos\OrderController@delete');
                });
            });

            Route::prefix('tags')->group(function () { // api/v1/pos/goods/...
                Route::get('fetch', 'Order\TagsController@fetch');
                Route::post('store', 'Order\TagsController@store');
                Route::post('{id}/edit_tag', 'Order\TagsController@edit_tag');
                Route::post('tags_store', 'Order\TagsController@tags_store');
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

                Route::prefix('pay')->group(function () { // api/v1/guest/ksher
                    Route::get('fetch', 'Order\KsherPayController@fetch_custom');
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
                Route::post('qrCodeReaderUrl', 'Order\NoticeOfPaymentFromCustomerController@qrCodeReaderUrl');
                Route::post('{id}/setCancel', 'Order\NoticeOfPaymentFromCustomerController@setCancel');
            });

            Route::prefix('orders')->group(function () { // api/admin/v1/orders/...
                Route::get('fetch', 'Order\AOrderController@fetch_orders');
                Route::prefix('details')->group(function () { // api/admin/v1/orders/...
                    Route::get('fetch', 'Order\OrderDetailController@fetch');
                    Route::get('fetch_pre_order_lists', 'Order\OrderDetailController@fetch_pre_order_lists');

                    Route::prefix('pos')->group(function () { // api/admin/v1/orders/...
                        Route::get('fetch', 'Order\AOrderController@pos_fetch');
                        Route::get('fetch_pre_pos_lists', 'Order\AOrderController@fetch_pre_pos_lists');
                    });
                });
            });

            Route::prefix("order")->group(function () {
                Route::post('newOrder', 'Order\AOrderController@newOrder');
                Route::post('{order}/addGoodsCake', 'Order\AOrderController@addGoodsCake');
                Route::post('{order}/changeCustomer', 'Order\AOrderController@changeCustomer');
                Route::post('{order}/changeDateTimeGet', 'Order\AOrderController@changeDateTimeGet');
                Route::post('{order}/prepareGoods', 'Order\AOrderController@prepareGoods');
                Route::post('{order}/customerNoPayment', 'Order\AOrderController@customerNoPayment');
                Route::post('{order}/pickUpGoods', 'Order\AOrderController@pickUpGoods');
                Route::post('{order}/summaryOfOrderDetails', 'Order\AOrderController@summaryOfOrderDetails');
                Route::post('{order}/{channel_id}/update_channel_order', 'Order\AOrderController@update_channel_order');
                Route::post('{order}/use_point_by_order_id', 'Order\AOrderController@use_point_by_order_id');
                Route::post('{order}/remove_use_point_by_order_id', 'Order\AOrderController@remove_use_point_by_order_id');
                Route::post('{order}/update_alert_facebook_by_prepare', 'Order\AOrderController@update_alert_facebook_by_prepare');

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

                    Route::post('update_sort_group_multi_cake', 'Order\OrderDetailController@update_sort_group_multi_cake');
                    Route::post('{id}/remove_muticake', 'Order\OrderDetailController@remove_muticake');
                    Route::post('{id}/add_multi_cake', 'Order\OrderDetailController@add_multi_cake');

                    Route::prefix('addOn')->group(function () { // api/admin/v1/order/detail/addOn
                        Route::post('{id}/autoUpdateAddOns', 'Order\OrderDetailController@autoUpdateAddOns');
                        Route::post('{id}/create', 'Order\OrderDetailController@createAddOn');
                        Route::post('{id}/delete', 'Order\OrderDetailController@deleteAddOn');
                    });

                    Route::prefix('productPrototype')->group(function () { // api/admin/v1/order/detail/addOn
                        Route::post('{detail_id}/store', 'Order\OrderProductPrototypeController@store');
                        Route::post('{detail_id}/delete', 'Order\OrderProductPrototypeController@delete');
                    });

                    Route::prefix('imageForMenu')->group(function () { // api/admin/v1/order/detail/addOn
                        Route::post('{detail_id}/store', 'Order\OrderImageForMenuController@store');
                        Route::post('{detail_id}/delete', 'Order\OrderImageForMenuController@delete');
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
                Route::post('{order}/alertPaymentExtendTimeByOrderID', 'Order\AOrderController@alertPaymentExtendTimeByOrderID');

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
                Route::post('{customer}/update', 'Order\CustomerController@update');
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

// Route::get('{promotion_id}/test', 'Momday\PromotionController@test');
// Route::get('test/{order}', 'Order\FacebookController@test_sumup_message');
Route::get('summaryOfOrderDetails/{order}', 'Order\FacebookController@summaryOfOrderDetails');


// Route::get('testssss/readerqrcode', 'Order\FacebookController@readerqrcode');
// Route::get('get_bese64', 'Order\FacebookController@get_bese64');
// Route::get('ocr_aiforthai', 'Order\FacebookController@aiforthai');
// Route::get('check_slip', 'Order\FacebookController@check_slip');
// Route::get('FacebookImagesAlertPaymentJob', 'Order\FacebookController@FacebookImagesAlertPaymentJob');
// Route::get('reqrcodetext', 'Order\NoticeOfPaymentFromCustomerController@reqrcodetext');
// Route::get('text_test/{text}', 'Order\WongnaiPosBillsController@text_test');
// Route::get('text_test/{text}', 'Order\WongnaiPosBillsController@text_test');
// Route::get('wongnai', 'Order\WongnaiPosBillsController@test');
Route::get('set_url_timeout', 'Order\WongnaiPosBillsController@set_url_timeout');
Route::post('url_set_time', 'Order\WongnaiPosBillsController@url_set_time')->name("url_set_time")->middleware("signed");
Route::get('check_expires', 'Order\WongnaiPosBillsController@check_expires');

Route::get('psid_member', 'Order\WongnaiPosBillsController@get_psid_member')->name("psid_member")->middleware("signed");
Route::post('psid_member', 'Order\WongnaiPosBillsController@post_psid_member')->name("psid_member")->middleware("signed");


// Route::get('/clear-cache/fghrfywertgsdfdrwet', function () {
//     Artisan::call('optimize:clear');
//     Artisan::call('config:clear');
//     Artisan::call('cache:clear');
//     Artisan::call('config:cache');
//     return 'FINISHED';
// });

// Route::get('/artisan/df4sd6f41wa6f1f6g8qw3f4as6df4196/migrate', function () {
//     return Artisan::call('migrate');
// });

Route::get('/artisan/df4sd6f41wa6f1f6g8qw3f4as6df4196/queue/refresh', function () {
    Artisan::call('queue:restart');
    Artisan::call('queue:work --queue=high,default');
    return "Finished";
});

Route::get('/artisan/df4sd6f41wa6f1f6g8qw3f4as6df4196/queue/restart', function () {
    return Artisan::call('queue:restart');
});

Route::get('/artisan/df4sd6f41wa6f1f6g8qw3f4as6df4196/queue/work', function () {
    return Artisan::call('queue:work --queue=high,default');
});

// Route::get('/artisan/df4sd6f41wa6f1f6g8qw3f4as6df4196/db/seed/{seed}', function ($seed) {
//     return Artisan::call('db:seed --class=' . $seed);
// });

// Route::get('/artisan/df4sd6f41wa6f1f6g8qw3f4as6df4196/{value}', function ($value) {
//     return Artisan::call($value);
// });


Route::prefix('callback')->group(function () { // api/callback/...
    Route::post('ksherPay', 'Order\KsherPayController@callBack');
});

Route::prefix('webhook')->group(function () { // api/webhook/...
    Route::post('facebook', 'Order\FacebookController@webhook');
    Route::get('facebook', 'Order\FacebookController@webhook');
    Route::post('line', 'Order\LineController@webhook');
    // Route::get('facebook', 'Order\FacebookController@webhook');
    // Route::get('hash_hmac', 'Order\FacebookController@hash_hmac');
    Route::get('save_image_base64', 'Order\FacebookController@save_image_base64');
});


Route::prefix('test')->group(function () { // api/webhook/...
    Route::get('date', function () {
        $day = "20240404";
        $time = "13:09";
        $date = \Carbon\Carbon::parse($day)->format("Y-m-d") . " " . $time . ":00";

        return $date;
    });
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
