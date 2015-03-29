<?php

namespace Tests;


use CodeWorkflow\MethodTypes\MethodFactory\MethodFactory;
use CodeWorkflow\Storage\ObjectStorage;
use CodeWorkflow\Storage\StorageUnit;
use StrongType\String;
use CodeWorkflow\MethodDefinition;
use CodeWorkflow\Compiler;

class StorageTest extends \PHPUnit_Framework_TestCase
{
    public function testStorageUnit() {
        $storageUnit = new StorageUnit();

        $storageUnit->store('key', 'value');
        $storageUnit->store('key2', 'value2');

        $this->assertTrue($storageUnit->isStored('key'), 'StorageUnit::isStored() has to return true but returned false for key');
        $this->assertTrue($storageUnit->isStored('key2'), 'StorageUnit::isStored() has to return true but returned false for key2');

        $this->assertEquals($storageUnit->retreive('key'), 'value', 'StorageUnit::retreive($key) not the same for key');
        $this->assertEquals($storageUnit->retreive('key2'), 'value2', 'StorageUnit::retreive($key) not the same for key2');
    }

    public function testObjectStorage() {
        $company = new \Company();
        $company->setCompanyName(new String('Dealings Offshore'));
        $definition = new MethodDefinition(new Compiler());
        $definition->name('getCompanyName')->string();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $failed = $method->execute($company)->checkReturned();

        $this->assertTrue($failed, 'testObjectStorage(): ReturnsStringMethod::checkReturned() returned false');

        $returned = $method->getReturned();
        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\ReturnedValue', $returned,
            'testObjectStorage(): ReturnsStringMethod::getReturned() did not return ReturnedValue object');

        $objectStorage = new ObjectStorage(new \SplObjectStorage());

        $storageUnit = new StorageUnit();
        $storageUnit->store($method->getMethodName(), $returned);
        $objectStorage->storeUnit($company, $storageUnit);

        $this->assertTrue($objectStorage->unitExists($company), 'testObjectStorage(): ObjectStorage::unitExists returned false but had to return true');
        $this->assertInstanceOf('CodeWorkflow\\Storage\\StorageUnit', $objectStorage->retreiveUnit($company),
            'testObjectStorage(): ObjectStorage::retreiveUnit() did not return StorageUnit object');

        $storageUnit->store('budala', $returned);
        $objectStorage->rejuvinateUnit($company, $storageUnit);

        $this->assertInstanceOf('CodeWorkflow\\Storage\\StorageUnit', $objectStorage->retreiveUnit($company),
            'testObjectStorage(): ObjectStorage::retreiveUnit() did not return StorageUnit object');
        $this->assertEquals(1, $objectStorage->getInnerStorage()->count(), 'testObjectStorage(): ObjectStorage must contain 1 value but containes ' . $objectStorage->getInnerStorage()->count());
    }


} 