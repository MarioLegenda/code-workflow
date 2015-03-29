<?php

namespace CodeWorkflow\Arguments;


class SingleArgument implements ArgumentInterface
{
    private $argument;

    public function __construct($argument) {
        $this->argument = $argument;
    }

    public function getArguments() {
        return $this->argument;
    }
} 