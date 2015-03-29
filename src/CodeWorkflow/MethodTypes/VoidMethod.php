<?php

namespace CodeWorkflow\MethodTypes;


use CodeWorkflow\Arguments\ArgumentInterface;
use CodeWorkflow\Arguments\MultipleArguments;
use CodeWorkflow\Arguments\NoArgument;
use CodeWorkflow\Arguments\SingleArgument;
use StrongType\Exceptions\CriticalTypeException;

class VoidMethod extends MethodType
{
    public function checkReturned() {
        return true;
    }
} 