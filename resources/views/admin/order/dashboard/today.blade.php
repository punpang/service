@extends('admin.layouts.main')

@section('body')
  <div class="mt-3 mb-2">
    <h4>รายการสั่งซื้อวันนี้ : {{ \Carbon\Carbon::now()->addYears(543)->format('d/m/Y') }}</h4>
    <div class="table-responsive">
      <table class="table table-hover text-center table-striped">
        <thead>
          <tr>
            <td>หมายเลขคำสั่งซื้อ</td>
            <td>ชื่อลูกค้า</td>
            <td>เบอร์โทร</td>
            <td>เวลารับ</td>
            <td>สถานะ</td>
            <td>รายละเอียด</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($orders as $order)
            <tr>
              <td>{{ $order->id }}</td>
              <td>{{ $order->customer->name }}</td>
              <td>{{ $order->customer->tel }}</td>
              <td>{{ \Carbon\Carbon::parse($order->time_get)->format('H:i') }}</td>
              <td>{{ $order->OrderStatus->status }}</td>
              <td>รายละเอียด</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
