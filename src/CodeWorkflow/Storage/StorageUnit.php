<?php

namespace CodeWorkflow\Storage;


use CodeWorkflow\Storage\Contracts\StorageUnitInterface;
use CodeWorkflow\Storage\Exceptions\StorageException;

class StorageUnit implements StorageUnitInterface
{
    private $storage = array();

    public function store($key, $value) {
        if(array_key_exists($key, $this->storage)) {
            throw new StorageException('StorageUnit: StorageUnit::store($key, $value); ' . $key . ' already exists in storage');
        }

        $this->storage[$key] = $value;
    }

    public function overwrite($key, $value) {
        $this->storage[$key] = $value;
    }

    public function retreive($key) {
        if( ! $this->isStored($key)) {
            return null;
        }

        return $this->storage[$key];
    }

    public function isStored($key) {
        return array_key_exists($key, $this->storage);
    }
} 