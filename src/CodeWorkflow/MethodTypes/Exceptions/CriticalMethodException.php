<?php

namespace CodeWorkflow\MethodTypes\Exceptions;


class CriticalMethodException extends \Exception
{
    public function __construct($message) {
        $this->message = $message;
    }
} 