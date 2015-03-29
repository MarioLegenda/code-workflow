<?php

namespace StrongType;

/*
 Ako želim iterirat kroz multidimenzionalna polja, moram napravit RecursiveArrayIterator i onda s tim iteratorom napravit
 RecursiveIteratorIterator. Ako napravim RecursiveArrayIterator, on mi samo daje mogućnost da postane rekurzivan. Rekurziju moram
 napravit sam ili ga stavit u RecursiveIteratorIterator
*/

use StrongType\Exceptions\CriticalTypeException;

class ArrayType implements \IteratorAggregate, \Countable
{
    private $arrayType;

    public function __construct(array $arr) {
        $this->arrayType = new \RecursiveArrayIterator($arr);
    }

    public function getIterator() {
        return new \RecursiveIteratorIterator($this->arrayType);
    }

    public function seek($index) {

    }

    public function count() {
        return count($this->arrayType);
    }

    public function isEverything($expectedValue) {
        $validExpected = array('false', 'true', 'null', 'object', 'string', 'integer', 'float', 'number');

        if(in_array($expectedValue, $validExpected) === false) {
            throw new CriticalTypeException('ArrayType: ArrayType::isEverything($type) expects the values to be a string with one of these values:
            false, true, null, object, string, integer, float, number');
        }

        $rit = new \RecursiveIteratorIterator($this->arrayType);
    }
} 