@extends('layouts.main')
@section('body')


<h3 class="mt-2">แลกคูปอง</h3>
<p class="card-text">คะแนนสะสม {{ $member->PointCoupon->score_total }} คะแนน</p>
<div class="table-responsive">
  <table class="table table-hover text-center">
    <thead>
      <tr>
        <td>เลขคูปอง</td>
        <td>วันหมดอายุ/ใช้เมื่อ</td>
        <td>สถานะ</td>
      </tr>
    </thead>

    <tbody>
      @foreach ($coupons as $coupon)
        <tr>
          <td> <a href="{{ action('MemberController@ECoupon' , $coupon->id )}}">{{ $coupon->serial }}</a></td>
          <td>
            @if ($coupon->use == null)
              {{ \Carbon\Carbon::parse($coupon->expire)->addYears(543)->format('d/m/Y H:i:s') }}
            @else
              {{ \Carbon\Carbon::parse($coupon->use)->addYears(543)->format('d/m/Y H:i:s') }}
            @endif
            </td>
          <td>
            @if ($coupon->status == 'use')
            ใช้งานแล้ว
            @elseif ($coupon->status == 'unuse')
            ยังไม่ได้ใช้งาน
            @elseif ($coupon->status == 'delete')
            ยกเลิกแล้ว
            @endif
          </td>
        </tr>
      @endforeach

    </tbody>

  </table>
</div>

@endsection
