<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 14
 * Time: 오전 1:03
 */

namespace App\Services\Markdown;


use App\Exceptions\BadArgumentsException;

abstract class ManualMarkdownProvider
{
    protected $version;
    protected $documentFilename;
    protected $indexDocumentName = "documentation";
    /**
     * @var DocumentParser
     */
    protected $documentProvider;
    /**
     * @var SubNavigatorExtractor
     */
    protected $subNavigatorExtractor;
    protected $parsedDocumentHtml;
    protected $indexDocumentParsedHtml;
    protected $language;

    public function __construct(
        DocumentParser $documentProvider,
        SubNavigatorExtractor $subNavigatorExtractor
    ) {
        $this->documentProvider = $documentProvider;
        $this->subNavigatorExtractor = $subNavigatorExtractor;
    }

    /**
     * @param string $language
     * @throws BadArgumentsException
     */
    public function setLanguage(string $language)
    {
        $this->clearParsedDocumentHtml();
        $this->language = $language;
    }

    protected function clearParsedDocumentHtml()
    {
        $this->parsedDocumentHtml = null;
    }

    public function setVersion(string $version)
    {
        $this->indexDocumentParsedHtml = null;
        $this->version = $version;
    }

    public function setDocumentFilename(string $documentMarkdownFilename)
    {

        $this->clearParsedDocumentHtml();
        $this->documentFilename = $documentMarkdownFilename;
    }

    /**
     * @return string
     * @throws BadArgumentsException
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

    protected function getMarkDownDocsContent($fileName)
    {
        $this->documentProvider->setVersion($this->version);
        $this->documentProvider->setLanguage($this->language);

        return $this->documentProvider->getMarkdownDocument($fileName);
    }


    abstract protected function beautifyDocument(string $html): string;
}
