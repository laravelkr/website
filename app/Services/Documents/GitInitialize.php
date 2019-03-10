<?php

namespace App\Services\Documents;

use File;
use Symfony\Component\Console\Output\ConsoleOutput;

class GitInitialize implements InitializeInterface
{
    /**
     * @var Location
     */
    protected $location;
    private $console;


    /**
     * DocsHandler constructor.
     * @param ConsoleOutput $console
     * @param Location $location
     */
    public function __construct(ConsoleOutput $console, Location $location)
    {
        $this->console = $console;
        $this->location = $location;
    }


    public function initialize()
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
