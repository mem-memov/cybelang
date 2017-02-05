<?php

namespace MemMemov\Cybe\Parser\Strings;

use MemMemov\Cybe\Parser\IPredicate;

class Predicate implements IPredicate
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }
}