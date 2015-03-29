<?php

namespace CodeWorkflow\MethodTypes;

use CodeWorkflow\Arguments\ArgumentInterface;
use CodeWorkflow\Arguments\MultipleArguments;
use CodeWorkflow\Arguments\NoArgument;
use CodeWorkflow\Arguments\SingleArgument;
use StrongType\Exceptions\CriticalTypeException;
use CodeWorkflow\MethodTypes\Exceptions\CriticalMethodException;

class ReturnsSelfMethod extends MethodType
{
    public function checkReturned() {
        if($this->getReturnedValue() !== null) {
            $returnedValue = $this->getReturnedValue();

            if( ! is_object($returnedValue)) {
                return false;
            }

            if(get_class($this->workingObject) !== get_class($returnedValue)) {
                return false;
            }

            return true;
        }

        return false;
    }
} 