<?php

namespace CodeWorkflow\Storage\Exceptions;


class StorageException extends \Exception
{
    public function __construct($message) {
        $this->message = $message;
    }
} 