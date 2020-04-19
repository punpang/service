@extends('admin.bestexpress.layouts.main')

@section('body')

@include('admin.bestexpress.layouts.errors')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
{{-- {!! Html::script('js/admin/bestexpress/tracking/create.js') !!} --}}

<div class="card border-0 shadow mb-2">
    <div class="card-header bg-white">
        <h5 class="mt-2 mb-2"><b>ข้อมูลผู้ส่ง</b>
          <a href="{{ action('BestExpress\SenderController@edit', $sender->id) }}" class="close text-danger"><i class="material-icons">edit</i></a>
        </h5>
    </div>
    <div class="card-body">
        <div class="form-group row mb-0">

          <div class="col-sm-6 p-0">
            <label class="col-12 col-form-label"><b>ชื่อผู้ส่ง/ร้าน/บริษัท/อื่น ๆ</b></label>
            <div class="col-12 text-middle pl-4 pt-3 pb-3">
              {{ $sender->name }}
            </div>


          </div>



          <div class="col-sm-6 p-0">
            <label class="col-12 col-form-label"><b>หมายเลขโทรศัพท์</b></label>
            <div class="col-12 text-middle pl-4 pt-3 pb-3">
              {{ $sender->tel }}
            </div>
          </div>


        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-12 col-form-label"><b>ที่อยู่</b></label>
            <div class="col-12 text-middle pl-4 pt-3 pb-3">
              {{ $sender->address }}
            </div>
        </div>

    </div>
</div>

{!! Form::open(['method' => 'post' , 'action' => ['BestExpress\SenderController@ShowTrackingPost' , $sender->id ]]) !!}
<div class="card border-0 shadow">
  <div class="card-body">
    <div class="form_group row">
      <div class="col-12 col-sm-2">
        <label for="" class="col-form-label">เลือกวันที่</label>
      </div>
      <div class="col-8 col-sm-6">
        <input type="date" name="dates" value="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" class="form-control">
      </div>
      <div class="col-4 col-sm-4">
        <button type="submit" class="btn btn-best btn-block">ค้นหา</button>
      </div>
    </div>
  </div>
</div>
{!! Form::close() !!}



@endsection
