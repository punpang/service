@extends('admin.bestexpress.layouts.main')

@section('body')

@include('admin.bestexpress.layouts.errors')
{{-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> --}}
{!! Html::script('js/admin/bestexpress/tracking/create.js') !!}

{!! Form::open(['method' => 'POST' , 'action' => 'BestExpress\TrackingController@store']) !!}

@include('admin.bestexpress.tracking._form' , ['header_name' => 'ลงทะเบียนพัสดุ' ,'btnname' => 'ลงทะเบียน' ,'btnclass' => 'btn-success'])
{{-- <div class="card border-0 shadow">
    <div class="card-header">
        <h5>ลงทะเบียนพัสดุ</h5>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-1 col-12 col-form-label">วันที่</label>
            <div class="col-sm-3 col-12 text-middle">
                <input type="date" name="dates" required value="{{ Carbon\Carbon::now()->format("Y-m-d") }}" class="form-control">
            </div>

            <label class="col-sm-2 col-12 col-form-label">เลขพัสดุ (WAYBILL)</label>
            <div class="col-sm-3 col-12 text-middle">
                <input type="number" required min="66000000000000" max="66999999999999" class="form-control{{ $errors->has('waybill') ? ' is-invalid' : '' }}" name="waybill" value="{{ old('waybill') }}">
                @if ($errors->has('waybill'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('waybill') }}</strong>
                    </span>
                @endif
            </div>

            <label class="col-sm-1 col-12 col-form-label">รวม</label>
            <div class="col-sm-2 col-12 text-middle">
                <input type="number" ng-model="shipping_charge + parcel_fee + other_values + besides" required readonly class="form-control" name="total" value="{{ old('total') }}">
            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label class="col-sm-1 col-12 col-form-label">ค่าจัดส่ง</label>
            <div class="col-sm-2 col-12 text-middle">
                <input type="number" name="shipping_charge" ng-model="shipping_charge" required value="" class="form-control">
            </div>

            <label class="col-sm-1 col-12 col-form-label">ค่าพัสดุ</label>
            <div class="col-sm-2 col-12 text-middle">
                <input type="number" required class="form-control" name="parcel_fee" ng-model="parcel_fee" value="">
            </div>

            <label class="col-sm-1 col-12 col-form-label">ค่าอื่น ๆ</label>
            <div class="col-sm-2 col-12 text-middle">
                <input type="number" required class="form-control" name="other_values" value="" ng-model="other_values">
            </div>

            <label class="col-sm-1 col-12 col-form-label">อื่น ๆ</label>
            <div class="col-sm-2 col-12 text-middle">
                <input type="number" required class="form-control" name="besides" value="" ng-model="besides">
            </div>

        </div>

    </div>


    <div class="card-footer text-right">
      <button type="submit" class="btn btn-success btn-lg">ลงทะเบียน</button>
      <button type="reset" class="btn btn-danger btn-lg">ล้างข้อมูล</button>
    </div>

</div> --}}

{!! Form::close() !!}


@endsection
