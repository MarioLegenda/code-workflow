<?php

namespace CodeWorkflow;


use CodeWorkflow\Arguments\ArgumentFactory;
use CodeWorkflow\Arguments\ArgumentInterface;
use StrongType\String;

class MethodDefinition
{
    private $definition = array(
        'method-name' => null,
        'void' => null,
        'returns' => array(
            'bool' => array(
                'true' => null,
                'false' => null
            ),
            'array' => null,
            'self' => null,
            'object' => null,
            'string' => null,
        ),
        'stop' => null,
        'arguments' => null,
        'parameters' => null,
    );

    private $compiler;

    public function __construct(Compiler $compiler) {
        $this->compiler = $compiler;
    }

    public function name($methodName) {
        $this->definition['method-name'] = $methodName;

        return $this;
    }

    public function getMethodName() {
        return $this->definition['method-name'];
    }

    public function withParameters() {
        $args = func_get_args();
        $this->definition['parameters'] = ArgumentFactory::createArgument($args);

        return $this;
    }

    public function getParameters() {
        return $this->definition['parameters'];
    }

    public function returnsValue() {
        return $this;
    }

    public function void() {
        $this->definition['void'] = true;

        return $this;
    }

    public function true() {
        $this->definition['returns']['bool']['true'] = true;

        return $this;
    }

    public function false() {
        $this->definition['returns']['bool']['false'] = true;

        return $this;
    }

    public function arr() {
        $this->definition['returns']['array'] = true;

        return $this;
    }

    public function string() {
        $this->definition['returns']['string'] = true;

        return $this;
    }

    public function object() {
        $this->definition['returns']['object'] = true;

        return $this;
    }

    public function self() {
        $this->definition['returns']['self'] = true;

        return $this;
    }

    public function save() {
        $this->compiler->save($this);

        return $this;
    }

    public function getDefinition() {
        return $this->definition;
    }
} 