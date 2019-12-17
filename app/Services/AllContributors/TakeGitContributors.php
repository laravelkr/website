<?php

namespace App\Services\AllContributors;

use GuzzleHttp\Client;

class TakeGitContributors
{
    private $guzzle;

    private $contributorDatas = [];

    private $contributorUrls = [
        'docs' => 'https://raw.githubusercontent.com/laravelkr/docs/master/.all-contributorsrc',
        'website' => 'https://raw.githubusercontent.com/laravelkr/website/master/.all-contributorsrc',
    ];

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function getDefaultData(): array
    {
        try {
            foreach ($this->contributorUrls as $tpye => $contributorUrl) {
                $this->contributorDatas[$tpye] = $this->getGitHubData($contributorUrl);
            }
        } catch (\Exception $exception) {
            $this->contributorDatas = [];
        }

        return $this->contributorDatas;
    }

    private function getGitHubData($url)
    {
        return $this->guzzle->get($url)->getBody()->getContents();
    }
}
