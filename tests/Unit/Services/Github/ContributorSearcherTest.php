<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 14
 * Time: 오전 1:49
 */

namespace Tests\Unit\Services\Github;


use App\Services\Github\ContributorSearcher;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Tests\TestCase;

class ContributorSearcherTest extends TestCase
{


    /**
     * @expectedException \App\Exceptions\BadArgumentsException
     */
    public function test_브랜치를_지정하지_않을_경우_예외발생확인()
    {
        $contributorSearcher = new ContributorSearcher(new Client(), new Crawler());

        $contributorSearcher->getContributors('documentation');
    }


    public function test_정상확인()
    {

        $contributorSearcher = new ContributorSearcher(new Client(), new Crawler());

        $contributorSearcher->setBranch(config('docs.default'));
        $contributors = $contributorSearcher->getContributors('documentation');

        $this->assertTrue(is_array($contributors));
    }

}