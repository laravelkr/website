<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 14
 * Time: 오후 12:23
 */

namespace App\Services\Github;


use App\Exceptions\BadArgumentsException;
use App\Exceptions\ContributorNotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
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
     * @throws GuzzleException
     * @throws ContributorNotFoundException
     */
    public function getContributors($fileName): array
    {

        try {

            $contributorsHtml = $this->searchContributors($fileName);
            $contributors = $this->convertHtmlToJson($contributorsHtml);
        } catch (ContributorNotFoundException $exception) {
            $contributors = [];
        }


        return $contributors;

    }

    /**
     * @param  string  $fileName
     * @return string
     * @throws BadArgumentsException
     * @throws ContributorNotFoundException
     * @throws GuzzleException
     */
    private function searchContributors(string $fileName): string
    {

        if (empty($this->branch)) {
            throw new BadArgumentsException();
        }

        try {

            $contributorsUrl = sprintf($this->baseUrl, "pre-kr-".$this->branch, $fileName.".md");


            $res = $this->guzzle->request('GET', $contributorsUrl);

            return $res->getBody()->getContents();
        } catch (ClientException $exception) {
            throw new ContributorNotFoundException();
        }

    }

    private function convertHtmlToJson(string $contributorsHtml): array
    {
        $contributors = [];

        $this->crawler->clear();
        $this->crawler->addHtmlContent($contributorsHtml);


        $this->crawler->filter('a.avatar-link')->each(function (Crawler $node) use (&$contributors) {

            $userId = str_replace("@", "", $node->filter('img')->attr('alt'));
            $userUrl = "https://github.com/".$userId;
            $imageUrl = $node->filter('img')->attr('src');
            $imageUrl = str_replace("s=40&", "s=160&", $imageUrl);
            $contributors[] = (object)[
                'userName' => $userId,
                'userBaseUrl' => $userUrl,
                'userImage' => $imageUrl,
            ];
        });

        if (count($contributors) == 0) {

            $node = $this->crawler->filter('.Details a')->first();


            $userUrl = "https://github.com".$node->attr('href');
            $imageUrl = $node->filter('img')->attr('src');
            $imageUrl = str_replace("s=40&", "s=160&", $imageUrl);
            $contributors[] = (object)[
                'userName' => str_replace("/", "", $node->attr('href')),
                'userBaseUrl' => $userUrl,
                'userImage' => $imageUrl,
            ];


        }

        return $contributors;
    }
}
