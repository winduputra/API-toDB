<?php

namespace App\Services;

use App\Models\LogGet;
use GuzzleHttp\Client;

class TenderParticipantService
{

    public static function getByCode($code) {
        $endpoint   = "https://inaproc.lkpp.go.id/isb/api/3324ec60-f4ab-4be4-ac26-7af73e2ddb48/json/736986758/PesertaPerTenderSPSE/tipe/4/parameter/" . $code;
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
