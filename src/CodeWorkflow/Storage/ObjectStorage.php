<?php

namespace CodeWorkflow\Storage;


use CodeWorkflow\MethodTypes\MethodType;
use CodeWorkflow\Storage\Contracts\StorageUnitInterface;
use CodeWorkflow\Storage\Exceptions\StorageException;

class ObjectStorage
{
    private $storage;

    public function __construct(\SplObjectStorage $storage) {
        $this->storage = $storage;
    }

    public function emptyStorage() {
        $this->storage = new \SplObjectStorage();
    }

    public function storeUnit($unit, StorageUnitInterface $storageUnit) {
        $this->isObject($unit);

        $this->storage->attach($unit, $storageUnit);
    }

    public function rejuvinateUnit($unit, StorageUnitInterface $storageUnit) {
        $this->isObject($unit);

        if( ! $this->storage->offsetExists($unit)) {
            $this->storeUnit($unit, $storageUnit);
            return $this;
        }

        $this->storage->detach($unit);
        $this->storage->attach($unit, $storageUnit);

        return $this;
    }

    public function retreiveUnit($unit) {
        $this->isObject($unit);

        if( ! $this->storage->offsetExists($unit)) {
            return null;
        }

        return $this->storage->offsetGet($unit);
    }

    public function unitExists($unit) {
        if( ! $this->storage->offsetExists($unit)) {
            return false;
        }

        return true;
    }

    public function getInnerStorage() {
        return $this->storage;
    }

    private function isObject($unit) {
        if( ! is_object($unit)) {
            throw new StorageException("ObjectStorage: Storage keys have to be objects (argument of Compiler::runObject()).");
        }

        return true;
    }
} 