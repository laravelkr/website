<?php


namespace App\Services\Documents;


use App\Exceptions\BadArgumentsException;

class Location
{
    public const SUPPORT_LANGUAGES = ['ko', 'en',];

    private string $docsPath;
    private string $basePath;

    private string $version;

    private string $language;
    private array $branchPrefix = [
        'ko' => 'kr-',
        'en' => 'pre-kr-',
    ];

    public function __construct()
    {
        $this->docsPath = resource_path(config('docs.resource_root'));
        $this->basePath = config('docs.basePath');
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @param  string  $language
     * @throws BadArgumentsException
     */
    public function setLanguage(string $language): void
    {
        if (!in_array($language, self::SUPPORT_LANGUAGES)) {
            throw new BadArgumentsException("지원하지 않는 언어입니다");
        }
        $this->language = $language;
    }


    public function getBaseLocation(): string
    {
        return sprintf("%s/%s", $this->docsPath, $this->basePath);
    }

    public function getVersionLocation(): string
    {
        return sprintf("%s/%s", $this->docsPath, $this->getBranch());
    }


    public function getFileLocation(string $fileName): string
    {
        if ($fileName === "README") {
            $path = $this->getBaseLocation();
        } else {
            $path = $this->getVersionLocation();
        }


        return sprintf("%s/%s.md", $path, $fileName);
    }


    public function getBranch(): string
    {
        return sprintf("%s%s", $this->branchPrefix[$this->language], $this->version);
    }

}
