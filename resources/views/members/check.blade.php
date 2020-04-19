@extends('layouts.main')
@section('body')

  {!! Form::open(['action' => 'MemberController@checked']) !!}
  <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card border-0">
                  <div class="card-header border-0 bg-gray h5 m-0">ตรวจสอบสมาชิก</div>

                  <div class="card-body border">
                      <div class="form-group m-0">
                        @include('layouts.errors')
                          <div class="form-group row justify-content-md-center">
                            <label for="phone" style="height:40px" class="col-md-3 mb-0 col-form-label h5 text-right d-none d-sm-none d-md-block"><b>เบอร์โทรศัพท์</b> </label>
                            <div class="col-12 col-md-9">
                              {!! Form::tel('phone',null,['class'=>'rounded-0 form-control','placeholder'=> 'เบอร์โทรศัพท์ 10 หลัก' ,'pattern' => '\d*' , 'required' ,'min' => "10" ,'max' => "10"]) !!}

                              {{-- <input type="tel" style="height:40px" min="10" max="10" required="" placeholder="เบอร์โทรศัพท์ 10 หลัก" class="rounded-0 form-control" pattern="\d*" name="phone"> --}}
                            </div>
                          </div>

                          <div class="form-group row justify-content-md-center mb-0">
                            <div class="col-12 col-md-3">

                            </div>
                            <div class="col-12 col-md-9">
                                <button class="btn btn-orange rounded-0 text-size-18 text-center btn-block" style="height:40px">
                                    <div>
                                        ตรวจสอบ
                                    </div>
                                </button>
                            </div>
                          </div>
                      </div>

                  </div>
              </div>
          </div>
      </div>
      {{ Form::close() }}

@endsection
