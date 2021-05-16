<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SCBPayment extends Model
{
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
                ]
        ];

        $authorization = "dfa1bac2-021f-44e6-a8c6-786876aac737";
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
