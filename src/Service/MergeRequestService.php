<?php


namespace App\Service;


use Gitlab\Client;

class MergeRequestService
{
    public function getMergeRequest(Client $client)
    {
        $projects = $client->projects()->all(["owned" => true]);

        for ($i = 0; $i < count($projects); $i++) {
            $mergeRequests[] = $client->mergeRequests()->all($projects[$i]["id"]);
        }
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