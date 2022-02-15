<?php

// Route::get('/clear-cache', function () {
//   Artisan::call('config:clear');
//   Artisan::call('cache:clear');
//   Artisan::call('config:cache');
//   return 'FINISHED';
// });


Route::get('/{any?}', "Momday\OrderController@mainWeb")->where('any', '^(?!api\/)[\/\w\.-]*');
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
// Route::get('/signup/{phone}','MemberController@signup')->name('member.signup');
/*
Auth::routes();

Route::get('test/http', function(){
  $source = '<html>
<head>
<style type="text/css">
#outerdiv {
height:400px;
overflow: hidden;
position: relative;
width: 700px;
}
#inneriframe {
height: 1000px;
left: -150px;
position: absolute;
top: -550px;
width: 970px;
}
</style>
</head>
<body>
<div id="outerdiv">
<iframe src="https://www.best-inc.co.th/track?bills=66010019955691" id="inneriframe" scrolling="no" ></iframe>
</div>
</body>
</html>';
  return $source;

});

Route::get('/', 'HomeController@welcome')->name('home');


//Route for normal user
// Route::group(['middleware' => ['auth']], function () {
//     Route::get('/home', 'HomeController@index');
// });
//Route for admin
// Route::group(['prefix' => 'admin'], function(){
//     Route::group(['middleware' => ['admin']], function(){
//         Route::get('/dashboard', 'admin\AdminController@index');
//     });
// });

Route::prefix('member')->group(function () {
  Route::get('/', 'MemberController@index')->name('member.index');
  Route::get('processed', 'MemberController@processed')->name('member.processed');
  Route::get('signup', 'MemberController@check')->name('member.signup');

  Route::get('signin', 'MemberController@signin')->name('member.signin');
  Route::post('signin', 'MemberController@SignInCheck')->name('member.signin');

  Route::post('checked', 'MemberController@checked')->name('member.checked');
  Route::get('condition', 'MemberController@condition')->name('member.condition');
  Route::post('signup/{phone}/store','MemberController@store')->name('member.store');
  Route::post('SignInDone', 'MemberController@SignInDone')->name('signin.member.SignInDone');
  Route::middleware('auth')->group(function(){
    Route::get('dashboard', 'MemberController@dashboard')->name('auth.member.dashboard');
    Route::get('purchase/history', 'MemberController@HistoryPurchase')->name('auth.member.HistoryPurchase');
    Route::get('point_coupon', 'MemberController@PointCoupon')->name('auth.member.PointCoupon');
    Route::get('point_coupon/CreateCoupon', 'MemberController@CreateCoupon')->name('auth.member.CreateCoupon');
    Route::get('point_coupon/CreateCoupon/{CouponId}/ConfirmCoupon', 'MemberController@ConfirmCoupon')->name('auth.member.ConfirmCoupon');
    Route::post('point_coupon/CreateCoupon/NewCoupon', 'MemberController@NewCoupon')->name('auth.member.NewCoupon');
    Route::get('point_coupon/MyCoupon/{CouponId}', 'MemberController@ECoupon')->name('auth.member.Coupon');
    Route::get('point_coupon/MyCoupon/', 'MemberController@MyCoupon')->name('auth.member.MyCoupon');
  });

  // Route::get('analyze/age', 'MemberController@analyze_age_of_member')->name('member.analyze_age_of_member');
});


Route::prefix('back/end/system')->group(function () {
  Route::get('last/sell', 'BackEndOfSystemController@last_sell'); //แจ้งเตือนการขายล่าสุด
  Route::get('last/sell/cancel', 'BackEndOfSystemController@LastSellCancel'); //แจ้งเตือนการขายล่าสุด กรณียกเลิกบิล
  Route::get('sumofday', 'BackEndOfSystemController@SumOfDay'); //แจ้งเตือนการยอดขายประจำวัน
  Route::get('order/today/count', 'BackEndOfSystemController@OrderTodayCount'); //รายการสั่งซื้อวันนี้
});

Route::prefix('punpang')->group(function () {
  Route::get('menu', 'Punpang\ProductController@index'); //แจ้งเตือนการขายล่าสุด
  Route::get('product/{id}', 'Punpang\ProductController@ProductId'); //แจ้งเตือนการขายล่าสุด

});

Route::prefix('order')->group(function () {
  Route::get('upload/image/order/{order_id}/{auth_key}', 'Order\UploadImgCustomerController@upload'); //เลือกรูป เขียนข้อความ อัปโหลด
  Route::post('upload/image/store', 'Order\UploadImgCustomerController@store'); //เลือกรูป เขียนข้อความ อัปโหลด
});

Route::prefix('best-express')->group(function () {
  Route::get('sender/{sender}/{date}',function($sender , $date){
    return redirect()->action('BestExpress\TrackingController@ShowTracking' , ['sender' => $sender , 'date' => $date]);
  });
  Route::get('sender/{sender}/date/{date}','BestExpress\TrackingController@ShowTracking');
});


Route::middleware('admin')->group(function(){

  Route::prefix('admin')->group(function () {

    Route::prefix('best-express')->group(function () {

      Route::get('dashboard','BestExpress\DashboardController@dashboard');

      Route::get('sender','BestExpress\SenderController@index');
      Route::get('sender/create','BestExpress\SenderController@create');
      Route::post('sender/store','BestExpress\SenderController@store');
      Route::get('sender/{sender}/show','BestExpress\SenderController@show');
      Route::get('sender/{sender}/edit','BestExpress\SenderController@edit');
      Route::patch('sender/{sender}/update','BestExpress\SenderController@update');
      Route::post('sender/{sender}/tracking/','BestExpress\SenderController@ShowTrackingPost');
      Route::get('sender/{sender}/date/{date}','BestExpress\SenderController@ShowTrackingGet');

      Route::get('tracking','BestExpress\TrackingController@index');
      Route::get('tracking/sender/find','BestExpress\TrackingController@SenderFind');
      Route::post('tracking/sender/choose','BestExpress\TrackingController@SenderChoose');
      Route::get('tracking/sender/{sender}/create','BestExpress\TrackingController@create');
      Route::post('tracking/store','BestExpress\TrackingController@store');
      Route::get('tracking/{waybill}','BestExpress\TrackingController@show');
      Route::get('tracking/{waybill}/edit','BestExpress\TrackingController@edit');
      Route::put('tracking/update/{id}','BestExpress\TrackingController@update');
      Route::get('export', 'BestExpress\TrackingController@export')->name('export');
      Route::get('importExportView', 'BestExpress\TrackingController@importExportView');
      Route::post('import', 'BestExpress\TrackingController@import')->name('import');

      Route::post('payment/create/sender/{sender}/date/{date}','BestExpress\PaymentController@create');
    });

    Route::prefix('order')->group(function () {

      Route::get('dashboard/today', 'Order\AOrderController@DashboardToday')->name('admin.order.dashboard.today'); //dashboard เฉพาะออร์เดอร์วันนั้นๆ

      Route::get('customer/find', 'Order\ACustomerController@Find')->name('admin.order.customer.find');
      Route::post('customer/find', 'Order\ACustomerController@Finded')->name('admin.order.customer.finded');
      Route::get('customer/new/{phone}', 'Order\ACustomerController@NewCustomer')->where('phone', '[0][0-9]{9}')->name('admin.order.customer.new');
      Route::post('customer/store', 'Order\ACustomerController@store');

      Route::get('new/step/1/{phone}', 'Order\AOrderController@NewOrder')->where('phone', '[0][0-9]{9}')->name('admin.order.order.new');
      Route::post('new/step/2/{phone}', 'Order\AOrderController@Step2')->where('phone', '[0][0-9]{9}');
      Route::post('new/createOrder/{phone}', 'Order\AOrderController@createOrder')->where('phone', '[0][0-9]{9}');

      Route::get('{order}', 'Order\AOrderController@ShowOrder');

      Route::post('{order}/payment/store', 'Order\PaymentController@store');
      Route::post('{order}/payment/cancel', 'Order\PaymentController@cancel');

      Route::post('{order}/alert/to/customer', 'Order\AOrderController@AlertToCustomer');

    });

  });

});

Route::prefix('test')->group(function () {
  // Route::get('analyze/age', 'MemberController@analyze_age_of_member')->name('member.analyze_age_of_member');
  // Route::get('return/points', 'MemberController@return_points');
  //
  // Route::get('signin/{phone}/check/', 'MemberController@check_signin')->name('test.member.signin.check');
  // Route::get('signin', 'ShotlinkController@signintest')->name('test.member.signin');

  // Route::get('member/dashboard', 'MemberController@dashboard')->name('test.member.dashboard');



  // Route::get('redirect', 'ShotlinkController@test');

});

Route::get('r/{id}/{key_link}', 'ShotlinkController@redirect');
Route::post('signin/SignInDone', 'MemberController@SignInDone')->name('signin.member.SignInDone');

Route::middleware('signed')->prefix('protected')->group(function(){
  Route::get('signup/{phone}','MemberController@signup')->name('signed.member.signup');

  Route::get('signin/{phone}/check', 'MemberController@check_signin')->name('signin.member.check');

  Route::get('order/payment/confirm/{order}', 'Order\PaymentController@confirm'); //อัปโหลดสลิปเพื่อแจ้งการชำระเงินจากลูกค้า


  Route::prefix('back/end/system')->group(function () {
    Route::get('dashboard/today', 'AOrderController@DashboardToday')->name('signed.backend.dashboard.today'); //dashboard เฉพาะออร์เดอร์วันนั้นๆ
  });

  Route::prefix('best-express')->group(function () {
    Route::get('sender/{sender}/date/{date}','BestExpress\SenderController@ShowTrackingGet')->name('signed.bestexpress.sender'); //สำหรับผู้ส่ง
  });
});
*/
