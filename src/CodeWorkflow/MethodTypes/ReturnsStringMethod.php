<?php

namespace CodeWorkflow\MethodTypes;

use CodeWorkflow\Arguments\ArgumentInterface;
use CodeWorkflow\Arguments\MultipleArguments;
use CodeWorkflow\Arguments\NoArgument;
use CodeWorkflow\Arguments\SingleArgument;
use CodeWorkflow\MethodTypes\Contracts\ReturnsValueInterface;
use StrongType\Exceptions\CriticalTypeException;
use StrongType\String;

class ReturnsStringMethod extends MethodType implements ReturnsValueInterface
{
    private $returned;

    public function checkReturned() {
        if($this->getReturnedValue() !== null) {
            $returnedValue = $this->getReturnedValue();
            if( ! is_string($returnedValue) AND ! $returnedValue instanceof String ) {
                return false;
            }

            $this->returned->setValue($returnedValue);

            return true;
        }

        return false;
    }

    public function setReturned(ReturnedValue $value) {
        $this->returned = $value;
    }

    public function getReturned() {
        return $this->returned;
    }
} 