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

    /**
     * ClientGuzzleHttp constructor.
     * @param $base_uri
     */
    public function __construct($base_uri)
    {
        $this->client = new Client(['base_uri' => $base_uri, 'timeout'  => 2.0 ]);
       
        //https://symfony.com/doc/current/components/serializer.html
        $this->serializer = new Serializer(
            [new GetSetMethodNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );
    }

    /**
     * @return array|null
     */
    public function getAllPokemon()
    {
        $oPokemon = [];

        try {
            $response = $this->client->request('GET', 'pokemon');
            $oPokemon = $this->serializer->denormalize(
                json_decode($response->getBody()->getContents(), true)['hydra:member'],
                'App\Entity\Pokemon[]',
                'json'
            );
        } catch (\Exception $ex) {
            //log some error here
            return null;
        }

        return $oPokemon;
    }

    public function postPokemon($arraybody)
    {
        $response = $this->client->request('POST', 'pokemon', [RequestOptions::JSON => $arraybody ]);
        return  $response->getStatusCode();
    }

}