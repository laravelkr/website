<?php


namespace App\Exceptions;


class CommitInformationNotFoundException extends \Exception
{
    protected $message = "Commit Information Not Found";
}