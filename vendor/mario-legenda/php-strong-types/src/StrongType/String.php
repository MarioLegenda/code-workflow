<?php

namespace StrongType;

use StrongType\Exceptions\CriticalTypeException;

class String extends Type
{
    private $innerString;

    public function __construct($string = null) {
        $this->typeCheck($string);

        $this->innerString = $string;
    }

    public function setType($string) {
        $this->typeCheck($string);

        $this->innerString = $string;
    }

    public function equals(String $toCheck) {
        if(strcmp($this->innerString, $toCheck->toString()) === 0) {
            return true;
        }

        return false;
    }

    public function toString() {
        return $this->innerString;
    }

    public function concat(String $string, $immutable = false) {
        $tempString = $this->innerString . $string->toString();
        if($immutable === true) {
            return new String($tempString);
        }

        $this->innerString = $tempString;

        return $this;
    }

    public function remove(String $toRemove, $immutable = false) {
        $actualString = $toRemove->toString();
        $pattern = '#' . $actualString . '#';
        $success = preg_match($pattern, $this->innerString, $match);
        if($success === 0 OR $success === false) {
            return false;
        }

        if($success === 1 AND strcmp($actualString, $match[0] === 0)) {
            $tempString = preg_replace($pattern, '', $this->innerString);
            if($immutable === true) {
                if(empty($tempString)) {
                    throw new CriticalTypeException('String: String::remove() has removed the portion that you specified but the new string is empty (\'\') so a new String object cannot be created. Try without the second parameter');
                }

                return new String($tempString);
            }

            $this->innerString = $tempString;
            return $this;
        }

        return false;
    }

    public function search(String $toSearch) {
        $actualString = $toSearch->toString();
        $pattern = '#' . $actualString . '#';

        $success = preg_match($pattern, $this->innerString, $match);

        if($success === 1 AND strcmp($actualString, $match[0]) === 0) {
            return true;
        }

        return false;
    }

    public function regexSearch($pattern) {
        $success = preg_match($pattern, $this->innerString, $match);

        if($success === 1) {
            return true;
        }

        return false;
    }

    public function extract(String $toExtract) {
        if( ! $this->search($toExtract)) {
            return false;
        }

        $actualString = $toExtract->toString();
        $pattern = '#' . $actualString . '#';
        $success = preg_match($pattern, $this->innerString, $match);

        if($success === 1 AND strcmp($actualString, $match[0]) === 0) {
            return new String($match[0]);
        }

        return false;
    }

    public function replace(String $toReplace, String $replacement) {
        if( ! $this->search($toReplace)) {
            return false;
        }

        $toReplaceActual = $toReplace->toString();
        $replacementActual = $replacement->toString();
        $pattern = '#' . $toReplaceActual . '#';

        $replaced = preg_replace($pattern, $replacementActual, $this->innerString);

        if(strcmp($replaced, $this->innerString) === 0) {
            return false;
        }

        if($replaced === null) {
            return false;
        }

        $this->innerString = $replaced;
        return true;
    }

    public function regexReplace($regexSearch, String $replacement) {
        $actualReplacement = $replacement->toString();

        $replaced = preg_replace($regexSearch, $actualReplacement, $this->innerString);

        if(strcmp($replaced, $this->innerString) === 0) {
            return false;
        }

        if($replaced === null) {
            return false;
        }

        $this->innerString = $replaced;
        return true;
    }

    private function typeCheck($string) {
        if($string !== null) {
            if( ! is_string($string)) {
                throw new CriticalTypeException("String: String() constructor called with an argument that is not a string. Makes sense for a String to receive a string, don't you think?");
            }

            if(empty($string)) {
                throw new CriticalTypeException("String: String() construct argument has to be a non-empty string. Don't pass '' ");
            }
        }
    }
} 