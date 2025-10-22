<?php

namespace App\Services;

use App\Models\LogGet;
use GuzzleHttp\Client;

class SatkerService
{
    public static function getMaster($year = null, $klpd = "D264") {
        if( $year == null ) {
            $year   = date('Y');
        }
        $endpoint   = "https://inaproc.lkpp.go.id/isb/api/24d1c5eb-17ba-4f1f-801e-4ae9501ec66d/json/736986761/MasterSatkerRUP/tipe/12:12/parameter/".$klpd.":" . $year;
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
