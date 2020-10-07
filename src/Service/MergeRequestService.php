<?php


namespace App\Service;


use Gitlab\Client;

class MergeRequestService
{
    public function getMergeRequest(Client $client)
    {
        $projects = $client->projects()->all(["owned" => true]);
        for ($i = 0; $i < count($projects); $i++){
            $mergeRequests[] = $client->mergeRequests()->all($projects[$i]["id"]);
        }
       // dump($mergeRequests); die;
        return $mergeRequests;
    }
}