@extends('admin.bestexpress.layouts.main')

@section('body')

@include('admin.bestexpress.layouts.errors')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
{!! Html::script('js/admin/bestexpress/sender/ShowTracking.js') !!}

{{-- <script src="https://cdn.rawgit.com/zenorocha/clipboard.js/master/dist/clipboard.min.js"></script> --}}
<div class="card border-0 shadow-sm rounded-0">
    <div class="card-header bg-white">
      <h4 class="mb-0">ข้อมูลผู้ส่ง <div class="close">
        {{ \Carbon\Carbon::parse($date)->addYears(543)->format('d-m-Y') }}
      </div></h4>

    </div>
    <div class="card-body h6 mb-0">
      <p>{{ __('bestexpress.sender.name' , ['name' => $sender->name]) }}</p>
      <p>{{ __('bestexpress.sender.number' , ['number' => $sender->tel]) }}</p>
      <p class="m-0">{{ __('bestexpress.sender.address' , ['address' => $sender->address]) }}</p>
    </div>
    <div class="card-footer bg-white">
      @if (Auth::Check() and Auth::user()->type == '1')
        {{-- {!! Form::open(['method' => 'post' , 'action' => ['BestExpress\PaymentController@create' , $sender->id , $date] , 'class' => 'm-0']) !!} --}}
        <button class="btn btn-warning" data-toggle="modal" data-target="#alert_payment">แจ้งการชำระเงิน</button>
        {{-- {!! Form::close() !!} --}}
        <button type="submit" name="payment_check" class="btn btn-best">ตรวจสอบการชำระ</button>


        {{-- modal-open alert_payment --}}
        <div class="modal fade" id="alert_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content rounded-0">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แจ้งการชำระเงิน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                {!! Form::open(['method' => 'post' , 'action' => ['BestExpress\PaymentController@create' , $sender->id , $date] , 'class' => 'm-0']) !!}
                <div class="modal-body">
                  <p class="mb-1"><b> <h5 class="m-0">สรุปยอดทั้งหมด</h5> </b> </p>
                  <input type="hidden" name="total" value="{{ $trackings->sum('total') }}">
                  <div class="table-responsive">
                    <table class="table border m-0">
                      <tbody>
                        <tr>
                          <td>ค่าขนส่ง</td>
                          <td class="text-right">{{ number_format($trackings->sum('shipping_charge'),2) }}</td>
                        </tr>
                        <tr>
                          <td>ค่าพัสดุ</td>
                          <td class="text-right">{{ number_format($trackings->sum('parcel_fee'),2) }}</td>
                        </tr>
                        <tr>
                          <td>ค่าบริการเสริม</td>
                          <td class="text-right">{{ number_format($trackings->sum('other_values'),2) }}</td>
                        </tr>
                        <tr>
                          <td>ค่าอื่น ๆ	</td>
                          <td class="text-right">{{ number_format($trackings->sum('besides'),2) }}</td>
                        </tr>
                        <tr class="table-info">
                          <td>ยอดรวม</td>
                          <td class="text-right">{{ number_format($trackings->sum('total'),2) }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer m-0 p-0 border-0">

                  <button type="submit" class="btn btn-danger rounded-0 btn-block btn-lg">แจ้งชำระเงิน</button>
                </div>
                {!! Form::close() !!}


            </div>
          </div>
        </div>
        {{-- modal-close alert_payment --}}


      @else

      @endif

    </div>
</div>

<div class="row mt-2 mb-2">
    {{-- <div class="col-12 col-sm-12 col-md- col-lg-10"> --}}
    <div class="col">
      <div class="input-group mb-1">
        <select ng-init="search_selected = 1" ng-model="search_selected" class="custom-select col-4 col-sm-3 col-md-3 col-lg-2 border-0 shadow-sm rounded-0" id="inputGroupSelect01">
          <option ng-value="1">{!! __('bestexpress.choose.recipient.number') !!}</option>
          <option ng-value="2">{!! __('bestexpress.choose.recipient.name') !!}</option>
          <option ng-value="3">{!! __('bestexpress.choose.recipient.waybill') !!}</option>
        </select>
        {{-- <input type="text" class="form-control" aria-label="Text input with dropdown button"> --}}
        <input type="text" ng-model="search_recipient_number" ng-show="search_selected == 1" pattern="\d*" class="form-control border-0 shadow-sm rounded-0" aria-label="Text input with dropdown button" placeholder="{!! __('bestexpress.choose.recipient.placeholder.number') !!}">
        <input type="text" ng-model="search_recipient_name" ng-show="search_selected == 2" class="form-control border-0 shadow-sm rounded-0" aria-label="Text input with dropdown button" placeholder="{!! __('bestexpress.choose.recipient.placeholder.name') !!}">
        <input type="text" ng-model="search_waybill" ng-show="search_selected == 3" pattern="\d*" class="form-control border-0 shadow-sm rounded-0" aria-label="Text input with dropdown button" placeholder="{!! __('bestexpress.choose.recipient.placeholder.waybill') !!}">
        <button ng-click="RedirectURL(GoToTrackingsWeb)" class="btn btn-danger btn-block shadow-sm col-lg-2 rounded-0" ng-disabled="ChooseWaybills.length < 1" >ติดตาม @{{ ChooseWaybills.length }} พัสดุ</button>
      </div>
    </div>
    {{-- <div class="col-12 col-sm-12 col-md-3 col-lg-2">
      <button ng-click="RedirectURL(GoToTrackingsWeb)" class="btn btn-danger btn-block shadow-sm" ng-disabled="ChooseWaybills.length < 1" >ติดตาม @{{ ChooseWaybills.length }} พัสดุ</button>
    </div> --}}
</div>

<div class="table-responsive bg-white shadow-sm" ng-init="trackings = {{ $trackings }}">
  <table class="table table-hover">
    <thead>
      <tr>
        <th class="text-nowrap text-center" ng-init="ChooseAll = 0">
          <i class="material-icons cursor-pointer" ng-show="ChooseAll == 0" ng-click="ChooseWaybills_All(ChooseAll = !ChooseAll)">check_box_outline_blank</i>
          <i class="material-icons text-success cursor-pointer" ng-show="ChooseAll == 1" ng-click="ChooseWaybills_All(ChooseAll = !ChooseAll)">check_box</i>
        </th>
        <th class="text-nowrap text-center">เลขพัสดุ</th>
        <th class="text-nowrap text-center">ชื่อผู้รับ</th>
        <th class="text-nowrap text-center">เบอร์โทรผู้รับ</th>
        <th class="text-nowrap text-center">ค่าขนส่ง</th>
        <th class="text-nowrap text-center">ค่าพัสดุ</th>
        <th class="text-nowrap text-center">ค่าบริการเสริม</th>
        <th class="text-nowrap text-center">ค่าอื่น ๆ</th>
        <th class="text-nowrap text-center">ยอดรวม</th>
        <th class="text-nowrap text-center">น้ำหนัก(กก)</th>
        <th class="text-nowrap text-center">ขนาด(ก*ย*ส)</th>
      </tr>
    </thead>
    <tbody>

      <tr ng-init="choose = 0" ng-repeat="tracking in trackings | filter:{ recipient_name : search_recipient_name , recipient_number : search_recipient_number , waybill : search_waybill }">
        <td class="text-nowrap text-center" ng-init="TrackingsAll(tracking.waybill)">
          <i class="material-icons cursor-pointer" ng-show="choose == 0 && ChooseAll == 0" ng-click="ChooseWaybill(tracking.waybill,choose = !choose)">check_box_outline_blank</i>
          <i class="material-icons text-success cursor-pointer" ng-show="choose == 1 && ChooseAll == 0" ng-click="ChooseWaybill(tracking.waybill,choose = !choose)">check_box</i>
          <i class="material-icons text-secondary cursor-pointer" ng-show="ChooseAll == 1">check_box</i>
        </td>
        <td class="text-nowrap">
          <a href="https://www.best-inc.co.th/track?bills=@{{ tracking.waybill }}" target="_blank">@{{ tracking.waybill }}</a>
        </td>
        <td class="text-nowrap">@{{ tracking.recipient_name }}</td>
        <td class="text-nowrap text-center">@{{ tracking.recipient_number }}</td>
        <td class="text-center">@{{ tracking.shipping_charge | number:2 }}</td>
        <td class="text-center">@{{ tracking.parcel_fee | number:2 }}</td>
        <td class="text-center">@{{ tracking.other_values | number:2 }}</td>
        <td class="text-center">@{{ tracking.besides | number:2 }}</td>
        <td class="text-center">@{{ tracking.total | number:2 }}</td>
        <td class="text-center">@{{ tracking.weight | number:2 }}</td>
        <td class="text-right">@{{ tracking.size }}</td>
      </tr>
      <tr class="table-info">
        <td colspan="2"><b>ยอดรวมทั้งหมด</b></td>
        <td colspan="1" class="text-left">{{ number_format($trackings->sum('total'),2) }} บ.</td>
        <td colspan="8"></td>
      </tr>
    </tbody>
  </table>
</div>

@endsection
