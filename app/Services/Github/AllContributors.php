<?php


namespace App\Services\Github;


use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class AllContributors
{


    /**
     * @var string
     */
    private $baseUrl = "https://raw.githubusercontent.com/laravelkr/docs/master/README.md";
    /**
     * @var Crawler
     */
    private $crawler;
    /**
     * @var Client
     */
    private $guzzle;


    public function __construct(Client $guzzle, Crawler $crawler)
    {
        $this->guzzle = $guzzle;
        $this->crawler = $crawler;
    }

    public function getHtml(): string
    {

        $readme = $this->guzzle->get($this->baseUrl)->getBody()->getContents();

        $readme = $this->filterContributors($readme);

        return $readme;
    }

    private function filterContributors(string $readme): string
    {

        $readme = explode("<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->", $readme);

        $readme = explode("<!-- ALL-CONTRIBUTORS-LIST:END -->", $readme[1]);

        return $readme[0];


    }
}