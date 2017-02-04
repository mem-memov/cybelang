<?php

namespace MemMemov\Cybe\Strings;

class Predicates
{
    public function create(string $string): Predicate
    {
        return new Predicate($string);
    }
}