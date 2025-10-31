<?php

namespace App\Services;

use App\Models\LogGet;
use GuzzleHttp\Client;

class TenderService
{
    public static function getAll($year = null, $lpse = "121") {
        if( $year == null ) {
            $year   = date('Y');
        }
        $endpoint   = "https://inaproc.lkpp.go.id/isb/api/e89f8ead-0727-4354-b937-31dc517bb989/json/736986757/TenderPengumumanDetailSPSE/tipe/4:4/parameter/".$year.":".$lpse;
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

    public static function getDone($year = null, $lpse = "121") {
        if( $year == null ) {
            $year   = date('Y');
        }
        $endpoint   = "https://inaproc.lkpp.go.id/isb/api/349fc588-e505-46e4-a692-451237f5682a/json/736986569/TenderSelesaiDetailSPSE/tipe/4:4/parameter/".$year.":".$lpse;
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
