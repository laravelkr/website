<?php


namespace App\Services\AllContributors;

use GuzzleHttp\Client;
use stdClass;

class Contributors
{
    /**
     * @var EmojiConverter
     */
    protected $emojiConverter;

    /*
    * git Contributor
    */
    private $ContributorUrls = [
        'docs' => 'https://raw.githubusercontent.com/laravelkr/docs/master/.all-contributorsrc',
        'website' => 'https://raw.githubusercontent.com/laravelkr/website/master/.all-contributorsrc',
    ];

    private $ContributorDatas = [];

    /**
     * @var Client
     */
    private $guzzle;


    public function __construct(Client $guzzle, EmojiConverter $emojiConverter)
    {
        $this->guzzle = $guzzle;
        $this->emojiConverter = $emojiConverter;
    }

    public function getHtml(): string
    {
        $this->getContributorDatas();

        $html = $this->convertHtml();

        return $html;
    }

    private function getContributorDatas()
    {
        foreach ($this->ContributorUrls as $contributorUrl) {
            array_walk(json_decode($this->getDefaultData($contributorUrl))->contributors, [$this, 'Contributors']);
        }
    }

    private function Contributors($res): bool
    {
        if (key_exists($res->login, $this->ContributorDatas)) {
            $this->ContributorDatas[$res->login]->contributions =
                array_merge(
                    $this->ContributorDatas[$res->login]->contributions,
                    $res->contributions
                );
            return false;
        }

        $this->ContributorDatas[$res->login] = $res;
        return true;
    }

    /**
     * @return string
     */
    private function getDefaultData(string $url): string
    {
        return $this->guzzle->get($url)->getBody()->getContents();
    }

    private function convertHtml(): string
    {
        $return = "";

        foreach ($this->ContributorDatas as $contributor) {
            $return .= "<div><a href=\"{$contributor->profile}\" target='_blank'><img src=\"{$contributor->avatar_url}\" width=\"100px;\" alt=\"{$contributor->name}\"><br><sub><b>{$contributor->name}</b></sub></a><br />";

            foreach ($contributor->contributions as $contribution) {
                $return .= "<span title='{$contribution}'>";
                $return .= $this->emojiConverter->convert($contribution);
                $return .= "</span>";
            }
            $return .= "</div>";
        }

        return $return;
    }
}
