<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 28
 * Time: 오후 2:09
 */

namespace App\Services\Markdown;


use App\Exceptions\BadArgumentsException;
use App\Services\Documents\Location;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Parsedown;

class DocumentParser
{

    private string $version;
    private string $language;

    public function __construct(protected Parsedown $parseDown, protected Location $location)
    {
    }


    /**
     * @param  string  $filename
     * @return string
     * @throws FileNotFoundException
     * @throws BadArgumentsException
     */
    public function getMarkdownDocument(string $filename): string
    {
        $this->location->setVersion($this->version);
        $this->location->setLanguage($this->language);
        $fileLocation = $this->location->getFileLocation($filename);

        if (!File::exists($fileLocation)) {
            throw new FileNotFoundException("File Not Found");
        }

        $fileContent = file_get_contents($fileLocation);

        $replacedVersionText = $this->replaceVersionText($fileContent);
        $replacedVersionText = str_replace('```noting','```',$replacedVersionText);
        $parsedContent = $this->parsingMarkdown($markdown);


        return $parsedContent;
    }


    private function replaceVersionText(string $fileContent): string
    {
        return str_replace('{{version}}', $this->version, $fileContent);
    }

    private function parsingMarkdown(string $markdown): string
    {
        return $this->parseDown->parse($markdown);
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }


}
