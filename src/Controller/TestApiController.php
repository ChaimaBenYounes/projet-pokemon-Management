<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\RequestOptions;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Service\ClientGuzzleHttp;

class TestApiController extends AbstractController
{
    private $clientGuzzleHttp;

    public function __construct(ClientGuzzleHttp $clientGuzzleHttp)
    {
        $this->clientGuzzleHttp = $clientGuzzleHttp;
    }

    /**
     * @Route("/pokemon", name="api-pokemon")
     */
    public function getAllPokemon()
    {
        $response = $this->clientGuzzleHttp->getClientGuzzleHttp()->request('GET', 'pokemon');
        $response = json_decode($response->getBody()->getContents(), true);
        
        return $this->render('test_api/pokemon.html.twig', [
            'pokemons' =>  $response['hydra:member'],
        ]);
    }

    /**
     * @Route("/pokemon/post", name="api-pokemon-post")
     */
    public function postPokemon()
    {
        $response = $this->client->request('POST', 'pokemon', [RequestOptions::JSON => ['nom' => 'namepokemon'] ]);
    
        return $this->render('test_api/index.html.twig', [
            'status' =>  $response->getStatusCode(),
        ]);
    }

     /**
     * @Route("/pokemon/post/{id}", name="api-pokemon-delete")
     */
    public function deletePokemon()
    {
       /*
       $response = $this->client->request('Delete', 'pokemon', [RequestOptions::JSON => ['nom' => 'namepokemon'] ]);
    
        return $this->render('test_api/index.html.twig', [
            'status' =>  $response->getStatusCode(),
        ]);
        */
    }

}


