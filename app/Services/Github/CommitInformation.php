<?php


namespace App\Services\Github;


use App\Exceptions\CommitInformationNotFoundException;
use Exception;
use GuzzleHttp\Client;

class CommitInformation
{

    private string $baseUrl = "https://api.github.com/repos/%s/%s/commits?sha=%s&path=%s&page=1&per_page=1";


    public function __construct(protected Client $client)
    {
    }


    public function getLastCommitDate($owner, $repo, $branch, $file): string
    {
        try {
            $url = sprintf($this->baseUrl, $owner, $repo, urlencode($branch), urlencode($file));
            $result = $this->client->get($url, [
                'headers' => [
                    "Authorization" => "token ".config('github.token'),
                ],
            ])->getBody()->getContents();


            $json = json_decode($result);

            if (empty($json)) {
                throw new CommitInformationNotFoundException();
            }

            $date = $json[0]->commit->author->date;

            return $date;
        } catch (Exception) {
            throw new CommitInformationNotFoundException();
        }
    }
}
