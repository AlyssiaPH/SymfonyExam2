<?php

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Gitlab\Client;

class ProjectService
{
    private $client;
    private $database;

    public function __construct(Client $client, EntityManagerInterface $database)
    {
        $this->client = $client;
        $this->database = $database;
    }

    public function index() {
        $projectAll = $this->client->projects()->all(["owned" => true]);


        // add to database
        for ($i = 0; $i < count($projectAll); $i++)
        {
            $project = new Project();
            $project->setIdGit($projectAll[$i]['id']);
            $this->database->persist($project);
            $this->database->flush();
        }
    }
}