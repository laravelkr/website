<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 14
 * Time: 오전 10:58
 */

namespace App\Exceptions;


class BadArgumentsException extends \Exception
{
    protected $code=400;
    protected $message="잘못된 요청입니다";

}