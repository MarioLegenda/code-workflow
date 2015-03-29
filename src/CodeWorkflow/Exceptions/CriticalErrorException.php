<?php

namespace CodeWorkflow\Exceptions;


class CriticalErrorException extends \Exception
{
    public function __construct($message) {
        $this->message = $message;
    }
} 