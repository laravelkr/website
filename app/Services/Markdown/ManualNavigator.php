<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 14
 * Time: 오전 1:03
 */

namespace App\Services\Markdown;


use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ManualNavigator extends ManualMarkdownProvider
{
    protected string $documentFilename = "documentation";

    public function setDocumentFilename(string $documentMarkdownFilename): void
    {
        throw new BadRequestHttpException("네비게이션 마크다운 파일은 변경할 수 없습니다");
    }


    protected function beautifyDocument(string $content): string
    {
        return Beautifier::beautifyNavigation($content);
    }

}
