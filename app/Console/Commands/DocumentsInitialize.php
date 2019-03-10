<?php

namespace App\Console\Commands;

use App\Services\Documents\InitializeInterface;
use Illuminate\Console\Command;

class DocumentsInitialize extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'docs:initialize';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Laravel 번역 문서를 다운로드합니다.';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @param InitializeInterface $docsDownloader
     * @return mixed
     */
    public function handle(InitializeInterface $docsDownloader)
    {
        $docsDownloader->initialize();

    }
}
