@extends('layouts.main')
@section('body')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
{{-- {!! Html::style('css/ImageUploadPreview.css') !!} --}}

<h5 class="mt-2">ระบบอัปโหลดรูปและข้อความ</h5>
<div class="card border-0 shadow-lg bg-white">
    <div class="card-body">
        <b>รายละเอียดการสั่งซื้อ</b>
        <hr>
        <p>หมายเลขคำสั่งซื้อ : {{ $upload->id_order }}</p>
        <p>ชื่อลูกค้า : {{ $upload->order->customer->name }}</p>
        <p>วัน-เวลารับสินค้า : {{ $upload->order->DateTimeGetFormat2() }}</p>
        <p>รายละเอียดสินค้า :
            {{ $upload->order->DetailsFormat() }}
            @if ($upload->order->code != '-'),{{ $upload->order->code }}
            @endif
            @if ($upload->order->other != '-'),{{ $upload->order->other }}
            @endif
        </p>
    </div>
</div>
<br>

<div class="card border-0 shadow-lg bg-white">
    <div class="card-body">
        <b>รายละเอียดการสั่งซื้อ</b>
        <hr>
        {!! Form::open(['method' => 'post' , 'enctype' => 'multipart/form-data' , 'action' => 'Order\UploadImgCustomerController@store' , 'files' => true]) !!}
        <input type='file' multiple ng-model-instant onchange="angular.element(this).scope().imageUpload(event)" />
        <div class="card-columns">
          <div class="card shadow" ng-repeat="img in imgs" >
            <img class="img-thumbnail rounded border-0" ng-src="@{{ img }}" />
          </div>
        </div>

        <div class="card-columns">
          <div class="card shadow" ng-repeat="fgsdfs in files" >
            @{{ fgsdfs }}
            <input type="file" ng-src="@{{ fgsdfs }}" name="bnopfdfskmas">
          </div>
        </div>

        <button type="button" class="btn btn-success btn-lg" ng-click="imageIsUpload()">Upload !</button>
        <button type="reset" class="btn btn-danger btn-lg" ng-click="imageIsResetAll()">Reset</button>
        {!! Form::close() !!}
    </div>
</div>
{!! Html::script('js/ImageUploadPreview.js') !!}

@endsection
