<?php

use StrongType\String;
use StrongType\Integer;
use StrongType\Float;

class Company
{
    private $employees = array();

    private $companyName;

    public function setCompanyName(String $companyName) {
        $this->companyName = $companyName;

        return $this;
    }

    public function getCompanyName() {
        return $this->companyName->toString();
    }

    public function hireEmployee(Person $person) {
        $this->employees[$person->getId()] = $person;
    }

    public function fireEmployee(Person $person) {
        if( ! array_key_exists($person->getId(), $this->employees)) {
            return false;
        }

        $tempEmplyees = array();
        foreach($this->employees as $emp) {
            if($emp->getId() !== $person->getId()) {
                $tempEmplyees[$emp->getId()] = $emp;
            }
        }

        $this->employees = $tempEmplyees;

        return true;
    }

    public function lookupEmployee(Person $person) {
        if( ! array_key_exists($person->getId(), $this->employees)) {
            return false;
        }

        return $this;
    }

    public function asArray() {
        return $this->employees;
    }

    public function __toString() {
        $toString = $this->companyName->toString() . ':<br>';
        foreach($this->employees as $emp) {
            $toString .= (string)$emp . '<br>';
        }

        return $toString;
    }
} 