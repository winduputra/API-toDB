<?php

namespace App\Services;

use App\Models\LogGet;
use GuzzleHttp\Client;

class TenderScheduleService
{

    public static function getByCode($code) {
        $endpoint   = "https://inaproc.lkpp.go.id/isb/api/3dc2d0ac-eb7e-4c89-889d-7c59205a04f6/json/736986787/JadwalPerTenderSPSE/tipe/4/parameter/" . $code;
        $client     = new Client();
        $request    = $client->get($endpoint);

        $statusCode = $request->getStatusCode();
        $response   = $request->getBody()->getContents();

        LogGet::create([
            'endpoint' => $endpoint,
            'response' => $response,
        ]);
        
        return json_decode($response);
    }

}
