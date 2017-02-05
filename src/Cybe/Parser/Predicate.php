<?php

namespace MemMemov\Cybe\Parser;

class Predicate
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }
}