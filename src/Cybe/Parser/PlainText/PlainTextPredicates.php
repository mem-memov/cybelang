<?php

namespace MemMemov\Cybe\Parser\PlainText;

use MemMemov\Cybe\Parser\Predicate;

class PlainTextPredicates
{
    public function create(string $string): Predicate
    {
        return new PlainTextPredicate($string);
    }
}