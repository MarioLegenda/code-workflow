<?php

namespace CodeWorkflow\MethodTypes;

use CodeWorkflow\Arguments\ArgumentInterface;
use CodeWorkflow\Arguments\MultipleArguments;
use CodeWorkflow\Arguments\NoArgument;
use CodeWorkflow\Arguments\SingleArgument;
use CodeWorkflow\MethodTypes\Exceptions\CriticalMethodException;
use StrongType\Exceptions\CriticalTypeException;

class ReturnsTrueMethod extends MethodType
{
    public function checkReturned() {
        if($this->getReturnedValue() !== null) {
            $returnedValue = $this->getReturnedValue();
            if($returnedValue === true) {
                return true;
            }

            return false;
        }

        return false;
    }
} 