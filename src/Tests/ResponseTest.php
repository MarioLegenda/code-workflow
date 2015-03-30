<?php

namespace Tests;


use CodeWorkflow\Response\ResponseFactory;
use CodeWorkflow\Response\ResponsePool;
use CodeWorkflow\Storage\ObjectStorage;
use CodeWorkflow\Storage\StorageUnit;
use CodeWorkflow\MethodDefinition;
use CodeWorkflow\Compiler;
use CodeWorkflow\MethodTypes\MethodFactory\MethodFactory;
use StrongType\String;

use Demo\Company;

class ResponseTest  extends \PHPUnit_Framework_TestCase
{
    public function testResponseCreation() {
        $responsePool = new ResponsePool();

        $responsePool->setActiveMethod(new String('getCompanyName'));
        $responsePool->setActiveStatus(new String('fail'));
        ResponseFactory::prepare($responsePool->getActiveStatus())->createResponse($responsePool, function() {
            return 'some string';
        });

        $this->assertTrue($responsePool->hasFailResponse(new String('getCompanyName')),
            'ResponseTest::testResponseCreation(): ResponsePool::hasFailResponse() had to return true for method getCompanyName');
        $this->assertInstanceOf('\\Closure', $responsePool->getFailResponse(new String('getCompanyName')),
            'ResponseTest::testResponseCreation(): ResponsePool::getFailResponse() had to return type \\Closure');
        $closure = $responsePool->getFailResponse(new String('getCompanyName'));
        $this->assertEquals('some string', $closure->__invoke(),
            'ResponseTest::testResponseCreation(): ResponsePool::getFailResponse() return closure did not return the expected string');

        $responsePool->setActiveMethod(new String('getCompanyName'));
        $responsePool->setActiveStatus(new String('success'));
        ResponseFactory::prepare($responsePool->getActiveStatus())->createResponse($responsePool, function() {
            return 'some string';
        });

        $this->assertTrue($responsePool->hasSuccessResponse(new String('getCompanyName')),
            'ResponseTest::testResponseCreation(): ResponsePool::hasSuccessResponse() had to return true for method getCompanyName');
        $this->assertInstanceOf('\\Closure', $responsePool->getSuccessResponse(new String('getCompanyName')),
            'ResponseTest::testResponseCreation(): ResponsePool::getSuccessResponse() had to return type \\Closure');
        $closure = $responsePool->getSuccessResponse(new String('getCompanyName'));
        $this->assertEquals('some string', $closure->__invoke(),
            'ResponseTest::testResponseCreation(): ResponsePool::getSuccessResponse() return closure did not return the expected string');

        $responsePool->eraseFailResponse(new String('getCompanyName'));

        $this->assertFalse($responsePool->hasFailResponse(new String('getCompanyName')));
        $this->assertNull($responsePool->getFailResponse(new String('getCompanyName')));
    }

    public function testResponseStorage() {
        $company = new Company();
        $responsePool = new ResponsePool();

        $responsePool->setActiveMethod(new String('getCompanyName'));
        $responsePool->setActiveStatus(new String('fail'));
        ResponseFactory::prepare($responsePool->getActiveStatus())->createResponse($responsePool, function() {
            return 'fail string';
        });

        $responsePool->setActiveMethod(new String('getCompanyName'));
        $responsePool->setActiveStatus(new String('success'));
        ResponseFactory::prepare($responsePool->getActiveStatus())->createResponse($responsePool, function() {
            return 'success string';
        });

        $storage = new ObjectStorage(new \SplObjectStorage());

        $storageUnit = new StorageUnit();
        $storageUnit->store('getCompanyName', $responsePool);

        $storage->storeUnit($company, $storageUnit);

        $responsePool->eraseFailResponse(new String('getCompanyName'));

        $storedResponsePool = $storage->retreiveUnit($company)->retreive('getCompanyName');

        $this->assertInstanceOf('CodeWorkflow\\Response\\ResponsePool', $storedResponsePool,
            'ResponseTest::testResponseStorage(): Failed to establish that stored unit is of type ResponsePool');

        $this->assertFalse($storedResponsePool->hasFailResponse(new String('getCompanyName')),
            'ResponseTest::testResponseStorage(): Failed assertinig that ResponsePool::hasFaileMethod() does not have a failed method');
    }

    public function testAdvancedResponseStorage() {
        $responseStorage = new ObjectStorage(new \SplObjectStorage());
        $responsePool = new ResponsePool();
        $workingObject = new Company();
        $workingObject->setCompanyName(new String('Dealings Offshore'));

        $definition = new MethodDefinition(new Compiler());
        $definition->name('getCompanyName')->withParameters(array())->void();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $responsePool->setActiveMethod(new String($method->getMethodName()));
        $responsePool->setActiveStatus(new String('fail'));
        ResponseFactory::prepare($responsePool->getActiveStatus())->createResponse($responsePool, function() {
            var_dump('getCompanyName fail');
        });


        $responsePool->clear();





    }
} 