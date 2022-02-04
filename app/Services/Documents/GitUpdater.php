<?php

namespace App\Services\Documents;

use App\Exceptions\BadArgumentsException;
use File;
use Symfony\Component\Console\Output\ConsoleOutput;

class GitUpdater implements UpdateInterface
{

    /**
     * @var string[]
     */
    private array $versions = [];

    public function __construct(protected ConsoleOutput $console, protected Location $location)
    {
        $this->versions = array_keys(config('docs.versions'));
    }

    /**
     * @throws BadArgumentsException
     */
    public function updateOnlyKoreanManualGit(): void
    {
        $this->location->setLanguage("ko");
        $this->updateAllVersion();
    }

    /**
     * @throws BadArgumentsException
     */
    public function updateWithKoreanManualGit(): void
    {
        $this->location->setLanguage("en");
        $this->updateAllVersion();
    }

    public function updateBaseGit(): void
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


    private function getVersionDirectoryPath(string $version): string
    {
        $this->location->setVersion($version);
        return $this->location->getVersionLocation();
    }

    private function getVersionBranch(string $version): string
    {
        $this->location->setVersion($version);
        return $this->location->getBranch();
    }


    private function updateDocument($version): void
    {
        $this->console->writeln(exec(sprintf("cd %s && git checkout %s && git pull 2>&1",
                $this->getVersionDirectoryPath($version),
                $this->getVersionBranch($version)
            ))
        );
    }

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
