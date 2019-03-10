<?php
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndexPage()
    {
        $this->get('/')->assertStatus(200);
    }
}
