<?php

namespace StrongType;


abstract class Number extends Type
{
    protected $number = null;

    abstract function toNumber();

    public function add(Number $number) {
        $this->number = $this->number + $number->toNumber();

        return $this;
    }

    public function substract(Number $number) {
        $this->number = $this->number - $number->toNumber();

        return $this;
    }

    public function divide(Number $number) {
        $this->number = $this->number / $number->toNumber();
        return $this;
    }

    public function multiply(Number $number) {
        $this->number = $this->number * $number->toNumber();
        return $this;
    }
} 