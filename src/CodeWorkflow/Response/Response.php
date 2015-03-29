<?php

namespace CodeWorkflow\Response;


use CodeWorkflow\Context;
use StrongType\String;

abstract class Response
{
    private $methodName;
    private $response;

    public function __construct() {

    }

    public function addMethodName(String $methodName) {
        $this->methodName = $methodName;
    }

    public function addResponseClosure(\Closure $closure) {
        $this->response = $closure;
    }

    public function getMethodName() {
        return $this->methodName;
    }

    public function getResponseClosure() {
        return $this->response;
    }

    public function runResponse(Context $context) {
        return $this->response->__invoke($context);
    }
} 