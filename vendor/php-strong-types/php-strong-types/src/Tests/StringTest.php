<?php

namespace App\ToolsBundle\Tests\StrongType;


use App\ToolsBundle\Helpers\StrongType\CriticalTypeException;
use App\ToolsBundle\Helpers\StrongType\String;

class StringTest extends \PHPUnit_Framework_TestCase
{
    public function testBasic() {
        try {
            $emptyString = new String();
            $fullString = new String('some string');
            $this->assertEquals('some string', $fullString->toString(), "testBasic(): 'some string' does not match \$fullString");

            $fullString->setType('other string');
            $this->assertEquals('other string', $fullString->toString(), 'testBasic(): \'other string\' does not match $fullString');
        } catch(CriticalTypeException $e) {
            $this->assertFalse(true, 'String has raised an exception with message: ' . $e->getMessage());
        }
    }

    public function testEqualsMethod() {
        try {
            $name = new String('Mario');
            $success = $name->equals(new String('Mario'));
            $this->assertTrue($success, 'testEqualsMethod(): Basic equals test failed but had to return true');

            $success = $name->equals(new String('mario'));
            $this->assertFalse($success, 'testEqualsMethod(): String::equals() is case always case sensitive');
        } catch(CriticalTypeException $e) {
            $this->assertFalse(true, 'String has raised an exception with message: ' . $e->getMessage());
        }
    }

    public function testConcatMethod() {
        try {
            $name = new String('Mario');
            $lastname = new String('Mario');
            $name->concat(new String(' Legenda'));

            $this->assertEquals('Mario Legenda', $name->toString(), 'testConcatMethod(): String::concat($string) failed');

            $newString = $name->concat(new String(' je car'), true);
            $this->assertEquals('Mario Legenda je car', $newString->toString(), 'testConcatMethod(): String::concat($string, $immutable) failed');
            $this->assertInstanceOf('App\\ToolsBundle\\Helpers\StrongType\\String', $newString, 'testConcatMethod(): String::concat($string, $immutable) if provided with $imutable = true, then should return a new string object');
        } catch(CriticalTypeException $e) {
            $this->assertFalse(true, 'String has raised an exception with message: ' . $e->getMessage());
        }
    }

    public function testRemoveMethod() {
        try {
            $name = new String('Mario');
            $name->remove(new String('Mario'));
            $this->assertEquals('', $name->toString(), 'testRemoveMethod(): \'Mario\' string could not be removed');

            $name->concat(new String('Mario'));
            $name->remove(new String('Ma'));
            $this->assertEquals('rio', $name->toString(), 'testRemoveMethod(): \'Ma\' string could not be removed');

            $name = new String('Mario Legenda');
            $newString = $name->remove(new String(' Legenda'), true);
            $this->assertEquals('Mario', $newString->toString(), 'testRemoveMethod(): \' Legenda\' string could not be removed');
        } catch(CriticalTypeException $e) {
            $this->assertFalse(true, 'String has raised an exception with message: ' . $e->getMessage());
        }
    }

    public function testSearchMethod() {
        try {
            $credentials = new String('Mario Legenda');
            $success = $credentials->search(new String('Mario'));
            $this->assertTrue($success, 'testSearchMethod(): \'Mario\' string could not be found');

            $success = $credentials->search(new String('Glupan'));
            $this->assertFalse($success, 'testSearchMethod(): \'Glupan\' string is found but should not be found');
        } catch(CriticalTypeException $e) {
            $this->assertFalse(true, 'String has raised an exception with message: ' . $e->getMessage());
        }
    }

    public function testExtractMethod() {
        try {
            $credentials = new String('Mario Legenda');

            $name = $credentials->extract(new String('Mario '));
            $this->assertEquals($name->toString(), 'Mario ', 'testExtractMethod(): Extracted string \'' . $name->toString() . '\' did not match');

            $part = $credentials->extract(new String('Leg'));
            $this->assertEquals($part->toString(), 'Leg', 'testExtractMethod(): Extracted string \'' . $part->toString() . '\' did not match');

            $this->assertEquals($credentials->toString(), 'Mario Legenda', 'testExtractedMethod(): $credentials String object has changed but should not');

        } catch(CriticalTypeException $e) {
            $this->assertFalse(true, 'String has raised an exception with message: ' . $e->getMessage());
        }
    }

    public function testReplaceMethod() {
        try {
            $credentials = new String('Mario Legenda');

            $success = $credentials->replace(new String('Legenda'), new String('Škrlec'));
            $this->assertTrue($success, 'testReplaceMethod(): String::replace() could not replace \'Legenda\' with \'Škrlec\'');
            $this->assertEquals($credentials->toString(), 'Mario Škrlec', 'testReplaceMethod(): String::replace() did not replace \'Legenda\' with \'Škrlec\' properly');

            $success = $credentials->replace(new String('Glupan'), new String('Budala'));
            $this->assertFalse($success, 'testReplaceMethod(): String::replace() succeded to replace \'Glupan\' with \'Budala\' but it shouldn\'t have');
            $this->assertEquals($credentials->toString(), 'Mario Škrlec', 'testReplaceMethod(): Current string ' . $credentials->toString() . ' does not match with the current inner string');

        } catch(CriticalTypeException $e) {
            $this->assertFalse(true, 'String has raised an exception with message: ' . $e->getMessage());
        }
    }

    public function testRegexReplaceMethod() {
        try {
            $credentials = new String('Mario Legenda');

            $success = $credentials->regexReplace('#Legenda#', new String('Škrlec'));

            $this->assertTrue($success, 'testRegexReplaceMethod(): String::regexReplace() could not replace \'Legenda\' with \'Škrlec\'');
            $this->assertEquals($credentials->toString(), 'Mario Škrlec', 'testRegexReplaceMethod(): String::regexReplace() did not replace \'Legenda\' with \'Škrlec\' properly');

        } catch(CriticalTypeException $e) {
            $this->assertFalse(true, 'String has raised an exception with message: ' . $e->getMessage());
        }
    }

    public function testRegexSearch() {
        try {
            $credentials = new String('Mario Škrlec');

            $success = $credentials->regexSearch('#Mario#');
            $this->assertTrue($success, 'testRegexSearch(): String::regexSearch() could not test \'Mario\' regex');

            $success = $credentials->regexSearch('#Budala#');
            $this->assertFalse($success, 'testRegexSearch(): String::regexSearch() found string \'Budala\' but it shouldn\'t');
        } catch(CriticalTypeException $e) {
            $this->assertFalse(true, 'String has raised an exception with message: ' . $e->getMessage());
        }
    }
} 