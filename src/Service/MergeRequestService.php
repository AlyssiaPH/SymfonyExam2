<?php


namespace App\Service;


use Gitlab\Client;

class MergeRequestService
{
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

    public function getProjectId(Client $client, int $id)
    {
        $projects = $client->projects()->all(["owned" => true]);
            $project = $projects([$id]["id"]);
            dump($project); die;
        return $project;
    }
}