<?php

namespace App\Services;

use App\Models\LogGet;
use GuzzleHttp\Client;

class NonTenderService
{

    public static function getAll($year = null, $lpse = "121") {
        if( $year == null ) {
            $year   = date('Y');
        }
        $endpoint   = "https://inaproc.lkpp.go.id/isb/api/f71d9aac-d8fa-41c1-84fb-f8b46a1eae58/json/736986792/NonTenderPengumumanDetailSPSE/tipe/4:4/parameter/".$year.":".$lpse;
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
        $endpoint   = "https://inaproc.lkpp.go.id/isb/api/6715036b-34b7-4c23-959b-fdf1c8b7bf6a/json/736986793/NonTenderSelesaiDetailSPSE/tipe/4:4/parameter/".$year.":".$lpse;
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
