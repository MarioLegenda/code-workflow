<?php

namespace CodeWorkflow\MethodTypes\Contracts;


use CodeWorkflow\MethodTypes\ReturnedValue;

interface ReturnsValueInterface
{
    function getReturned();
    function setReturned(ReturnedValue $value);
} 