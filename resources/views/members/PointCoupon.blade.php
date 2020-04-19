@extends('layouts.main')
@section('body')

  @include('layouts.errors')


<div class="card-deck text-center mb-2">
    <div class="card mb-0">
        <div class="card-body">
            <h5 class="card-title">คะแนนสะสม</h5>
            <p class="card-text">
              @if (isset($member->PointCoupon->score_total))
                {{ $member->PointCoupon->score_total }}
              @else
                0
              @endif
              คะแนน
            </p>
        </div>
    </div>
</div>

@if (isset($member->PointCoupon->score_total))
  <a href="{{ action('MemberController@MyCoupon') }}" class="btn btn-orange">คูปองของฉัน</a>
  <a href="{{ action('MemberController@CreateCoupon') }}" class="btn btn-msg">แลกคูปอง</a>
@else
  <button disabled class="btn btn-orange">คูปองของฉัน</button>
  <button disabled class="btn btn-msg">แลกคูปอง</button>
@endif

@endsection
