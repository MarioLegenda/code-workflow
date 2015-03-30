<?php

namespace StrongType;


class Integer extends Number
{
    public function __construct($number = null) {
        $this->checkType($number);

        $this->number = $number;
    }

    public function setType($type) {
        $this->number = $type;
    }

    public function roundDown() {
        $this->number = floor($this->number);
    }

    public function roundUp() {
        $this->number = ceil($this->number);
    }

    public function toNumber() {
        if( ! is_int($this->number)) {
            return new Float($this->number);
        }

        return $this->number;
    }

    private function checkType($type) {
        if($type !== null) {
            if( ! is_int($type)) {
                throw new CriticalTypeException('Integer: Integer object must be constructed with an actual number. Some other type given');
            }
        }
    }
} 