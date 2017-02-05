<?php

namespace MemMemov\Cybe\Parser\Strings;

use MemMemov\Cybe\Parser\IPredicate;

class Predicates
{
    public function create(string $string): IPredicate
    {
        return new Predicate($string);
    }
}