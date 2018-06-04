<?php

namespace App\Exceptions;

class BaseException extends \Exception
{

    protected $statusCode;

    public function __construct($code, $message, $statusCode)
    {
        $this->statusCode = $code;
        parent::__construct($message, $statusCode);
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

}