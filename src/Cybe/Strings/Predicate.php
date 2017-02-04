<?php

namespace MemMemov\Cybe\Strings;

class Predicate
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }
}