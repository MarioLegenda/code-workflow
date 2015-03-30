<?php

require 'vendor/autoload.php';

use StrongType\String;
use StrongType\Integer;
use StrongType\Float;

use CodeWorkflow\Compiler;
use CodeWorkflow\Arguments\ArgumentFactory;

use Demo\Company;
use Demo\Job;
use Demo\Person;
use Demo\Unique;


$company = new Company();
$john = new Person(new Unique());
/*$john->setName(new String('John'));
$john->setLastname(new String('Doe'));
$john->setAge(new Integer(28));*/

$johanna = new Person(new Unique());
/*$johanna->setName(new String('Johanna'));
$johanna->setLastname(new String('Doe'));
$johanna->setAge(new Integer(28));*/

/*$company->hireEmployee($johanna);
$company->hireEmployee($john);

$johanna->foundJob(new Job($company));
$john->foundJob(new Job($company));

$company->fireEmployee($johanna);*/

$compiler = new Compiler();

$compiler
    ->runObject($company)
    ->withMethods(
        $compiler->method()->name('setCompanyName')->withParameters(new String('Shady Kaymans Company'))->void()->save()
    )
    ->runObject($john)
    ->withMethods(
        $compiler->method()->name('setName')->withParameters(new String('John'))->void()->save(),
        $compiler->method()->name('setLastname')->withParameters(new String('Doe'))->void()->save(),
        $compiler->method()->name('setAge')->withParameters(new Integer(28))->void()->save()
    )
    ->then()
    ->runObject($company)
    ->withMethods(
        $compiler->method()->name('hireEmployee')->withParameters($john)->void()->save()
    )
    ->then()
    ->runObject($john)
    ->withMethods(
        $compiler->method()->name('foundJob')->withParameters(new Job($company))->void()->save()
    )
    ->compile();
/*$compiler
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
    ->ifMethod('asArray')->succedes()->thenRun(function($context) {
        return 'succeded';
    })
    ->compile();*/



