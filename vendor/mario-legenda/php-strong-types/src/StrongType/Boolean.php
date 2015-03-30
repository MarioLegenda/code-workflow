<?php

namespace StrongType;

use StrongType\Exceptions\CriticalTypeException;

class Boolean extends Type
{
    private $innerBool;

    public function __construct($boolean) {
        $this->typeCheck($boolean);
        $this->innerBool = $boolean;
    }

    public function setType($type) {
        $this->typeCheck($type);

        $this->innerBool = $type;
    }

    public function toBoolean() {
        return $this->innerBool;
    }

    public function equals(Boolean $boolean) {
        if($boolean->toBoolean() === $this->innerBool) {
            return true;
        }

        return false;
    }

    public static function isTrue(Boolean $boolean) {
        return $boolean->toBoolean() === true;
    }

    public static function isFalse(Boolean $boolean) {
        return $boolean->toBoolean() === false;
    }

    private function typeCheck($boolean) {
        if( ! is_bool($boolean)) {
            throw new CriticalTypeException("Bool: Bool() constructor called with an argument that is not a boolean. Makes sense for a Bool to receive a boolean, don't you think?");
        }
    }
} 