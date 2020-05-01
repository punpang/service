<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GoogleCloudVision\GoogleCloudVision;
use GoogleCloudVision\Request\AnnotateImageRequest;

class GoogleOcr extends Model
{
    protected $table = "google_ocrs";
    protected $connection = 'mysql';

    public $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'google_image_path',
        'ocr_text',
        'type',
        'status',
    ];

    public static function ocrImage($imageFile, $imagePath)
    {
        try {
            if ($imageFile) {

                //convert image to base64
                $image = base64_encode(file_get_contents($imageFile));
                //Sending image for OCR server
                $request = new AnnotateImageRequest();
                $request->setImage($image);
                $request->setFeature("TEXT_DETECTION");
                $gcvRequest = new GoogleCloudVision([$request],  env('GOOGLE_CLOUD_KEY'));
                //Send Request to check image OCR or not through annotate
                $response = $gcvRequest->annotate();
                //return json_encode([$response->responses[0]->textAnnotations[0]->description]);

                $textAnnotations = $response->responses[0]->textAnnotations;
                unset($textAnnotations[0]);
                foreach ($textAnnotations as $item) {
                    $explode = explode(".", $item->description);
                    $countExplode = count($explode);
                    if (strlen($item->description) >= 4 && strlen($item->description) <= 10) { //strlen($item->description) >= 4 && strlen($item->description) <= 10
                        if ($countExplode == 2 && $item->description > 0 && $explode[1] == '0') {
                            $ocr = GoogleOcr::where('ocr_text', $item->description)
                                ->where('google_image_path', $imagePath)
                                ->where('type', 'money')
                                ->first();
                            if (!$ocr) {
                                $q = new GoogleOcr;
                                $q->google_image_path = $imagePath;
                                $q->ocr_text = $item->description;
                                $q->type = 'money';
                                $q->save();
                            }
                        }
                    } else if (strlen($item->description) >= 5) {
                        if ($countExplode != 2) {
                            $ocr = GoogleOcr::where('ocr_text', $item->description)->first();
                            if (!$ocr) {
                                $q = new GoogleOcr;
                                $q->google_image_path = $imagePath;
                                $q->ocr_text = $item->description;
                                $q->type = 'ref';
                                $q->save();
                            }
                        }
                    }
                }
                return response()->json([
                    'success' => true
                ], 200);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }


    public static function ocrImagev2($imageFile, $imagePath)
    {
        if ($imageFile) {

            // เรียก ocr ทั้งหมดที่มี
            $removeObject = GoogleOcr::select('ocr_text')->get();
            // จัดให้อยู่ในรูป []
            $removes = [null];
            foreach ($removeObject as $remove) {
                $removes[] = $remove['ocr_text'];
            }
            return $removes;
            //convert image to base64
            $image = base64_encode(file_get_contents($imageFile));
            //Sending image for OCR server
            $request = new AnnotateImageRequest();
            $request->setImage($image);
            $request->setFeature("TEXT_DETECTION");
            $gcvRequest = new GoogleCloudVision([$request],  env('GOOGLE_CLOUD_KEY'));
            //Send Request to check image OCR or not through annotate
            $response = $gcvRequest->annotate();
            //return json_encode([$response->responses[0]->textAnnotations[0]->description]);

            $textAnnotations = $response->responses[0]->textAnnotations;

            $refs = ['null', 25, 18, 12, 20, 24, 6, 18];/* null,SCB,K+,KTC,ธนชาติ,ออมสิน,กรุงเทพ,TMB */
            /*
            $removes = [
                "ххх-ххх026-6", "ххх-ххх-5562", "siaas:", "ปี", "มานะ", "สมศักดิ์", "XXX-XXX-0809", "XXX-XXX026-6",
                "พรรษิษ 
                'null'ฐ์", "ศรีสุข", "XXX-XXX-5562", "อบอุ่น", "Prompt", "successfully", "901-0-xxx954", "Amount", "ทีเอ็มบี",
                "тмв", "หน้าหลัก", "โอนเพิ่ม", "จำนวนมิน", "กฤติยาพร", "wssauj", "จำนวนมัน", "XXX-XXx026-6", "LaJ.9.", "XXX-XXX-1196"
            ];
            */
            //dd($textAnnotations);
            foreach ($textAnnotations as $item) {
                $countText = strlen($item->description);
                $refsSearch = array_search($countText, $refs);
                if ($refsSearch != false) {
                    if (array_search($item->description, $removes) == false) {
                        $explode = explode(".", $item->description);
                        $countExplode = count($explode);
                        if ($countExplode != 2) {
                            $refValue[] = $item->description;
                        }
                    }
                }

                /*
                foreach ($refs as $ref) {
                    if (strlen($item->description) == $ref) {
                        if (empty(array_search($item->description, $removes))) {
                            $refValue[] = $item->description;
                        }
                    }
                }*/
                if (strlen($item->description) >= 4 && strlen($item->description) <= 10) { //strlen($item->description) >= 4 && strlen($item->description) <= 10
                    $explode = explode(".", $item->description);
                    $countExplode = count($explode);
                    if ($countExplode == 2 && $item->description > 0 && $explode[1] == '0') {
                        $money[] = $item->description;
                    }
                }
            }

            if (empty($money)) {
                $money = null;
            } else {
                if (count($money) > 1) {
                    $moneyDemo = array_unique($money);
                    $money = $moneyDemo;
                }
            }

            /*
            foreach($removes as $remove){
                $array_search = array_search($remove,$refValue);
                if(array_search($remove,$refValue)){
                    unset($refValue[$array_search]);
                }
                
            }
            */

            foreach ($refValue as $ref) {
                $q = new GoogleOcr;
                $q->google_image_path = $imagePath;
                $q->ocr_text = $ref;
                $q->type = 'ref';
                $q->save();
            }

            foreach ($money as $m) {
                $q = new GoogleOcr;
                $q->google_image_path = $imagePath;
                $q->ocr_text = $m;
                $q->type = 'money';
                $q->save();
            }

            return [
                'ref' => $refValue,
                'money' => $money,
                //'textAnnotations' => $textAnnotations
            ];

            // วิธีที่ 2
            /*
            foreach ($data_text as $item) {

            }

            dd($refs);
            */
        }
    }
}
