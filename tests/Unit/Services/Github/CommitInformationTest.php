<?php

namespace Tests\Unit\Services\Github;

use App\Services\Github\CommitInformation;
use GuzzleHttp\Client;
use Tests\TestCase;

class CommitInformationTest extends TestCase
{

    public function testGetLastCommitDate()
    {

        $commitInformation = new CommitInformation(new Client());


        $date = $commitInformation->getLastCommitDate('laravelkr','docs','kr-5.5','readme.md');


        $this->assertTrue(is_string($date));

    }
}
