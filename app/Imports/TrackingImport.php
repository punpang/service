<?php

namespace App\Imports;

use App\BestExpress\Tracking;
use Maatwebsite\Excel\Concerns\ToModel;

class TrackingImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      // $trackings = Tracking::where('waybill',$row[0])->first();
      if (Tracking::where('waybill',$row[2])->first() == NULL and $row[2] != 'เลขที่พัสดุ') {
          return new Tracking([
          'dates' => request('dates'),
          // 'id' => $row[1],
          'waybill' => $row[2],
          'shipping_charge' => $row[10], //ค่าขนส่ง
          'other_values' => $row[11], //ค่าบริการเสริม
          'parcel_fee' => $row[12], //ค่าวัสดุ
          'besides' => $row[13], //อื่น ๆ
          'sender_number' => $row[25],
          'recipient_name' => $row[31],
          'recipient_number' => $row[32],
          'total' => $row[16],
          'weight' => $row[18],
          'size' => $row[22]
        ]);
      }

        // return new Tracking([
        //   'dates' => request('dates'),
        //   // 'id' => $row[1],
        //   if ($row) {
        //     'waybill' => $row[0]
        //   },
        //   'shipping_charge' => $row[1],
        //   'other_values' => $row[2],
        //   'parcel_fee' => $row[3],
        //   'besides' => $row[4],
        //   'sender_number' => $row[5],
        //   'recipient_name' => $row[6],
        //   'recipient_number' => $row[7],
        //   'total' => $row[2] + $row[3] + $row[4] + $row[1],
        // ]);
    }
}
