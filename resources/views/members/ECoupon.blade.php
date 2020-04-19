@extends('layouts.main')
@section('body')


<h3 class="mt-2">แลกคูปอง</h3>
<p class="card-text">คะแนนสะสม {{ $member->PointCoupon->score_total }} คะแนน</p>
<hr>
@include('layouts.errors')
<div class="card mb-2">
    <div class="card-body">
        <h5 class="card-title">รายละเอียดคูปอง</h5>
        <hr>
        <p class="card-text">หมายเลขคูปอง : {{ $coupon->serial }}</p>
        @if ($coupon->use == null)
        <p class="card-text">สร้างเมื่อ : {{ \Carbon\Carbon::parse($coupon->created)->addYears(543)->format('d/m/Y H:i:s') }}</p>
        <p class="card-text">วันหมดอายุ : {{ \Carbon\Carbon::parse($coupon->expire)->addYears(543)->format('d/m/Y H:i:s') }}</p>
        @else
        <p class="card-text">ใบเสร็จที่ใช้ : {{ $bill->bill_sale_id }}</p>
        <p class="card-text">ใช้เมื่อ : {{ \Carbon\Carbon::parse($coupon->use)->addYears(543)->format('d/m/Y H:i:s') }}</p>
        @endif
        <p class="card-text">สถานะ :
            @if ($coupon->status == 'use')
            ใช้งานแล้ว
            @elseif ($coupon->status == 'unuse')
            ยังไม่ได้ใช้งาน
            @elseif ($coupon->status == 'delete')
            ยกเลิกแล้ว
            @endif
        </p>
        <hr>
        <h6 class="text-danger m-1">- แจ้ง/แสดงคูปองกับพนักงานเพื่อใช้งาน</h6>
        <h6 class="text-danger m-1">- คูปองมีอายุ 1 ปี</h6>
        <h6 class="text-danger m-1">- คูปองสามารถใช้ได้ครั้งเดียว</h6>
        <h6 class="text-danger m-1">- ห้ามให้หมายเลขคูปองแก่บุคคลอื่น</h6>
    </div>
</div>





@endsection
