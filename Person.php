<?php

use StrongType\String;
use StrongType\Integer;

class Person
{
    private $uniqueId;
    private $name;
    private $lastname;
    private $age;

    private $job;

    public function __construct(Unique $unique) {
        $this->uniqueId = $unique->getUniqueId();
    }

    public function getId() {
        return $this->uniqueId;
    }

    public function setName(String $name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name->toString();
    }

    public function setLastname(String $lastname) {
        $this->lastname = $lastname;
    }

    public function getLastname() {
        return $this->lastname->toString();
    }

    public function setAge(Integer $age) {
        $this->age = $age;
    }

    public function getAge() {
        return $this->age->toNumber();
    }

    public function foundJob(Job $company) {
    }

    public function __toString() {
        return '<br>Id: ' . $this->getId() . '<br>Name: ' . $this->getName() . '<br>Lastname: ' . $this->getLastname() . '<br>Age: ' . $this->getAge(). '<br>';
    }
} 