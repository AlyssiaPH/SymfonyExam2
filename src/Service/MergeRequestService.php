<?php


namespace App\Service;


use Gitlab\Client;

class MergeRequestService
{
    public function getRequest(Client $client)
    {
        $issues = $client->projects()->all();
        return $issues;
    }
}