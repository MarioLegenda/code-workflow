<?php

namespace Tests;


use StrongType\Boolean;

class BooleanTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor() {
        $bool = new Boolean(true);
        $bool->setType(false);
    }

    public function testMethods() {
        $bool = new Boolean(true);

        $this->assertTrue($bool->toBoolean(), 'BooleanTest::testMethods(): Boolean::toBoolean() had to be true');
        $this->assertTrue($bool->isTrue(new Boolean(true)), 'BooleanTest::testMethods(): Boolean::isTrue() had to be true');
        $this->assertTrue($bool->isFalse(new Boolean(false)), 'BooleanTest::testMethods(): Boolean::isFalse() had to be true');
        $this->assertTrue($bool->equals(new Boolean(true)), 'BooleanTest::testMethods(): Boolean::equals() had to be true');
    }
} 