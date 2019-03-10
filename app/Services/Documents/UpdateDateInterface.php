<?php


namespace App\Services\Documents;


interface UpdateDateInterface
{
    public function getDocsUpdatedAt($lang, $version, $doc);
}