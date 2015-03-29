<?php

namespace CodeWorkflow\MethodTypes;

use CodeWorkflow\Arguments\ArgumentInterface;
use CodeWorkflow\Arguments\MultipleArguments;
use CodeWorkflow\Arguments\NoArgument;
use CodeWorkflow\Arguments\SingleArgument;
use StrongType\Exceptions\CriticalTypeException;

class ReturnsFalseMethod extends MethodType
{
    public function checkReturned() {
        if($this->getReturnedValue() !== null) {
            $returnedValue = $this->getReturnedValue();
            if($returnedValue === false) {
                return true;
            }

            return false;
        }

        return false;
    }
} 