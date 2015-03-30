<?php

namespace Tests;


use CodeWorkflow\Compiler;
use StrongType\Integer;
use StrongType\String;

use Demo\Company;
use Demo\Person;
use Demo\Unique;

class CompilerTest  extends \PHPUnit_Framework_TestCase
{
    /*public function testBasicCompiler() {
        $company = new Company();
        $person = new Person(new Unique());

        $compiler = new Compiler();

        $compiler
            ->runObject($company)
            ->withMethods(
                $compiler->method()->name('setCompanyName')->withParameters(new String('Offshore Dealings'))->void()->save(),
                $compiler->method()->name('getCompanyName')->string()->save()
            )
            ->ifMethod('getCompanyName')->fails()->thenRun(function($context) use ($company) {
                return false;
            })
            ->ifMethod('getCompanyName')->succedes()->thenRun(function($context) use ($company) {
                 return $context->getObjectStorage()->retreiveUnit($company)->retreive('getCompanyName')->getValue();
            })
            ->then()
            ->runObject($person)
            ->withMethods(array(
                'setName' => new String('Mario'),
                'setLastname' => new String('Legenda'),
                'setAge' => new Integer(28)
            ))
            ->compile();

        $response = $compiler->getResponseFor($company, 'getCompanyName');
        $this->assertInternalType('string', $response, 'CompilerTest::testBasicCompiler(): Compiler::getResponseFor(\'getCompanyName\' did not return a string');
        $this->assertEquals('Offshore Dealings', $response, 'CompilerTest::testBasicCompiler: Compiler::getResponseFor(\'getCompanyName\') did not return correct value. ' . $response . ' returned');
    }*/

    public function testAdvancedCompiler() {
        $company = new Company();
        $john = new Person(new Unique());
        $johanna = new Person(new Unique());

        $compiler = new Compiler();
        $compiler
            ->runObject($company)
            ->withMethods(
                $compiler->method()->name('setCompanyName')->withParameters(new String('Dealings Offshore'))->self()->save(),
                $compiler->method()->name('getCompanyName')->string()->save()
            )
            ->ifMethod('getCompanyName')->succedes()->thenRun(function($context) use ($company) {
                return $context->getObjectStorage()->retreiveUnit($company)->retreive('getCompanyName')->getValue();
            })
            ->then()
            ->runObject($john)
            ->withMethods(array(
                'setName' => new String('John'),
                'setLastname' => new String('Doe'),
                'setAge' => new Integer(28)
            ))
            ->then()
            ->runObject($johanna)
            ->withMethods(array(
                'setName' => new String('Joanna'),
                'setLastname' => new String('Doe'),
                'setAge' => new Integer(25)
            ))
            ->then()
            ->runObject($company)
            ->withMethods(
                $compiler->method()->name('hireEmployee')->withParameters($john)->void()->save(),
                $compiler->method()->name('hireEmployee')->withParameters($johanna)->void()->save(),
                $compiler->method()->name('lookupEmployee')->withParameters($john)->self()->save(),
                $compiler->method()->name('asArray')->arr()->save()
            )
            ->ifMethod('asArray')->fails()->thenRun(function($context) {
                return 'failed';
            })
            ->ifMethod('asArray')->succedes()->thenRun(function($context) use ($company) {
                return $context->getObjectStorage()->retreiveUnit($company)->retreive('asArray')->getValue();
            })
            ->compile();

        $this->assertEquals('Dealings Offshore', $compiler->runResponseFor($company, 'getCompanyName'),
            'CompilerTest::testAdvancedCompiler(): Compiler did not return the desired response for Company::getCompanyName()');

        $this->assertInternalType('array', $compiler->runResponseFor($company, 'asArray'),
            'CompilerTest::testAdvancedCompiler(): Compiler did not return the desired response for Company::asArray()');
    }
} 