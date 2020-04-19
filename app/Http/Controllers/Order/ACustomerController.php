<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\ACustomer;
use Session;

use function GuzzleHttp\Promise\all;

class ACustomerController extends Controller
{
  public function index()
  {
    $data = ACustomer::get();
    return response()->json($data, 200);
  }

  public function phoneOnly()
  {
    $data = ACustomer::select('phone')->get();
    return response()->json($data, 200);
  }

  public function selectCustomerByPhone($phone)
  {
    $data = ACustomer::where('phone',$phone)->first();
    return response()->json($data, 200);
  }

  public function Find()
  {
    return view('admin.order.customer.find');
  }

  public function Finded()
  {
    request()->validate([
      'phone' => 'digits:10|numeric|regex:/[0][0-9]/' //|unique:customers,phone
    ], [
      'phone.digits' => 'โปรดกรอกหมายเลขโทรศัพท์ 10 หลัก',
      'phone.regex' => 'โปรดกรอกขึ้นต้นด้วยเลข 0 เท่านั้น',
      'phone.numeric' => 'โปรดกรอกเป็นตัวเลขเท่านั้น',
    ]);

    $customer = ACustomer::where('phone', request('phone'))->first();
    if ($customer == null) {
      $phone = request('phone');
      //Session::flash('primary', 'หมายเลขนี้ ไม่เคยทำรายการมาก่อน');

      return redirect()->action('Order\ACustomerController@NewCustomer', ['phone' => request('phone')]);
    } else {
      return redirect()->action('Order\AOrderController@NewOrder', ['phone' => request('phone')]);
    }
  }

  public function NewCustomer($phone)
  {
    return view('admin.order.customer.NewCustomer', compact('phone'));
  }

  public function store()
  {
     request()->validate([
      'name' => 'required',
      'phone' => 'required|unique:order.a_customer,phone'
    ], [
      'name.required' => 'กรุณากรอกชื่อลูกค้า',
      'phone.unique' => 'หมายเลขนี้ มีอยู่ในระบบแล้ว'
    ]);

    //return request()->all();
    $customer = ACustomer::create(request()->all());
    //$customer->create(request()->all());
    /*
    $customer->name = request('name');
    $customer->phone = request('phone');
    */   
    
    return response()->json($customer);
  }

  public function edit(ACustomer $customer)
  {
    request()->validate([
      'name' => 'required',
      'phone' => 'required|unique:order.a_customer,phone,' . $customer->id
    ], [
      'name.required' => 'กรุณากรอกชื่อลูกค้า',
      'phone.unique' => 'หมายเลขนี้ มีอยู่ในระบบแล้ว'
    ]);

    $customer->update(request()->all());
    $customer->save();
    /*
    $customer->name = request('name');
    $customer->phone = request('phone');
    $customer->save();
    */
    return response()->json($customer);
  }
}
