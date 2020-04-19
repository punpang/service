@extends('admin.layouts.main')

@section('body')
{!! Form::open(['action' => 'Order\ACustomerController@Finded' , 'class' => 'm-0']) !!}
  <div class="row pr-2 pl-2 justify-content-center">

      <div class="card col-md-5 p-0">

          <div class="card-header">
              <h5 class="m-0">ค้นหาลูกค้า</h5>
          </div>

          <div class="card-body">

              {{-- @include('layouts.errors') --}}

              <div class="form-group m-0">
                  <label for="phone">เบอร์โทรศัพท์</label>
                  {{-- {!! Form::tel('phone',null,['class'=>'rounded-0 form-control'.$errors->has('danger') ? ' is-invalid' : '' ,'placeholder'=> 'เบอร์โทรศัพท์ 10 หลัก' ,'pattern' => '\d*' , 'required' ,'min' => "10" ,'max' => "10"]) !!} --}}
                  <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="เบอร์โทรศัพท์ 10 หลัก" pattern="\d*" required min="10" max="10">

                  @if ($errors->has('phone'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('phone') }}</strong>
                      </span>
                  @endif

              </div>

          </div>

          <div class="card-footer p-0 border-0">
              {!! Form::submit('ค้นหา',['class' => 'btn btn-orange rounded-0 text-size-18 text-center btn-block']) !!}
          </div>

      </div>

  </div>
{!! Form::close() !!}
@endsection
