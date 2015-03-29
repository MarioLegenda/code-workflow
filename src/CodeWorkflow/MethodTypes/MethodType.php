<?php

namespace CodeWorkflow\MethodTypes;

use CodeWorkflow\Arguments\ArgumentInterface;
use CodeWorkflow\Arguments\MultipleArguments;
use CodeWorkflow\Arguments\NoArgument;
use CodeWorkflow\Arguments\SingleArgument;
use StrongType\Exceptions\CriticalTypeException;
use CodeWorkflow\MethodTypes\Exceptions\CriticalMethodException;

abstract class MethodType
{
    protected $methodName;
    protected $arguments = null;

    private $returnedValue = null;
    protected  $workingObject = null;

    abstract public function checkReturned();

    public function __construct($methodName, ArgumentInterface $arguments = null) {
        $this->methodName = $methodName;
        $this->arguments = $arguments;
    }

    public function getReturnedValue() {
        return $this->returnedValue;
    }

    public function getMethodName() {
        return $this->methodName;
    }

    public function execute($workingObject) {
        $this->workingObject = $workingObject;

        if( ! method_exists($workingObject, $this->methodName)) {
            throw new CriticalMethodException('ReturnsTrueMethod: Method \'' . $this->methodName . '\' has not been found in object ' . get_class($workingObject));
        }

        if($this->arguments === null) {
            $methodName = $this->methodName;
            $this->returnedValue = $workingObject->$methodName();

            return $this;
        }

        if($this->arguments instanceof NoArgument) {
            $methodName = $this->methodName;
            $this->returnedValue = $workingObject->$methodName();

            return $this;
        }

        if($this->arguments instanceof SingleArgument) {
            $methodName = $this->methodName;
            $this->returnedValue = $workingObject->$methodName($this->arguments->getArguments());
            return $this;
        }

        if($this->arguments instanceof MultipleArguments) {
            $argNum = $this->arguments->argCount();

            if($argNum >= 6) {
                throw new CriticalTypeException("Compiler: Maximum argument number for any method is 6. Exception thrown for method " . $this->methodName);
            }

            if($this->arguments === null) {
                $methodName = $this->methodName;
                $this->returnedValue = $workingObject->$methodName();
                return $this;
            }

            $arguments = $this->arguments->getArguments();
            if($argNum === 1) {
                $methodName = $this->methodName;
                $this->returnedValue = $workingObject->$methodName($arguments[0]);

                return $this;
            }

            if($argNum === 2) {
                $methodName = $this->methodName;
                $this->returnedValue = $workingObject->$methodName(
                    $arguments[0],
                    $arguments[1]
                );

                return $this;
            }

            if($argNum === 3) {
                $methodName = $this->methodName;
                $this->returnedValue = $workingObject->$methodName(
                    $arguments[0],
                    $arguments[1],
                    $arguments[2]
                );

                return $this;
            }

            if($argNum === 4) {
                $methodName = $this->methodName;
                $this->returnedValue = $workingObject->$methodName(
                    $arguments[0],
                    $arguments[1],
                    $arguments[2],
                    $arguments[3]
                );

                return $this;
            }

            if($argNum === 5) {
                $methodName = $this->methodName;
                $this->returnedValue = $workingObject->$methodName(
                    $arguments[0],
                    $arguments[1],
                    $arguments[2],
                    $arguments[3],
                    $arguments[4]
                );

                return $this;
            }

            if($argNum === 6) {
                $methodName = $this->methodName;
                $this->returnedValue = $workingObject->$methodName(
                    $arguments[0],
                    $arguments[1],
                    $arguments[2],
                    $arguments[3],
                    $arguments[4],
                    $arguments[5]
                );

                return $this;
            }
        }

        throw new CriticalMethodException('MethodType::execute() could not execute method ' . $this->methodName . ' with object ' . get_class($workingObject));
    }
} 