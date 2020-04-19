@extends('admin.layouts.main')

@section('body')

@include('admin.layouts.errors')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
{!! Html::script('js/admin/order/order/ShowOrder.js') !!}

<div class="row">

    <div class="col-12 col-sm-3">

        <nav class="navbar navbar-expand-lg navbar-dark bg-green-2 d-sm-none mb-3">
            <a class="navbar-brand" href="#">เมนูจัดการ</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-toggle="modal" data-target="#modal_payment">การชำระเงิน</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="aboutOrders" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            เกี่ยวกับรายการสั่งซื้อ
                        </a>
                        <div class="dropdown-menu border-0 shadow rounded-0" aria-labelledby="aboutOrders">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="aboutHistorys" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ประวัติรายการสั่งซื้อ
                        </a>
                        <div class="dropdown-menu border-0 shadow rounded-0" aria-labelledby="aboutHistorys">
                            <a class="dropdown-item" href="#">การชำระเงิน</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>

                </ul>
            </div>
        </nav>

        {{-- --}}
        <div class="card border-0 shadow-sm rounded-0 mb-3">
            <div class="card-body">
                <h5 class="text-orange-hard"><b>ผู้สั่งซื้อ</b></h5>
                <div class="pl-3">
                    คุณ {{ $order->customer->name }} <br>
                    เบอร์ {{ $order->customer->tel }}
                </div>
            </div>
        </div>
        {{-- --}}

        <ul class="nav flex-column d-none d-sm-block shadow-sm">
            <li class="nav-item">
                @if($order->Balance() > 0)
                    <a class="nav-link nav-green" href="#" data-toggle="modal" data-target="#modal_payment">การชำระเงิน</a>
                @endif                
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-green" href="#" id="aboutOrders" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    เกี่ยวกับรายการสั่งซื้อ
                </a>
                <div class="dropdown-menu border-0 shadow rounded-0" aria-labelledby="aboutOrders">
                    <a class="dropdown-item" href="#">วันเวลาที่รับ</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-green" href="#" id="aboutHistorys" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ประวัติรายการสั่งซื้อ
                </a>
                <div class="dropdown-menu border-0 shadow rounded-0" aria-labelledby="aboutHistorys">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_history_payment">การชำระเงิน</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>

        </ul>

    </div>

    <div class="col-12 col-sm-9">

        {{-- --}}
        <div class="card border-0 shadow-sm rounded-0 mb-3">
            <div class="card-body">
                <h5 class="text-orange-hard"><b>รายละเอียด #{{$order->id }}</b></h5>
                <div class="pl-3">
                    {{ $order->DateTimeGetFormat() }}
                    <br>
                    {{ $order->DetailsFormat() }}

                    @if ($order->msg == '-')
                    @endif
                    <br>
                    <text class="m-0 text-tomato">[ {{ $order->code }} ]</text> ,
                    @if ($order->msg != '-')
                    {{ $order->msg }}
                    @elseif ($order->msg != '-')

                    <p class="text-tomato">ไม่เขียนข้อความ</p>
                    @endif

                    @if ($order->other != '-')
                    <br>
                    {{ $order->other }}
                    @endif
                </div>
                <div class="pl-3">

                </div>
            </div>
            <div class="card-fotter pb-2 pr-3 text-right">
                {{ $order->CreatedAtFormat() }}
            </div>
        </div>

        {{-- --}}

    </div>
</div>

{{-- model --}}

{{-- model payment --}}
{!! Form::open(['method' => 'POST' , 'action' => ['Order\PaymentController@store',$order->id]]) !!}
    <div class="modal fade" id="modal_payment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">การชำระเงิน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>รวมยอด</td>
                                <td class="text-right">{{ number_format($order->TotalAll(),2) }}</td>
                    </tr>
                    <tr>
                        <td>ชำระแล้ว</td>
                        <td class="text-right">{{ number_format($order->Deposit(),2) }}</td>
                    </tr>
                    <tr>
                        <td>คงเหลือ</td>
                        <td class="text-right">{{ number_format($order->Balance(),2) }}</td>
                    </tr>
                    </tbody>
                    </table>
                </div> --}}
                <div class="container-fluid">
                    <div class="form-group row">
                        <label for="channel_payment" class="pl-0 col-sm-6 col-form-label text-orange-hard"><b>ช่องทางการชำระเงิน</b></label>
                        <select class="form-control col-sm-6" ng-model="modal_payment_channel_payment" required name="payment_channel">
                            <option value="">โปรดเลือก</option>
                            @foreach ($order->PaymentChannel() as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="value" class="pl-0 col-sm-6 col-form-label text-orange-hard"><b>ชำระครั้งนี้</b></label>
                        <input type="tel" name="value" ng-model="modal_payment_value" required class="form-control col-sm-6 text-center" parent="\d*" name="" value="">
                    </div>

                    <div class="form-group row" ng-if="modal_payment_value - TotalBalance >= 0">
                        <label for="value" class="pl-0 col-sm-6 col-form-label text-orange-hard"><b>เงินทอน</b></label>
                        <input type="text" readonly value="@{{ modal_payment_value - TotalBalance | currency:'' }}" class="form-control col-sm-6 text-center">
                    </div>

                    <div class="form-group row">
                        <div for="" class="pl-0 col-sm-6"></div>
                        <div class="pl-0 pr-0 col-sm-6">
                            <button type="submit" ng-disabled="modal_payment_value <= 0 || modal_payment_value == null || modal_payment_channel_payment == null" class="btn btn-orange btn-block">ชำระเงิน</button>
                        </div>
                    </div>

                </div>
                <hr>
                <h6 class="text-orange-hard"><b>รายละเอียดการชำระเงิน</b></h6>
                <div class="table-responsive">
                    <table class="table small table-bordered m-0">
                        <tbody>
                            <tr>
                                <td>ราคาสินค้า</td>
                                <td class="text-right">{{ number_format($order->total,2) }}</td>
                            </tr>
                            @if ($order->add > 0)
                            <tr>
                                <td>ราคาเพิ่มเติม</td>
                                <td class="text-right">{{ number_format($order->add,2) }}</td>
                            </tr>
                            @endif

                            <tr>
                                <td>อื่น ๆ</td>
                                <td class="text-right">{{ number_format(0,2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-right border-0">รวมยอด</td>
                                <td class="text-right">{{ number_format($order->TotalAll(),2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-right border-0">ชำระแล้ว</td>
                                <td class="text-right">{{ number_format($order->Deposit(),2) }}</td>
                            </tr>
                            {{-- <tr>
                                    <td class="text-right border-0">ส่วนลด</td>
                                    <td class="text-right">{{ number_format(0,2) }}</td>
                            </tr> --}}
                            <tr>
                                <td class="text-right border-0">คงเหลือ</td>
                                <td class="text-right" ng-init="TotalBalance = {{ $order->Balance() }}">{{ number_format($order->Balance(),2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    </div>
    {!! Form::close() !!}
    {{-- --}}
    {{-- modal_history_payment --}}
    <div class="modal fade" id="modal_history_payment">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ประวัติการชำระเงิน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table table-bordered m-0 text-center">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">ช่องทางการชำระเงิน</th>
                                    <th class="text-nowrap">มูลค่า</th>
                                    <th class="text-nowrap">อ้างอิงใบเสร็จ</th>
                                    <th class="text-nowrap">ชำระเมื่อ</th>
                                    <th class="text-nowrap">สถานะ</th>
                                    <th class="text-nowrap">การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->HistoryPayment as $HistoryPayment)
                                <tr>
                                    <td class="text-nowrap">{{ $HistoryPayment->PaymentChannel->name }}</td>
                                    <td class="text-nowrap">{{ number_format($HistoryPayment->value,2) }}</td>
                                    <td class="text-nowrap">{{ $HistoryPayment->bill_id }}</td>
                                    <td class="text-nowrap">{{ $HistoryPayment->CreatedAtFormat() }}</td>
                                    <td class="text-nowrap">
                                        @if ($HistoryPayment->status == 1)
                                        <b class="m-0 text-success">สำเร็จ</b>
                                        @else
                                        <b class="m-0 text-danger">ยกเลิก</b>
                                        @endif
                                    </td>
                                    
                                    <td class="text-nowrap">
                                    @if ($HistoryPayment->status == 1)
                                        <a href="#" ng-click="click_modal_confirm_cancel_bill( {{ $HistoryPayment->id }} )" data-toggle="modal" data-dismiss="modal" aria-label="Close" data-target="#modal_confirm_cancel_bill"><i class="material-icons text-danger">cancel</i></a>
                                    @endif
                                    </td>                                    
                                </tr>
                                @endforeach
                                <tr class="text-right">
                                    <td colspan="3" class="border-0"></td>
                                    <td class="border-0">รวมยอด</td>
                                    <td colspan="2" class="text-right">{{ number_format($order->TotalAll(),2) }}</td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3" class="border-0"></td>
                                    <td class="border-0">ชำระแล้ว</td>
                                    <td colspan="2" class="text-right">{{ number_format($order->Deposit(),2) }}</td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3" class="border-0"></td>
                                    <td class="border-0">คงเหลือ</td>
                                    <td colspan="2" class="text-right">{{ number_format($order->Balance(),2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- --}}

    {{-- modal_confirm_cancel_bill --}}
    {!! Form::open(['method' => 'POST' , 'action' => ['Order\PaymentController@cancel',$order->id]]) !!}
    <div class="modal fade" id="modal_confirm_cancel_bill">
        <div class="modal-dialog modal-center">
            <div class="modal-content rounded-0 border-0">
                <div class="modal-body text-center">
                    <h6 class="m-0 text-danger">คุณแน่ใจว่าต้องการยกเลิกการชำระเงินหรือไม่</h6>
                </div>
                <input type="hidden" name="cancel_bill_id" value="@{{ cancel_bill_id }}">
                <div class="modal-footer p-0">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-6 col-sm-6 p-0">
                        <button type="button" class="btn btn-danger btn-block rounded-0" data-toggle="modal" data-dismiss="modal" aria-label="Close" data-target="#modal_history_payment">ย้อนกลับ</button>
                      </div>
                      <div class="col-6 col-sm-6 p-0">
                        <button type="submit" class="btn btn-success btn-block rounded-0">ยกเลิกการชำระเงิน</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    {{-- modal_alert_to_customer --}}
    {!! Form::open(['method' => 'POST' , 'action' => ['Order\AOrderController@AlertToCustomer',$order->id]]) !!}
    <div class="modal fade" id="modal_alert_to_customer">
        <div class="modal-dialog modal-center">
            <div class="modal-content rounded-0 border-0">
                <div class="modal-body text-center">
                    <h6 class="m-0 text-danger">คุณต้องการแจ้งรายละเอียดการชำระเงินแก่ลูกค้าหรือไม่</h6>
                </div>
                <div class="modal-footer p-0">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-6 col-sm-6 p-0">
                        <button type="button" class="btn btn-danger btn-block rounded-0" data-toggle="modal" data-dismiss="modal" aria-label="Close" data-target="#modal_history_payment">ย้อนกลับ</button>
                      </div>
                      <div class="col-6 col-sm-6 p-0">
                        <button type="submit" class="btn btn-success btn-block rounded-0">แจ้งเตือน</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    {{-- --}}
    @endsection
