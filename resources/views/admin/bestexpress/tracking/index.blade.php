@extends('admin.bestexpress.layouts.main')

@section('body')

{{-- @include('admin.bestexpress.layouts.errors') --}}
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
{!! Html::script('js/admin/bestexpress/sender/ShowTracking.js') !!}

<div class="row mt-2 mb-2">
    {{-- <div class="col-12 col-sm-12 col-md- col-lg-10"> --}}
    <div class="col">
      <div class="input-group mb-1">
        <select ng-init="search_selected = 1" ng-model="search_selected" class="custom-select col-4 col-sm-3 col-md-3 col-lg-2 border-0 shadow-sm rounded-0" id="inputGroupSelect01">
          <option ng-value="1">เบอร์ผู้รับ</option>
          <option ng-value="2">ชื่อผู้รับ</option>
          <option ng-value="3">เลขพัสดุ</option>
        </select>
        <input type="text" ng-model="search_recipient_number" ng-show="search_selected == 1" pattern="\d*" class="form-control border-0 shadow-sm rounded-0" aria-label="Text input with dropdown button" placeholder="กรอกเบอร์โทรของผู้รับ">
        <input type="text" ng-model="search_recipient_name" ng-show="search_selected == 2" class="form-control border-0 shadow-sm rounded-0" aria-label="Text input with dropdown button" placeholder="กรอกชื่อของผู้รับ">
        <input type="text" ng-model="search_waybill" ng-show="search_selected == 3" pattern="\d*" class="form-control border-0 shadow-sm rounded-0" aria-label="Text input with dropdown button" placeholder="กรอกเลขพัสดุของผู้รับ">
        <button ng-click="RedirectURL(GoToTrackingsWeb)" class="btn btn-danger btn-block shadow-sm col-lg-2 rounded-0" ng-disabled="ChooseWaybills.length < 1" >ติดตาม @{{ ChooseWaybills.length }} พัสดุ</button>
      </div>
    </div>
    {{-- <div class="col-12 col-sm-12 col-md-3 col-lg-2">
      <button ng-click="RedirectURL(GoToTrackingsWeb)" class="btn btn-danger btn-block shadow-sm" ng-disabled="ChooseWaybills.length < 1" >ติดตาม @{{ ChooseWaybills.length }} พัสดุ</button>
    </div> --}}
</div>

<div class="table-responsive bg-white shadow" ng-init="trackings = {{ $trackings }}">
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-nowrap text-center" ng-init="ChooseAll = 0">
                  <i class="material-icons cursor-pointer" ng-show="ChooseAll == 0" ng-click="ChooseWaybills_All(ChooseAll = !ChooseAll)">check_box_outline_blank</i>
                  <i class="material-icons text-success cursor-pointer" ng-show="ChooseAll == 1" ng-click="ChooseWaybills_All(ChooseAll = !ChooseAll)">check_box</i>
                </th>
                <th class="text-nowrap text-center">เลขพัสดุ</th>
                <th class="text-nowrap text-center">ค่าจัดส่ง</th>
                <th class="text-nowrap text-center">ค่าพัสดุ</th>
                <th class="text-nowrap text-center">ค่าบริการเสริม</th>
                <th class="text-nowrap text-center">ค่าอื่น ๆ</th>
                <th class="text-nowrap text-center">รวม</th>
                <th class="text-nowrap text-center">วันที่รับพัสดุ</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-init="choose = 0" ng-repeat="tracking in trackings | filter:{ recipient_name : search_recipient_name , recipient_number : search_recipient_number , waybill : search_waybill }">
                <td class="text-nowrap text-center" ng-init="TrackingsAll(tracking.waybill)">
                  <i class="material-icons cursor-pointer" ng-show="choose == 0 && ChooseAll == 0" ng-click="ChooseWaybill(tracking.waybill,choose = !choose)">check_box_outline_blank</i>
                  <i class="material-icons text-success cursor-pointer" ng-show="choose == 1 && ChooseAll == 0" ng-click="ChooseWaybill(tracking.waybill,choose = !choose)">check_box</i>
                  <i class="material-icons text-secondary cursor-pointer" ng-show="ChooseAll == 1">check_box</i>
                </td>
                <td class="text-nowrap text-center">
                  <a href="https://www.best-inc.co.th/track?bills=@{{ tracking.waybill }}" target="_blank">@{{ tracking.waybill }}</a>
                </td>
                <td class="text-nowrap text-center">@{{ tracking.shipping_charge | number:2 }}</td>
                <td class="text-nowrap text-center">@{{ tracking.parcel_fee | number:2 }}</td>
                <td class="text-nowrap text-center">@{{ tracking.other_values | number:2 }}</td>
                <td class="text-nowrap text-center">@{{ tracking.besides | number:2 }}</td>
                <td class="text-nowrap text-center">@{{ tracking.total | number:2 }}</td>
                <td class="text-nowrap text-center">@{{ tracking.dates }}</td>

                {{-- <td>{{ $tracking-> }}</td>
                <td>{{ $tracking-> }}</td> --}}
            </tr>
        </tbody>
    </table>
</div>
@endsection
