<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SCBPayment extends Model
{
    public static function getAuthorization()
    {
        $json = [
            "applicationKey" => "l7e3d720b4ded7430484fe335d7999eaf0",
            "applicationSecret" => "dcf95e5ae0ce4f8db598c126f15b126a"
        ];

        $headers = [
            'content-type' => 'application/json',
            'resourceOwnerId' => "l7e3d720b4ded7430484fe335d7999eaf0",
            'requestUId' => (string) Str::uuid(),
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->post("https://api-sandbox.partners.scb/partners/sandbox/v1/oauth/token",
            [
                'headers' => $headers,
                'json' => $json
            ]
        );

        $body = $response->getBody();
        $data = json_decode($body,true);

        return $data["data"]['accessToken'];
    }


    public static function CreateDeeplink($amount,$ref1,$ref2)
    {

        //dd(Str::random(60));
        $json = [
            "transactionType" => "PURCHASE",
            "transactionSubType" => ["BP"],
                "billPayment" => [
                    "paymentAmount" => $amount,
                    "accountTo" => "737483903222539",
                    "ref1" => $ref1,
                    "ref2" => $ref2,
                    "ref3" => "SCB"
                ],
            "merchantMetaData" => [
                "callbackUrl" => "https://www.punpangs.com/callback",
               // "merchantInfo" => [
               //     "name" => "punpang"
               // ]
            ]
        ];

        $authorization = SCBPayment::getAuthorization();
        //return $authorization;

        $resourceOwnerId = "l7e3d720b4ded7430484fe335d7999eaf0";
        $requestUId = (string) Str::uuid();

        $headers = [
            'content-type' => 'application/json',
            'authorization' => 'Bearer '.$authorization,
            'accept-language' => 'TH',
            'resourceOwnerId' => $resourceOwnerId,
            'requestUId' => $requestUId,
            'channel' => 'scbeasy',
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->post("https://api-sandbox.partners.scb/partners/sandbox/v3/deeplink/transactions",
            [
                'headers' => $headers,
                'json' => $json
            ]
        );
        $body = $response->getBody();
        return json_decode($body,true);
    }
}
