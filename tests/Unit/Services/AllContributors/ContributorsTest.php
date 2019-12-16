<?php

namespace Tests\Unit;

use App\Services\AllContributors\EmojiConverter;
use GuzzleHttp\Client;
use http\Client\Response;
use Mockery\Mock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\AllContributors\Contributors;


class ContributorsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testGetHtml()
    {
        $contributors = new Contributors(new Client(), new EmojiConverter());

        $res = $contributors->getHtml();

        $this->assertIsString($res);
    }

    public function testGetResponce()
    {
//        $contributors = new Contributors(new Client(), new EmojiConverter());
//        $mockClient = \Mockery::mock(Response::class);
//        $mockClient->shouldReceive('')->andReturn($body);

        $mock = \Mockery::mock(new Contributors(new Client(), new EmojiConverter()));

//        $mock->getHtml()

//        $contributors::getHtml()


    }


//    public function testGetResponce()
//    {
//        $text = <<< EOF
//
//EOF;
//
//
//        $responseMock = \Mockery::mock();
////        ->assertJsonPath('team.owner.name', 'foo')
//    }
}
