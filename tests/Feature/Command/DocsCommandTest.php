<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 14
 * Time: 오전 1:35
 */

namespace Tests\Feature;


use Tests\TestCase;

class DocsCommandTest extends TestCase
{


    /**
     * @test
     */
    public function Download()
    {

        $this->artisan('docs:initialize')->assertExitCode(0);
    }


    /**
     * @test
     */
    public function Update()
    {

        $this->artisan('docs:update')->assertExitCode(0);
    }



}
