<?php

namespace App\Console\Commands;

use App\Services\Documents\InitializeInterface;
use Illuminate\Console\Command;

class DocumentsInitialize extends Command
{
    protected $signature = 'docs:initialize';

    protected $description = 'Laravel 번역 문서를 다운로드합니다.';

    public function handle(InitializeInterface $docsDownloader): void
    {
        $docsDownloader->initialize();
    }
}
