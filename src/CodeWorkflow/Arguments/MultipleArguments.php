<?php

namespace CodeWorkflow\Arguments;


use StrongType\Exceptions\CriticalTypeException;

class MultipleArguments implements ArgumentInterface
{
    private $arguments;

    public function __construct($argument) {
        if( ! is_array($argument)) {
            throw new CriticalTypeException('MultipleArguments: MultipleArguments::__construct() has to receive a non empty array. Non-array type given');
        }

        if(empty($argument)) {
            throw new CriticalTypeException('MultipleArguments: MultipleArguments::__construct() has to receive a non empty array. Empty array given');
        }

        $this->arguments = $argument;
    }

    public function getArguments() {
        return $this->arguments;
    }

    public function argCount() {
        return count($this->arguments);
    }
} 