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


        /*dd($this->client->request('POST', 'tokens', [RequestOptions::FORM_PARAMS =>
            ['email' => 'users_0@test.com',
                'password' => 'pwd123']
        ]));*/
       
        //https://symfony.com/doc/current/components/serializer.html
        $this->serializer = new Serializer(
            [new GetSetMethodNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );
    }

    public function getTokenFromApi(){

        $response = $this->client->request('POST', 'tokens', [RequestOptions::FORM_PARAMS =>
            ['email' => 'users_0@test.com',
                'password' => 'pwd123']
        ]);

        $body = $response->getBody()->getContents();
        $token =  json_decode($body)->{'token'};

        return $token;
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
        dd($oPokemon);
        return $oPokemon;
    }

    public function postPokemon($arraybody)
    {
        $response = $this->client->request('POST', 'pokemon', [RequestOptions::JSON => $arraybody ]);
        return  $response->getStatusCode();
    }

}