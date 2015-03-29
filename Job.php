<?php

class Job
{
    private $company;

    public function __construct(Company $company) {
        $this->company = $company;
    }

    public function getCompany() {
        return $this->company;
    }
} 