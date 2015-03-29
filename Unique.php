<?php

class Unique
{
    private static $seed = 654;
    private static $uniqueSeed = array();
    private $uniqueId;
    private $hash;

    public function __construct() {
        $this->uniqueId = self::$seed;
        self::$seed++;
        $this->createUniqueId(false);
    }

    private function createUniqueId($failSafe) {
        $tempPurchaseOrder = strtoupper(substr(sha1($this->uniqueId), 0, 6));

        if($failSafe === false) {
            if(in_array($tempPurchaseOrder, self::$uniqueSeed) === false) {
                self::$uniqueSeed[] = $tempPurchaseOrder;
                $this->hash = $tempPurchaseOrder;

                $this->createUniqueId(true);
            }
        }

        if($failSafe === true) {
            return;
        }

    }

    public function getUniqueId() {
        return $this->uniqueId . '-' . $this->hash;
    }
} 