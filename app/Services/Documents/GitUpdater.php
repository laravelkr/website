<?php

namespace App\Services\Documents;

use App\Exceptions\BadArgumentsException;
use File;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

class GitUpdater implements UpdateInterface
{
    /**
     * @var Location
     */
    protected $location;
    /**
     * @var Command
     */
    private $console;

    /**
     * @var string[]
     */
    private $versions = [];

    private $branchPrefix = "";

    /**
     * DocsHandler constructor.
     * @param ConsoleOutput $console
     * @param Location $location
     */
    public function __construct(ConsoleOutput $console, Location $location)
    {
        $this->console = $console;
        $this->location = $location;
        $this->versions = array_keys(config('docs.versions'));
    }

    /**
     * @throws BadArgumentsException
     */
    public function updateOnlyKoreanManualGit()
    {

        $this->location->setLanguage("ko");
        $this->updateAllVersion();
    }

    /**
     * @throws BadArgumentsException
     */
    public function updateWithKoreanManualGit()
    {

        $this->location->setLanguage("en");
        $this->updateAllVersion();
    }

    public function updateBaseGit()
    {

        $exitCheckDir = $this->location->getBaseLocation();

        if (!File::exists($exitCheckDir)) {
            $this->console->writeln("Docs git not exist");
            return;
        }

        $this->console->writeln("Update start base repository");
        $this->console->writeln(
            exec(sprintf('cd %s && git pull origin 2>&1', $exitCheckDir))
        );
        $this->console->writeln("Update end base repository");
    }

    protected function updateAllVersion(): void
    {
        foreach ($this->versions as $version) {

            $this->location->setVersion($version);

            $this->initializeVersionDirectory($version);
            $this->console->writeln("Update start $version");
            $this->updateDocument($version);
            $this->console->writeln("Update end $version");
        }
    }


    /**
     * @param $version
     * @return string
     */
    private function getVersionDirectoryPath($version): string
    {

        $this->location->setVersion($version);
        return $this->location->getVersionLocation();
    }

    private function getVersionBranch($version)
    {
        $this->location->setVersion($version);
        return $this->location->getBranch($version);
    }


    private function updateDocument($version)
    {
        $this->console->writeln(exec(sprintf("cd %s && git checkout %s && git pull 2>&1",
                $this->getVersionDirectoryPath($version),
                $this->getVersionBranch($version)
            ))
        );
    }

    /**
     * @param string $version
     */
    protected function initializeVersionDirectory(string $version): void
    {
        $gitDir = $this->location->getBaseLocation();
        $exitCheckDir = $this->getVersionDirectoryPath($version);
        if (File::exists($exitCheckDir)) {
            $this->console->writeln("Already exists Version $version Directory");
            return;
        }

        $this->console->writeln("Copy Version $version Directory");
        $this->console->writeln(exec(sprintf('cp -Rf %s %s 2>&1', $gitDir, $exitCheckDir)));
    }

}
