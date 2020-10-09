<?php

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Gitlab\Client;

class ProjectService
{
    private $client;
    private $database;
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * @var ProjectRepository
     */

    public function __construct(Client $client, EntityManagerInterface $database, ManagerRegistry $registry)
    {
        $this->client = $client;
        $this->database = $database;
        $this->registry = $registry;
    }

    public function index()
    {

        $projectRepository = new ProjectRepository($this->registry);
        $projectAll = $this->client->projects()->all(["owned" => true]);

        // add to database
        for ($i = 0; $i < count($projectAll); $i++) {
            $project = new Project();
            $project->setIdGit($projectAll[$i]['id']);
            $project->setName($projectAll[$i]['name']);

            if (!$projectRepository->findOneBy(['id_git'=>$project->getIdGit()])) {

                $this->database->persist($project);
                $this->database->flush();

            }

        }
    }
}