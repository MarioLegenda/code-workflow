<?php

namespace CodeWorkflow;

use CodeWorkflow\Arguments\ArgumentFactory;
use CodeWorkflow\Exceptions\CriticalErrorException;
use CodeWorkflow\Exceptions\MethodResolverException;
use CodeWorkflow\MethodTypes\Contracts\ReturnsValueInterface;
use CodeWorkflow\MethodTypes\Exceptions\CriticalMethodException;
use CodeWorkflow\MethodTypes\MethodFactory\MethodFactory;
use CodeWorkflow\Response\Response;
use CodeWorkflow\Response\ResponseFactory;
use CodeWorkflow\Response\ResponsePool;
use CodeWorkflow\Storage\StorageUnit;
use StrongType\Exceptions\CriticalTypeException;
use CodeWorkflow\Storage\ObjectStorage;
use StrongType\String;

class Compiler
{
    private $workingObject = null;
    private $compilerFailed = false;

    private $methods = array();


    private $objectStorage;
    private $responseStorage;
    private $responsePool;

    public function __construct() {
        $this->objectStorage = new ObjectStorage(new \SplObjectStorage());
        $this->responseStorage = new ObjectStorage(new \SplObjectStorage());
        $this->responsePool = new ResponsePool();
    }

    public function runObject($object) {
        if( ! is_object($object)) {
            throw new CriticalErrorException('MethodResolver: MethodResolver::newExecution($object) $object parameter has to be an object');
        }

        $this->methods = array();
        $this->workingObject = $object;

        return $this;
    }

    public function method() {
        return new MethodDefinition($this);
    }

    public function save(MethodDefinition $definition) {
        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();
        $this->methods[] = $method;
    }

    public function withMethods($setStack = null) {
        if( ! is_array($setStack)) {
            return $this;
        }

        if(empty($setStack)) {
            return $this;
        }

        foreach($setStack as $methodName => $argument) {
            $definition = new MethodDefinition($this);

            $definition->name($methodName)->withParameters($argument)->void();

            $methodFactory = new MethodFactory($definition);
            $method = $methodFactory->createMethod();
            $this->methods[] = $method;
        }

        return $this;
    }

    public function compile() {
        try {
            if($this->compilerFailed === false) {
                foreach($this->methods as $method) {
                    $failed = $method->execute($this->workingObject)->checkReturned();

                    if($method instanceof ReturnsValueInterface) {
                        if($this->objectStorage->unitExists($this->workingObject)) {
                            $storageUnit = $this->objectStorage->retreiveUnit($this->workingObject);
                            $storageUnit->store($method->getMethodName(), $method->getReturned());

                            $this->objectStorage->storeUnit($this->workingObject, $storageUnit);
                            $this->responsePool->clear();
                        }
                        else {
                            $storageUnit = new StorageUnit();
                            $storageUnit->store($method->getMethodName(), $method->getReturned());
                            $this->objectStorage->storeUnit($this->workingObject, $storageUnit);
                        }
                    }

                    if($failed === false) {
                        $this->compilerFailed = true;
                        break;
                    }

                    if($this->responsePool->hasFailResponse(new String($method->getMethodName()))) {
                        $this->responsePool->eraseFailResponse(new String($method->getMethodName()));
                    }
                }
            }

            return $this;
        }
        catch(CriticalMethodException $e) {
            echo $e->getMessage();
            die();
        }
        catch(CriticalTypeException $e) {
            echo $e->getMessage();
            die();
        }

        return $this;
    }

    public function then() {
        try {
            if($this->compilerFailed === false) {
                foreach($this->methods as $method) {
                    $failed = $method->execute($this->workingObject)->checkReturned();

                    if($method instanceof ReturnsValueInterface) {
                        if($this->objectStorage->unitExists($this->workingObject)) {
                            $storageUnit = $this->objectStorage->retreiveUnit($this->workingObject);
                            $storageUnit->store($method->getMethodName(), $method->getReturned());

                            $this->objectStorage->storeUnit($this->workingObject, $storageUnit);
                            $this->responsePool->clear();

                            $this->responsePool->clear();
                        }
                        else {
                            $storageUnit = new StorageUnit();
                            $storageUnit->store($method->getMethodName(), $method->getReturned());
                            $this->objectStorage->storeUnit($this->workingObject, $storageUnit);
                        }
                    }

                    if($failed === false) {
                        $this->compilerFailed = true;
                        break;
                    }

                    if($this->responsePool->hasFailResponse(new String($method->getMethodName()))) {
                        $this->responsePool->eraseFailResponse(new String($method->getMethodName()));
                    }
                }
            }

            return $this;
        }
        catch(CriticalMethodException $e) {
            echo $e->getMessage();
            die();
        }
        catch(CriticalTypeException $e) {
            echo $e->getMessage();
            die();
        }

        return $this;
    }

    public function hasFailed() {
    }

    public function hasSucceded() {
    }

    public function ifMethod($methodName) {
        if( ! method_exists($this->workingObject, $methodName)) {
            throw new CriticalErrorException('Compiler::ifMethod(): ' . $methodName . ' not found on object ' . get_class($this->workingObject));
        }

        $this->responsePool->setActiveMethod(new String($methodName));
        return $this;
    }

    public function fails() {
        $this->responsePool->setActiveStatus(new String('fail'));
        return $this;
    }

    public function succedes() {
        $this->responsePool->setActiveStatus(new String('success'));
        return $this;
    }

    public function thenRun(\Closure $closure) {
        ResponseFactory::prepare($this->responsePool->getActiveStatus())->createResponse($this->responsePool, $closure);

        if($this->responseStorage->unitExists($this->workingObject)) {
            $this->responseStorage->rejuvinateUnit(
                $this->responsePool->getActiveMethod(),
                $this->workingObject,
                $this->responsePool
            );

            $this->responsePool->clear();
            return $this;
        }

        $storageUnit = new StorageUnit();
        $storageUnit->store($this->responsePool->getActiveMethod()->toString(), $this->responsePool);
        $this->responseStorage->storeUnit($this->workingObject, $storageUnit);

        $this->responsePool->clear();
        return $this;
    }

    public function runResponseFor($workingObject, $methodName) {
        if( ! $this->responseStorage->unitExists($workingObject)) {
            return null;
        }

        $storageUnit = $this->responseStorage->retreiveUnit($workingObject);

        if( ! $storageUnit->isStored($methodName)) {
            return null;
        }

        $responsePool = $storageUnit->retreive($methodName);


        if($responsePool->hasFailResponse(new String($methodName))) {
            $response = $responsePool->getFailResponse(new String($methodName));

            $context = new Context();
            $context->setObjectStorage($this->objectStorage);

            return $response->__invoke($context);
        }

        if($responsePool->hasSuccessResponse(new String($methodName))) {
            $response = $responsePool->getSuccessResponse(new String($methodName));

            $context = new Context();
            $context->setObjectStorage($this->objectStorage);

            return $response->__invoke($context);
        }

        return null;
    }
} 