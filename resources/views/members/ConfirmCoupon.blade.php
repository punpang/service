@extends('layouts.main')
@section('body')

{{-- {{ $coupons }} --}}

<h3 class="mt-2">แลกคูปอง</h3>
<p class="card-text">คะแนนสะสม {{ $member->PointCoupon->score_total }} คะแนน</p>
{!! Form::open(['action' => 'MemberController@NewCoupon']) !!}
<div class="card mb-2">
    <div class="card-body">
      <input type="hidden" name="CouponId" value="{{ $coupon->id }}">
        <h5 class="card-title">{{ $coupon->name }}</h5>
        <p class="card-text">ใช้คะแนน {{ $coupon->value }} คะแนน</p>
        <hr>
        <h6 class="text-danger m-1">- คูปองมีอายุ 1 ปี</h6>
        <h6 class="text-danger m-1">- คูปองสามารถใช้ได้ครั้งเดียว</h6>
        <h6 class="text-danger m-1">- ห้ามให้รหัสคูปองแก่บุคคลอื่น</h6>
        <h6 class="text-danger m-1">- กรุณาตรวจสอบความถูกต้องก่อนกดยืนยัน หากออกคูปองแล้ว ไม่สามารถเปลี่ยนแปลงได้</h6>
    </div>
    <button class="btn btn-orange btn-lg rounded-0">
        <h5 class="m-0">ยืนยัน</h5>
    </button>
</div>
{!! Form::close() !!}

@endsection
