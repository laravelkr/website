<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 14
 * Time: 오후 12:23
 */

namespace App\Services\Github;


use App\Exceptions\BadArgumentsException;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ContributorSearcher
{

    /**
     * TODO 정식지원 API 확인 불가, 추후 API 추가시 변경 필요
     * @var string
     */
    private $baseUrl = "https://github.com/laravelkr/docs/contributors/%s/kr/%s";
    /**
     * @var Crawler
     */
    private $crawler;
    /**
     * @var Client
     */
    private $guzzle;
    private $branch;


    public function __construct(Client $guzzle, Crawler $crawler)
    {
        $this->guzzle = $guzzle;
        $this->crawler = $crawler;
    }


    public function setBranch(string $branch)
    {

        $this->branch = $branch;
    }

    /**
     * @param $fileName
     * @return array
     * @throws BadArgumentsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getContributors($fileName): array
    {

        $contributorsHtml = $this->searchContributors($fileName);

        $contributors = $this->convertHtmlToJson($contributorsHtml);

        return $contributors;

    }

    /**
     * @param string $fileName
     * @return string
     * @throws BadArgumentsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function searchContributors(string $fileName): string
    {

        if (empty($this->branch)) {
            throw new BadArgumentsException();
        }

        $contributorsUrl = sprintf($this->baseUrl, "pre-kr-" . $this->branch, $fileName . ".md");


        $res = $this->guzzle->request('GET', $contributorsUrl);

        return $res->getBody()->getContents();

    }

    private function convertHtmlToJson(string $contributorsHtml): array
    {
        $contributors = [];

        $this->crawler->clear();
        $this->crawler->addHtmlContent($contributorsHtml);


        $this->crawler->filter('.list-style-none li')->each(function (Crawler $node) use (&$contributors) {

            $userUrl = "https://github.com" . $node->filter('a')->attr('href');
            $imageUrl = $node->filter('img')->attr('src');
            $imageUrl = str_replace("s=40&", "s=80", $imageUrl);
            $contributors[] = (object)[
                'userName' => trim($node->text()),
                'userBaseUrl' => $userUrl,
                'userImage' => $imageUrl,
            ];
        });


        return $contributors;
    }
}