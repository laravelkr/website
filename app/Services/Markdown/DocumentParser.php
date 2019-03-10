<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 28
 * Time: 오후 2:09
 */

namespace App\Services\Markdown;


use App\Services\Documents\Location;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Parsedown;

class DocumentParser
{
    /**
     * @var Location
     */
    private $location;
    private $parseDown;

    private $version;
    private $language;

    public function __construct(Parsedown $parseDown, Location $location)
    {
        $this->parseDown = $parseDown;
        $this->location = $location;
    }


    /**
     * @param string $filename
     * @return string
     * @throws FileNotFoundException
     * @throws \App\Exceptions\BadArgumentsException
     */
    public function getMarkdownDocument(string $filename): string
    {

        $this->location->setVersion($this->version);
        $this->location->setLanguage($this->language);
        $fileLocation = $this->location->getFileLocation($filename);

        if (!File::exists($fileLocation)) {
            throw new FileNotFoundException();
        }

        $fileContent = file_get_contents($fileLocation);

        $replacedVersionText = $this->replaceVersionText($fileContent);
        $parsedContent = $this->parsingMarkdown($replacedVersionText);


        return $parsedContent;
    }


    /**
     * @param string $fileContent
     * @return string
     */
    private function replaceVersionText(string $fileContent): string
    {
        return str_replace('{{version}}', $this->version, $fileContent);
    }

    private function parsingMarkdown(string $markdown)
    {

        return $this->parseDown->parse($markdown);
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }


}