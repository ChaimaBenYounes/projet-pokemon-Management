<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\ClientGuzzleHttp;

class PokemonController extends AbstractController
{
    private $clientGuzzleHttp;

    public function __construct(ClientGuzzleHttp $clientGuzzleHttp)
    {
        $this->clientGuzzleHttp = $clientGuzzleHttp;
    }

    /**
     * @Route("/token", name="api-pokemon-get-token")
     */
    public function getTokens(){
        $response = $this->clientGuzzleHttp->getTokenFromApi();
        dd($response);
    }

    /**
     * @Route("/pokemon", name="api-pokemon")
     */
    public function getAllPokemon()
    {
        /*if (!$pokemons = $this->clientGuzzleHttp->getAllPokemon()) {
            return null;
        }*/
        return $this->render('api/pokemon.html.twig', [
            'pokemons' =>  $this->clientGuzzleHttp->getAllPokemon(),
        ]);
    }

    /**
     * @Route("/pokemon/post", name="api-pokemon-post")
     */
    public function postPokemon()
    {
        $arraybody = ['nom' => 'pokemon1'];
        return $this->render('api/index.html.twig', [
            'status' =>  $this->clientGuzzleHttp->postPokemon($arraybody),
        ]);
    }
}


