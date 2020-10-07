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
        $requests = [];
        for($i= 0; $i<count($request); $i++){
            array_push($requests, $request[$i]);
        }
            dump($requests); die;

        $content = $this->twig->render('MergeRequest/mergeRequest.html.twig', ['requests' => $requests]);
        return new Response($content);

    }
}