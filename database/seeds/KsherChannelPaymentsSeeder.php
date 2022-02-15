<?php

use Illuminate\Database\Seeder;
use App\Order\KsherChannelPayment;

class KsherChannelPaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                "id" =>  1,
                "payment_code" =>  "promptpayQR",
                "text" =>  "QR CODE พร้อมเพย์",
                "remark" =>  "ไม่มีค่าธรรมเนียม",
                "color" =>  "info",
                "image" =>  "1AU5EBhr1zLrCD3bbU_CoCvI1YhiLtREd",
                "image2" =>  "1jpGiesT_GVoZoK_zc7pvg3IHpfqkb9oQ",
                "fee_value" =>  0,
                "fee_type" =>  "bath",
                "fee_type_th" =>  "บาท",
                "sort" => "1",
                "status_use" =>  1,
                "channel" => "promptpay",
                "minimum" => 1,
            ],
            [
                "id" =>  2,
                "payment_code" =>  "eWallet",
                "text" =>  "E-WALLET",
                "remark" =>  "ค่าธรรมเนียม 3%",
                "color" =>  "info",
                "image" =>  "18azZhssTmSzxpVH-9yRoeXQTlZqQL12w",
                "image2" =>  "1dkP7rTQkUiowO_2mhCKM_70_Qf_B7ElN",
                "fee_value" =>  3,
                "fee_type" =>  "percent",
                "fee_type_th" =>  "เปอร์เซ็นต์",
                "sort" => "6",
                "status_use" =>  1,
                "channel" => "wechat,alipay,truemoney,airpay,linepay",
                "minimum" => 1,
            ],
            [
                "id" =>  3,
                "payment_code" =>  "mobileBanking",
                "text" =>  "MOBILE BANKING",
                "remark" =>  "ค่าธรรมเนียม 15 บาท",
                "color" =>  "error",
                "image" =>  "14KKzrkyTqXFHWHzhPMWyrozAn13EHi48",
                "image2" =>  "1hdrVzp2Hsxy0O--5OEM_QKsIyBvrhOI-",
                "fee_value" =>  15,
                "fee_type" =>  "bath",
                "fee_type_th" =>  "บาท",
                "sort" => "4",
                "status_use" =>  1,
                "channel" => "scb_easy,bbl_deeplink,baybank_deeplink",
                "minimum" => 20,
            ],
            [
                "id" =>  4,
                "payment_code" =>  "debitCreditCard",
                "text" =>  "บัตรเดบิต/บัตรเครดิต",
                "remark" =>  "ค่าธรรมเนียม 3 %",
                "color" =>  "error",
                "image" =>  "-",
                "image2" =>  "1IRBZVqtAKU0tTeERDwf0j0QL44KfD4de",
                "fee_value" =>  3,
                "fee_type" =>  "percent",
                "fee_type_th" =>  "เปอร์เซนต์",
                "sort" => "5",
                "status_use" =>  1,
                "channel" => "card",
                "minimum" => 1,
            ],
            [
                "id" =>  5,
                "payment_code" =>  "transferByCustomer",
                "text" =>  "โอนชำระด้วยตัวเอง",
                "remark" =>  "ไม่มีค่าธรรมเนียม",
                "color" =>  "error",
                "image" =>  "-",
                "image2" =>  "1zzP9yRA5-DvIx03SKHabOZvBOX_miTjU",
                "fee_value" =>  0,
                "fee_type" =>  "bath",
                "fee_type_th" =>  "บาท",
                "sort" => "2",
                "status_use" =>  1,
                "channel" => "transferByCustomer",
                "minimum" => 1,
            ],
            [
                "id" =>  6,
                "payment_code" =>  "notPayment",
                "text" =>  "ไม่สะดวกชำระมัดจำ",
                "remark" =>  "โปรดติดต่อทางร้าน",
                "color" =>  "error",
                "image" =>  "-",
                "image2" =>  "1b6aPVEkRSvigHbryeT3nC5B_rVDvFDV7",
                "fee_value" =>  10,
                "fee_type" =>  "bath",
                "fee_type_th" =>  "บาท",
                "sort" => "3",
                "status_use" =>  1,
                "channel" => "notPayment",
                "minimum" => 1,
            ],
        ];

        foreach ($datas as $data) {
            $new = new KsherChannelPayment;
            $new->id  = $data["id"];
            $new->payment_code  = $data["payment_code"];
            $new->text  = $data["text"];
            $new->remark  = $data["remark"];
            $new->color  = $data["color"];
            $new->image  = $data["image"];
            $new->image2  = $data["image2"];
            $new->fee_value  = $data["fee_value"];
            $new->fee_type  = $data["fee_type"];
            $new->fee_type_th  = $data["fee_type_th"];
            $new->sort  = $data["sort"];
            $new->status_use  = $data["status_use"];
            $new->channel = $data["channel"];
            $new->minimum  = $data["minimum"];
            $new->save();
        }
    }
}
