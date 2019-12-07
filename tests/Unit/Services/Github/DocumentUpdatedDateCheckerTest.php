<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 14
 * Time: 오전 11:26
 */

namespace Tests\Unit\Services\Github;

use App\Services\Github\UpdatedDateChecker;
use App\Services\Github\CommitInformation;
use GuzzleHttp\Client;
use Tests\TestCase;

class DocumentUpdatedDateCheckerTest extends TestCase
{

    /**
     * @test
     */
    public function 문서_업데이트일자_확인()
    {

        $documentUpdatedDateChecker = new UpdatedDateChecker(new CommitInformation(new Client()));

        $updatedDate = $documentUpdatedDateChecker->getDocsUpdatedAt('kr', config('docs.default'), 'readme');

        $this->assertTrue((bool)strtotime($updatedDate));

        $updatedDate = $documentUpdatedDateChecker->getDocsUpdatedAt('en', config('docs.default'), 'readme');

        $this->assertTrue((bool)strtotime($updatedDate));

    }


    /**
     * @test
     */
    public function 지원하지않는_문서요청_예외확인()
    {
        $this->expectException(\App\Exceptions\NotSupportedLanguageException::class);
        $documentUpdatedDateChecker = new UpdatedDateChecker(new CommitInformation(new Client()));
        $documentUpdatedDateChecker->getDocsUpdatedAt('jp', config('docs.default'), 'readme');
    }

}
