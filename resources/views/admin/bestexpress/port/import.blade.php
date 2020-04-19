@extends('admin.bestexpress.layouts.main')

@section('body')

@include('admin.bestexpress.layouts.errors')
{{-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> --}}
{{-- {!! Html::script('js/admin/bestexpress/tracking/create.js') !!} --}}

<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            นำเข้าข้อมูลพัสดุ
        </div>
        <div class="card-body">
            <form action="{{ action('BestExpress\TrackingController@import') }}" method="POST" class="m-0" enctype="multipart/form-data">
                @csrf
                <div class="form_group row">
                  <div class="col-12 col-sm-6">
                    <input type="date" required name="dates" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                  </div>
                  <div class="col-12 col-sm-6">
                    <input type="file" required name="file" class="form-control">
                  </div>

                </div>
                <br>
                <button class="btn btn-best">นำเข้าข้อมูลพัสดุ</button>
                {{-- <a class="btn btn-warning" href="{{ route('export') }}">Export User Data</a> --}}
            </form>
        </div>
    </div>
</div>
@endsection
