@extends('layouts.main')
@section('body')

  <h4 class="mt-2">ประวัติการสั่งซื้อ</h4>
  <div class="table-responsive">
    <table class="table table-hover text-center">
      <thead>
        <tr>
          <td>เลขที่บิล</td>
          <td>ยอดซื้อ</td>
          <td>วันที่ทำรายการ</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($bills as $bill)
          <tr>
            <td>{{ $bill->bill_sale_id }}</td>
            <td>{{ number_format($bill->total_money,2) }}</td>
            <td>{{ \Carbon\Carbon::parse($bill->bill_sale_created_date)->addYears(543)->format("d-m-Y H:i:s") }}</td>
          </tr>
        @endforeach

      </tbody>

    </table>
  </div>

@endsection
