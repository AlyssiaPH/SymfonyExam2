<?php


namespace App\Controller;


use Gitlab\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{

    /**
     * @Route ("/api", name="api")
     */
    public function request(Client $client)
    {
        $issues = $client->projects()->all();
        dump($issues); die;
    }
    /**
     * @Route ("/home", name="home")
     */
    public function home(){
        $content = "<h1> COUCOU </h1>";
        return new Response($content);
    }
}