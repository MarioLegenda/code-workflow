<?php

namespace CodeWorkflow;


use CodeWorkflow\Storage\ObjectStorage;

class Context
{
    private $objectStorage;

    public function setObjectStorage(ObjectStorage $storage) {
        $this->objectStorage = $storage;
    }

    public function getObjectStorage() {
        return $this->objectStorage;
    }
} 