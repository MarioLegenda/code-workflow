<?php

require 'vendor/autoload.php';

use StrongType\Integer;
use StrongType\ArrayType;

$person = array(
    'name' => 'Mario',
    'lastname' => 'Legenda',
    'public-info' => array(
        'age' => 28,
        'birth-date' => '18.06.1986',
        'address' => array(
            'Sunčana 24',
            'Ernestinovo',
            '31215',
            'Osječko-baranjska županija'
        ),
        'hair-color' => 'brown',
        'eye-color' => 'brown',
        'college' => 'no',
    ),
    'oib' => 1256984596321
);

$numeric = array(
    'Mario',
    'Legenda',
    array(
        28,
        '18.06.1986',
        array(
            'Sunčana 24',
            'Ernestinovo',
            '31215',
            'Osječko-baranjska županija'
        ),
        'brown',
        'brown',
        'no'
    ),
    1256984596321
);

$array = new ArrayType($person);

$array->isEverything(null);

