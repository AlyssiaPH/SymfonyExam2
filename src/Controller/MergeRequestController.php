<?php


namespace App\Controller;

use App\Service\MergeRequestService;
use Gitlab\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


class MergeRequestController
{

    /**
     * @var MergeRequestService
     */
    private $mergeRequestService;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var Client
     */
    private $client;


    public function __construct(MergeRequestService $mergeRequestService, Environment $twig, Client $client)
    {
        $this->mergeRequestService = $mergeRequestService;
        $this->twig = $twig;
        $this->client = $client;
    }

    /**
     * @Route("/request", name="request")
     */
    public function getMergeRequest()
    {
        $request = $this->mergeRequestService->getMergeRequest($this->client);
        $content = $this->twig->render('MergeRequest/mergeRequest.html.twig', ['requests' => $request]);
        return new Response($content);
    }

    /**
     * @Route("/projet/{id}", name="projet")
     */
    public function getProjectById(Client $client, $id){
        $projet = $this->mergeRequestService->getProjectId($client, $id);
        //dump($projet); die;
        $content = $this->twig->render('projet/projet.html.twig', ['projet' => $projet]);
        return new Response($content);
    }

    /**
     * @Route("/projets", name="projets")
     */
    public function getProjectsList(Client $client){
        $projets = $this->mergeRequestService->getProjects($client);
        $content = $this->twig->render('projet/projects.html.twig', ['projects' =>$projets]);
        return new Response($content);
    }

}