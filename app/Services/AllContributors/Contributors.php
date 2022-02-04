<?php


namespace App\Services\AllContributors;

use GuzzleHttp\Client;
use stdClass;

class Contributors
{
    private string $baseUrl = "https://raw.githubusercontent.com/laravelkr/docs/master/.all-contributorsrc";


    public function __construct(protected Client $guzzle, protected EmojiConverter $emojiConverter)
    {
    }

    public function getHtml(): string
    {
        $contributors = $this->getDefaultData();

        $html = $this->convertHtml(json_decode($contributors));

        return $html;
    }

    private function getDefaultData(): string
    {
        return $this->guzzle->get($this->baseUrl)->getBody()->getContents();
    }

    private function convertHtml(stdClass $contributors): string
    {
        $return = "";


        foreach ($contributors->contributors as $contributor) {
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
