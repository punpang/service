<div class="card border-0 shadow " ng-init="loading = 0">
    <div class="card-header bg-white">
        <h4 class="m-0">{{ $header_name }}</h4>
    </div>
    <div class="card-body">
      <h5 class="m-0">ข้อมูลผู้ส่ง</h5>
      <hr>
      <div class="form-group row mb-0">

        <div class="col-sm-6 p-0">
          <label class="col-12 col-form-label">ชื่อผู้ส่ง</label>
          <div class="col-12">
            <input type="text" class="form-control" readonly value="{{ $sender->name }}">
          </div>
        </div>

        <div class="col-sm-6 p-0">
          <label class="col-12 col-form-label">หมายเลขโทรศัพท์</label>
          <div class="col-12">
            <input type="text" class="form-control" readonly value="{{ $sender->tel }}">
          </div>
        </div>

        <div class="col-12 p-0">
          <label class="col-12 col-form-label">ที่อยู่</label>
          <div class="col-12">
            <textarea rows='2' type="text" class="form-control" readonly>{{ $sender->address }}</textarea>
          </div>
        </div>


      </div>

      <hr>

      <h5 class="m-0">ข้อมูลผู้รับ</h5>
      <hr>

        <div class="form-group row">
            {{-- <label class="col-sm-1 col-12 col-form-label">วันที่</label> --}}
            <div class="col-sm-4 col-12 text-middle">
              @if (isset($tracking))
                {!! Form::date('dates',null,['class' => 'form-control' , 'required']) !!}
                <div ng-init="shipping_charge = {{ $tracking->shipping_charge }}"></div>
                <div ng-init="parcel_fee = {{ $tracking->parcel_fee }}"></div>
                <div ng-init="other_values = {{ $tracking->other_values }}"></div>
                <div ng-init="besides = {{ $tracking->besides }}"></div>
              @else
                {!! Form::date('dates',\Carbon\Carbon::now()->format("Y-m-d"),['class' => 'form-control' , 'required']) !!}
              @endif

                {{-- <input type="date" name="dates" required value="{{ Carbon\Carbon::now()->format("Y-m-d") }}" class="form-control"> --}}
            </div>

            {{-- <label class="col-sm-1 col-12 col-form-label">เบอรผู้รับ</label> --}}
            <div class="col-sm-4 col-12 text-middle">
              {!! Form::hidden('sender_number',$sender->tel,['required']) !!}

              {!! Form::tel('recipient_number',null,['class' => 'form-control' , 'placeholder' => 'เบอร์ผู้รับ'  , 'required']) !!}
                {{-- <input type="number" required min="66000000000000" max="66999999999999" class="form-control{{ $errors->has('waybill') ? ' is-invalid' : '' }}" name="waybill" value="{{ old('waybill') }}"> --}}
                {{-- @if ($errors->has('waybill'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('waybill') }}</strong>
                    </span>
                @endif --}}
            </div>

            {{-- <label class="col-sm-2 col-12 col-form-label">เลขพัสดุ (WAYBILL)</label> --}}
            <div class="col-sm-4 col-12 text-middle">
              {!! Form::number('waybill',null,['class' => 'form-control' , 'placeholder' => 'เลขพัสดุ (WAYBILL)' , 'min' => '66000000000000' , 'max' => '66999999999999' , 'required']) !!}
                {{-- <input type="number" required min="66000000000000" max="66999999999999" class="form-control{{ $errors->has('waybill') ? ' is-invalid' : '' }}" name="waybill" value="{{ old('waybill') }}"> --}}
                {{-- @if ($errors->has('waybill'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('waybill') }}</strong>
                    </span>
                @endif --}}
            </div>
        </div>

        <hr>

        <div class="form-group row">
            {{-- <label class="col-sm-1 col-12 col-form-label">ค่าจัดส่ง</label> --}}
            <div class="col-sm-2 col-12 text-middle mb-2">
              {!! Form::number('shipping_charge',null,['class' => 'form-control' , 'placeholder' => 'ค่าจัดส่ง' , 'pattern' => '\d*' , 'ng-min' => '1' , 'required' ,'ng-model' => 'shipping_charge']) !!}

                {{-- <input type="number" name="shipping_charge" ng-model="shipping_charge" required value="" class="form-control" placeholder="">  --}}
            </div>

            {{-- <label class="col-sm-1 col-12 col-form-label">ค่าพัสดุ</label> --}}
            <div class="col-sm-2 col-12 text-middle mb-2">
              {!! Form::number('parcel_fee',null,['class' => 'form-control' , 'placeholder' => 'ค่าพัสดุ' , 'pattern' => '\d*'  , 'required' ,'ng-model' => 'parcel_fee']) !!}
                {{-- <input type="number" required class="form-control" name="parcel_fee" ng-model="parcel_fee" value=""> --}}
            </div>

            {{-- <label class="col-sm-1 col-12 col-form-label">ค่าอื่น ๆ</label> --}}
            <div class="col-sm-2 col-12 text-middle mb-2">
              {!! Form::number('other_values',null,['class' => 'form-control' , 'placeholder' => 'ค่าอื่น ๆ' , 'pattern' => '\d*' , 'required' ,'ng-model' => 'other_values']) !!}
                {{-- <input type="number" required class="form-control" name="other_values" value="" ng-model="other_values"> --}}
            </div>

            {{-- <label class="col-sm-1 col-12 col-form-label">อื่น ๆ</label> --}}
            <div class="col-sm-2 col-12 text-middle mb-2">
              {!! Form::number('besides',null,['class' => 'form-control' , 'placeholder' => 'อื่น ๆ ' , 'pattern' => '\d*'  , 'required' ,'ng-model' => 'besides']) !!}
                {{-- <input type="number" required class="form-control" name="besides" value=""  ng-model="besides"> --}}
            </div>

            {{-- <label class="col-sm-1 col-12 col-form-label">รวม</label> --}}
            <div class="col-sm-4 col-12 text-middle mb-2">
              {!! Form::number('total',null,['class' => 'form-control' , 'placeholder' => 'รวมทั้งหมด' , 'readonly' , 'required' ,'ng-model' => "shipping_charge + parcel_fee + other_values + besides"]) !!}
            </div>
        </div>

    </div>


    <div class="card-footer text-right">
      {!! Form::submit($btnname,['class' => 'btn btn-lg '.$btnclass]) !!}
{{--
      <button type="submit" class="btn btn-success btn-lg">ลงทะเบียน</button>
      <button type="reset" class="btn btn-danger btn-lg">ล้างข้อมูล</button> --}}
    </div>

</div>
