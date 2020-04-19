@extends('admin.bestexpress.layouts.main')

@section('body')

@include('admin.bestexpress.layouts.errors')
{{-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> --}}
{!! Html::script('js/admin/bestexpress/tracking/create.js') !!}

<div class="card border-0 shadow">
    <div class="card-header">
        <h5>WAYBILL :: <a href="https://www.best-inc.co.th/track?bills={{ $tracking->waybill }}">{{ $tracking->waybill }}</a></h5>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-4 col-12 col-form-label">วันที่รับพัสดุ :: {{ Carbon\Carbon::parse($tracking->dates)->addYears(543)->format("d/m/Y") }}</label>
            <label class="col-sm-4 col-12 col-form-label">สร้างเมื่อ :: {{ Carbon\Carbon::parse($tracking->created_at)->addYears(543)->format("d/m/Y H:i:s") }}</label>
            <label class="col-sm-4 col-12 col-form-label">แก้ไขล่าสุด :: {{ Carbon\Carbon::parse($tracking->updated_at)->addYears(543)->format("d/m/Y H:i:s") }}</label>
        </div>

        <div class="table-responsive">
          <table class="table table-hover">
            <tbody>
              <tr>
                <td>ค่าจัดส่ง</td>
                <td class="text-right">{{ number_format($tracking->shipping_charge,2) }}</td>
              </tr>

              <tr>
                <td>ค่าพัสดุ</td>
                <td class="text-right">{{ number_format($tracking->parcel_fee,2) }}</td>
              </tr>

              <tr>
                <td>ค่าอื่น ๆ</td>
                <td class="text-right">{{ number_format($tracking->other_values,2) }}</td>
              </tr>

              <tr>
                <td>อื่น ๆ</td>
                <td class="text-right">{{ number_format($tracking->besides,2) }}</td>
              </tr>

              <tr class="table-active">
                <td>รวม</td>
                <td class="text-right">{{ number_format($tracking->total,2) }}</td>
              </tr>


            </tbody>
          </table>
        </div>

    </div>


    <div class="card-footer">
      <a href="{{ action('BestExpress\TrackingController@edit' , $tracking->waybill ) }}" class="btn btn-warning btn-lg">แก้ไขข้อมูล</a>
    </div>

</div>


@endsection
