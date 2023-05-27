<?php

namespace App\Imports;

use App\Helper;
use App\Order\WongnaiPosBills;
use Maatwebsite\Excel\Concerns\ToModel;

class WongnaiPosBillsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model($row = [])
    {
        if ($row[0] != "Total" && $row[0] != "วันที่ชำระเงิน") {
            WongnaiPosBills::firstOrCreate(
                [
                    'bill_id' => $row[3]
                ],
                [
                    "payment_date" => $row[0],
                    "payment_time" => $row[1],
                    "total" => Helper::cut_comma_to_numeric($row[8]),
                    "order_type" => $row[19],
                    "payment_type" => $row[21],
                ]
            );
        }
        // return new WongnaiPosBills([
        //     "payment_date" => $row[0],
        //     "payment_time" => $row[1],
        //     "bill_id" => $row[3],
        //     "total" => $row[8],
        //     "order_type" => $row[19],
        //     "payment_type" => $row[21],
        // ]);
    }
}
