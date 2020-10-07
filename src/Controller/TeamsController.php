<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Team;

class TeamsController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * ProductController constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/teams", name="teams")
     */
    public function index()
    {
        $teamsList = $this->entityManager->getRepository(Team::class)->getTeams();
        return $this->render('teams/index.html.twig', [
            'controller_name' => 'TeamsController', "teamsList" => $teamsList,
        ]);
    }
}
