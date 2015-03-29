<?php

namespace CodeWorkflow\MethodTypes;

use CodeWorkflow\Arguments\ArgumentInterface;
use CodeWorkflow\Arguments\MultipleArguments;
use CodeWorkflow\Arguments\NoArgument;
use CodeWorkflow\Arguments\SingleArgument;
use CodeWorkflow\MethodTypes\Contracts\ReturnsValueInterface;
use StrongType\Exceptions\CriticalTypeException;

class ReturnsArrayMethod extends MethodType implements ReturnsValueInterface
{
    private $returned;

    public function checkReturned() {
        if($this->getReturnedValue() !== null) {
            $returnedValue = $this->getReturnedValue();

            if( ! is_array($returnedValue)) {
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