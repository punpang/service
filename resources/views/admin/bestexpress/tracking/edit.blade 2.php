@extends('admin.bestexpress.layouts.main')

@section('body')

@include('admin.bestexpress.layouts.errors')
{{-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> --}}
{!! Html::script('js/admin/bestexpress/tracking/create.js') !!}

{!! Form::model($tracking,['method' => 'put' , 'action' => ['BestExpress\TrackingController@update',$tracking->id] ]) !!}

  @include('admin.bestexpress.tracking._form', ['header_name' => 'เปลี่ยนแปลงพัสดุ' ,'btnname' => 'เปลี่ยนแปลง' ,'btnclass' => 'btn-warning'])

{!! Form::close() !!}


@endsection
