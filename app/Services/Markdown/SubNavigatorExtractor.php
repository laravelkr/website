<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 28
 * Time: 오후 2:19
 */

namespace App\Services\Markdown;


use App\Exceptions\BadArgumentsException;
use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

class SubNavigatorExtractor
{

    /**
     * @var Crawler
     */
    private $crawler;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @param string $bodyHtml
     * @return string
     * @throws BadArgumentsException
     */
    public function extract(string $bodyHtml): string
    {

        if (empty($bodyHtml)) {
            throw new BadArgumentsException();
        }

        $this->crawler->clear();
        $this->crawler->addHtmlContent($bodyHtml);
        try {
            return $this->crawler->filter('h1+ul')->html();
        } catch (InvalidArgumentException $exception) {
        }

        return "";
    }


}