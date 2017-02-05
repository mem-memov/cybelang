<?php

namespace MemMemov\Cybe\Parser;

class Predicates
{
    public function create(string $string): Predicate
    {
        return new Predicate($string);
    }
}