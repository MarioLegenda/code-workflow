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

    public function seek($index, $depth = null) {
    }

    public function count() {
        return count($this->arrayType);
    }

    public function isEverything($expectedValue) {
        if(is_array($expectedValue)) {
            throw new CriticalTypeException('ArrayType::isEverything(): Argument cannot be of type array');
        }



        $rit = new \RecursiveIteratorIterator($this->arrayType);
    }
} 