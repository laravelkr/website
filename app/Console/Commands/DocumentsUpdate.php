<?php

namespace App\Console\Commands;

use App\Services\Documents\UpdateInterface;
use Illuminate\Console\Command;

class DocumentsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'docs:update';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Laravel 번역 문서를 최신버전으로 업데이트합니다.';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @param UpdateInterface $docsUpdater
     * @return mixed
     */
    public function handle(UpdateInterface $docsUpdater)
    {
        $docsUpdater->updateOnlyKoreanManualGit();
        $docsUpdater->updateWithKoreanManualGit();
    }
}
