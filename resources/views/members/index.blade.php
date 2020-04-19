@extends('layouts.main')
@section('body')


  @include('layouts.errors')

  <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card border-0">
                  <div class="card-header border-0 bg-gray h5 m-0">ปั้นแป้ง เบเกอรี่ ปราณบุรี สวัสดีค่ะ</div>

                  <div class="card-body border-0 row justify-content-md-center">
                    <div class="col-12 col-md-9">
                        <a href="{{ action('MemberController@signin') }}" class="btn btn-orange btn-block  mb-2">
                            <div class="h6 p-1 m-0">
                                เข้าสู่ระบบ
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-9">
                        <a href="{{ action('MemberController@check') }}" class="btn btn-msg btn-block ">
                            <div class="h6 p-1 m-0">
                                สมัครสมาชิก
                            </div>
                        </a>
                    </div>
                  </div>
              </div>
          </div>
      </div>

@endsection
