<?php

namespace Tests\Unit\Services\AllContributors;

use App\Services\AllContributors\TakeGitContributors;
use GuzzleHttp\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TakeGitContributorsTest extends TestCase
{
    public function testGetGitHubResponce()
    {
        $data = new TakeGitContributors(new Client());

        $response = $data->getDefaultData();

        $this->assertCount(
            2,
            $response,
            'TakeGitContributors Count Check Error'
        );
    }
}
