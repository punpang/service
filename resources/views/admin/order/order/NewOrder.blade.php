@extends('admin.layouts.main')

@section('body')

@include('layouts.errors')
{{-- {!! Form::open(['action' => 'Order\ACustomerController@store' , 'class' => 'm-0']) !!} --}}
{{-- <div class="row pr-2 pl-2 justify-content-center"> --}}
{{ Form::open(['action' => ['Order\AOrderController@Step2' , $customer->tel]]) }}

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
                  @if (old('date_get'))
                    <input type="date" name="date_get" required value="{{ old('date_get') }}" class="form-control">
                  @else
                    <input type="date" name="date_get" required value="{{ Carbon\Carbon::now()->format("Y-m-d") }}" class="form-control">
                  @endif
                </div>
            </div>

            <div class="form-group row mb-0">
                <label class="col-sm-3 col-12 col-form-label">เวลาที่รับ</label>
                <div class="col-sm-9 col-12 text-middle">
                  <select class="form-control" required name="time_get">
                    <option value="">เลือกเวลารับ</option>
                    @foreach ($times as $time)
                      @if (old('time_get') == $time['data'])
                            <option value="{{ $time['data'] }}" selected>{{ $time['show'] }}</option>
                      @else
                            <option value="{{ $time['data'] }}">{{ $time['show'] }}</option>
                      @endif
                      {{-- <option value="{{ $time['data'] }}">{{ $time['show'] }}</option> --}}
                    @endforeach
                  </select>
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
              <select class="form-control" name="m1" required>
                  <option value="">โปรดเลือก</option>
                  @foreach ($m1 as $key => $value)
                    @if (old('m1') == $key)
                          <option value="{{ $key }}" selected>{{ $value }}</option>
                    @else
                          <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                  @endforeach
              </select>
              {{-- {!! Form::select('m1',$m1,NULL,['class' => 'form-control']) !!} --}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">เนื้อเค้ก</label>
            <div class="col-sm-9 col-12 text-middle">
              <select class="form-control" name="m2" required>
                  <option value="">โปรดเลือก</option>
                  @foreach ($m2 as $key => $value)
                    @if (old('m2') == $key)
                          <option value="{{ $key }}" selected>{{ $value }}</option>
                    @else
                          <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                  @endforeach
              </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">รูปแบบ</label>
            <div class="col-sm-9 col-12 text-middle">
              <select class="form-control" name="m3" required>
                  <option value="">โปรดเลือก</option>
                  @foreach ($m3 as $key => $value)
                    @if (old('m3') == $key)
                          <option value="{{ $key }}" selected>{{ $value }}</option>
                    @else
                          <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                    {{-- <option value="{{$key}}">{{$value}}</option> --}}
                  @endforeach
              </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">ขนาด</label>
            <div class="col-sm-9 col-12 text-middle">
              <select class="form-control" name="m4" required>
                  <option value="">โปรดเลือก</option>
                  @foreach ($m4 as $key => $value)
                    @if (old('m4') == $key)
                          <option value="{{ $key }}" selected>{{ $value }}</option>
                    @else
                          <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                  @endforeach
              </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">สินค้า</label>
            <div class="col-sm-9 col-12 text-middle">
              <input type="text" required class="form-control" name="code" value="{{ old('code') }}">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">เขียนข้อความ</label>
            <div class="col-sm-9 col-12 text-middle">
              <input type="text" required class="form-control" name="msg" value="{{ old('msg') }}">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-12 col-form-label">รายละเอียดเพิ่มเติม</label>
            <div class="col-sm-9 col-12 text-middle">
                <textarea name="other" required class="form-control" rows="3" cols="80">{{ old('other') }}</textarea>
            </div>
        </div>

        <hr>

        <div class="form-group row mb-0">
          <div class="col-sm-6 col-12 mb-1 mt-1">
            <button type="submit" class="btn btn-success btn-block btn-lg">ตรวจสอบ</button>
          </div>
          <div class="col-sm-6 col-12 mb-1 mt-1">
            <button class="btn btn-danger btn-block btn-lg">ยกเลิก</button>
          </div>
        </div>
    </div>
</div>
{{ Form::close() }}

{{-- </div> --}}


{{-- {!! Form::close() !!} --}}
@endsection
