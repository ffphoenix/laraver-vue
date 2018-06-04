<?php

namespace App\Exceptions;

class AuthenticationException extends BaseException
{
    protected $details;
    public function __construct($code, $message) {

        parent::__construct($code, $message, 401);
    }
}