<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookMessager extends Model
{

    public static function url()
    {
        return "https://graph.facebook.com/";
    }

    public static function version()
    {
        return 'v10.0/';
    }

    public static function pageToken()
    {
        return [
            'app' => env('FACEBOOK_PAGE_APP_ID'),
            'access_token' => env('FACEBOOK_PAGE_ACCESS_TOKEN'),
            'page' => env('FACEBOOK_PAGE_ID'),
            'appsecret_proof' => env('FACEBOOK_PAGE_APPSECRET_PROOF')
        ];
    }

    public static function getPSIDV1($customer) //
    {
        if (!empty($customer->fbid)) { //มี FBID
            if (empty($customer->psid)) { // ไม่มี PSID
                $url = 'https://graph.facebook.com/v6.0/' . $customer->fbid . '/ids_for_pages?';
                $pageToken = FacebookMessager::pageToken();
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url . "app=" . $pageToken['app'] . "&access_token=" . $pageToken['access_token'] . "&appsecret_proof=" . $pageToken['appsecret_proof'] . "&page=" . $pageToken['page'],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                $PSID = json_decode($response, true);

                $customer->psid = $PSID['data'][0]['id'];
                $customer->save();
            }
            return $customer->psid;
        }

        return "Don't have Facebook ID";
    }

    public static function getPSID($customer) //
    {
        if (!empty($customer->fbid)) { //มี FBID
            if (empty($customer->psid)) { // ไม่มี PSID

                $pageToken = FacebookMessager::pageToken();
                $url = self::url() . self::version() . $customer->fbid . '/ids_for_pages?' . "app=" . $pageToken['app'] . "&access_token=" . $pageToken['access_token'] . "&appsecret_proof=" . $pageToken['appsecret_proof'] . "&page=" . $pageToken['page'];

                //$url = 'https://graph.facebook.com/v6.0/' . $customer->fbid . '/ids_for_pages?' . "app=" . $pageToken['app'] . "&access_token=" . $pageToken['access_token'] . "&appsecret_proof=" . $pageToken['appsecret_proof'] . "&page=" . $pageToken['page'];

                $client = new \GuzzleHttp\Client();
                $response = $client->get($url);
                $body = $response->getBody();
                $PSID = json_decode($body->getContents(), true);

                $customer->psid = $PSID['data'][0]['id'];
                $customer->save();
            }
            return $customer->psid;
        }

        return ['status' => 'error', 'message' => "Don't have Facebook ID"];
    }

    public static function postMessage($customer, $channel_of_purchase, $text, $allow) //ลูกค้าทีค้นหาแล้ว ช่องทางการซื้อที่ค้นหาแล้ว ข้อความ
    {
        //return 'pass';
        $psid = FacebookMessager::getPSID($customer);
        if (empty($psid) || empty($text) || $channel_of_purchase != "FACEBOOK" || !$allow) {
            return 'ไม่สามารถส่งข้อความได้';
        }

        try {
            $pageToken = FacebookMessager::pageToken();
            $url = self::url() . self::version() . 'me/messages?access_token=' . $pageToken['access_token'];
            $data = [
                'recipient' => ['id' => $psid],
                'message' => ['text' => $text],
                "messaging_type" => "MESSAGE_TAG",
                "tag" => "POST_PURCHASE_UPDATE"
            ];
            $client = new \GuzzleHttp\Client();
            $response = $client->post($url, ['form_params' => $data]);

            return $response->getStatusCode();
        } catch (\Exception $e) {
            FacebookMessager::postMessageNotAllow($psid, $text);
        }
    }

    public static function postMessageNotAllow($psid, $text) //ส่งข้อความหาลูกค้าที่เกิน 24 ชม.
    {
        $pageToken = FacebookMessager::pageToken();
        $url = self::url() . self::version() . 'me/messages?access_token=' . $pageToken['access_token'];
        $data = [
            'recipient' => ['id' => $psid],
            'message' => ['text' => $text],
            "messaging_type" => "MESSAGE_TAG",
            "tag" => "POST_PURCHASE_UPDATE"
        ];
        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, ['form_params' => $data]);

        return $response->getStatusCode();
    }

    public static function postMessageV1($customer, $channel_of_purchase, $text) //ลูกค้าทีค้นหาแล้ว ช่องทางการซื้อที่ค้นหาแล้ว ข้อความ
    {
        $psid = FacebookMessager::getPSID($customer);
        if (empty($psid) || empty($text) && $channel_of_purchase == "FACEBOOK") {
            return 'ไม่สามารถส่งข้อความได้';
        }

        $url = 'https://graph.facebook.com/v6.0/me/messages';
        $pageToken = FacebookMessager::pageToken();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "access_token=" . $pageToken['access_token'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n  \"recipient\":{\r\n    \"id\":\"$psid\"\r\n  },\r\n  \"message\":{\r\n  \t\"text\": \"$text\"\r\n  }\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return 'success';
    }
}
