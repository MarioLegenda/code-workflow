<?php

namespace CodeWorkflow\Response;


use CodeWorkflow\Exceptions\CriticalErrorException;
use StrongType\String;

class ResponsePool
{
    private $successResponses = array();
    private $failResponses = array();

    private $activeMethod = null;
    private $activeStatus = null;

    public function __construct() {
    }

    public function setActiveMethod(String $activeMethod) {
        $this->activeMethod = $activeMethod;
    }

    public function setActiveStatus(String $activeStatus) {
        if( ! $activeStatus->equals(new String('fail')) AND ! $activeStatus->equals(new String('success'))) {
            throw new CriticalErrorException('ResponsePool: Active status can be only \'fail\' or \'success\'');
        }

        $this->activeStatus = $activeStatus;
    }

    public function getActiveStatus() {
        if($this->activeStatus === null) {
            throw new CriticalErrorException('ResponsePool: Active status cannot be fetched if it is not set before');
        }

        return $this->activeStatus;
    }





    public function addFailResponse(\Closure $response) {
        if($this->hasFailResponse($this->activeMethod)) {
            throw new CriticalErrorException('ResponsePool: Fail response for method ' . $this->activeMethod->toString() . ' has already been added');
        }

        $this->failResponses[$this->activeMethod->toString()] = $response;
    }

    public function hasFailResponse(String $methodName) {
        return array_key_exists($methodName->toString(), $this->failResponses);
    }

    public function getFailResponse(String $methodName) {
        if($this->hasFailResponse($methodName)) {
            return $this->failResponses[$methodName->toString()];
        }

        return null;
    }

    public function eraseFailResponse(String $methodName) {
        $tempResponses = array();

        foreach($this->failResponses as $mthName => $response) {
            if( ! $methodName->equals(new String($mthName))) {
                $tempResponses[$mthName]= $response;
            }
        }

        $this->failResponses = $tempResponses;
    }




    public function addSuccessResponse(\Closure $response) {
        if($this->hasSuccessResponse($this->activeMethod)) {
            throw new CriticalErrorException('ResponsePool: Success response for method ' . $this->activeMethod->toString() . ' has already been added');
        }

        $this->successResponses[$this->activeMethod->toString()] = $response;
    }

    public function hasSuccessResponse(String $methodName) {
        return array_key_exists($methodName->toString(), $this->successResponses);
    }

    public function getSuccessResponse(String $methodName) {
        return $this->successResponses[$methodName->toString()];
    }

    public function eraseSuccessResponse(String $methodName) {
        $tempResponses = array();

        foreach($this->successResponses as $mthName => $response) {
            if( ! $methodName->equals(new String($mthName))) {
                $tempResponses[$mthName]= $response;
            }
        }

        $this->successResponses = $tempResponses;
    }

    public function emptyPool() {
        $this->successResponses = array();
        $this->failResponses = array();

        $this->activeMethod = null;
        $this->activeStatus = null;
    }
} 