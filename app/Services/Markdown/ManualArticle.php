<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 14
 * Time: 오전 1:03
 */

namespace App\Services\Markdown;


class ManualArticle extends ManualMarkdownProvider
{


    protected function beautifyDocument(string $content): string
    {
        return Beautifier::beautifyArticle($content);
    }


    public function getSubTableContent(): string
    {
        return $this->subNavigatorExtractor->extract($this->parsedDocumentHtml);
    }


}
