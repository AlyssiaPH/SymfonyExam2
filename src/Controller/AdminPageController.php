<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPageController extends AbstractController
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
     * @Route("/adminpage", name="admin_page")
     */
    public function index(Request $request)
    {
        $team= new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            dump($team);
            $this->entityManager->persist($team);
            // actually executes the queries (i.e. the INSERT query)
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_page');
        }
        $teamsList = $this->entityManager->getRepository(Team::class)->getTeams();

        return $this->render('admin_page/index.html.twig', [
            'controller_name' => 'AdminPageController', 'form' => $form->createView(),"teamsList" => $teamsList,
        ]);
    }
}
