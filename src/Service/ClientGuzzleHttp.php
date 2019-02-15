<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class ClientGuzzleHttp
{
    private $client; 

    public function __construct($base_uri){

        $this->client = new Client([
            'base_uri' => $base_uri,
            'timeout'  => 2.0,
        ]);
    }

    public function getAllPokemon()
    {
        $response = $this->client->request('GET', 'pokemon');
        $response = json_decode($response->getBody()->getContents(), true);
        
        return $response['hydra:member'];
    }

    public function postPokemon($arraybody)
    {
        $response = $this->client->request('POST', 'pokemon', [RequestOptions::JSON => $arraybody ]);
        return  $response->getStatusCode();
    }

}