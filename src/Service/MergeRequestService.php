<?php

namespace App\Service;

use Gitlab\Client;

class MergeRequestService
{
    /**
     * @param Client $client
     * @return mixed All the merge requests from the client
     */
    public function getMergeRequest(Client $client)
    {
        $projects = $client->projects()->all(["owned" => true]);
        for ($i = 0; $i < count($projects); $i++) {
            $projectRequests = $client->mergeRequests()->all($projects[$i]["id"]);
            for ($y=0; $y <count($projectRequests); $y++)
            {
                $mergeRequests[] = $projectRequests[$y];
            }
        }
        //dump ($mergeRequests); die;
        return $mergeRequests;
    }

    /**
     * @param Client $client
     * @param $idProject The id of the project
     * @return mixed All the requests from the client in a project
     */
    public function getMergeRequestFromproject(Client $client, $idProject)
    {
        $projects = $client->projects()->all(["owned" => true]);
            $projectRequests = $client->mergeRequests()->all($projects["gitLabId"]["id"]);
        return $projectRequests;
    }

    /**
     * @param Client $client
     * @param $idProject The id of the project
     * @return mixed All the requests from the client in a project
     */
    public function getMergeRequestFromprojectId(Client $client, $idProject)
    {
       $mergeRequest = $client->mergeRequests()->all($idProject);
       return $mergeRequest;
    }

    public function getProjectId(Client $client, int $id)
    {
        $projects = $client->projects()->all(["owned" => true]);
            $project = $projects[$id];
            //dump($project); die;
        return $project;
    }

    public function getProjects(Client $client){
        $projects = $client->projects()->all(["owned" => true]);
        return $projects;
    }
}