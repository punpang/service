@extends('admin.bestexpress.layouts.main')

@section('body')

@include('admin.bestexpress.layouts.errors')
{{-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> --}}
{{-- {!! Html::script('js/admin/bestexpress/tracking/create.js') !!} --}}

  <div class="card border-0 shadow">
    <div class="card-header bg-white">
      <h4 class="m-0">ค้นหาผู้ส่ง</h4>
    </div>
    <div class="card-body">
      {!! Form::open(['method' => 'post' , 'action' => 'BestExpress\TrackingController@SenderChoose' , 'class' => 'm-0' ])!!}
      <div class="form_group row">
        <div class="col-sm-8 col-12 mt-2">
          <input type="tel" name="SenderFind" id="SenderFind" placeholder="ชื่อผู้ส่ง/เบอร์โทร" required autofocus class="form-control">
        </div>
        <div class="col-sm-4 col-12 mt-2">
          <button type="submit" class="btn btn-best btn-block">ค้นหา</button>
        </div>
      </div>

      @isset($senders)
        <br>
        @if ($senders->count() > 0)

            <div class="table-responsive">
              <table class="table table-hover text-left">
                <thead>
                  <tr>
                    <th>ชื่อผู้ส่ง</th>
                    <th>เบอร์โทร</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($senders as $sender)
                    <tr>
                      <td>
                        <a href="{{ action('BestExpress\TrackingController@create' , $sender->id )}}">{{ $sender->name }}</a>
                      </td>
                      <td>{{ $sender->tel }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        @elseif ($senders->count() == 0)
          <div class="alert alert-danger m-0">
            ไม่มีชื่อร้าน/เบอร์โทร ที่ค้นหา <a href="{{ action('BestExpress\SenderController@create') }}">สร้างรายชื่อใหม่</a>
          </div>
        @endif
      @endisset


    </div>
  </div>
@endsection
