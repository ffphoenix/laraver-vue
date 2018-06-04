<?php

namespace App\Exceptions;

class ForbidenException extends BaseException
{
    protected $details;
    public function __construct($code, $message, $details = null) {

        $this->details = $details;
        parent::__construct($code, $message, 403);
    }

    public function getDetails(){
        return $this->details;
    }
}