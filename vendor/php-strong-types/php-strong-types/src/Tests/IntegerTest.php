<?php

namespace App\ToolsBundle\Tests\StrongType;


use App\ToolsBundle\Helpers\StrongType\Float;
use App\ToolsBundle\Helpers\StrongType\Integer;

class IntegerTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction() {
        $integer = new Integer(5);

        $this->assertEquals(5, $integer->toNumber(), 'testConstruction(): Integer::toInteger() did not return 5 as correct value');
    }

    public function testNumberMethods() {
        $integer = new Integer(5);

        $integer->add(new Integer(10))->add(new Integer(25))->substract(new Integer(35));
        $this->assertEquals(5, $integer->toNumber(), 'testAddMethod(): Integer::testNumberMethods() did not return 5 after certain operations. I returned ' . $integer->toNumber());

        $shouldBeFloat = $integer
            ->add(new Float(10.54))
            ->add(new Integer(5))
            ->substract(new Float(10.56))
            ->toNumber();

        $this->assertInstanceOf('App\\ToolsBundle\\Helpers\\StrongType\\Float', $shouldBeFloat, 'testNumberMethods(): $shouldBeFloat variable should be of type Float');
        $this->assertEquals(9.98, $shouldBeFloat->toNumber(), 'testNumberMethods(): Float::toNumber() should return -5.56 but returned ' . $shouldBeFloat->toNumber());

    }
} 