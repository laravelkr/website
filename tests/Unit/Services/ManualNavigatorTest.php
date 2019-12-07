<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 14
 * Time: 오전 1:49
 */

namespace Tests\Unit\Services;


use App\Services\Markdown\DocumentParser;
use App\Services\Markdown\ManualNavigator;
use App\Services\Markdown\SubNavigatorExtractor;
use Tests\TestCase;

class ManualNavigatorTest extends TestCase
{
    /**
     * @var ManualNavigator
     */
    private $navigator;

    protected function setUp():void
    {
        parent::setUp();

        $this->navigator = new ManualNavigator($this->app->make(DocumentParser::class),
            $this->app->make(SubNavigatorExtractor::class)
        );

    }

    /**
     * @test
     */
    public function 버전을_지정하지_않을_경우_예외발생확인()
    {

        $this->expectException(\App\Exceptions\BadArgumentsException::class);
        $this->navigator->getContent();
    }

    /**
     * @test
     */
    public function 문서의_이름을_변경하려고_할_경우_예외발생확인()
    {

        $this->expectException(\Symfony\Component\HttpKernel\Exception\BadRequestHttpException::class);

        $this->navigator->setLanguage('ko');
        $this->navigator->setVersion(config('docs.default'));
        $this->navigator->setDocumentFilename('documentation');

    }


    /**
     * @test
     */
    public function 정상문서파일확인()
    {

        $this->navigator->setLanguage('ko');
        $this->navigator->setVersion(config('docs.default'));

        $contents = $this->navigator->getContent();
        $this->assertTrue(is_string($contents));
    }

}
