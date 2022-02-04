<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 14
 * Time: 오전 1:03
 */

namespace App\Services\Markdown;


use App\Exceptions\BadArgumentsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

abstract class ManualMarkdownProvider
{
    protected string $version;
    protected string $documentFilename;
    protected ?string $parsedDocumentHtml;
    protected ?string $indexDocumentParsedHtml;
    protected string $language;

    public function __construct(
        protected DocumentParser $documentProvider,
        protected SubNavigatorExtractor $subNavigatorExtractor
    ) {
    }

    public function setLanguage(string $language): void
    {
        $this->clearParsedDocumentHtml();
        $this->language = $language;
    }

    protected function clearParsedDocumentHtml(): void
    {
        $this->parsedDocumentHtml = null;
    }

    public function setVersion(string $version): void
    {
        $this->indexDocumentParsedHtml = null;
        $this->version = $version;
    }

    public function setDocumentFilename(string $documentMarkdownFilename): void
    {
        $this->clearParsedDocumentHtml();
        $this->documentFilename = $documentMarkdownFilename;
    }

    /**
     * @return string
     * @throws BadArgumentsException|FileNotFoundException
     */
    public function getContent(): string
    {
        if (empty($this->documentFilename) || empty($this->version)) {
            throw new BadArgumentsException();
        }

        if (empty($this->parsedDocumentHtml)) {
            $html = $this->getMarkDownDocsContent($this->documentFilename);
            $html = $this->beautifyDocument($html);
            $this->parsedDocumentHtml = $html;
        }

        return $this->parsedDocumentHtml;
    }

    /**
     * @param $fileName
     * @return string
     * @throws BadArgumentsException
     * @throws FileNotFoundException
     */
    protected function getMarkDownDocsContent($fileName): string
    {
        $this->documentProvider->setVersion($this->version);
        $this->documentProvider->setLanguage($this->language);

        return $this->documentProvider->getMarkdownDocument($fileName);
    }


    abstract protected function beautifyDocument(string $html): string;
}
