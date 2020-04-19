<div class="card border-0 shadow" ng-init="loading = 0">
    <div class="card-header bg-white">
        <h5 class="mt-2 mb-2"><b>{{ $header_name }}</b></h5>
    </div>
    <div class="card-body">

        <div class="form-group row mb-0">

          <div class="col-sm-6 p-0">
            <label class="col-12 col-form-label">ชื่อผู้ส่ง/ร้าน/บริษัท/อื่น ๆ</label>
            <div class="col-12 text-middle">
              {!! Form::text('name',null,['class' => 'form-control' , 'required']) !!}
            </div>
          </div>

          <div class="col-sm-6 p-0">
            <label class="col-12 col-form-label">หมายเลขโทรศัพท์</label>
            <div class="col-12 text-middle">
              {!! Form::tel('tel',null,['class' => 'form-control' , 'patern' => '\d*' , 'required']) !!}
            </div>
          </div>


        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-12 col-form-label">ที่อยู่</label>
            <div class="col-sm-12 col-12 text-middle">
              {!! Form::textarea('address',null,['class' => 'form-control' , 'rows' => '3' , 'number' , 'min' => '66000000000000' , 'max' => '66999999999999' , 'required']) !!}
            </div>
        </div>

    </div>


    <div class="card-footer bg-white">
      {!! Form::submit($btnname,['class' => 'btn btn-lg '.$btnclass]) !!}
{{--
      <button type="submit" class="btn btn-success btn-lg">ลงทะเบียน</button>
      <button type="reset" class="btn btn-danger btn-lg">ล้างข้อมูล</button> --}}
    </div>

</div>
