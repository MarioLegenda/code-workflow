<?php

namespace CodeWorkflow\Arguments;


class ArgumentFactory
{
    public static function createArgument(array $possibleArgument) {
        if(empty($possibleArgument)) {
            return new NoArgument();
        }

        if(count($possibleArgument) > 1) {
            return new MultipleArguments($possibleArgument);
        }

        return new SingleArgument($possibleArgument[0]);
    }
} 