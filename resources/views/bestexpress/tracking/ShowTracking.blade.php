@extends('bestexpress.layouts.main')

@section('body')

{{-- @include('bestexpress.layouts.errors') --}}
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
{!! Html::script('js/bestexpress/tracking/ShowTracking.js') !!}
{!! Html::style('css/loading.css') !!}
{!! Html::style('css/loading-btn.css') !!}

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h4 class="mb-0">ข้อมูลผู้ส่ง <div class="close">
                {{ \Carbon\Carbon::parse($date)->addYears(543)->format('d-m-Y') }}
            </div>
        </h4>

    </div>
    <div class="card-body h6 mb-0">
        <p>ชื่อร้าน : {{ $sender->name }}</p>
        <p>เบอร์โทร : {{ $sender->tel }}</p>
        <p class="mb-0">ที่อยู่ : {{ $sender->address }}</p>
    </div>
</div>

<div class="row mt-2 mb-2">
    <div class="col">
        <div class="input-group mb-1">
            <select ng-init="search_selected = 1" ng-model="search_selected" class="custom-select col-4 col-sm-3 col-md-3 col-lg-2 border-0 shadow-sm rounded-0" id="inputGroupSelect01">
                <option ng-value="1">เบอร์ผู้รับ</option>
                <option ng-value="2">ชื่อผู้รับ</option>
                <option ng-value="3">เลขพัสดุ</option>
            </select>
            {{-- <input type="text" class="form-control" aria-label="Text input with dropdown button"> --}}
            <input type="text" ng-model="search_recipient_number" ng-show="search_selected == 1" pattern="\d*" class="form-control border-0 shadow-sm rounded-0" aria-label="Text input with dropdown button" placeholder="กรอกเบอร์โทรศัพท์">
            <input type="text" ng-model="search_recipient_name" ng-show="search_selected == 2" class="form-control border-0 shadow-sm rounded-0" aria-label="Text input with dropdown button" placeholder="กรอกชื่อ">
            <input type="text" ng-model="search_waybill" ng-show="search_selected == 3" pattern="\d*" class="form-control border-0 shadow-sm rounded-0" aria-label="Text input with dropdown button" placeholder="กรอกเลขพัสดุของผู้รับ">
        </div>
    </div>
</div>

{{-- <input type="text" ng-model="search.recipient_number" pattern="\d*" autofocus class="form-control mt-2 mb-2 border-0 shadow-sm" placeholder="คลิกและกรอกเบอร์โทรเพื่อค้นหา"> --}}

<div class="card-columns" ng-init="trackings = {{ $trackings }}">
    <div class="card shadow-sm border-0" ng-repeat="tracking in trackings | filter:{ recipient_name : search_recipient_name , recipient_number : search_recipient_number , waybill : search_waybill }">
        <div class="card-body">
            <p><b>
                    @{{ tracking.recipient_name }} </b> </p> @{{ tracking.waybill }} </div> <div class="card-footer border-0 p-0">
                        {{-- https://www.best-inc.co.th/track?bills=@{{ tracking.waybill }} --}}
                        <a href="https://www.best-inc.co.th/track?bills=@{{ tracking.waybill }}" target="_blank" class="btn btn-block btn-best ">ติดตามพัสดุ</a>
                        {{-- <div ng-click="hbtnofi=!!!hbtnofi" ng-class="{'running':hbtnofi}" class="hovering ld-over-full-inverse"><a href="https://www.best-inc.co.th/track?bills=@{{ tracking.waybill }}" target="_blank" class="btn
                        btn-block btn-best ">ติดตามพัสดุ</a>
                        <div class="ld ld-ring ld-spin h1"></div>
        </div> --}}
    </div>
</div>
</div>

@endsection
