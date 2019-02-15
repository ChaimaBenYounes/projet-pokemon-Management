<?php

namespace App\Service;

use GuzzleHttp\Client;

class ClientGuzzleHttp
{
    private $client; 

    public function __construct($base_uri){

        $this->client = new Client([
            'base_uri' => $base_uri,
            'timeout'  => 2.0,
        ]);
    }

    public function getClientGuzzleHttp()
    {
        return $this->client;
    }
}