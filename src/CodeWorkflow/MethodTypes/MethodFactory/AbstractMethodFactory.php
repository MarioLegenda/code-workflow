<?php

namespace CodeWorkflow\MethodTypes\MethodFactory;


use CodeWorkflow\DefinitionExaminer;
use CodeWorkflow\MethodDefinition;

abstract class AbstractMethodFactory
{
    protected $methodDefinition;
    protected $examiner;

    public function __construct(MethodDefinition $definition) {
        $this->methodDefinition = $definition;
        $this->examiner = new DefinitionExaminer($definition);
    }

    abstract function createMethod();
} 