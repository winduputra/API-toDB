<?php

namespace App\Services;

use App\Models\LogGet;
use GuzzleHttp\Client;

class NonTenderScheduleService
{

    public static function getByCode($code) {
        $endpoint   = "https://inaproc.lkpp.go.id/isb/api/0094d483-16cb-41e1-9c81-b8cc3c31e5c4/json/736986767/JadwalPerNonTenderSPSE/tipe/4/parameter/" . $code;
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
