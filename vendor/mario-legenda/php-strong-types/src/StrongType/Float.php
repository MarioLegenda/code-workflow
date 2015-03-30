<?php

namespace StrongType;


class Float extends Number
{
    public function __construct($number) {
        $this->checkType($number);

        $this->number = $number;
    }

    public function toNumber() {
        return $this->number;
    }

    public function setType($type) {
        $this->number = $type;
    }

    private function checkType($type) {
        if($type !== null) {
            if( ! is_float($type)) {
                throw new CriticalTypeException('Integer: Integer object must be constructed with an actual number. Some other type given');
            }
        }
    }
} 