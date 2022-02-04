<?php

namespace App\Services\Documents;

use File;
use Symfony\Component\Console\Output\ConsoleOutput;

class GitInitialize implements InitializeInterface
{

    public function __construct(protected ConsoleOutput $console, protected Location $location)
    {
    }


    public function initialize(): void
    {
        $exitCheckDir = $this->location->getBaseLocation();

        if (File::exists($exitCheckDir)) {
            $this->console->writeln("Docs git already exist");
            return;
        }

        $this->console->writeln("Downloading docs git repository");
        $this->console->writeln(
            exec(sprintf('git clone https://github.com/laravelkr/docs.git %s 2>&1', $exitCheckDir))
        );
    }

}
