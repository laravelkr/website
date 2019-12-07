<?php
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    /**
     * @test
     */
    public function IndexPage()
    {
        $this->get('/')->assertStatus(200);
    }
}
