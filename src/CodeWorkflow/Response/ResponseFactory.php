<?php

namespace CodeWorkflow\Response;


use CodeWorkflow\Exceptions\CriticalErrorException;
use StrongType\String;

class ResponseFactory
{
    private static $type = null;

    private static $instance;

    private function init() {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new ResponseFactory();
    }

    public static function prepare(String $type) {
        self::init();

        if( ! $type->equals(new String('fail')) AND ! $type->equals(new String('success'))) {
            throw new CriticalErrorException('ResponseFactory::prepare() has to receive a string of either \'fail\' or \'success\'');
        }

        self::$type = $type;

        return self::$instance;
    }

    public function createResponse(ResponsePool $responsePool, \Closure $closure) {
        if(self::$type === null) {
            throw new CriticalErrorException('ResponseFactory::createResponse() cannot create a response. Please, call ResponseFactory::prepare($type) first');
        }

        if(self::$type->equals(new String('fail'))) {
            self::$type = null;
            $responsePool->addFailResponse($closure);
            return;
        }

        if(self::$type->equals(new String('success'))) {
            self::$type = null;
            $responsePool->addSuccessResponse($closure);
            return;
        }

        throw new CriticalErrorException('ResponseFactory::createResponse(): No response could be created for type ' . self::$type->toString());
    }
} 