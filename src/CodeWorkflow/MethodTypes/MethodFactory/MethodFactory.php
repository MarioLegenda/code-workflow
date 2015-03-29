<?php

namespace CodeWorkflow\MethodTypes\MethodFactory;


use CodeWorkflow\DefinitionExaminer;
use CodeWorkflow\MethodTypes\ReturnedValue;
use CodeWorkflow\MethodTypes\ReturnsObjectMethod;
use CodeWorkflow\MethodTypes\ReturnsTrueMethod;
use CodeWorkflow\MethodTypes\ReturnsFalseMethod;
use CodeWorkflow\MethodTypes\VoidMethod;
use CodeWorkflow\MethodTypes\ReturnsSelfMethod;
use CodeWorkflow\MethodTypes\ReturnsStringMethod;
use CodeWorkflow\MethodTypes\ReturnsArrayMethod;
use StrongType\Exceptions\CriticalTypeException;

class MethodFactory extends AbstractMethodFactory
{
    public function createMethod() {
        if($this->examiner->isVoid()) {
            if($this->examiner->hasArguments()) {
                return new VoidMethod(
                    $this->methodDefinition->getMethodName(),
                    $this->methodDefinition->getParameters()
                );
            }

            if( ! $this->examiner->hasArguments()) {
                return new VoidMethod(
                    $this->methodDefinition->getMethodName()
                );
            }

            throw new CriticalTypeException('MethodFactory::createMethod(): Method ' . $this->methodDefinition->getMethodName() . ' was not found by the MethodFactory');
        }

        if($this->examiner->isReturningBool()) {
            if($this->examiner->hasToBeTrue()) {
                if($this->examiner->hasArguments()) {
                    return new ReturnsTrueMethod(
                        $this->methodDefinition->getMethodName(),
                        $this->methodDefinition->getParameters()
                    );
                }

                if( ! $this->examiner->hasArguments()) {
                    return new ReturnsTrueMethod(
                        $this->methodDefinition->getMethodName()
                    );
                }
            }
        }

        if($this->examiner->isReturningBool()) {
            if($this->examiner->hasToBeFalse()) {
                if($this->examiner->hasArguments()) {
                    return new ReturnsFalseMethod(
                        $this->methodDefinition->getMethodName(),
                        $this->methodDefinition->getParameters()
                    );
                }

                if( ! $this->examiner->hasArguments()) {
                    return new ReturnsFalseMethod(
                        $this->methodDefinition->getMethodName()
                    );
                }
            }
        }

        if($this->examiner->isReturningArray()) {
            if ($this->examiner->hasArguments()) {
                $arrayMethod =  new ReturnsArrayMethod(
                    $this->methodDefinition->getMethodName(),
                    $this->methodDefinition->getParameters()
                );

                $arrayMethod->setReturned(new ReturnedValue());

                return $arrayMethod;
            }

            if (!$this->examiner->hasArguments()) {
                $arrayMethod =  new ReturnsArrayMethod(
                    $this->methodDefinition->getMethodName()
                );

                $arrayMethod->setReturned(new ReturnedValue());

                return $arrayMethod;
            }
        }

        if($this->examiner->doesReturnObject()) {
            if($this->examiner->hasArguments()) {
                $objectMethod =  new ReturnsObjectMethod(
                    $this->methodDefinition->getMethodName(),
                    $this->methodDefinition->getParameters()
                );

                $objectMethod->setReturned(new ReturnedValue());

                return $objectMethod;
            }

            if( ! $this->examiner->hasArguments()) {
                $objectMethod = new ReturnsObjectMethod(
                    $this->methodDefinition->getMethodName()
                );

                $objectMethod->setReturned(new ReturnedValue());

                return $objectMethod;
            }
        }

        if($this->examiner->doesReturnString()) {
            if ($this->examiner->hasArguments()) {
                $stringMethod =  new ReturnsStringMethod(
                    $this->methodDefinition->getMethodName(),
                    $this->methodDefinition->getParameters()
                );

                $stringMethod->setReturned(new ReturnedValue());

                return $stringMethod;
            }

            if (!$this->examiner->hasArguments()) {
                $stringMethod = new ReturnsStringMethod(
                    $this->methodDefinition->getMethodName()
                );

                $stringMethod->setReturned(new ReturnedValue());

                return $stringMethod;
            }
        }

        if($this->examiner->doesReturnSelf()) {
            if($this->examiner->hasArguments()) {
                return new ReturnsSelfMethod(
                    $this->methodDefinition->getMethodName(),
                    $this->methodDefinition->getParameters()
                );
            }

            if( ! $this->examiner->hasArguments()) {
                return new ReturnsSelfMethod(
                    $this->methodDefinition->getMethodName()
                );
            }
        }
    }
} 