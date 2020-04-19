@extends('layouts.main')
@section('body')

  {!! Form::open(['action' => ['MemberController@store', $phone] , 'method'=>'POST']) !!}
  <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card border-0">
                  <div class="card-header border-0 bg-gray h5 m-0">สมัครสมาชิก</div>

                  <div class="card-body border">
                    @include('layouts.errors')

                    <div class="form-group">
                      <label for="name">ชื่อลูกค้า</label>
                      {!! Form::text('name',null,['class'=>'rounded-0 form-control' ,'placeholder'=> 'สามารถใช้ชื่อเล่นได้']) !!}
                    </div>

                    <div class="form-group">
                      <label for="phone">เบอร์โทรศัพท์</label>
                      {!! Form::tel('phone',$phone,['class'=>'rounded-0 form-control', 'readonly' ,'placeholder'=> 'เบอร์โทรศัพท์ 10 หลัก' ,'pattern' => '\d*' , 'required' ,'min' => "10" ,'max' => "10"]) !!}
                    </div>
                    <div class="form-group form-check">
                      {!! Form::checkbox('condition',1,false,['class' => 'form-check-input']) !!}
                      {{-- <input type="checkbox" class="form-check-input"> --}}
                      {!! Form::label('condition','คุณอ่านและยอมรับเงื่อนไขทุกประการ',['class' => 'form-check-label']) !!}
                      <a href="{{ route('member.condition') }}" target="_blank">กดอ่านเงื่อนไข</a>
                      {{-- <label class="form-check-label" for="condition">คุณอ่านและยอมรับ <a href="{{ route('member.condition') }}" target="_blank">เงื่อนไข</a> ทุกประการ</label> --}}
                    </div>
                    {!! Form::submit('ยืนยัน',['class' => 'btn btn-orange rounded-0 text-size-18 text-center btn-block']) !!}
                      {{-- <div class="form-group m-0">
                        @include('layouts.errors')
                          <div class="form-group row justify-content-md-center">
                            <label for="name" style="height:40px" class="col-md-3 mb-0 col-form-label h5 text-right d-none d-sm-none d-md-block"><b>ชื่อลูกค้า</b> </label>
                            <div class="col-12 col-md-9">
                              {!! Form::text('name',null,['class'=>'rounded-0 form-control' ,'placeholder'=> 'ชื่อลูกค้า *สามารถใช้ชื่อเล่นได้']) !!}

                            </div>
                          </div>

                          <div class="form-group row justify-content-md-center">
                            <label for="phone" style="height:40px" class="col-md-3 mb-0  col-form-label h5 text-right d-none d-sm-none d-md-block"><b>เบอร์โทรศัพท์</b> </label>
                            <div class="col-12 col-md-9">
                              {!! Form::tel('phone',$phone,['class'=>'rounded-0 form-control', 'readonly' ,'placeholder'=> 'เบอร์โทรศัพท์ 10 หลัก' ,'pattern' => '\d*' , 'required' ,'min' => "10" ,'max' => "10"]) !!}

                            </div>
                          </div>
                          <div class="form-group row justify-content-md-center">

                            <label  class="col-md-3 form-check-label h5 text-right d-none d-sm-none d-md-block"></label>
                            <div class="col-12 col-md-9 form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                {!! Form::checkbox('condition',['class' => 'form-check-input'],false) !!}
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                <div class="col-1 pr-0" style="padding-top:3px">

                                </div>
                                <div class="col pr-0" style="font-size:14px">
                                  คุณอ่านและยอมรับ <a href="{{ route('member.condition') }}" target="_blank">เงื่อนไข</a> ทุกประการ
                                </div>

                            </div>
                          </div>

                          <div class="form-group row justify-content-md-center mb-0">
                            <div class="col-12 col-md-3">

                            </div>
                            <div class="col-12 col-md-9">
                              {!! Form::submit('ยืนยัน',['class' => 'btn btn-orange rounded-0 text-size-18 text-center btn-block']) !!}
                            </div>
                          </div>
                      </div> --}}

                  </div>
              </div>
          </div>
      </div>
      {{ Form::close() }}

@endsection
