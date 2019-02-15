<?php
namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class ClientGuzzleHttp
{
    private $client; 
    private $serializer;

    public function __construct($base_uri)
    {
        $this->client = new Client(['base_uri' => $base_uri, 'timeout'  => 2.0 ]);
       
        //https://symfony.com/doc/current/components/serializer.html
        $this->serializer = new Serializer(
            [new GetSetMethodNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );

    }

    public function getAllPokemon()
    {
        $response = $this->client->request('GET', 'pokemon');
        $responseArray = json_decode($response->getBody()->getContents(), true)['hydra:member'];
        $oPokemon = $this->serializer->denormalize($responseArray, 'App\Entity\Pokemon[]', 'json');
        return $oPokemon;
    }

    public function postPokemon($arraybody)
    {
        $response = $this->client->request('POST', 'pokemon', [RequestOptions::JSON => $arraybody ]);
        return  $response->getStatusCode();
    }

}