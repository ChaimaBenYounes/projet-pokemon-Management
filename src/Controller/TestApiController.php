<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
        /*if (!$pokemons = $this->clientGuzzleHttp->getAllPokemon()) {
            return null;
        }*/
        return $this->render('test_api/pokemon.html.twig', [
            'pokemons' =>  $this->clientGuzzleHttp->getAllPokemon(),
        ]);
    }

    /**
     * @Route("/pokemon/post", name="api-pokemon-post")
     */
    public function postPokemon()
    {
        $arraybody = ['nom' => 'pokemon1'];
        return $this->render('test_api/index.html.twig', [
            'status' =>  $this->clientGuzzleHttp->postPokemon($arraybody),
        ]);
    }
}


