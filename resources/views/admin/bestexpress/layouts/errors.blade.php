@if ($errors->any())
    <div class="alert alert-danger rounded-0 mb-2">
            @foreach ($errors->all() as $error)
                {!! $error !!} <br>
            @endforeach
    </div>
@endif

@if (Session::has('danger'))
	<div class="alert alert-danger rounded-0 mb-2">{!! Session::get('danger') !!}</div>
@endif

@if (Session::has('warning'))
	<div class="alert alert-warning rounded-0 mb-2">{!! Session::get('warning') !!}</div>
@endif

@if (Session::has('success'))
	<div class="alert alert-success rounded-0 mb-2">{!! Session::get('success') !!}</div>
@endif
