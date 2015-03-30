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
$mario = new Person(new Unique());
/*$mario->setName(new String('Mario'))
      ->setLastname(new String('Škrlec'))
      ->setAge(new Integer(28));*/

$martina = new Person(new Unique());
/*$martina->setName(new String('Martina'))
        ->setLastname(new String('Prezime'))
        ->setAge(new Integer(28));

$company->hireEmployee($martina);
$company->hireEmployee($mario);

$martina->foundJob(new Job($company));
$mario->foundJob(new Job($company));

$company->fireEmployee($martina);*/

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
    ->runObject($mario)
    ->withMethods(array(
        'setName' => new String('John'),
        'setLastname' => new String('Doe'),
        'setAge' => new Integer(28)
    ))
    ->then()
    ->runObject($martina)
    ->withMethods(array(
        'setName' => new String('Joanna'),
        'setLastname' => new String('Doe'),
        'setAge' => new Integer(25)
    ))
    ->then()
    ->runObject($company)
    ->withMethods(
        $compiler->method()->name('hireEmployee')->withParameters($mario)->void()->save(),
        $compiler->method()->name('hireEmployee')->withParameters($martina)->void()->save(),
        $compiler->method()->name('lookupEmployee')->withParameters($mario)->self()->save(),
        $compiler->method()->name('asArray')->arr()->save()
    )
    ->ifMethod('asArray')->fails()->thenRun(function($context) {
        return 'failed';
    })
    ->ifMethod('asArray')->succedes()->thenRun(function($context) {
        return 'succeded';
    })
    ->compile();

var_dump($compiler->runResponseFor($company, 'getCompanyName'));



