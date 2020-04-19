@extends('layouts.main')
@section('body')

{!! Form::open(['action' => 'MemberController@SignInDone']) !!}
	<div class="row justify-content-center mt-2">
		<div class="col-md-4">
			<div class="card border-0">

				<div class="card-body border">
					<h6 class="mb-3 text-center">คุณต้องการเข้าสู่ระบบ อุปกรณ์นี้ใช่ไหม ? <br /><br />
						<small class="text-danger text-center">*ห้ามส่งลิงก์ให้กับบุคคลอื่นเด็ดขาด*</small></h6>

					<input type="hidden" name="phone" value="{{ $phone }}">
					<input type="hidden" name="check" value="{{ $check->id }}">
					{!! Form::submit('เข้าสู่ระบบ',['class' => 'btn btn-orange rounded-0 btn-lg btn-block']) !!}

				</div>
			</div>
		</div>
	</div>
{{ Form::close() }}

@endsection
