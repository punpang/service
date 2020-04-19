@extends('admin.bestexpress.layouts.main')

@section('body')

@include('admin.bestexpress.layouts.errors')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
{{-- {!! Html::script('js/admin/bestexpress/tracking/create.js') !!} --}}

  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ชื่อผู้ส่ง/ร้าน/บริษัท/อื่น ๆ</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($senders as $sender)
          <tr>
            <td>
              <a href="{{ action('BestExpress\SenderController@show' , $sender->id )}}">{{ $sender->name }}</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
