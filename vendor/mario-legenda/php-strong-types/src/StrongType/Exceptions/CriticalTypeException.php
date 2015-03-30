<?php

namespace StrongType\Exceptions;


class CriticalTypeException extends \Exception
{
    public function __construct($message) {
        $this->message = $message;
    }
} 