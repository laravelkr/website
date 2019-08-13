<?php


namespace App\Services\AllContributors;

use GuzzleHttp\Client;

class Contributors
{
    /**
     * @var EmojiConverter
     */
    protected $emojiConverter;

    /*
     * git Contributor
     */
    private $ContributorUrl = [
        'docs' => 'https://raw.githubusercontent.com/laravelkr/docs/master/.all-contributorsrc',
        'website' => 'https://raw.githubusercontent.com/laravelkr/website/master/.all-contributorsrc',
    ];

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
        $DefaultData = [];
        foreach ($this->ContributorUrl as $site => $url) {
            $contributors = json_decode($this->getDefaultData($url))->contributors;

            foreach ($contributors as $contributor) {

                // 연관 배열을 합치기 위한 작업.
                if (key_exists($contributor->login, $DefaultData)) {
                    $temp = array_merge($DefaultData[$contributor->login]->contributions, $contributor->contributions);
                    $DefaultData[$contributor->login]->contributions = $temp;
                    continue;
                }

                $DefaultData[$contributor->login] = $contributor;
            }
        }

        $html = $this->convertHtml($DefaultData);

        return $html;
    }


    /**
     * guzzle을 통한 배열 가져오기,
     *
     * @param string $url
     * @return string
     */
    private function getDefaultData(string $url): string
    {
        return $this->guzzle->get($url)->getBody()->getContents();
    }

    /**
     *
     *
     * @param array $contributors
     * @return string
     * @throws \Exception
     */
    private function convertHtml(array $contributors): string
    {
        $return = "";

        foreach ($contributors as $contributor) {
            $return .= "<div><a href=\"{$contributor->profile}\" target='_blank'><img src=\"{$contributor->avatar_url}\" width=\"100px;\" alt=\"{$contributor->name}\"><br><sub><b>{$contributor->name}</b></sub></a><br />";

            try {
                foreach ($contributor->contributions as $contribution) {
                    $return .= "<span title='{$contribution}'>";
                    $return .= $this->emojiConverter->convert($contribution);
                    $return .= "</span>";
                }
            } catch (\Exception $exception) {
                // emoji가 정상적으로 변경이 되지않은 경우 .. 따로 노출할 부분은 없으므로,
            }

            $return .= "</div>";
        }

        return $return;
    }
}
