<?php

namespace CodeWorkflow\Arguments;


class NoArgument implements ArgumentInterface
{
    public function getArguments() {
        return false;
    }
} 