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
    public function __construct(public readonly string $title, public readonly string $doc)
    {
    }

}
