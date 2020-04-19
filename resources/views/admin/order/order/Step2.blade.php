@extends('admin.layouts.main')

@section('body')

@include('layouts.errors')
{{-- {!! Form::open(['action' => 'Order\ACustomerController@store' , 'class' => 'm-0']) !!} --}}
{{-- <div class="row pr-2 pl-2 justify-content-center"> --}}
{{ Form::open(['action' => ['Order\AOrderController@createOrder' , $customer->tel]]) }}

<h5>รายการสั่งซื้อใหม่</h5>

<div class="card-deck">
    <div class="card">
        <div class="card-header">
            ข้อมูลลูกค้า
        </div>
        <div class="card-body">
          <input type="hidden" name="IDCustomer" required disabled value="{{ $customer->id }}" class="form-control">

            <div class="form-group row">
                <label class="col-sm-3 col-4 col-form-label">ชื่อลูกค้า</label>
                <div class="col-sm-9 col-8 text-middle">{{ $customer->name }}</div>
            </div>

            <div class="form-group row mb-0">
                <label class="col-sm-3 col-4 col-form-label">เบอร์โทร</label>
                <div class="col-sm-9 col-8 text-middle">{{ $customer->tel }}</div>
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            วัน-เวลารับสินค้า
        </div>
        <div class="card-body">

            <div class="form-group row">
                <label class="col-sm-3 col-12 col-form-label">วันที่รับ</label>
                <div class="col-sm-9 col-12 text-middle">
                  <input type="date" name="date_get" readonly required value="{{ $data['date_get'] }}" class="form-control">
                </div>
            </div>

            <div class="form-group row mb-0">
                <label class="col-sm-3 col-12 col-form-label">เวลาที่รับ</label>
                <div class="col-sm-9 col-12 text-middle">
                  <input type="time" name="time_get" readonly required value="{{ $data['time_get'] }}" class="form-control">
                </div>
            </div>

        </div>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header">
        รายละเอียด
    </div>
    <div class="card-body">

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">ประเภท</label>
            <div class="col-sm-9 col-12 text-middle">
              <input type="hidden" name="m1"  required value="{{ $data['m1']['id'] }}" class="form-control">
              <input type="text" readonly required value="{{ $data['m1']['m1'] }}" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">เนื้อเค้ก</label>
            <div class="col-sm-9 col-12 text-middle">
              <input type="hidden" name="m2"  required value="{{ $data['m2']['id'] }}" class="form-control">
              <input type="text" readonly required value="{{ $data['m2']['m2'] }}" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">รูปแบบ</label>
            <div class="col-sm-9 col-12 text-middle">
              <input type="hidden" name="m3" readonly required value="{{ $data['m3']['id'] }}" class="form-control">
              <input type="text" readonly required value="{{ $data['m3']['m3'] }}" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">ขนาด</label>
            <div class="col-sm-9 col-12 text-middle">
              <input type="hidden" name="m4" readonly required value="{{ $data['m4']['id'] }}" class="form-control">
              <input type="text" readonly required value="{{ $data['m4']['m4'] }}" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">สินค้า</label>
            <div class="col-sm-9 col-12 text-middle">
              <input type="text" required readonly class="form-control" name="code" value="{{ $data['code'] }}">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">เขียนข้อความ</label>
            <div class="col-sm-9 col-12 text-middle">
              <input type="text" required readonly class="form-control" name="msg" value="{{ $data['msg'] }}">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">รายละเอียดเพิ่มเติม</label>
            <div class="col-sm-9 col-12 text-middle">
                <textarea name="other" readonly required class="form-control" rows="3" cols="80">{{ $data['other'] }}</textarea>
            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">ราคาสินค้า</label>
            <div class="col-sm-3 col-12 text-middle">
              <input type="text" required  class="form-control" name="total" value="{{ $price->price }}">
            </div>
            <label class="col-sm-3 col-12 col-form-label">ราคาเพิ่มเติม</label>
            <div class="col-sm-3 col-12 text-middle">
              <input type="text" required  class="form-control" name="add" value="0">
            </div>
        </div>

        <hr>

        <div class="form-group row mb-0">
          <div class="col-sm-6 col-12 mb-1 mt-1">
            <button type="submit" class="btn btn-success btn-block btn-lg">สร้างรายการใหม่</button>
          </div>
          <div class="col-sm-6 col-12 mb-1 mt-1">
            <a href="javascript:history.back()" class="btn btn-warning btn-block btn-lg">แก้ไขรายการ</a>
          </div>
        </div>
    </div>
</div>

{{ Form::close() }}

{{-- </div> --}}


{{-- {!! Form::close() !!} --}}
@endsection
