@extends('layouts.main')
@section('body')

  <div class="row justify-content-center mb-2">
      <div class="col-md-8">
          <div class="card border-0">
              <div class="card-header border-0 bg-gray h5 m-0">วิธีใช้</div>

              <div class="card-body border">
                  <div class="form-group m-0">
                    1.แจ้งพนักงาน "สะสมคะแนน" <br>
                    2.แจ้งหมายเลขโทรศัพท์กับพนักงาน <br>
                    3.รับ SMS แจ้งเตือนการซื้อสินค้า
                  </div>
              </div>
          </div>
      </div>
  </div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0">
            <div class="card-header border-0 bg-gray h5 m-0">เงื่อนไข - อายุของคะแนนสะสม (สำหรับลูกค้าสมาชิก)</div>

            <div class="card-body border">
                <div class="form-group m-0">
                    - ทุก ๆ ยอดซื้อ 50 บาท จะได้รับคะแนน 1 คะแนน <br>
                    - สามารถสะสมและใช้คะแนนได้เฉพาะหน้าร้านเท่านั้น <br>
                    - สินค้าที่ได้รับส่วนลดพิเศษ ไม่สามารถสะสมคะแนนได้ <br>
                    - สามารถใช้งานร่วมกับโปรโมชั่น 3 ชิ้น 100 บาท ได้ <br>
                    - คะแนนสะสมไม่มีวันหมดอายุ <br>
                    - ทางร้าน ฯ ขอสงวนสิทธิ์ในการเปลี่ยนแปลง แก้ไข และยกเลิก สิทธิประโยชน์ โดยไม่ต้องแจ้งให้ทราบล่วงหน้า<br>

                    *ทางร้านถือว่าลูกค้าทุกท่านที่ใช้บริการอ่านและยอดรับเงื่อนไขทุกประการ
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
