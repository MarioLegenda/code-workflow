<?php

namespace CodeWorkflow\Exceptions;


class MethodResolverException extends \Exception
{
    public function __construct($message) {
        $this->message = $message;
    }
} 