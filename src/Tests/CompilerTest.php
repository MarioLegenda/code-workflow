<?php

namespace Tests;


use CodeWorkflow\Compiler;
use StrongType\Integer;
use StrongType\String;

class CompilerTest  extends \PHPUnit_Framework_TestCase
{
    public function testBasicCompiler() {
        $company = new \Company();
        $person = new \Person(new \Unique());

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


    }
} 