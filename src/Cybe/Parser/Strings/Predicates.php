<?php

namespace MemMemov\Cybe\Parser\Strings;

class Predicates
{
    public function create(string $string): Predicate
    {
        return new Predicate($string);
    }
}