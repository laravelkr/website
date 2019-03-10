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


    public function testDownload()
    {

        $this->artisan('docs:initialize')->assertExitCode(0);
    }


    public function testUpdate()
    {

        $this->artisan('docs:update')->assertExitCode(0);
    }



}