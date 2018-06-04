<?php

namespace App\Exceptions;

class BadRequestException extends BaseException
{
    protected $details;
    public function __construct($code, $message, $details = null) {

        $this->details = $details;
        parent::__construct($code, $message, 400);
    }

    public function getDetails(){
        return $this->details;
    }
}