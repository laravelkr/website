<?php


namespace App\Services\Documents;


interface UpdateDateInterface
{
    public function getDocsUpdatedAt(string $lang, string $version, string $doc);
}
