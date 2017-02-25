<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use MemMemov\Cybelang\Cybe\Parser\Predicate;

class PlainTextPredicates
{
    public function create(string $string): Predicate
    {
        return new PlainTextPredicate($string);
    }
}