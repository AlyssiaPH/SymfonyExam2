<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Team;

class TeamDetailsController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * ProductController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/teams/{teamName}", name="team_details")
     * @param string $teamName
     * @return Response
     */
    public function index(string $teamName)
    {
        $team = $this->entityManager->getRepository(Team::class)->getTeamByName($teamName);
        return $this->render('team_details/index.html.twig', [
            'controller_name' => 'TeamDetailsController', "team" =>$team,
        ]);
    }
}
