<?php

namespace CodeWorkflow;


class DefinitionExaminer
{
    private $definition;

    public function __construct(MethodDefinition $definition) {
        $this->definition = $definition->getDefinition();
    }

    public function isMethodDefined() {
        return true;
    }

    public function getMethodName() {
        $this->definition['method-name'];
    }

    public function hasArguments() {
        if($this->definition['parameters'] !== null) {
            return true;
        }

        return false;
    }

    public function isVoid() {
        if($this->definition['void'] !== true) {
            return false;
        }

        return true;
    }

    public function returnsSomething() {
        $bool = $this->definition['returns']['bool'];

        if($bool['true'] === true OR $bool['false'] === true) {
            return true;
        }

        if($this->definition['returns']['array'] === true) {
            return true;
        }

        return false;
    }

    public function isReturningBool() {
        $bool = $this->definition['returns']['bool'];

        if($bool['true'] === true OR $bool['false'] === true) {
            return true;
        }

        return false;
    }

    public function isReturningArray() {
        if($this->definition['returns']['array'] === true) {
            return true;
        }

        return false;
    }

    public function hasToBeTrue() {
        $bool = $this->definition['returns']['bool'];
        if($bool['true'] === true) {
            return true;
        }

        return false;
    }

    public function hasToBeFalse() {
        $bool = $this->definition['returns']['bool'];
        if($bool['false'] === true) {
            return true;
        }

        return false;
    }

    public function doesReturnObject() {
        if($this->definition['returns']['object'] === true) {
            return true;
        }

        return false;
    }

    public function doesReturnString() {
        if($this->definition['returns']['string'] === true) {
            return true;
        }

        return false;
    }

    public function doesReturnSelf() {
        if($this->definition['returns']['self'] === true) {
            return true;
        }

        return false;
    }
} 