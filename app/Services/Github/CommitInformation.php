<?php


namespace App\Services\Github;


use GuzzleHttp\Client;

class CommitInformation
{

    /**
     * @var Client
     */
    private $client;
    private $baseUrl = "https://api.github.com/repos/%s/%s/commits?sha=%s&path=%s&page=1&per_page=1";


    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function getLastCommitDate($owner, $repo, $branch, $file)
    {
        $url = sprintf($this->baseUrl, $owner, $repo, urlencode($branch), urlencode($file));
        $result = $this->client->get($url, [
            'headers' => [
                "Authorization" => "token " . config('github.token'),
            ],
        ])->getBody()->getContents();


        $json = json_decode($result);

        $date = $json[0]->commit->author->date;

        return $date;
    }
}