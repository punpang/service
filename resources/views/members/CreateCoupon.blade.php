@extends('layouts.main')
@section('body')

{{-- {{ $coupons }} --}}

<h3 class="mt-2">แลกคูปอง</h3>
<p class="card-text">คะแนนสะสม {{ $member->PointCoupon->score_total }} คะแนน</p>

<div class="card-deck">

  @foreach ($coupons as $coupon)
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $coupon->name }}</h5>
            <p class="card-text">ใช้คะแนน {{ $coupon->value }} คะแนน</p>
        </div>
        <a href="{{ action('MemberController@ConfirmCoupon' , $coupon->id ) }}" class="btn btn-orange rounded-0">
            <h5 class="m-0">แลกคูปอง</h5>
        </a>
    </div>
  @endforeach


</div>

@endsection
