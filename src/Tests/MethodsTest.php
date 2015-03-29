<?php

namespace Tests;


use CodeWorkflow\Compiler;
use CodeWorkflow\MethodDefinition;
use CodeWorkflow\MethodTypes\MethodFactory\MethodFactory;
use StrongType\Integer;
use StrongType\String;

class MethodsTest extends \PHPUnit_Framework_TestCase
{
    public function testMethodDefinition() {
        $definition = new MethodDefinition(new Compiler());

        $definition->name('someMethod')->withParameters(array())->void()->save();
    }

    /**
     * @depends testMethodDefinition
     */
    public function testMethodFactory() {
        $definition = new MethodDefinition(new Compiler());
        $definition->name('someMethod')->withParameters(array())->void();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\VoidMethod', $method, 'testMethodFactory(): MethodFactory::createMethod() has to return VoidMethod');

        $definition = new MethodDefinition(new Compiler());
        $definition->name('someMethod')->withParameters(array())->true();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\ReturnsTrueMethod', $method, 'testMethodFactory(): MethodFactory::createMethod() has to return RetrunsTrueMethod');

        $definition = new MethodDefinition(new Compiler());
        $definition->name('someMethod')->withParameters()->object();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\ReturnsObjectMethod', $method, 'testMethodFactory(): MethodFactory::createMethod() has to return ReturnsObjectMethod');

        $definition = new MethodDefinition(new Compiler());
        $definition->name('someMethod')->withParameters()->self();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\ReturnsSelfMethod', $method, 'testMethodFactory(): MethodFactory::createMethod() has to return ReturnsSelfMethod');

        $definition = new MethodDefinition(new Compiler());
        $definition->name('someMethod')->withParameters()->false();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\ReturnsFalseMethod', $method, 'testMethodFactory(): MethodFactory::createMethod() has to return ReturnsFalseMethod');

        $definition = new MethodDefinition(new Compiler());
        $definition->name('someMethod')->withParameters()->arr();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\ReturnsArrayMethod', $method, 'testMethodFactory(): MethodFactory::createMethod() has to return ReturnsArrayMethod');

        $definition = new MethodDefinition(new Compiler());
        $definition->name('someMethod')->withParameters()->string();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\ReturnsStringMethod', $method, 'testMethodFactory(): MethodFactory::createMethod() has to return ReturnsStringMethod');
    }

    public function testVoidMethod() {
        $definition = new MethodDefinition(new Compiler());
        $mario = new \Person(new \Unique());
        $mario->setName(new String('Mario'));
        $mario->setLastname(new String('Škrlec'));
        $mario->setAge(new Integer(28));

        $definition->name('hireEmployee')->withParameters($mario)->void();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\VoidMethod', $method, 'testVoidMethod(): MethodFactory::createMethod() has to return VoidMethod');

        $company = new \Company();
        $returned = $method->execute($company)->checkReturned();

        $this->assertTrue($returned, 'testVoidMethod(): Company::hireEmployee could not be executed as void');
        $this->assertInstanceOf('Company', $company->lookupEmployee($mario), 'testVoidMethod(): Company::hireEmployee() has failed inserting new Person()');
    }

    public function testStringMethod() {
        $company = new \Company();
        $company->setCompanyName(new String('Dealings Offshore'));
        $definition = new MethodDefinition(new Compiler());
        $definition->name('getCompanyName')->string();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\ReturnsStringMethod', $method, 'testStringMethod(): MethodFactory::createMethod() has to return ReturnsStringMethod');

        $returned = $method->execute($company)->checkReturned();
        $this->assertTrue($returned, 'testStringMethod(): Company::getCompanyName() has not returned a string');
    }

    public function testTrueMethod() {
        $company = new \Company();
        $company->setCompanyName(new String('Dealings Offshore'));
        $mario = new \Person(new \Unique());
        $company->hireEmployee($mario);

        $definition = new MethodDefinition(new Compiler());
        $definition->name('fireEmployee')->withParameters($mario)->true();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\ReturnsTrueMethod', $method, 'testTrueMethod(): MethodFactory::createMethod() has to return ReturnsTrueMethod');

        $returned = $method->execute($company)->checkReturned();
        $this->assertTrue($returned, 'testTrueMethod(): Company::fireEmployee() has to return true');
    }

    public function testFalseMethod() {
        $company = new \Company();
        $company->setCompanyName(new String('Dealings Offshore'));
        $mario = new \Person(new \Unique());
        $martina = new \Person(new \Unique());
        $company->hireEmployee($mario);

        $definition = new MethodDefinition(new Compiler());

        $returned = $company->fireEmployee($martina);
        $definition->name('fireEmployee')->withParameters($martina)->false();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\ReturnsFalseMethod', $method, 'testFalseMethod(): MethodFactory::createMethod() has to return ReturnsFalseMethod');

        $returned = $method->execute($company)->checkReturned();
        $this->assertTrue($returned, 'testTrueMethod(): Company::fireEmployee() has to return true');
    }

    public function testArrayMethod() {
        $company = new \Company();
        $company->setCompanyName(new String('Dealings Offshore'));
        $mario = new \Person(new \Unique());
        $martina = new \Person(new \Unique());
        $company->hireEmployee($mario);
        $company->hireEmployee($martina);

        $definition = new MethodDefinition(new Compiler());
        $definition->name('asArray')->arr();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\ReturnsArrayMethod', $method, 'testArrayMethod(): MethodFactory::createMethod() has to return ReturnsArrayMethod');

        $returned = $method->execute($company)->checkReturned();
        $this->assertTrue($returned, 'testArrayMethod(): Company::asArray() has to return array');

    }

    public function testObjectMethod() {
        $company = new \Company();
        $company->setCompanyName(new String('Dealings Offshore'));
        $mario = new \Person(new \Unique());
        $company->hireEmployee($mario);

        $definition = new MethodDefinition(new Compiler());
        $definition->name('lookupEmployee')->withParameters($mario)->object();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\ReturnsObjectMethod', $method, 'testObjectMethod(): MethodFactory::createMethod() has to return ReturnsObjectMethod');

        $returned = $method->execute($company)->checkReturned();
        $this->assertTrue($returned, 'testObjectMethod(): Company::lookupEmployee() has to return true');
    }

    public function testSelfMethod() {
        $definition = new MethodDefinition(new Compiler());
        $definition->name('setCompanyName')->withParameters(new String('Dealings Offshore'))->self();

        $methodFactory = new MethodFactory($definition);
        $method = $methodFactory->createMethod();

        $this->assertInstanceOf('CodeWorkflow\\MethodTypes\\ReturnsSelfMethod', $method, 'testSelfMethod(): MethodFactory::createMethod() has to return ReturnsSelfMethod');
        $company = new \Company();
        $returned = $method->execute($company)->checkReturned();

        $this->assertTrue($returned, 'testSelfMethod(): ReturnsSelfMethod::execute() has to return true');
    }
}