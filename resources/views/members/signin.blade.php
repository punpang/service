@extends('layouts.main')
@section('body')

	{!! Form::open(['action' => 'MemberController@SignInCheck']) !!}
  <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card border-0">
                  <div class="card-header border-0 bg-gray h5 m-0">เข้าสู่ระบบ</div>

                  <div class="card-body border">
                    @include('layouts.errors')

                    <div class="form-group">
                      <label for="phone">เบอร์โทรศัพท์</label>
                      {!! Form::tel('phone',null,['class'=>'rounded-0 form-control' ,'placeholder'=> 'เบอร์โทรศัพท์ 10 หลัก' ,'pattern' => '\d*' , 'required' ,'min' => "10" ,'max' => "10"]) !!}
                    </div>

                    {!! Form::submit('เข้าสู่ระบบ',['class' => 'btn btn-orange rounded-0 text-size-18 text-center btn-block']) !!}

                  </div>
              </div>
          </div>
      </div>
      {{ Form::close() }}

@endsection
