<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\ProjectRepository;
use App\Repository\TeamRepository;
use App\Service\MergeRequestService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Gitlab\Client;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/team")
 */
class TeamController extends AbstractController
{
    private $client;
    private $database;
    /**
     * @var ManagerRegistry
     */
    private $registry;

    public function __construct(Client $client, EntityManagerInterface $database, ManagerRegistry $registry)
    {
        $this->client = $client;
        $this->database = $database;
        $this->registry = $registry;
    }


    /**
     * @Route("/", name="team_index", methods={"GET"})
     */
    public function index(TeamRepository $teamRepository)
    {
        $project = new \ProjectService($this->client, $this->database, $this->registry);
        $project->index();
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="team_new", methods={"GET","POST"})
     */
    public function newTeam(Request $request)
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('team_index');
        }

        return $this->render('team/new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_show", methods={"GET"})
     */
    public function showTeam(Team $team)
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
            'merges' => $team->getProjects(),
        ]);
    }

    /**
     * @Route("/merges/{id_team}/{id_project}", name="team_showMerges", methods={"GET"})
     */
    public function showTeamMerge(int $id_team, int $id_project)
    {
        $merge = New MergeRequestService();
        $mergeRequests = $merge->getMergeRequestFromprojectId($this->client, $id_project);

        return $this->render('team/showMerges.html.twig', [
            'merges' => $mergeRequests,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="team_edit", methods={"GET","POST"})
     */
    public function editTeam(Request $request, Team $team): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('team_index');
        }

        return $this->render('team/edit.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_delete", methods={"DELETE"})
     * @param Request $request
     * @param Team $team
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteTeam(Request $request, Team $team)
    {
        if ($this->isCsrfTokenValid('delete' . $team->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('team_index');
    }
}
