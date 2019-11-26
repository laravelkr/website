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

    /**
     * @var array
     */
    private $contributorUrls = [
        'docs' => 'https://raw.githubusercontent.com/laravelkr/docs/master/.all-contributorsrc',
        'website' => 'https://raw.githubusercontent.com/laravelkr/website/master/.all-contributorsrc',
    ];

    private $contributorDatas = [];

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
        $this->fetchContributorDatas();

        $html = $this->convertHtml();

        return $html;
    }

    private function fetchContributorDatas()
    {
        foreach ($this->contributorUrls as $contributorUrl) {
            array_walk(
                json_decode($this->getDefaultData($contributorUrl))->contributors,
                [$this, 'settingContributors']
            );
        }
    }

    private function settingContributors($res): bool
    {
        $user_id = $res->login;

        if ($this->existsContributor($user_id)) {
            $this->contributorDatas[$user_id]->contributions =
                array_merge(
                    $this->contributorDatas[$user_id]->contributions,
                    $res->contributions
                );

            return false;
        }

        $this->contributorDatas[$user_id] = $res;
        return true;
    }

    private function existsContributor(string $user_id): bool
    {
        return key_exists($user_id, $this->contributorDatas);
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

        foreach ($this->contributorDatas as $contributor) {
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
