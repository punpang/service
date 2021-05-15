<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SCBPayment extends Model
{
    public static function CreateDeeplink($amount,$ref1,$ref2='34222')
    {
        $json = [
            "transactionType" => "PURCHASE",
            "transactionSubType" => ["BP"],
                "billPayment" => [
                    "paymentAmount" => $amount,
                    "accountTo" => "737483903222539",
                    "ref1" => $ref1,
                    "ref2" => $ref2,
                    "ref3" => "SCB"
                ]
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->post("https://api-sandbox.partners.scb/partners/sandbox/v3/deeplink/transactions",
            [
                'headers' => [
                    'content-type' => 'application/json',
                    'authorization' => 'Bearer 1b13b342-d1bb-4c65-b5f8-d3ea8c956f17',
                    'accept-language' => 'TH',
                    'resourceOwnerId' => 'l7e3d720b4ded7430484fe335d7999eaf0',
                    'requestUId' => '7040111a-630d-41fe-8687-2604a4fdc3df',
                    'channel' => 'scbeasy',
                ],
                'json' => $json
            ]
        );
        $body = $response->getBody();
        return json_decode($body,true);
    }
}
