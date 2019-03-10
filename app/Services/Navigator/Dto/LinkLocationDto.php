<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 28
 * Time: 오후 3:25
 */

namespace App\Services\Navigator\Dto;


class LinkLocationDto
{
    public $title;
    public $doc;

    public function __construct(string $title,string $doc)
    {
        $this->title = $title;
        $this->doc = $doc;
    }

}