<?php

namespace CodeWorkflow\MethodTypes;


class ReturnedValue
{
    private $value;

    public function setValue($value) {
        $this->value = $value;
    }

    public function getValue() {
        return $this->value;
    }
} 